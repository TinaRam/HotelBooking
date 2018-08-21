<?php
  include("start.php");
  require_once("db.php");

  $die = "Kan ikke koble til database";
  $radnr = $_GET["radnr"];
  $navn = $_GET["hotellnavn"];
  $antallRom = $_GET["antallRom"];

  $sqlSetning = "SELECT b.romnr, b.datofra, b.datotil, b.hotellnavn, (SELECT romtype FROM rom WHERE hotellnavn = b.hotellnavn AND romnr = b.romnr) AS romtype
                        FROM bestilling AS b WHERE radnr = '$radnr';";
  $sqlResultat = mysqli_query($db,$sqlSetning);

  if ($sqlResultat) {
    $rad = mysqli_fetch_array($sqlResultat);
    $datotil = $rad["datotil"];
    $datofra = $rad["datofra"];
    $hotellnavn = $rad["hotellnavn"];
    $romtype = $rad["romtype"];

  } else {
    print("Kan ikke koble til database");
  }
?>

<script type="text/javascript">
function visSlett() {
  document.getElementById("slett").style.display = "block";
}
</script>

<div id="endre">
  <h2>Endre bestilling</h2>
  <p>Det er kun dato som kan endres. Skal hotellnavn og/eller romtype endres kan du kansellere bestillingen og bestille på nytt.</p>

  <form method="post" id="endreBestilling" name="endreBestilling">
    Hotellnavn: <strong><?php echo $hotellnavn ?></strong><br>
    Romtype: <strong><?php echo $romtype ?></strong><br>
    Innsjekkingsdato <input type="text" class="datepicker" id="innsjekking" name="innsjekking" value="<?php echo $datofra ?>" autocomplete="off" required
    <?php
      if ($datofra < date("Y-m-d")) {
        print("readonly class='inaktiv'");
      }
    ?>
    ><br>
    Utsjekkingsdato <input type="text" class="datepicker" id="utsjekking" name="utsjekking" value="<?php echo $datotil ?>" autocomplete="off" required><br><br>

    <?php
      if ($antallRom > 1) {
        print("Bestillingen har $antallRom rombestillinger. Hvor mange rom skal endres?<br>");

        print("<select name='velgAntallRom'>");

        for ($i = $antallRom; $i > 0; $i--) {
          print("<option value='$i'>$i</option>");
        }
        print("</select><br><br>");
      } else {
        print("<input type='hidden' name='velgAntallRom' value='1'>");
      }
    ?>

    <input type="submit" name="submit" id="submit" class="button" value="Endre bestilling">

  </form>
</div>
<div id="slett">
  <h2>Kanseller bestilling</h2>
  <form method="post" id="slett" name="slett">
    <?php
      if ($antallRom > 1) {
        print("Bestillingen har $antallRom rombestillinger. Hvor mange rom skal kanselleres?<br>");

        print("<select name='velgAntallRom'>");

        for ($i = $antallRom; $i > 0; $i--) {
          print("<option value='$i'>$i</option>");
        }
        print("</select><br><br>");
      } else {
        print("<input type='hidden' name='velgAntallRom' value='1'>");
      }
    ?>
    <input type="submit" name="submitSlett" id="submit" class="button red" value="Kanseller bestilling" onClick="return confirm('Er du sikker på at du vil slette bestillingen? Det kan ikke gjøres om!');">
  </form>
</div>

