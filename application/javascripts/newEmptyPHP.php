<?php
session_start();
include('config.php');
include('funcao.php');
if (IsSet($_SESSION['flog_login'])) {
	$flog_login     = $_SESSION['flog_login'];
	$flog_senha     = $_SESSION['flog_senha'];
	$flog_nome      = $_SESSION['flog_nome'];
	$flog_sobrenome = $_SESSION['flog_subrenome'];
};

//include('dono.php');
$lat = '0';
$long = '0';
if (isSet($_POST['flog_login']) && isSet($_POST['flog_senha'])) {
	$flog_login = $_POST ['flog_login'];
	$flog_senha = $_POST ['flog_senha'];
	// verifico se o usuario/senha esta correto.
    $query_user = mysql_query("SELECT id, nome, sobrenome FROM $tab_users where login='$flog_login' and senha='$flog_senha'") or die(print(mysql_error()));
    $num_rows = mysql_num_rows($query_user);
	IF ($num_rows != 1) {
		UnSet($flog_login);
		UnSet($flog_senha);
                header("Location: errlogin.php");
	} else {
		$_SESSION['flog_login'] = $flog_login;
		$_SESSION['flog_senha'] = $flog_senha;
		$line = mysql_fetch_array($query_user, MYSQL_ASSOC);
		$flog_nome 		= $line['nome'];
		$flog_sobrenome = $line['sobrenome']; 
		$user_id        = $line['id'];
		$email          = $line['email'];
		$_SESSION['flog_nome']      = $flog_nome;
		$_SESSION['flog_subrenome'] = $flog_sobrenome;
		$_SESSION['flog_user_id']   = $user_id;
		$_SESSION['flog_email']   = $email;
            setcookie("login","$flog_login",time()+864000);
            setcookie("senha","$flog_senha",time()+864000);

	};
}
else
{
	if (IsSet($_SESSION['flog_login'])) {
		$flog_login     = $_SESSION['flog_login'];
		$flog_senha     = $_SESSION['flog_senha'];
		$flog_nome      = $_SESSION['flog_nome'];
		$flog_sobrenome = $_SESSION['flog_subrenome'];
		$user_id        = $_SESSION['flog_user_id'];
	};
};
?>
<?php
/*global $dono;
$id_user = idealizar($dono);
global $tab_preferencias;
$query = $query = mysql_query("SELECT * FROM $tab_preferencias WHERE id_user='$id_user'") or die(print(mysql_error()));
while($data = mysql_fetch_array($query)){
	$cor_fundo = $data['cor_fundo'];
	$cor_letra = $data['cor_letra'];
	$cor_titulo = $data['cor_titulo'];
	$tamanho_titulo = $data['tamanho_titulo'];
	$titulo_flog = $data['titulo_flog'];
	$tipo_letra = $data['tipo_letra'];
	$titulo_flog = $data['titulo_flog'];
	$f1 = $data['favorito_1'];
	$f2 = $data['favorito_2'];
	$f3 = $data['favorito_3'];
	$f4 = $data['favorito_4'];
	$f5 = $data['favorito_5'];
	$f6 = $data['favorito_6'];
	$f7 = $data['favorito_7'];
	$f8 = $data['favorito_8'];
	$f9 = $data['favorito_9'];
	$f10 = $data['favorito_10'];
}
*/
$lat = '0';
$long = '0';
global $tab_fotos;
$id_foto = $_GET['id'];
$img_prin = $data_prin['url'];
$query_prin = mysql_query("SELECT * FROM tab_fotos WHERE id='$id_foto' ORDER BY id DESC LIMIT 1") or die(print(mysql_error()));
	while($data_prin = mysql_fetch_array($query_prin)){
                $principal = $data_prin['titulo'];
        	$img_prin = $data_prin['url'];
	        $coment_foto = $data_prin['comentario'];
         	$datapost = $data_prin['data'];
         	$album = $data_prin['album'];
		$user = $data_prin['id_user'];
                $cam = $data_prin['camera'];
                $mod = $data_prin['modelo'];
                $exp = $data_prin['expo'];
                $abert = $data_prin['abertura'];
                $is = $data_prin['iso'];
                $len = $data_prin['lente'];
		$id_user = $data_prin['id_user'];
                $foto = $data_prin['id'];
		$idfoto = $data_prin['id'];
                $lat = $data_prin['latitude'];
                $long = $data_prin['longitude'];
                                $_SESSION['foto'] = $foto;
                                $_SESSION['latitude'] = $lat;
                                $_SESSION['longitude'] = $long;
                                $_SESSION['album'] = $album;
	}
