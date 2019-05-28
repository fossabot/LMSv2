<?php
/**
    * Calculate amortissement for an item
    *
    * @param $type_amort    type d'amortisssment "lineaire=2" ou "degressif=1"
    * @param $va            valeur d'acquisition
    * @param $duree         duree d'amortissement
    * @param $coef          coefficient d'amortissement
    * @param $date_achat    Date d'achat
    * @param $date_use      Date d'utilisation
    * @param $date_tax      date du debut de l'annee fiscale
    * @param $view          "n" pour l'annee en cours ou "all" pour le tableau complet (default 'n')
*/
 
//Parametros 2, valor, 5, 20, '2011-01-25', '2011-02-08'
echo (json_encode(Amort(2, 4980, 5, 20, '2011-01-25','2011-01-25', '2011-01-25', 'all')));
 
function Amort($type_amort, $va, $duree, $coef, $date_achat, $date_use, $date_tax, $view="n") {
      // By Jean-Mathieu Doleans qui s'est un peu pris le chou :p
      // Attention date mise en service/dateachat ->amort lineaire  et $prorata en jour !!
      // amort degressif au prorata du nombre de mois.
      // Son point de depart est le 1er jour du mois d'acquisition et non date de mise en service
      if ($type_amort == "2") {
         if (!empty($date_use)) {
            $date_achat = $date_use;
         }
      }
      $prorata             = 0;
      $ecartfinmoiscourant = 0;
      $ecartmoisexercice   = 0;
      $date_Y  =  $date_m  =  $date_d  =  $date_H  =  $date_i  =  $date_s  =  0;
      sscanf($date_achat, "%4s-%2s-%2s %2s:%2s:%2s",
             $date_Y, $date_m, $date_d,
             $date_H, $date_i, $date_s); // un traitement sur la date mysql pour recuperer l'annee
      // un traitement sur la date mysql pour les infos necessaires
      $date_Y2 = $date_m2 = $date_d2 = $date_H2 = $date_i2 = $date_s2=0;
      sscanf($date_tax, "%4s-%2s-%2s %2s:%2s:%2s",
             $date_Y2, $date_m2, $date_d2,
             $date_H2, $date_i2, $date_s2);
      $date_Y2 = date("Y");
      switch ($type_amort) {
         case "2" :
            ########################### Calcul amortissement lineaire ###########################
            if (($va > 0)
                && ($duree > 0)
                && !empty($date_achat)) {
               ## calcul du prorata temporis en jour ##
               $ecartfinmoiscourant = (30-$date_d); // calcul ecart entre jour date acquis
                                                    // ou mise en service et fin du mois courant
               // en lineaire on calcule en jour
               if ($date_d2 < 30) {
                  $ecartmoisexercice = (30-$date_d2);
               }
               if ($date_m > $date_m2) {
                  $date_m2 = $date_m2+12;
               } // si l'annee fiscale debute au dela de l'annee courante
               $ecartmois  = (($date_m2-$date_m)*30); // calcul ecart entre mois d'acquisition
                                                      // et debut annee fiscale
               $prorata    = $ecartfinmoiscourant+$ecartmois-$ecartmoisexercice;
               ## calcul tableau d'amortissement ##
               $txlineaire = (100/$duree); // calcul du taux lineaire
               $annuite    = ($va*$txlineaire)/100; // calcul de l'annuitee
               $mrt        = $va; //
               // si prorata temporis la derniere annnuite cours sur la duree n+1
               if ($prorata > 0) {
                  $duree = $duree+1;
               }
               for($i=1 ; $i<=$duree ; $i++) {
                  $tab['annee'][$i]    = $date_Y+$i-1;
                  $tab['annuite'][$i]  = $annuite;
                  $tab['vcnetdeb'][$i] = $mrt; // Pour chaque annee on calcul la valeur comptable nette
                                               // de debut d'exercice
                  $tab['vcnetfin'][$i] = abs(($mrt - $annuite)); // Pour chaque annee on calcule la valeur
                                                               // comptable nette de fin d'exercice
                  // calcul de la premiere annuite si prorata temporis
                  if ($prorata  >0) {
                     $tab['annuite'][1]  = $annuite*($prorata/360);
                     $tab['vcnetfin'][1] = abs($va - $tab['annuite'][1]);
                  }
                  $mrt = $tab['vcnetfin'][$i];
               }
               // calcul de la derniere annuite si prorata temporis
               if ($prorata > 0) {
                  $tab['annuite'][$duree]  = $tab['vcnetdeb'][$duree];
                  $tab['vcnetfin'][$duree] = $tab['vcnetfin'][$duree-1] - $tab['annuite'][$duree];
               }
            } else {
               return "-";
            }
            break;
         case "1" :
            ########################### Calcul amortissement degressif ###########################
            if (($va > 0)
                && ($duree > 0)
                && ($coef > 1)
                && !empty($date_achat)) {
               ## calcul du prorata temporis en mois ##
               // si l'annee fiscale debute au dela de l'annee courante
               if ($date_m > $date_m2) {
                  $date_m2 = $date_m2+12;
               }
               $ecartmois      = ($date_m2-$date_m)+1; // calcul ecart entre mois d'acquisition
                                                       // et debut annee fiscale
               $prorata        = $ecartfinmoiscourant+$ecartmois-$ecartmoisexercice;
               ## calcul tableau d'amortissement ##
               $txlineaire     = (100/$duree); // calcul du taux lineaire virtuel
               $txdegressif    = $txlineaire*$coef; // calcul du taux degressif
               $dureelineaire  = (int) (100/$txdegressif); // calcul de la duree de l'amortissement
                                                           // en mode lineaire
               $dureedegressif = $duree-$dureelineaire; // calcul de la duree de l'amortissement
                                                        // en mode degressif
               $mrt            = $va;
               // amortissement degressif pour les premieres annees
               for($i=1 ; $i<=$dureedegressif ; $i++) {
                  $tab['annee'][$i]    = $date_Y+$i-1;
                  $tab['vcnetdeb'][$i] = $mrt; // Pour chaque annee on calcule la valeur comptable nette
                                             // de debut d'exercice
                  $tab['annuite'][$i]  = $tab['vcnetdeb'][$i]*$txdegressif/100;
                  $tab['vcnetfin'][$i] = $mrt - $tab['annuite'][$i]; //Pour chaque annee on calcule la valeur
                                                                   //comptable nette de fin d'exercice
                  // calcul de la premiere annuite si prorata temporis
                  if ($prorata > 0) {
                     $tab['annuite'][1]  = ($va*$txdegressif/100)*($prorata/12);
                     $tab['vcnetfin'][1] = $va - $tab['annuite'][1];
                  }
                  $mrt = $tab['vcnetfin'][$i];
               }
               // amortissement en lineaire pour les derneres annees
               if ($dureelineaire != 0) {
                  $txlineaire = (100/$dureelineaire); // calcul du taux lineaire
               } else {
                  $txlineaire = 100;
               }
               $annuite = ($tab['vcnetfin'][$dureedegressif]*$txlineaire)/100; // calcul de l'annuite
               $mrt     = $tab['vcnetfin'][$dureedegressif];
               for($i=$dureedegressif+1 ; $i<=$dureedegressif+$dureelineaire ; $i++) {
                  $tab['annee'][$i]    = $date_Y+$i-1;
                  $tab['annuite'][$i]  = $annuite;
                  $tab['vcnetdeb'][$i] = $mrt; // Pour chaque annee on calcule la valeur comptable nette
                                               // de debut d'exercice
                  $tab['vcnetfin'][$i] = abs(($mrt - $annuite)); // Pour chaque annee on calcule la valeur
                                                               // comptable nette de fin d'exercice
                  $mrt                 = $tab['vcnetfin'][$i];
               }
               // calcul de la derniere annuite si prorata temporis
               if ($prorata > 0) {
                  $tab['annuite'][$duree] = $tab['vcnetdeb'][$duree];
                  if (isset($tab['vcnetfin'][$duree-1])) {
                     $tab['vcnetfin'][$duree] = ($tab['vcnetfin'][$duree-1] - $tab['annuite'][$duree]);
                  } else {
                     $tab['vcnetfin'][$duree] = 0;
                  }
               }
            } else {
               return "-";
            }
            break;
         default :
            return "-";
      }
      // le return
      if ($view == "all") {
         // on retourne le tableau complet
         return $tab;
      }
      // on retourne juste la valeur residuelle
      // si on ne trouve pas l'annee en cours dans le tableau d'amortissement dans le tableau,
      // le materiel est amorti
      if (!array_search(date("Y"),$tab["annee"])) {
         $vnc = 0;
      } else if (mktime(0 , 0 , 0, $date_m2, $date_d2, date("Y"))
                 - mktime(0 , 0 , 0 , date("m") , date("d") , date("Y")) < 0 ) {
         // on a depasse la fin d'exercice de l'annee en cours
         //on prend la valeur residuelle de l'annee en cours
         
         $vnc = $tab["vcnetfin"][array_search(date("Y"), $tab["annee"])];
      } else {
         // on se situe avant la fin d'exercice
         // on prend la valeur residuelle de l'annee n-1
         $vnc = $tab["vcnetdeb"][array_search(date("Y"), $tab["annee"])];
      }
      return $vnc;
   }
?>


