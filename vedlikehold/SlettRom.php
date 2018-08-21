<?php
include("start.php");
include("dynamiske_funksjoner.php");
?>
<script>
function srh(hotellnavn) {
  var foresporsel=new XMLHttpRequest();

  foresporsel.onreadystatechange=function() {
    if (foresporsel.readyState==4 && foresporsel.status==200) {
      document.getElementById("romtype").innerHTML=foresporsel.responseText;
    }
  }
  foresporsel.open("GET","phpRomtype.php?hotellnavn="+hotellnavn);
  foresporsel.send();
  document.getElementById('romtype').innerHTML = "";
  document.getElementById('romnr').innerHTML = "";
}

function srr(romtype) {
  var foresporsel=new XMLHttpRequest();
  var hotellnavn=document.getElementById("hotellnavn").value;
  var getsend = "romtype=";
  var getsend = getsend + romtype;
  var getsend = getsend + "&hotellnavn=";
  var getsend = getsend + hotellnavn;

  foresporsel.onreadystatechange=function()
  {
    if (foresporsel.readyState==4 && foresporsel.status==200)
    {
      document.getElementById("romnr").innerHTML=foresporsel.responseText;
    }
  }
  foresporsel.open("GET","phpSlettRom.php?"+getsend);

  foresporsel.send();
  document.getElementById("romnr").innerHTML = "";
}

function slettRomValidering() {
  document.getElementById("feilmelding").style.color = "red";

  var hotellnavn = document.forms.slettRomForm.hotellnavn.value;
  var romtype = document.forms.slettRomForm.romtype.value;
  var romnr = document.forms.slettRomForm.romnr.value;

  var feilmelding = "Alle feltene må fylles ut";

  if (!hotellnavn || !romtype || !romnr) {
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  return confirm("Sletting kan ikke angres, er du sikker?");
}
</script>

<h2>Velg hotell og deretter romtype du vil slette rom i</h2>

<form method="post" name="slettRomForm" id="slettRomForm">
  Hotellnavn <select name="hotellnavn" id="hotellnavn" onChange="srh(this.value)" required>
                <option value="">Velg hotell</option>
                <?php	listeboksHotell(); 	?>
              </select><br>
  Romtype <select name="romtype" id="romtype" onChange="srr(this.value)" required>
            <option value=""> --- </option>
            <?php   // listeboksRomtype(); 	?>
          </select><br>
  Romnummer <select name="romnr" id="romnr" required>
              <option value=""> --- </option>
              <?php // listeboksSlettRom(); ?>
            </select><br>
  <input type="submit" name="submit" id="submit" value="Slett rom" onclick="return slettRomValidering()">
</form>
<br>
<div id="melding"></div>
<div id="feilmelding"></div>
<?php

  if (isset($_POST["submit"])) {
    $hotellnavn = $_POST["hotellnavn"];
    $romnr = $_POST["romnr"];

    if (!$hotellnavn || !$romnr) {
      print("Velg hotellnavn, romtype og romnummer");
    } else {
      $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn' AND romnr = '$romnr';";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        $antallRader = mysqli_num_rows($sqlResultat);

        if ($antallRader == 0) {
          print("Fant ikke angitt rom");
        } else {
          $sqlSetning = "SELECT * FROM bestilling WHERE hotellnavn = '$hotellnavn' AND romnr = '$romnr';";
          $sqlResultat = mysqli_query($db,$sqlSetning);

          if ($sqlResultat) {
            $antallRader = mysqli_num_rows($sqlResultat);

            if ($antallRader == 0) {
              // FINNES IKKE I BESTILLING, SLETT ROMMET
              $sqlSetning = "DELETE FROM rom WHERE hotellnavn = '$hotellnavn' AND romnr = '$romnr';";
              $sqlResultat = mysqli_query($db,$sqlSetning);

              if ($sqlResultat) {
                print("<br>Rommet er slettet");
              } else {
                echo $die;
              }
            } else {
              // FINNES I BESTILLING
              print("<br>Rommet er registrert i bestillingstabellen. Du kan velge å slette alle de aktuelle radene:<br>");

                $sqlSetning = "SELECT * FROM bestilling WHERE hotellnavn = '$hotellnavn' AND romnr = '$romnr';";
                $sqlResultat = mysqli_query($db,$sqlSetning);

                if ($sqlResultat) {
                  $antallRader = mysqli_num_rows($sqlResultat);

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
                    <input type="hidden" value="<?php echo $romnr ?>" name="romnr">
                    <input type="hidden" value="<?php echo $hotellnavn ?>" name="hotellnavn">
                    <input type="submit" class="button red" name="slettBestilling" value="Slett fra begge tabellene">
                  </form>
                  <?php
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

  if (isset($_POST["slettBestilling"])) {
    $hotellnavn = $_POST["hotellnavn"];
    $romnr = $_POST["romnr"];

    $sqlSetning = "DELETE FROM bestilling WHERE hotellnavn = '$hotellnavn' AND romnr = '$romnr';";
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $sqlSetning = "DELETE FROM rom WHERE hotellnavn = '$hotellnavn' AND romnr = '$romnr';";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        print("Rommet er slettet fra rom- og bestillingstabellen");
      } else {
        echo $die;
      }
    }
  }

include("slutt.php")
?>