$query_cata = mysql_query("SELECT * FROM $tab_users WHERE id = '$id_user' ORDER BY id DESC LIMIT 1") or die(print(mysql_error()));
    while($data_cata = mysql_fetch_array($query_cata)){
       	$no = $data_cata ['nome'];
		$sob = $data_cata['sobrenome'];
        $cid = $data_cata['cidade'];
		$pai = $data_cata['pais'];
		$dono = $data_cata['login'];
		$email = $data_cata['email'];
    }
 $query_pro = mysql_query("SELECT * FROM $tab_users WHERE login = '$flog_login' ORDER BY id DESC LIMIT 1") or die(print(mysql_error()));
    while($data_pro = mysql_fetch_array($query_pro)){
       	$numer = $data_pro ['id'];
        $_SESSION['numer'] = $numer;
		$nono = $data_pro['nome'];
    }
global $tab_ranking;
$ip=$_SERVER['REMOTE_ADDR']; // pega o ip;
	if( $_SESSION['ip'] != $ip){
		mysql_query("UPDATE $tab_ranking SET visitas=visitas+1 WHERE id_user='$id_user' ") or die(print(mysql_error()));
		$_SESSION['ip'] = $ip;
	}

$ipuser=$_SERVER['REMOTE_ADDR'];
  $query_rank = mysql_query("SELECT * FROM tab_rank WHERE foto='$idfoto' AND pip='$ipuser' LIMIT 1") or die(print(mysql_error()));
    $num_rows = mysql_num_rows($query_rank);
	IF ($num_rows == 0) {
       mysql_query("INSERT INTO tab_rank (foto,pip) VALUES ('$idfoto','$ipuser')");
              $busc = mysql_query("SELECT * FROM tab_rank2 WHERE foto='$idfoto'");
              $lin = mysql_num_rows($busc);
              IF ($lin == 0){
              mysql_query("INSERT INTO tab_rank2 (foto,vista) VALUES ('$idfoto',1)");
              } else {
              mysql_query("UPDATE tab_rank2 SET vista=vista+1 WHERE foto='$idfoto'");
              }
}
$rata = mysql_query("SELECT * FROM tab_rank2 WHERE foto='$idfoto' LIMIT 1");
 while($ratarata = mysql_fetch_array($rata)){
       	$nvisit = $ratarata['vista'];
}
//$link = mysql_connect("localhost","clubecom_root","123456");
//if ($link) {
//$dbcon = mysql_select_db("clubecom_fotos",$link);
//}
//$query_res = "SELECT count(*) as dd, avg(rateval) as xx FROM tab_aval WHERE imagem='$idfoto'";
//$result1 - mysql_query($query_res);
//if($line = mysql_fetch_array($result1)) {
$query_res = mysql_query("SELECT count(*) as dd, avg(rateval) as xx FROM tab_aval WHERE imagem='$idfoto'");
while($linha = mysql_fetch_array($query_res)){
       	$count = $linha['dd'];
       	$rateval = $linha['xx'];
       	$tot = number_format($rateval, 1, ',', '');
}

