<?php
  $hotellnavn = $_GET["hotellnavn"];

  include("db.php");

  if (!$hotellnavn) {
    $sqlSetning = "SELECT hotellnavn FROM hotellromtype GROUP BY hotellnavn;";
  } else {
    $sqlSetning = "SELECT hotellnavn FROM hotellromtype WHERE hotellnavn LIKE '%$hotellnavn%' GROUP BY hotellnavn";
  }
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
    $antallRader = mysqli_num_rows($sqlResultat);

    for ($i=0; $i < $antallRader; $i++) {
      $rad = mysqli_fetch_array($sqlResultat);
      $hotellnavn = $rad["hotellnavn"];
      print("<br><button type='button' class='buttonForslag' id='slettHotell' onClick='pressRomtype(this.value)' value='$hotellnavn'>$hotellnavn</button>");
    }
    } else {
        print("Kan ikke koble til database");
    }

?>