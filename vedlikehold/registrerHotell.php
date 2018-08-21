<?php
  include("start.php");
  $die = "Kan ikke koble til database";
?>
<script type="text/javascript">
  function mouseOver(element) {
      document.getElementById("melding").style.color="blue";

      if (element== document.getElementById("hotellnavn")) {
        document.getElementById("melding").innerHTML = "Skriv inn ønsket hotellnavn";
      }
      if (element==document.getElementById("land")) {
        document.getElementById("melding").innerHTML = "Skriv inn ønsket land";
      }
      if (element==document.getElementById("sted")) {
        document.getElementById("melding").innerHTML = "Skriv inn ønsket sted";
      }
      if (element==document.getElementById("bilde")) {
        document.getElementById("melding").innerHTML = "Valgfritt: Velg ønsket hotellbilde";
      }
  }
</script>
<h3>Registrer hotell</h3>
<br>
<form method="post" id="registrerHotell" name="registrerHotell" enctype="multipart/form-data">
  Hotellnavn <input type="text" id="hotellnavn" name="hotellnavn" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="mouseOver(this)" onMouseout="musUt()" required><br>
  Land <input type="text" id="land" name="land" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="mouseOver(this)" onMouseout="musUt()" required><br>
  Sted <input type="text" id="sted" name="sted" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="mouseOver(this)" onMouseout="musUt()" required><br>
  Bilde <input type="file" name="bilde" id="bilde" onMouseover="mouseOver(this)" onMouseout="musUt()"><br>
  <br>
  <input type="submit" id="submit" name="submit" value="Registrer" onclick="return registrerHotellValidate()">
  <input type="reset" id="reset" name="reset" value="Nullstill"><br>
</form>
<br>
<?php
  if (isset($_POST["submit"])) {
    $hotellnavn = $_POST["hotellnavn"];
    $land = $_POST["land"];
    $sted = $_POST["sted"];
    $bilde = $_FILES["bilde"];
    $filnavn = $bilde['name']; // bilde.jpg

    $filnavn = preg_replace('/[æøåÆØÅ]+/', '', $filnavn);

    include("validering.php");
    $gyldigNavn=validerHotellnavn($hotellnavn);
    $gyldigLand=validerLandet($land);
    $gyldigSted=validerStedet($sted);



      if ($gyldigNavn && $gyldigLand && $gyldigSted) {
      require_once('db.php');

      $sql = "SELECT * FROM hotell WHERE hotellnavn = '$hotellnavn';";
      $sqlResultat = mysqli_query($db,$sql);

      if ($sqlResultat) {
        $antallRader = mysqli_num_rows($sqlResultat);

        if ($antallRader != 0) {
          print("Hotellnavn eksisterer allerede.");
        } else {
          if ($filnavn) {
            $sqlSetning = "SELECT hotell.bilde, hotellromtype.rombilde
                              FROM hotell JOIN hotellromtype
                              WHERE bilde = '$filnavn'
                              OR rombilde = '$filnavn'
                              limit 1;";
            $sqlResultat = mysqli_query($db,$sqlSetning);

            if ($sqlResultat) {
              $antallRader = mysqli_num_rows($sqlResultat);

              if ($antallRader != 0) {
                $x = 0;

                while (true) {
                  $bildenavn = $x.$filnavn;

                  $sqlSetning = "SELECT hotell.bilde, hotellromtype.rombilde
                                    FROM hotell JOIN hotellromtype
                                    WHERE bilde = '$bildenavn'
                                    OR rombilde = '$bildenavn'
                                    limit 1;";
                  $sqlResultat = mysqli_query($db,$sqlSetning);

                  if ($sqlResultat) {
                    $antallRader = mysqli_num_rows($sqlResultat);

                    if ($antallRader == 0) {
                      $filnavn = $bildenavn;
                      break;
                    } else {
                      $x++;
                    }
                  } else {
                    echo $die;
                  }
                }}

                $type = $bilde['type']; // image/jpg
                $tmp_name = $bilde['tmp_name']; // url til der filen er nå (midlertidlig)
                $error = $bilde['error']; // error=0: Ingen feil!  error=1: Feil ved opplastning av fil!
                $size = $bilde['size']; // filstørrelse (f.eks. 1352022)

                $bildeformat = explode('.', $filnavn); // Deler f.eks. bjarvinUS.png --> 'bjarvinUS' og 'png'
                $filendelse = strtolower(end($bildeformat)); // små bokstaver fordi format kan skrives både som jpg og JPG. end() henter den siste verdien i et array.

                // Bildeformater som tillates //
                $gyldigFormat = array('jpg', 'jpeg', 'gif', 'png');

                if (in_array($filendelse, $gyldigFormat)) {
                  $sqlSetning = "INSERT INTO hotell VALUES ('$hotellnavn','$sted','$land','$filnavn')";
                  $sqlResultat = mysqli_query($db,$sqlSetning);

                  if ($sqlResultat) {
                    $url="../filer/".$filnavn;
                    move_uploaded_file($tmp_name, $url) or die ("En feil oppstod: Kunne ikke lagre bilde");
                    print("$hotellnavn, $land, $sted og bilde er registrert.");
                  } else {
                    print("Ikke mulig &aring; registrere data i databasen");
                  }


                } else {
                  print("Bildet er i ugyldig format. ");
                }
            } else {
              echo $die;
            }
          } else {
            $sqlSetning = "INSERT INTO hotell (hotellnavn, sted, land) VALUES ('$hotellnavn','$sted','$land')";
            $sqlResultat = mysqli_query($db,$sqlSetning);

            if ($sqlResultat) {
              print("$hotellnavn, $land, $sted er registrert.");
            } else {
              print("Ikke mulig &aring; registrere data i databasen");
            }
          }
        }
      } else {
        echo $die;
      }
    }

  }
?>
<div id="melding"></div>
<div id="feilmelding"></div>
<div id="kanIkke"></div>


<?php
  include("slutt.php");
?>
