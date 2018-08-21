<?php
  require_once("db.php");
  $hotellnavn = $_GET["hotellnavn"];
  $romtype = $_GET["romtype"];

  $sqlSetning = "SELECT rombilde FROM hotellromtype WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
  $sqlResultat = mysqli_query($db,$sqlSetning);

  if ($sqlResultat) {

      $rad = mysqli_fetch_array($sqlResultat);
      $rombilde = $rad["rombilde"];
      print("<br><img src='../../filer/$rombilde'>");

  } else {
    print("Kan ikke koble til database");
  }
?>
