<?php
  include("start.php");
  require_once("db.php");

  $die = "Kan ikke koble til database";
  $bestnr = $_GET["bestnr"];
  $navn = $_GET["hotellnavn"];

  $sqlSetning = "SELECT b.romnr, b.datofra, b.datotil, b.hotellnavn, (SELECT romtype FROM rom WHERE hotellnavn = b.hotellnavn AND romnr = b.romnr) AS romtype
                FROM bestilling AS b WHERE bestnr = '$bestnr' GROUP BY romtype;";
  $sqlResultat = mysqli_query($db,$sqlSetning);

  if ($sqlResultat) {
    $antallRader = mysqli_num_rows($sqlResultat);
    $rad = mysqli_fetch_array($sqlResultat);
    $datotil = $rad["datotil"];
    $datofra = $rad["datofra"];
    $hotellnavn = $rad["hotellnavn"];
    $romtype = $rad["romtype"];
  } else {
    print("Kan ikke koble til database");
  }
?>

<div id="endre">
  <h2>Endre bestilling</h2>
  <p>Det er kun dato som kan endres. Skal hotellnavn og/eller romtype endres kan du kansellere bestillingen og bestille på nytt.</p>

  <form method="post" id="endreBestilling" name="endreBestilling">
    Hotellnavn: <strong><?php echo $hotellnavn ?></strong><br>
    Romtype:<br> <strong>
    <?php
    print("$romtype<br>");
    for ($i=0; $i < $antallRader; $i++) {
      $rad = mysqli_fetch_array($sqlResultat);
      $romtype = $rad["romtype"];
      print("$romtype<br>");
    }
    ?></strong><br>
    Innsjekkingsdato <input type="date" id="innsjekking" name="innsjekking" value="<?php echo $datofra ?>" required
    <?php
      if ($datofra < date("Y-m-d")) {
        print("readonly class='inaktiv'");
      }
    ?>
    ><br>
    Utsjekkingsdato <input type="date" id="utsjekking" name="utsjekking" value="<?php echo $datotil ?>" required><br><br>


    <input type="submit" name="submit" id="submit" class="button" value="Endre bestilling">

  </form>
</div>

