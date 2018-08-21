
<?php
  $sqlSetning = "INSERT INTO bestilling (brukernavn, datofra, datotil, hotellnavn, romnr) VALUES ";

  $romtype = $_POST["romtype"];
  $antallRom = $_POST["antallRom"];

  for ($i=0; $i < count($romtype); $i++) {
    

    $sql = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn'
                          AND romtype = '$romtype[$i]'
                          AND romnr NOT IN (SELECT romnr FROM bestilling WHERE hotellnavn = '$hotellnavn' AND (datofra BETWEEN '$innsjekking' AND '$utsjekking'
                          OR datotil BETWEEN '$innsjekking' AND '$utsjekking'))
                          limit 1;";
    $sqlResultat = mysqli_query($db,$sql);

    if ($sqlResultat) {
      $antallRader = mysqli_num_rows($sqlResultat);

      if ($antallRader == 0) {
        print("Fant ingen ledige rom på $hotellnavn på denne datoen. ");
      } else {
        for ($j=0; $j < $antallRader; $j++) {
          $rad = mysqli_fetch_array($sqlResultat);
          $nyttNr = $rad["romnr"];
        }
      }
    }
    $sqlSetning .= " ( ";
    $sqlSetning .= " '$brukernavn', '$innsjekking', '$utsjekking', '$hotellnavn', '$nyttNr' ";
    $sqlSetning .= " ) ";

    if ($i != count($romtype) - 1) {
      $sqlSetning .= " , ";
    }
  }
  $sqlSetning .= " ; ";

  echo $sqlSetning;
?>
