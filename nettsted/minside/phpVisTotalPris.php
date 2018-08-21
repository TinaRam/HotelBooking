<?php
  require_once('db.php');

  $hotellnavn = $_GET["hotellnavn"];
  $romtype = $_GET["romtype"];
  $antallRom = $_GET["antallRom"];
  $innsjekking = $_GET["innsjekking"];
  $utsjekking = $_GET["utsjekking"];

  $dato1 = date_create("$innsjekking");
  $dato2 = date_create("$utsjekking");
  $forskjell = date_diff($dato1,$dato2);

  $antallNetter = $forskjell -> format('%a');

  $sqlSetning = "SELECT pris, pris * $antallRom AS totalPris FROM hotellromtype WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
  $sqlResultat = mysqli_query($db,$sqlSetning);

  if ($sqlResultat) {
    $rad = mysqli_fetch_array($sqlResultat);
    $prisPerNatt = $rad["totalPris"];
    $pris = $rad["pris"];
    $totalPris = $prisPerNatt * $antallNetter;

    if ($antallNetter == 1) {
      print("<br>Totalpris $antallNetter natt");
    } else {
      print("<br>Totalpris $antallNetter netter");
    }
    print("<br><strong>$totalPris,-</strong>");
  } else {
    print("Kan ikke koble til database");
  }
?>