<?php
  if (isset($_POST["submit"])) {
    $innsjekking = $_POST["innsjekking"];
    $utsjekking = $_POST["utsjekking"];
    $gjennomført = false;

    if (!$innsjekking || !$utsjekking) {
      print("Velg inn- og utsjekkingsdato.");
    } else if ($innsjekking == $datofra && $utsjekking == $datotil) {
      print("Velg ny inn- og/eller utsjekkingsdato.");
    } else if ($utsjekking <= $innsjekking) {
      print("Innsjekkingsdato kan ikke være før eller på samme dag som utsjekkingsdato.");
    } else if ($innsjekking < date("Y-m-d")) {
      print("Innsjekkingsdato kan ikke være før dagens dato.");
    } else {
      $muligEndring = 0;

      $sqls = "SELECT b.romnr, b.datofra, b.datotil, b.hotellnavn, (SELECT romtype FROM rom WHERE hotellnavn = b.hotellnavn AND romnr = b.romnr) AS romtype
                    FROM bestilling AS b WHERE bestnr = '$bestnr' GROUP BY romtype;";
      $sqlr = mysqli_query($db,$sqls);

      if ($sqlr) {
        $ar = mysqli_num_rows($sqlr);

        for ($x=0; $x < $ar; $x++) { // FOR HVER ROMTYPE...
          $rad = mysqli_fetch_array($sqlr);
          $romtype = $rad["romtype"];

          $sqlSet = "SELECT b.romnr, b.datofra, b.datotil, b.hotellnavn, (SELECT romtype FROM rom WHERE hotellnavn = b.hotellnavn AND romnr = b.romnr) AS romtype
                    FROM bestilling AS b WHERE bestnr = '$bestnr'
                    AND (SELECT romtype FROM rom WHERE hotellnavn = b.hotellnavn AND romnr = b.romnr) = '$romtype';";
          $res = mysqli_query($db,$sqlSet);

          if ($res) {
            $rader = mysqli_num_rows($res);

            for ($y=0; $y < $rader; $y++) { // FOR HVERT ANTALL AV DEN ROMTYPEN...
              $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn'
                                    AND romtype = '$romtype'
                                    AND romnr NOT IN (SELECT romnr FROM bestilling WHERE hotellnavn = '$hotellnavn' AND (datofra BETWEEN '$innsjekking' AND '$utsjekking'
                                    OR datotil BETWEEN '$innsjekking' AND '$utsjekking') AND bestnr != '$bestnr');";
              $sqlResultat = mysqli_query($db,$sqlSetning);
              if ($sqlResultat) {
                $antallRader = mysqli_num_rows($sqlResultat);
                if ($antallRader >= $rader) {
                    $setningSql = "SELECT * FROM bestilling
                                      WHERE hotellnavn = '$hotellnavn'
                                      AND (SELECT romtype FROM rom WHERE hotellnavn = bestilling.hotellnavn AND romnr = bestilling.romnr) = '$romtype'
                                      AND datotil = '$datotil' AND datofra = '$datofra';";
                    $resultatSql = mysqli_query($db,$setningSql);

                    if ($resultatSql) {
                      $antallRader = mysqli_num_rows($resultatSql);

                      if ($antallRader == 0) {
                        $ledig = 1;
                      } else {
                        $ledig = 0;
                        $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn'
                                              AND romtype = '$romtype'
                                              AND romnr NOT IN (SELECT romnr FROM bestilling WHERE hotellnavn = '$hotellnavn' AND (datofra BETWEEN '$innsjekking' AND '$utsjekking'
                                              OR datotil BETWEEN '$innsjekking' AND '$utsjekking'))
                                              limit 1;";
                        $sqlResultat = mysqli_query($db,$sqlSetning);

                        if ($sqlResultat) {
                          $funker = 1;
                        } else {
                          echo $die;
                        }
                      }
                    }
                } else {
                  $muligEndring = 0;
                  $funker = 0;
                  exit("Finnes ikke nok ledige rom av ønsket romtype");
                }
              }
            }
          } else {
            echo $die;
          }

        }
      } else {
        echo $die;
      }
  }
  if ($muligEndring == 1) {
    print("Kan endre");
  } else {
    print("Kan ikke endre");
  }
  if ($ledig == 1) {
    $sqlSetning = "UPDATE bestilling SET datofra = '$innsjekking', datotil = '$utsjekking' WHERE bestnr = '$bestnr';";
    $sqlResultat = mysqli_query($db,$sqlResultat);

    if ($sqlResultat) {
      print("Bestillingen er endret");
    } else {
      echo $die;
    }
  }
  if ($funker == 1) {
    for ($x=0; $x < $ar; $x++) { // FOR HVER ROMTYPE...
      for ($y=0; $y < $rader; $y++) { // FOR HVERT ANTALL AV DEN ROMTYPEN...
    $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn'
                          AND romtype = '$romtype'
                          AND romnr NOT IN (SELECT romnr FROM bestilling WHERE hotellnavn = '$hotellnavn' AND (datofra BETWEEN '$innsjekking' AND '$utsjekking'
                          OR datotil BETWEEN '$innsjekking' AND '$utsjekking'))
                          limit 1;";
    $sqlResultat = mysqli_query($db,$sqlSetning);
    if ($sqlResultat) {

      $rad = mysqli_fetch_array($sqlResultat);
      $nyttRomnr = $rad["romnr"];

      $sqlSetning = "UPDATE bestilling SET datofra = '$innsjekking', datotil = '$utsjekking', romnr = '$nyttRomnr' WHERE bestnr = '$bestnr';";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        print("Bestillingen er endret");
        $muligEndring = 1;
      } else {
        echo $die;
      }
  }}}
}
}


  include("slutt.php");
?>
