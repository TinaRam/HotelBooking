<?php
  require_once('db.php');

  $hotellnavn = $_GET["hotellnavn"];
  $romtype = $_GET["romtype"];
  $innsjekking = $_GET["innsjekking"];
  $utsjekking = $_GET["utsjekking"];

  if ($innsjekking >= $utsjekking) {
    print("Innsjekkingsdato må være før utsjekkingsdato.");
  } else if ($innsjekking < date("Y-m-d")) {
    print("Innsjekkingsdato kan ikke være før dagens dato.");
  } else {
    $sqlSetning = "SELECT COUNT(*) AS ledigeRom FROM rom WHERE hotellnavn = '$hotellnavn'
                        AND romtype = '$romtype'
                        AND romnr NOT IN (SELECT romnr FROM bestilling WHERE hotellnavn = '$hotellnavn' AND (datofra BETWEEN '$innsjekking' AND '$utsjekking'
                        OR datotil BETWEEN '$innsjekking' AND '$utsjekking'));";
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $antallRader = mysqli_num_rows($sqlResultat);

      $rad = mysqli_fetch_array($sqlResultat);
      $ledigeRom = $rad["ledigeRom"];

      if ($antallRader == 0) {
        print("<br><span class='ledigeRomTekst' id='ingenLedige'>Fant ingen ledige $romtype på denne datoen.</span>");
      } else {
        if ($ledigeRom == 0) {
          print("<br><span class='ledigeRomTekst' id='ingenLedige'>Fant ingen ledige $romtype på denne datoen.</span>");
        } else {
          print("<br><span class='ledigeRomTekst'><strong>Fant $ledigeRom ledige $romtype.</strong></span>");
        }
      }
    } else {
      print("Kan ikke koble til database");
    }
  }
?>
