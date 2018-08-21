<?php
  include("start.php");
  require_once("dynamiske_funksjoner.php");
  $die = "Kan ikke koble til database";
?>
<script>
function shrt(hotellnavn) {
  var foresporsel=new XMLHttpRequest();

  foresporsel.onreadystatechange=function() {
    if (foresporsel.readyState==4 && foresporsel.status==200) {
      document.getElementById("romtype").innerHTML=foresporsel.responseText;
    }
  }
  foresporsel.open("GET","phpRomtype.php?hotellnavn="+hotellnavn);
  foresporsel.send();
  document.getElementById('romtype').innerHTML = "";
}

function slettHotellromtypeValidering() {
  document.getElementById("feilmelding").style.color = "red";

  var hotellnavn = document.forms.slettHotellromtype.hotellnavn.value;
  var romtype = document.forms.slettHotellromtype.romtype.value;

  var feilmelding = "Alle feltene må fylles ut";

  if (!hotellnavn || !romtype) {
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  return confirm("Sletting kan ikke angres, er du sikker?");
}
</script>

<h2> Slett hotellromtype </h2>
<form method="post" action="" name="slettHotellromtype" id="slettHotellromtype">
  Hotellnavn <select name="hotellnavn" id="hotellnavn" onChange="shrt(this.value)" required>
                <option value="">Velg hotell</option >
                <?php	listeboksHotell(); 	?>
              </select><br>
  Romtype <select name="romtype" id="romtype" required>
            <option value=""> --- </option >
          </select><br>
  <input type="submit" name="submit" id="submit" value="Slett hotellromtypen" onclick="return slettHotellromtypeValidering()">
</form>
<div id="feilmelding"></div>
<?php
  if (isset($_POST["submit"])) {
    $hotellnavn = $_POST["hotellnavn"];
    $romtype = $_POST["romtype"];

    if (!$hotellnavn || !$romtype) {
      print("Boksene kan ikke fylles ut med tomme valg! Velg hotellnavn og romtype");
    } else {
          $sqlSetning = "SELECT * FROM hotellromtype WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
          $sqlResultat = mysqli_query($db,$sqlSetning);

          if ($sqlResultat) {
            $antallRader = mysqli_num_rows($sqlResultat);

            if ($antallRader == 0) {
              print("Ingen resultater for angitt hotell og romtype.");
            } else {
              $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
              $sqlResultat = mysqli_query($db,$sqlSetning);

              if ($sqlResultat) {
                $antallRader = mysqli_num_rows($sqlResultat);

                if ($antallRader == 0) {
                  // FINNES IKKE NOEN ANDRE STEDER. SLETT HOTELLROMTYPEN
                  $sqlSetning = "SELECT rombilde FROM hotellromtype WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
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

                  $sqlSetning = "DELETE FROM hotellromtype WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
                  $sqlResultat = mysqli_query($db,$sqlSetning);

                  if ($sqlResultat) {
                    print("Hotellromtypen er sletta");
                  } else {
                    echo $die;
                  }
                } else {
                  $sqlSetning = "SELECT * FROM bestilling
                                    WHERE hotellnavn = '$hotellnavn'
                                    AND (SELECT romtype FROM rom WHERE hotellnavn = '$hotellnavn' AND romnr = bestilling.romnr) = '$romtype';";

                  $sqlResultat = mysqli_query($db,$sqlSetning);

                  if ($sqlResultat) {
                    $antallRader = mysqli_num_rows($sqlResultat);

                    if ($antallRader == 0) {
                      // FINNES IKKE I BESTILLING, MEN I ROM
                      print("<font color='blue'><br>Hotellromtypen er registrert i rom-tabellen. Du kan velge å slette alle de aktuelle radene:</font><br><br>");

                      $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
                      $sqlResultat = mysqli_query($db,$sqlSetning);

                      if ($sqlResultat) {
                        $antallRader = mysqli_num_rows($sqlResultat);

                        print("<table class='visTabell'>");
                        print("<tr><th>Hotellnavn</th><th>Romtype</th><th>Romnr</th></tr>");

                        for ($i=0; $i < $antallRader; $i++) {
                          $rad = mysqli_fetch_array($sqlResultat);
                          $hotellnavn = $rad["hotellnavn"];
                          $romtype = $rad["romtype"];
                          $romnr = $rad["romnr"];

                          print("<tr><th>$hotellnavn</th><th>$romtype</th><th>$romnr</th></tr>");
                        }
                        print("</table>");
                        ?>
                        <form method="post" onSubmit="return confirm('Er du sikker på at du vil slette fra alle tabellene? Dette kan ikke gjøres om!');">
                          <input type="hidden" value="<?php echo $romtype ?>" name="romtype">
                          <input type="hidden" value="<?php echo $hotellnavn ?>" name="hotellnavn">
                          <input type="submit" class="button red" name="slettRom" value="Slett fra begge tabellene">
                        </form>
                        <?php
                      } else {
                        echo $die;
                      }
                    } else {
                      // FINNES I BESTILLING
                      print("<br><font color='blue'>Hotellromtypen er registrert i rom- og bestillingstabellen. Du kan velge å slette alle de aktuelle radene:</font><br><br>");

                      $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
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

                          print("<tr><th>$hotellnavn</th><th>$romtype</th><th>$romnr</th></tr>");
                        }
                        print("</table>");

                        $sqlSetning = "SELECT * FROM bestilling
                                          WHERE hotellnavn = '$hotellnavn'
                                          AND (SELECT romtype FROM rom WHERE hotellnavn = '$hotellnavn' AND romnr = bestilling.romnr) = '$romtype';";
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
                            <input type="hidden" value="<?php echo $romtype ?>" name="romtype">
                            <input type="hidden" value="<?php echo $hotellnavn ?>" name="hotellnavn">
                            <input type="submit" class="button red" name="slettRomOgBestilling" value="Slett fra alle tabellene">
                          </form>
                          <?php
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
          } else {
            echo $die;
          }
        }
    }

  if (isset($_POST["slettRom"])) {
    $hotellnavn = $_POST["hotellnavn"];
    $romtype = $_POST["romtype"];

    $sqlSetning = "DELETE FROM rom WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $sqlSetning = "SELECT rombilde FROM hotellromtype WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype'";
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
      $sqlSetning = "DELETE FROM hotellromtype WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        print("Hotellromtypen er slettet fra rom- og hotellromtypetabellen");
      } else {
        echo $die;
      }
    } else {
      echo $die;
    }
  }
  if (isset($_POST["slettRomOgBestilling"])) {
    $hotellnavn = $_POST["hotellnavn"];
    $romtype = $_POST["romtype"];

    $sqlSetning = "DELETE FROM bestilling
                          WHERE hotellnavn = '$hotellnavn'
                          AND (SELECT romtype FROM rom WHERE hotellnavn = '$hotellnavn' AND romnr = bestilling.romnr) = '$romtype';";

    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $sqlSetning = "DELETE FROM rom WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        $sqlSetning = "SELECT rombilde FROM hotellromtype WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype'";
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
        $sqlSetning = "DELETE FROM hotellromtype WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
        $sqlResultat = mysqli_query($db,$sqlSetning);

        if ($sqlResultat) {
          print("Hotellromtype er slettet fra bestilling-, rom- og hotellromtypetabellen");
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

  include("slutt.php")
?>
