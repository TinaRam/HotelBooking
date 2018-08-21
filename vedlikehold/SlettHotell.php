<?php
  include("start.php");
  require_once("dynamiske_funksjoner.php");
  $die = "Kan ikke koble til database";
?>

<h3>Slett hotell</h3>
<form method="post" id="slettHotellForm" name="slettHotellForm" onSubmit="return confirm('Er du sikker på at du vil slette hotellet? Dette kan ikke gjøres om!');">
  Hotellnavn <select name="hotellnavn" id="hotellnavn" required>
                <option value="">Velg hotell</option>
                <?php listeboksHotell(); ?>
              </select>
<input type="submit" id="submit" name="submit" value="Slett hotell" onclick="return slettHotellValidering()">
</form>
<div id="feilmelding"></div>
<?php
  if (isset($_POST["submit"])) {
    $hotellnavn = $_POST["hotellnavn"];

    if (!$hotellnavn) {
      print("Velg hotellnavn fra listeboksen");
    } else {

          $sqlSetning = "SELECT * FROM hotell WHERE hotellnavn = '$hotellnavn';";
          $sqlResultat = mysqli_query($db,$sqlSetning);

          if ($sqlResultat) {
            $antallRader = mysqli_num_rows($sqlResultat);

            if ($antallRader == 0) {
              print("Fant ikke angitt hotell.");
            } else {
              $sqlSetning = "SELECT * FROM hotellromtype WHERE hotellnavn = '$hotellnavn';";
              $sqlResultat = mysqli_query($db,$sqlSetning);

              if ($sqlResultat) {
                $antallRader = mysqli_num_rows($sqlResultat);

                if ($antallRader == 0) {
                  $sqlSetning = "SELECT bilde FROM hotell WHERE hotellnavn = '$hotellnavn'";
                  $sqlResultat = mysqli_query($db,$sqlSetning);

                  if ($sqlResultat) {
                    $antallRader = mysqli_num_rows($sqlResultat);

                    for ($i=0; $i < $antallRader; $i++) {
                      $rad = mysqli_fetch_array($sqlResultat);
                      $bilde = $rad["bilde"];
                      $filnavn = "../filer/$bilde";

                      if ($bilde) {
                        unlink($filnavn);
                      }
                    }
                  }
                  $sqlSetning = "DELETE FROM hotell WHERE hotellnavn = '$hotellnavn';";
                  $sqlResultat = mysqli_query($db,$sqlSetning);

                  if ($sqlResultat) {
                    print("Hotellet er slettet");
                  } else {
                    echo $die;
                  }
                } else {
                  $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn';";
                  $sqlResultat = mysqli_query($db,$sqlSetning);

                  if ($sqlResultat) {
                    $antallRader = mysqli_num_rows($sqlResultat);

                    if ($antallRader == 0) {
                      // FINNES I HOTELLROMTYPE
                      $sqlSetning = "SELECT * FROM hotellromtype WHERE hotellnavn = '$hotellnavn';";
                      $sqlResultat = mysqli_query($db,$sqlSetning);

                      if ($sqlResultat) {
                        $antallRader = mysqli_num_rows($sqlResultat);

                        print("<font color='blue'><b> <br>$hotellnavn er registrert i hotellromtype-tabellen. <br><br>Du kan velge å slette hotellet likevel, men da slettes også alle de aktuelle radene.</b><br>Se igjennom innholdet og bekreft</b></font>");
                        print("<table class='visTabell'>");
                        print("<tr><th>Rombilde</th><th>Hotellnavn</th><th>Romtype</th><th>Pris</th><th>Antall rom</th></tr>");

                        for ($i=0; $i < $antallRader; $i++) {
                          $rad = mysqli_fetch_array($sqlResultat);
                          $hotellnavn = $rad["hotellnavn"];
                          $romtype = $rad["romtype"];
                          $pris = $rad["pris"];
                          $rombilde = $rad["rombilde"];
                          $antallrom = $rad["antallrom"];

                          print("<tr><td><img src=../filer/$rombilde></td><td>$hotellnavn</td><td>$romtype</td><td>$pris</td><td>$antallrom</td></tr>");
                        }

                        print("</table>");

                        ?>
                        <form method="post" onSubmit="return confirm('Er du sikker på at du vil slette fra begge tabellene? Dette kan ikke gjøres om!');">
                          <input type="hidden" value="<?php echo $hotellnavn ?>" name="hotellnavn">
                          <input type="submit" class="button red" name="slettHotellromtype" value="Slett fra begge tabellene">
                        </form>
                        <?php

                      } else {
                        echo $die;
                      }
                    } else {
                      $sqlSetning = "SELECT * FROM bestilling WHERE hotellnavn = '$hotellnavn';";
                      $sqlResultat = mysqli_query($db,$sqlSetning);

                      if ($sqlResultat) {
                        $antallRader = mysqli_num_rows($sqlResultat);

                        if ($antallRader == 0) {
                          // SPØR OM SLETT, FINNES I ROM
                          print("<font color='blue'><b><br>$hotellnavn finnes i hotellromtype- og romtabellen.<br><br> </b></font>");
                          print("<font color='blue'><b>Du kan velge å slette hotellet likevel, men da slettes også alle de aktuelle radene.<br>Se igjennom innholdet og bekreft</b></font>");

                          $sqlSetning = "SELECT * FROM hotellromtype WHERE hotellnavn = '$hotellnavn';";
                          $sqlResultat = mysqli_query($db,$sqlSetning);

                          if ($sqlResultat) {
                            $antallRader = mysqli_num_rows($sqlResultat);

                            print("<h4>Hotellromtype</h4>");
                            print("<table class='visTabell'>");
                            print("<tr><th>Rombilde</th><th>Hotellnavn</th><th>Romtype</th><th>Pris</th><th>Antall rom</th></tr>");

                            for ($i=0; $i < $antallRader; $i++) {
                              $rad = mysqli_fetch_array($sqlResultat);
                              $hotellnavn = $rad["hotellnavn"];
                              $romtype = $rad["romtype"];
                              $pris = $rad["pris"];
                              $rombilde = $rad["rombilde"];
                              $antallrom = $rad["antallrom"];

                              print("<tr><td><img src=../filer/$rombilde></td><td>$hotellnavn</td><td>$romtype</td><td>$pris</td><td>$antallrom</td></tr>");
                            }
                            print("</table>");

                            $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn';";
                            $sqlResultat = mysqli_query($db,$sqlSetning);

                            if ($sqlResultat) {
                              $antallRader = mysqli_num_rows($sqlResultat);

                              print("<h4>Rom</h4>");
                              print("<table class='visTabell'>");
                              print("<tr><th>Hotellnavn</th><th>Romtype</th><th>Romnr</th></tr>");

                              for ($i=0; $i < $antallRader; $i++) {
                                $rad = mysqli_fetch_array($sqlResultat);
                                $hotellnavn = $rad["hotellnavn"];
                                $romtype = $rad["romtype"];
                                $romnr = $rad["romnr"];

                                print("<tr><td>$hotellnavn</td><td>$romtype</td><td>$romnr</td></tr>");
                              }
                              print("</table>");

                              ?>
                              <form method="post" onSubmit="return confirm('Er du sikker på at du vil slette fra alle tabellene? Dette kan ikke gjøres om!');">
                                <input type="hidden" value="<?php echo $hotellnavn ?>" name="hotellnavn">
                                <input type="submit" class="button red" name="slettHotellromtypeOgRom" value="Slett fra alle tabellene">
                              </form>
                              <?php
                            }
                          }
                        } else {
                          // HOTELLET HAR BESTILLINGER
                          print("<font color='blue'><b><br>$hotellnavn finnes i hotellromtype, rom- og bestillingstabellen. <br><br>Du kan velge å slette hotellet likevel, men da slettes også alle de aktuelle radene.</b><br>Se igjennom innholdet og bekreft</b></font>");

                          $sqlSetning = "SELECT * FROM hotellromtype WHERE hotellnavn = '$hotellnavn';";
                          $sqlResultat = mysqli_query($db,$sqlSetning);

                          if ($sqlResultat) {
                            $antallRader = mysqli_num_rows($sqlResultat);

                            print("<h4>Hotellromtype</h4>");
                            print("<table class='visTabell'>");
                            print("<tr><th>Rombilde</th><th>Hotellnavn</th><th>Romtype</th><th>Pris</th><th>Antall rom</th></tr>");

                            for ($i=0; $i < $antallRader; $i++) {
                              $rad = mysqli_fetch_array($sqlResultat);
                              $hotellnavn = $rad["hotellnavn"];
                              $romtype = $rad["romtype"];
                              $pris = $rad["pris"];
                              $rombilde = $rad["rombilde"];
                              $antallrom = $rad["antallrom"];

                              print("<tr><td><img src=../filer/$rombilde></td><td>$hotellnavn</td><td>$romtype</td><td>$pris</td><td>$antallrom</td></tr>");
                            }
                            print("</table>");

                            $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn';";
                            $sqlResultat = mysqli_query($db,$sqlSetning);

                            if ($sqlResultat) {
                              $antallRader = mysqli_num_rows($sqlResultat);

                              print("<h4>Rom</h4>");
                              print("<table class='visTabell'>");
                              print("<tr><th>Hotellnavn</th><th>Romtype</th><th>Romnr</th></tr>");

                              for ($i=0; $i < $antallRader; $i++) {
                                $rad = mysqli_fetch_array($sqlResultat);
                                $hotellnavn = $rad["hotellnavn"];
                                $romtype = $rad["romtype"];
                                $romnr = $rad["romnr"];

                                print("<tr><td>$hotellnavn</td><td>$romtype</td><td>$romnr</td></tr>");
                              }
                              print("</table>");

                              $sqlSetning = "SELECT * FROM bestilling WHERE hotellnavn = '$hotellnavn';";
                              $sqlResultat = mysqli_query($db,$sqlSetning);

                              if ($sqlResultat) {
                                $antallRader = mysqli_num_rows($sqlResultat);

                                print("<h4>Bestilling</h4>");
                                print("<table class='visTabell'>");
                                print("<tr><th>Bestillingsnr</th><th>Brukernavn</th><th>Innsjekking</th><th>Utsjekking</th><th>Hotellnavn</th><th>Romnr</th></tr>");

                                for ($i=0; $i < $antallRader; $i++) {
                                  $rad = mysqli_fetch_array($sqlResultat);
                                  $radnr = $rad["radnr"];
                                  $brukernavn = $rad["brukernavn"];
                                  $datotil = $rad["datotil"];
                                  $datofra = $rad["datofra"];
                                  $hotellnavn = $rad["hotellnavn"];
                                  $romnr = $rad["romnr"];

                                  print("<tr><td>$radnr</td><td>$brukernavn</td><td>$datofra</td><td>$datotil</td><td>$hotellnavn</td><td>$romnr</td></tr>");
                                }
                                print("</table>");

                                ?>
                                <form method="post" onSubmit="return confirm('Er du sikker på at du vil slette fra alle tabellene? Dette kan ikke gjøres om!');">
                                  <input type="hidden" value="<?php echo $hotellnavn ?>" name="hotellnavn">
                                  <input type="submit" class="button red" name="slettAlle" value="Slett fra alle tabellene">
                                </form>
                                <?php
                              }
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
              } else {
                echo $die;
              }
            }
          } else {
            echo $die;
          }
        }
    }


  if (isset($_POST["slettAlle"])) {
    $hotellnavn = $_POST["hotellnavn"];

    $sqlSetning = "DELETE FROM bestilling WHERE hotellnavn = '$hotellnavn';";
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $sqlSetning = "DELETE FROM rom WHERE hotellnavn = '$hotellnavn';";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        $sqlSetning = "SELECT rombilde FROM hotellromtype WHERE hotellnavn = '$hotellnavn'";
        $sqlResultat = mysqli_query($db,$sqlSetning);

        if ($sqlResultat) {
          $antallRader = mysqli_num_rows($sqlResultat);

          for ($i=0; $i < $antallRader; $i++) {
            $rad = mysqli_fetch_array($sqlResultat);
            $rombilde = $rad["rombilde"];
            $filnavn = "../filer/$rombilde";

            if ($rombilde) {
              unlink($filnavn);
            }
          }
        }
        $sqlSetning = "DELETE FROM hotellromtype WHERE hotellnavn = '$hotellnavn';";
        $sqlResultat = mysqli_query($db,$sqlSetning);

        if ($sqlResultat) {
          $sqlSetning = "SELECT bilde FROM hotell WHERE hotellnavn = '$hotellnavn'";
          $sqlResultat = mysqli_query($db,$sqlSetning);

          if ($sqlResultat) {
            $antallRader = mysqli_num_rows($sqlResultat);

            for ($i=0; $i < $antallRader; $i++) {
              $rad = mysqli_fetch_array($sqlResultat);
              $bilde = $rad["bilde"];
              $filnavn = "../filer/$bilde";

              if ($bilde) {
                unlink($filnavn);
              }
            }
          }
          $sqlSetning = "DELETE FROM hotell WHERE hotellnavn = '$hotellnavn';";
          $sqlResultat = mysqli_query($db,$sqlSetning);

          if ($sqlResultat) {
            print("$hotellnavn er sletta fra hotellromtype- og hotelltabellen.");
          } else {
            echo $die;
          }
        } else {
          echo $die;
        }
      } else {
        echo $die;
      }
    } else {
      echo $die;
    }
  }

  if (isset($_POST["slettHotellromtypeOgRom"])) {
    $hotellnavn = $_POST["hotellnavn"];

    $sqlSetning = "DELETE FROM rom WHERE hotellnavn = '$hotellnavn';";
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $sqlSetning = "SELECT rombilde FROM hotellromtype WHERE hotellnavn = '$hotellnavn'";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        $antallRader = mysqli_num_rows($sqlResultat);

        for ($i=0; $i < $antallRader; $i++) {
          $rad = mysqli_fetch_array($sqlResultat);
          $rombilde = $rad["rombilde"];
          $filnavn = "../filer/$rombilde";

          if ($rombilde) {
            unlink($filnavn);
          }
        }
      }
      $sqlSetning = "DELETE FROM hotellromtype WHERE hotellnavn = '$hotellnavn';";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        $sqlSetning = "SELECT bilde FROM hotell WHERE hotellnavn = '$hotellnavn'";
        $sqlResultat = mysqli_query($db,$sqlSetning);

        if ($sqlResultat) {
          $antallRader = mysqli_num_rows($sqlResultat);

          for ($i=0; $i < $antallRader; $i++) {
            $rad = mysqli_fetch_array($sqlResultat);
            $bilde = $rad["bilde"];
            $filnavn = "../filer/$bilde";

            if ($bilde) {
              unlink($filnavn);
            }
          }
        }
        $sqlSetning = "DELETE FROM hotell WHERE hotellnavn = '$hotellnavn';";
        $sqlResultat = mysqli_query($db,$sqlSetning);

        if ($sqlResultat) {
          print("$hotellnavn er sletta fra hotellromtype- og hotelltabellen.");
        } else {
          echo $die;
        }
      } else {
        echo $die;
      }
    } else {
      echo $die;
    }
  }

  if (isset($_POST["slettHotellromtype"])) {
    $hotellnavn = $_POST["hotellnavn"];

    // SLETT BILDE

    $sqlSetning = "SELECT rombilde FROM hotellromtype WHERE hotellnavn = '$hotellnavn'";
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $antallRader = mysqli_num_rows($sqlResultat);

      for ($i=0; $i < $antallRader; $i++) {
        $rad = mysqli_fetch_array($sqlResultat);
        $rombilde = $rad["rombilde"];
        $filnavn = "../filer/$rombilde";

        if ($rombilde) {
          unlink($filnavn);
        }
      }
    }

    $sqlSetning = "DELETE FROM hotellromtype WHERE hotellnavn = '$hotellnavn';";
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $sqlSetning = "SELECT bilde FROM hotell WHERE hotellnavn = '$hotellnavn'";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        $antallRader = mysqli_num_rows($sqlResultat);

        for ($i=0; $i < $antallRader; $i++) {
          $rad = mysqli_fetch_array($sqlResultat);
          $bilde = $rad["bilde"];
          $filnavn = "../filer/$bilde";

          if ($bilde) {
            unlink($filnavn);
          }
        }
      }
      $sqlSetning = "DELETE FROM hotell WHERE hotellnavn = '$hotellnavn';";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        print("$hotellnavn er sletta fra hotellromtype- og hotelltabellen.");
      } else {
        echo $die;
      }
    } else {
      echo $die;
    }
  }

  include("slutt.php")
?>
