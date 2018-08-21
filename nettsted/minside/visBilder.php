<?php
  $hotellnavn = $_GET["verdi"];

  require_once('db.php');

  $sqlSetning = "SELECT bilde FROM hotell WHERE hotellnavn = '$hotellnavn' AND bilde IS NOT NULL;";
  $sqlResultat = mysqli_query($db,$sqlSetning);

  if ($sqlResultat) {
    $antallRader = mysqli_num_rows($sqlResultat);

    if ($antallRader == 0) {

    } else {
      $rad = mysqli_fetch_array($sqlResultat);
      $bilde = $rad["bilde"];
      print("<img src='../../filer/$bilde'>");
    }
  } else {
    print("Kan ikke koble til database");
  }

?>
