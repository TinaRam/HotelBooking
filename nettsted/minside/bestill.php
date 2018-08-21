<?php 
  for ($i=0; $i < $antallRader; $i++) {
    $rad = mysqli_fetch_array($sqlResultat);
    $romnr = $rad["romnr"];

    if (in_array($romnr,$opptattRom)) {

    } else {
      $i = $antallRader;

      $sqlSetning = "INSERT INTO bestilling (brukernavn, datofra, datotil, hotellnavn, romnr) VALUES
                              ('minside', '$innsjekking', '$utsjekking', '$hotellnavn', '$romnr');";

      mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; registrere data i databasen");
      print("Booking gjennomført!");
    }
  }
?>
