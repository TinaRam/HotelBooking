<?php
/*if ($sted && !$romtype) {
  $sqlSetning = "SELECT hrt.hotellnavn, h.sted, GROUP_CONCAT(hrt.romtype) AS romtype FROM hotellromtype AS hrt
                   INNER JOIN hotell AS h ON h.hotellnavn = hrt.hotellnavn
                   WHERE h.sted LIKE '%$sted%'
                   GROUP BY h.hotellnavn;";
} else if ($romtype && !$sted) {
  $sqlSetning = "SELECT hrt.hotellnavn, h.sted, GROUP_CONCAT(hrt.romtype) AS romtype FROM hotellromtype AS hrt
                   INNER JOIN hotell AS h ON h.hotellnavn = hrt.hotellnavn
                   WHERE hrt.romtype = '$romtype'
                   GROUP BY h.hotellnavn;";
} else if ($sted && $romtype) {
  $sqlSetning = "SELECT hrt.hotellnavn, h.sted, GROUP_CONCAT(hrt.romtype) AS romtype FROM hotellromtype AS hrt
                   INNER JOIN hotell AS h ON h.hotellnavn = hrt.hotellnavn
                   WHERE hrt.romtype = '$romtype'
                   AND h.sted LIKE '%$sted%'
                   GROUP BY h.hotellnavn;";
} else {
  $sqlSetning = "SELECT hrt.hotellnavn, h.sted, GROUP_CONCAT(hrt.romtype) AS romtype FROM hotellromtype AS hrt
                     INNER JOIN hotell AS h ON h.hotellnavn = hrt.hotellnavn
                     GROUP BY h.hotellnavn;";
}
*/

$sqlSetning = "SELECT hrt.hotellnavn, h.sted, GROUP_CONCAT(hrt.romtype) AS romtype FROM hotellromtype AS hrt
                 INNER JOIN hotell AS h ON h.hotellnavn = hrt.hotellnavn
                 WHERE ";

$flag = 0;
if(!empty($sted)){
   $sqlSetning .= " sted LIKE '%$sted%' ";
   $flag = 1;
}
if(!empty($romtype)){
   if($flag == 1){
        $sqlSetning .= " AND ";
   }
   $sqlSetning .= " romtype  = '$romtype' ";
   $flag = 1;
}
   $sqlSetning .= " GROUP BY h.hotellnavn; ";

 ?>
