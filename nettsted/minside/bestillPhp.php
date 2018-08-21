<?php
if (isset($_POST["submit"])) {
    $hotellnavn = $_POST["hotellnavn"];
    $innsjekking = $_POST["innsjekking"];
    $utsjekking = $_POST["utsjekking"];
    $romtype = $_POST["romtype"];
    $antallRom = $_POST["antall"];
    $brukernavn = $_SESSION['brukernavn'];

    if (!$hotellnavn || !$innsjekking || !$utsjekking || !$romtype || !$antallRom) {
      print("Vennligst velg hotell og antall rom.");
    } else {
      // SJEKK OM DET FINNES BESTILLINGER PÅ SAMME HOTELL, SAMME ROM, SAMME DAG
      $sqlSetning = "SELECT b.radnr, b.datofra, b.datotil, b.hotellnavn, b.romtype, SUM(b.antall) AS antall,
                                                    hrt.antallrom, hrt.antallrom - SUM(b.antall) AS ledigeRom
                        FROM bestilling AS b
                        INNER JOIN hotellromtype AS hrt ON b.hotellnavn = hrt.hotellnavn AND b.romtype = hrt.romtype
                        WHERE b.datofra = '$innsjekking'
                        AND b.datotil = '$utsjekking'
                        AND b.hotellnavn = '$hotellnavn'
                        AND b.romtype = '$romtype';";

      $sqlResultat = mysqli_query($db,$sqlSetning) or die ("Kan ikke hente fra database.");
      $antallRader = mysqli_num_rows($sqlResultat);

      $rad = mysqli_fetch_array($sqlResultat);
      $ledigeRom = $rad["ledigeRom"];
      $radnr = $rad["radnr"];

      if (!$radnr) {
        //INGEN BESTILLINGER. SJEKK OM HOTELLET FINNES OG HAR DET ROMMMET
        $sqlSetning = "SELECT hrt.hotellnavn, h.sted, GROUP_CONCAT(hrt.romtype) AS romtype FROM hotellromtype AS hrt
      	                   INNER JOIN hotell AS h ON h.hotellnavn = hrt.hotellnavn
                           WHERE h.hotellnavn = '$hotellnavn' AND hrt.romtype = '$romtype'
                           GROUP BY h.hotellnavn;";
        $sqlResultat = mysqli_query($db,$sqlSetning) or die ("Kan ikke hente fra database.");
        $antallRader = mysqli_num_rows($sqlResultat);

        if ($antallRader == 0) {
          //HOTELLET HAR IKKE ROMTYPEN
          print("Dette hotellet tilbyr ikke rom av typen $romtype.");
        } else {
          //HOTELLET FINNES OG HAR ROMTYPEN
          $sqlSetning = "INSERT INTO bestilling (brukernavn,datofra,datotil,hotellnavn,romnr) VALUES ('$brukernavn','$innsjekking','$utsjekking','$hotellnavn','$romnr')";
          mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; registrere data i databasen");
          print("Bestillingen er gjennomført! Ingen andre bestillinger finnes.");
        }
      } else {
        //HOTELLET HAR BESTILLINGER PÅ SAMME ROM PÅ SAMME DATO
        if ($ledigeRom >= $antallRom) {
          $sqlSetning = "INSERT INTO bestilling (brukernavn,datofra,datotil,hotellnavn,romnr) VALUES ('$brukernavn','$innsjekking','$utsjekking','$hotellnavn','$romnr')";
          mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; registrere data i databasen");
          print("Bestillingen er gjennomført! Bestillinger finnes på samme dato. Ledige rom: $ledigeRom");
        } else {
          //HOTELLET HAR IKKE LEDIG ROM PÅ DEN DATOEN
          print("Dette hotellet har ikke $antallRom $romtype ledig for denne datoen. Alle er tatt.");
        }
      }
    }
  }
?>