$query_num = "SELECT * FROM tab_fotos WHERE album = '$album'";
$res = mysql_query($query_num);
$num_num = mysql_num_rows($res);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $titulo_flog." - ".$titulo; ?></title>
<?php
echo "
<STYLE>
a:link  {   font-style          :   normal;
        text-decoration         :   none; 
		color					:	#f5deb3;}
a:active{   font-style          :   normal;
        text-decoration         :   none;
		color					:	#f5deb3;}
a:visited{  text-decoration     :   none;
        font-style              :   normal; 
		color					:	#f5deb3;}
a:hover{    text-decoration     :   underline; 
		color					:	#ff4500;}
</STYLE>
<style type=\"text/css\">
<!--
body {
background-color : black;
}


.style1 {
	font-family: Arial, Verdana;
	font-size: 12px;
	color: #ffffff;
	font-weight: bold;
}
.style2 {
	font-family: Arial, Verdana;
	font-size: 11px;
	color: #ffffff;
	
}
.style3 {
	font-family: Arial, Verdana;
	font-size: 14px;
	color: #ffffff;
}
.style4 {
	font-family: Verdana, Arial;
	color: #ffffff;
	font-size: 14px;
	font-weight: bold;
}
.padrao {
        font-size: 10px;
        font-family: Arial, Verdana;
        color: #ffffff;
}
.style5 {
	font-family: Verdana, Arial;
	font-size: 12px;
	color: #ffffff;
}
.style6 {
	font-family: Arial, Verdana;
	font-size: 24px;
#	color: #696969;
        color: #ffffff;
}
.style7 {
	font-family: Arial, Verdana;
	font-size: 11px;
	color: #000000;
	
}
style8 {
	font-family: Verdana, Arial;
	font-size: 6px;
	color: #ffffff;
	}
-->
</style>";
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1
</head>

<link rel="stylesheet" href="../jquery/Gallery/css/blueimp-gallery.css">
<link rel="stylesheet" href="../jquery/Gallery/css/blueimp-gallery-indicator.css">
<link rel="stylesheet" href="../jquery/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="../jquery/Holdon/HoldOn.min.css">

<body bgcolor="#000000" align="center">
<span class="style1">
<table bgcolor="#000000" width="800" border="0" align="center">
  <tr>
<td height="120" colspan="12" valign="top"><div align="center"> 
              <? include ("../top_usuarios.php"); ?>
            </div></td>
    
  </tr>
  <tr>
     <td bgcolor="#000000" height="14" colspan="8" valign="top"><div align="right" class="style6">
              <div align="center"><b>Álbum de <?php echo $dono; ?></b></div></div></td>
  </tr>
  <tr>
    <td width="20" heigth="1"></td>
    <td width="600"></td>
    <td width="20"></td>
    <td width="15"></td>
    <td width="38"></td>
    <td width="38"></td>
    <td width="38"></td>
    <td width="30"></td>
  </tr>
  <tr>
    <td width="20"></td>
    <td width="650"><div align="center">
      <?php
		  echo "<span class=\"style4\">";
		  echo "<img src= \"maior.php?foto=$img_prin\" style='border-color:white' border='1'";
                  br2(2);
                  echo $principal;
		  br2(1);
		  echo "</span>";
		  echo "<span class=\"style1\">";
		  echo $coment_foto;
		  br2(1);
		  echo "Enviado em <b>".stamp2str($datapost, "/")."</b>&nbsp;&nbsp;&nbsp;Hora : <b>".stamp3str($datapost, ":")."</b>";
		  echo "</span>";
		  br2(1);
		  echo "<hr>";
		  ?>
         </div></td>
       <td></td>
       <td colspan="4" rowspan="16" align="center" valign="top">
       <?php
	           	if (IsSet ($flog_login)) {
			echo "<span class='style8'>Você está logado,<br>$nono</span>";
			
			} else {
			print ('
			<span class="style8">Logue-se para<br>comentar e votar:</span>
      <form id="form1" name="form1" method="post" action="lastpict.php?id='.$foto.'"><label><span class="style1">Login
          </span>
          <span class="style7">
          <input name="flog_login" type="text" class="style7" size="15" maxlength="30" />
          </span></label><br>
        <span class="style1"&nbsp;&nbsp;>Senha        </span>
        <span class="style1"><br>
        <label>
        <input name="flog_senha" type="password" class="style7" size="15" maxlength="30" />
        </label><br>
        <INPUT type=image
      src="../imag/imag/logar.jpg" align=absMiddle name=login></span> 
        </form>');
				}
		br();
			echo "<hr>";
		 echo "<div align='center' class='style3'>As Recentes<br><br>";       
		  
                  
		  echo "<span class=\"style2\">";
                  $query_ult = mysql_query("SELECT * FROM $tab_fotos WHERE id_user='$id_user' ORDER BY id DESC LIMIT 6") or die(print(mysql_error()));
			while($data_ult = mysql_fetch_array($query_ult)){
                          //      br2(1);
                         //       echo "Data : <b>".stamp2str($data_ult['data'], "/")."</b>";
			//	br2(1);
				echo "<a href = \"lastpict.php?id=".$data_ult['id']."\"><img src=\"mini.php?foto=".$data_ult['url']."\" style=border-color:\"#ffffff\" border=\"1\"></a>";
				br2(2);
			//	echo "Título : <b>".$data_ult['titulo']."</b>";
			//	br2(1);
			}
			echo "<a href = \"allpict.php?iduser=$id_user\"><H3><b>Ver todas ($num_num)</b></H3></a>";
                        echo "<a href = \"javascript:openGallery('$dono');\"><H3><b>Slideshow</b></H3></a>";
                        echo "<a href='../index.php'><H3>Página inicial</H3></a>";
			echo "</span>";
		  ?>
    </div></td>
    <td rowspan="16"></td>
  </tr>
  <tr>
    <td></td>
    <td width="600"><div align="center">
   <table width="600" border="0">
    <tr align="center">
    <td width="290" height="1" valign="top" class="padrao">

              <?php
        	if (IsSet ($flog_login)) {
                include("avalie.php");
                echo "<hr>";
                print ('
        		<form name="form1" method="post" action="savecmt.php">
    <div align="center"><font color="#ffffff" size="1" face="Verdana, Arial, Helvetica, sans-serif">
        <input type="hidden" name="id_foto" id="id_foto" value="'.$id_foto.'" />
		<input type="hidden" name="email_to" id="email_to" value="'.$email.'" />
		<input type="hidden" name="login_pict" id="login_pict" value="'.$dono.'" />
      <br>
      Comente esta foto :<br>
      <textarea name="com_com" id="com_com"></textarea>
    </p>
      <p>
        <input type="submit" name="Submit" value="Enviar Comentário">
		<p>
		');
		}  else {
   echo "<div align='center'><font size='2' font color='#ffffff' face ='Verdana, Arial'><b><u>Avaliação da foto</u></b></div>";
   if ($count < 1) {
   echo "<div align='center'><font size='2' font color='#ffff00' face ='Verdana, Arial'><b>Só usuário pode votar</b></div>";
   }
   if ($count == 1) {
   echo "<div align='center'><font size='2' font color='#ffff00' face ='Verdana, Arial'><b>$count&nbsp;voto&nbsp;&nbsp;=&nbsp;&nbsp;$tot&nbsp;pontos</b></div>";
      }
   if ($count > 1) {
   echo "<div align='center'><font size='2' font color='#ffff00' face ='Verdana, Arial'><b>$count&nbsp;votos, média de&nbsp;$tot&nbsp;pontos</b></div>";
   }
   echo "<div align='center'><font size='2' font color='#ffff00' face ='Verdana, Arial'><b>Visitas recebidas : $nvisit</b></div>";
   echo "<hr>";
       }
              echo "<div align='center'><font size='2' font color='#ffffff' face ='Verdana'><b><u>Comentários</u></b></div>";
			  global $tab_coments;
			  $query_coments = mysql_query("SELECT * FROM $tab_coments WHERE id_post = '$id_foto' ORDER BY id DESC");
			  while($data_coments = mysql_fetch_array($query_coments)){
                                echo "<span class=\"style5\"><a href=\"http://photosclic.com"."/"."{$data_coments['flog']}"."/"."allpict.php"."\" target=\"_self\"><b>".$data_coments['flog']."</b></a></span>";
                                br();
                                echo "<span class=\"style2\"><b>".$data_coments['comentario']."</b></span>";
				br(2);
			  }
			  echo "<hr>";
			  ?>
</p></td>

      <td width="20"></td>
  <td width="290" height="1" valign="top"><div align="center">
    <?php
echo "<font size='2' font color='#ffffff' face ='Verdana'><center><b><u>Dados do Autor</u></b></font>";
br();
echo "<font size='1' font color='#ffffff' face ='Verdana'><b>Nome: ".$no." ".$sob."</b></font>";
br();
echo "<font size='1' font color='#ffffff' face ='Verdana'><b>Cidade: $cid</b></font>";
br();
echo "<font size='1' font color='#ffffff' face ='Verdana'><b>País: $pai</b></font>";
br();	
br();
echo "<font size='2' font color='#ffffff' face ='Verdana'><center><b><u>Dados da Foto</u></b></font>";
br();
echo "<font size='1' font color='#ffffff' face ='Verdana'><b>Nome: $principal</b></font>";
br();
echo "<font size='1' font color='#ffffff' face ='Verdana'><b>Câmera: $cam</b></font>";
br();
echo "<font size='1' font color='#ffffff' face ='Verdana'><b>Modelo: $mod</b></font>";
br();
echo "<font size='1' font color='#ffffff' face ='Verdana'><b>Exposição: $exp</b></font>";
br();
echo "<font size='1' font color='#ffffff' face ='Verdana'><b>Abertura: $abert</b></font>";
br();
echo "<font size='1' font color='#ffffff' face ='Verdana'><b>ISO: $is</b></font>";
br();
echo "<font size='1' font color='#ffffff' face ='Verdana'><b>Dist.Focal: $len</b>mm</center></font>";
br();
if ($lat == 0) {}
else {
include('map.php');
}
br();

?>

<script src="../jquery/jquery-1.11.3.min.js"></script>
<script src="../jquery/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<script src="../jquery/Holdon/HoldOn.min.js"></script>


<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
    <div class="slides"></div>
    <h3 class="title"></h3>
    <a class="prev"><i class="fa fa-angle-left"></i> </a>
    <a class="next"><i class="fa fa-angle-right"></i></a>
    <a class="close"><i class="fa fa-times"></i></a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
</div>

  </div></td></tr>
  <tr>
    <td width="290"></td>
    <td width="20"></td>
    <td width="290"></td>

  </tr>
   
  </table></td>
      
      </td>
  </tr>
  <tr>
    <td></td>
    <td width="600"><div align="center"></div></td>
    <td colspan="1" rowspan="14"></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</tr>
</table>
</body>
</html>



<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

// funcoes que tratam do slideshow

function openGallery (user) {
   HoldOn.open();
	$.post ('../getPicts.php',
	   {album: user},
	   function (data) {
         HoldOn.close();
         var gallery = blueimp.Gallery(data, {slideshowInterval:3000} );

	
	   },
	   'json'
	  );
}

</SCRIPT>
