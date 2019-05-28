<?php

$host = "localhost";
$login = "photoscl_root";
$senha = "raul1940";
$banco = "photoscl_fotos";
//    include "config.php";
//    include "dono.php";
$dono = $_POST ['album'];
$tabela = "tab_fotos"; //Tabela do Banco $banco
$connect = mysql_connect("$host", "$login", "$senha") or die("Erro na Conexao");
mysql_select_db("$banco");


$dado2 = mysql_query("SELECT concat('.',url_completa) as href, titulo as title, 'image/jpeg' as type FROM $tabela WHERE album='$dono' ORDER by id ASC");
$json = '[';
$json_array = array();

while ($row = mysql_fetch_array($dado2, MYSQL_ASSOC)) {
   //$path = 'http://www.photosclic.com/' . substr($row['href'], 1);
   array_push($json_array, $row);
    
   //$json = $json . '{href: "' . $row['href'] . '", title: "' . $row['title'] . '", type: "' . $row['type'] . '"},';
}

if (substr($json, -1, 1) == ',') {
   $json = substr($json, 0, -1);
}

$json = $json . ']';
print_r(json_encode($json_array));

//echo($json);
?>