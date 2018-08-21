<?php
  $sorter = $_GET["sorter"];
  require_once("db.php");


  if ($sorter == "Hotellnavn") {
    $sqlSetning .= " ORDER BY h.hotellnavn ";
  } else if ($sorter == "Sted") {
    $sqlSetning .= " ORDER BY h.sted ";
  } else if ($sorter == "Pris lav-høy") {
    $sqlSetning .= " ORDER BY MIN(hrt.pris) ASC ";
  } else if ($sorter == "Pris høy-lav") {
    $sqlSetning .= " ORDER BY MIN(hrt.pris) DESC ";
  }

  $sqlResultat = mysqli_query($db,$sqlSetning);

  if ($sqlResultat) {
    $antallRader = mysqli_num_rows($sqlResultat);

    include("printHotell.php");
  }
?>
