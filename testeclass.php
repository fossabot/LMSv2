<?php

header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=\"download.pdf\"");

$tst = file_get_contents('http://172.16.47.152:8080/birt-report/frameset?__report=supplier_list.rptdesign&__toolbar=false&__format=pdf&rep_id=1&rep_auth=dcc6fce4572e5899f6eaaff13944504b');
header("Content-Length: " . strlen($tst));

echo ($tst);
?>