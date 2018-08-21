<?php
  require_once("db.php");
  $hotellnavn = $_GET["hotellnavn"];

  $sqlSetning = "SELECT romtype FROM hotellromtype WHERE hotellnavn = '$hotellnavn';";
  $sqlResultat = mysqli_query($db,$sqlSetning);

  if ($sqlResultat) {
    $antallRader = mysqli_num_rows($sqlResultat);

    print("<option value=''>Velg romtype</option>");

    for ($i=0; $i < $antallRader; $i++) {
      $rad = mysqli_fetch_array($sqlResultat);
      $romtype = $rad["romtype"];

      print("<option value='$romtype'>$romtype</option>");
    }
  } else {
    print("<option value=''>Kan ikke koble til database</option>");
  }
?>