<?php
  if (isset($_POST["submit"])) {
    $innsjekking = $_POST["innsjekking"];
    $utsjekking = $_POST["utsjekking"];
    $velgAntallRom = $_POST["velgAntallRom"];
    $gjennomført = false;
    $ledigRom = true;

    if (!$innsjekking || !$utsjekking) {
      print("Velg inn- og utsjekkingsdato.");
    } else if ($innsjekking == $datofra && $utsjekking == $datotil) {
      print("Velg ny inn- og/eller utsjekkingsdato.");
    } else if ($utsjekking <= $innsjekking) {
      print("Innsjekkingsdato kan ikke være før eller på samme dag som utsjekkingsdato.");
    } else if ($innsjekking < date("Y-m-d")) {
      print("Innsjekkingsdato kan ikke være før dagens dato.");
    } else {
      if ($velgAntallRom > 1) {
        $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn'
                              AND romtype = '$romtype'
                              AND romnr NOT IN (SELECT romnr FROM bestilling WHERE hotellnavn = '$hotellnavn' AND (datofra BETWEEN '$innsjekking' AND '$utsjekking'
                              OR datotil BETWEEN '$innsjekking' AND '$utsjekking'));";
        $sqlResultat = mysqli_query($db,$sqlSetning);

        if ($sqlResultat) {
          $antallRader = mysqli_num_rows($sqlResultat);
          if ($antallRader >= $velgAntallRom) {
            for ($r=0; $r < $velgAntallRom; $r++) {
              $sqlSetning = "SELECT * FROM bestilling
                                WHERE hotellnavn = '$hotellnavn'
                                AND (SELECT romtype FROM rom WHERE hotellnavn = bestilling.hotellnavn AND romnr = bestilling.romnr) = '$romtype'
                                AND datotil = '$datotil' AND datofra = '$datofra';";
              $sqlResultat = mysqli_query($db,$sqlSetning);

              if ($sqlResultat) {
                $antallRader = mysqli_num_rows($sqlResultat);

                for ($i=0; $i < $antallRader; $i++) {
                  $rad = mysqli_fetch_array($sqlResultat);
                  $radnr = $rad["radnr"];

                  $sqlSetning = "SELECT *, (SELECT romtype FROM rom WHERE hotellnavn = bestilling.hotellnavn AND romnr = bestilling.romnr) AS romtype
                                      FROM bestilling
                                      WHERE hotellnavn = '$hotellnavn'
                                      AND (SELECT romtype FROM rom WHERE hotellnavn = bestilling.hotellnavn AND romnr = bestilling.romnr) = '$romtype'
                                      AND (datofra BETWEEN '$datofra' AND '$datotil' OR datotil BETWEEN '$datofra' AND '$datotil');";
                  $sqlResultat = mysqli_query($db,$sqlSetning);

                  if ($sqlResultat) {
                    $antallRader = mysqli_num_rows($sqlResultat);

                    if ($antallRader == 0) {
                        $sqlSetning = "UPDATE bestilling SET datofra = '$innsjekking', datotil = '$utsjekking'
                                      WHERE radnr = '$radnr'";
                        $sqlResultat = mysqli_query($db,$sqlSetning);

                        if ($sqlResultat) {
                          $gjennomført = true;
                        } else {
                          echo $die;
                        }
                    } else {
                        // Finn ut hvilket rom som er neste ledige rom
                        $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn'
                                              AND romtype = '$romtype'
                                              AND romnr NOT IN (SELECT romnr FROM bestilling WHERE hotellnavn = '$hotellnavn' AND (datofra BETWEEN '$innsjekking' AND '$utsjekking'
                                              OR datotil BETWEEN '$innsjekking' AND '$utsjekking'))
                                              limit 1;";
                        $sqlResultat = mysqli_query($db,$sqlSetning);

                        if ($sqlResultat) {
                          $antallRader = mysqli_num_rows($sqlResultat);

                          if ($antallRader == 0) {
                            $ledigRom = false;
                          } else { // Book bestilling på det ledige rommet

                            for ($j=0; $j < $antallRader; $j++) {
                              $rad = mysqli_fetch_array($sqlResultat);
                              $nyttNr = $rad["romnr"];

                              $setning = "UPDATE bestilling SET datofra = '$innsjekking', datotil = '$utsjekking', romnr = '$nyttNr'
                                                    WHERE radnr = $radnr;";
                              $restultat = mysqli_query($db,$setning);

                              if ($restultat) {
                                $gjennomført = true;
                              } else {
                                echo $die;
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
              }
            }
          } else {
            print("Finnes ikke nok ledige rom");
          }
        }
      } else {
        $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn'
                              AND romtype = '$romtype'
                              AND romnr NOT IN (SELECT romnr FROM bestilling WHERE hotellnavn = '$hotellnavn' AND (datofra BETWEEN '$innsjekking' AND '$utsjekking'
                              OR datotil BETWEEN '$innsjekking' AND '$utsjekking'));";
        $sqlResultat = mysqli_query($db,$sqlSetning);

        if ($sqlResultat) {
          $antallRader = mysqli_num_rows($sqlResultat);

          if ($antallRader == 0) {
            print("Ikke nok ledige rom");
          } else {
              $sqlSetning = "SELECT * FROM bestilling
                                WHERE hotellnavn = '$hotellnavn'
                                AND (SELECT romtype FROM rom WHERE hotellnavn = bestilling.hotellnavn AND romnr = bestilling.romnr) = '$romtype'
                                AND datotil = '$datotil' AND datofra = '$datofra';";
              $sqlResultat = mysqli_query($db,$sqlSetning);

              if ($sqlResultat) {
                $antallRader = mysqli_num_rows($sqlResultat);

                for ($i=0; $i < $antallRader; $i++) {
                  $rad = mysqli_fetch_array($sqlResultat);
                  $radnr = $rad["radnr"];

                  $sqlSetning = "SELECT *, (SELECT romtype FROM rom WHERE hotellnavn = bestilling.hotellnavn AND romnr = bestilling.romnr) AS romtype
                                      FROM bestilling
                                      WHERE hotellnavn = '$hotellnavn'
                                      AND (SELECT romtype FROM rom WHERE hotellnavn = bestilling.hotellnavn AND romnr = bestilling.romnr) = '$romtype'
                                      AND (datofra BETWEEN '$datofra' AND '$datotil' OR datotil BETWEEN '$datofra' AND '$datotil');";
                  $sqlResultat = mysqli_query($db,$sqlSetning);

                  if ($sqlResultat) {
                    $antallRader = mysqli_num_rows($sqlResultat);

                    if ($antallRader == 0) {
                        $sqlSetning = "UPDATE bestilling SET datofra = '$innsjekking', datotil = '$utsjekking'
                                      WHERE radnr = '$radnr'";
                        $sqlResultat = mysqli_query($db,$sqlSetning);

                        if ($sqlResultat) {
                          $gjennomført = true;
                        } else {
                          echo $die;
                        }
                    } else {
                        // Finn ut hvilket rom som er neste ledige rom
                        $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn'
                                              AND romtype = '$romtype'
                                              AND romnr NOT IN (SELECT romnr FROM bestilling WHERE hotellnavn = '$hotellnavn' AND (datofra BETWEEN '$innsjekking' AND '$utsjekking'
                                              OR datotil BETWEEN '$innsjekking' AND '$utsjekking'))
                                              limit 1;";
                        $sqlResultat = mysqli_query($db,$sqlSetning);

                        if ($sqlResultat) {
                          $antallRader = mysqli_num_rows($sqlResultat);

                          if ($antallRader == 0) {
                            $ledigRom = false;
                          } else { // Book bestilling på det ledige rommet

                            for ($j=0; $j < $antallRader; $j++) {
                              $rad = mysqli_fetch_array($sqlResultat);
                              $nyttNr = $rad["romnr"];

                              $setning = "UPDATE bestilling SET datofra = '$innsjekking', datotil = '$utsjekking', romnr = '$nyttNr'
                                                    WHERE radnr = $radnr;";
                              $restultat = mysqli_query($db,$setning);

                              if ($restultat) {
                                $gjennomført = true;
                              } else {
                                echo $die;
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
              }

          }
        } else {
          echo $die;
        }
      }
    }
    if ($gjennomført) {
      print("Bestilling er endret");
    } else if (!$ledigRom) {
      print("Fant ingen ledige rom på ønsket dato");
    }
  }

  if (isset($_POST["submitSlett"])) {
    $velgAntallRom = $_POST["velgAntallRom"];
    $gjennomført = false;

    if ($velgAntallRom > 1) {
      $sqlSetning = "SELECT * FROM bestilling
                        WHERE hotellnavn = '$hotellnavn'
                        AND (SELECT romtype FROM rom WHERE hotellnavn = bestilling.hotellnavn AND romnr = bestilling.romnr) = '$romtype'
                        AND datotil = '$datotil' AND datofra = '$datofra'
                        limit $velgAntallRom;";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        $antallRader = mysqli_num_rows($sqlResultat);


        for ($i=0; $i < $antallRader; $i++) {
          $rad = mysqli_fetch_array($sqlResultat);
          $radnr = $rad["radnr"];

          $sqlSetning = "DELETE FROM bestilling WHERE radnr = '$radnr';";
          $sqlResult = mysqli_query($db,$sqlSetning);

          if ($sqlResult) {
            $gjennomført = true;
          } else {
            echo $die;
          }
        }
      }
    } else {
      $sqlSetning = "DELETE FROM bestilling WHERE radnr = '$radnr';";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        $gjennomført = true;
      } else {
        echo $die;
      }
    }
    if ($gjennomført) {
      print("Bestilling er kansellert.");
    }
  }

  include("slutt.php");
?>
