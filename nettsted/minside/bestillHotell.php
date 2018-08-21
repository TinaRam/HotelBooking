<?php
  include("start.php");
  require_once('../dynamiske_funksjoner.php');
  require_once('db.php');

  $sqlSetning = "SELECT MAX(bestnr) AS bestnr FROM bestilling;";
  $sqlResultat = mysqli_query($db,$sqlSetning);

  if ($sqlResultat) {
    $antallRader = mysqli_num_rows($sqlResultat);

    if ($antallRader == 0) {
      $nyttBestnr = 1000;
    } else {
      $rad = mysqli_fetch_array($sqlResultat);
      $bestnr = $rad["bestnr"];

      $nyttBestnr = $bestnr + 1;
    }
  } else {
    print("Kan ikke koble til database");
  }
?>

<script type="text/javascript">
function setRomtype(antallRom, romtype) {
  //global variabel - kan brukes av flere funksjoner
  thisRomtype = romtype;
  //sett antallrom, innsjekking og utsjekking til default igjen
  //document.getElementById("antallRom").value = "";
  document.getElementById("innsjekking").value = "";
  document.getElementById("utsjekking").value = "";

  //fjern teksten som viser pris - disse er ikke riktige lenger

  //document.getElementById("antallRom").innerHTML = "<option value=''>Velg antall rom</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option>";

  visDato(antallRom, romtype);
}

function setInnsjekking(innsjekking) {
  //global variabel - kan brukes av flere funksjoner
  thisInnsjekking = innsjekking;

  //sett utsjekking til default igjen og fjern totalpris-teksten - ellers viser totalprisen det samme som tidligere, med feil antall netter
  document.getElementById("utsjekking").value = "";
  document.getElementById("visTotalPris").innerHTML = "";
}

function visHotell(sok) {
	var foresporsel=new XMLHttpRequest();

	foresporsel.onreadystatechange=function() {
		if (foresporsel.readyState==4 && foresporsel.status==200) {
			document.getElementById("meldingHotellnavn").innerHTML=foresporsel.responseText;
		}
	}
	foresporsel.open("GET","phpVisHotell.php?sok="+sok);
	foresporsel.send();
  document.getElementById('meldingHotellnavn').innerHTML = "";
}

function verdiHotell(verdi) {
  // global variabel - kan brukes av flere funksjoner
  thisHotellnavn = verdi;

  // unødvendig?
  //var value = document.getElementById('hotellnavnValue').value;

  // Fjern forslagene og sett inn nullstill-knapp
  meldingHotellnavn.innerHTML = "<br><a class='buttonForslag' href='bestillHotell.php' id='hotellnavnValue' value=''>Velg annet hotell</a>";

  // Sett søkefeltets value til hotellnavnet
  document.getElementById("sok").value = thisHotellnavn;

  var foresporsel=new XMLHttpRequest();

	foresporsel.onreadystatechange=function() {
		if (foresporsel.readyState==4 && foresporsel.status==200) {
			document.getElementById("romtype").innerHTML=foresporsel.responseText;
		}
	}
	foresporsel.open("GET","romForHotell.php?verdi="+thisHotellnavn);
	foresporsel.send();

  // Fjern default romtype-listeboks for å sette inn ny med riktige romtyper
  document.getElementById("romtype").innerHTML = "";

  // Vis romtype-diven
  document.getElementById("bokserRomtype").style.visibility = "visible";

  // Funksjon for å vise hotellbilde
  visBilde(verdi);
}

function visBilde(verdi) {
  var foresporsel=new XMLHttpRequest();

	foresporsel.onreadystatechange=function() {
		if (foresporsel.readyState==4 && foresporsel.status==200) {
			document.getElementById("visBilde").innerHTML=foresporsel.responseText;
		}
	}
	foresporsel.open("GET","visBilde.php?verdi="+verdi);
	foresporsel.send();
}

function visDato(antallRom, romtype) {
  // Vis dato-diven
  document.getElementById("bokserDato").style.visibility = "visible";

  // Sett innsjekking og utsjekkings-value til ingenting - skulle man velge romtype på nytt så blir prisene feil
  document.getElementById("innsjekking").value = "";
  document.getElementById("utsjekking").value = "";


  /*var foresporsel=new XMLHttpRequest();
	foresporsel.onreadystatechange=function() {
		if (foresporsel.readyState==4 && foresporsel.status==200) {
			document.getElementById("visPris").innerHTML+=foresporsel.responseText;
		}
	}
  foresporsel.open("GET","phpVisPris.php?antallRom="+antallRom+"&hotellnavn="+thisHotellnavn+"&romtype="+romtype);
	foresporsel.send();*/
}

function visSubmit(utsjekking) {
  // Global variabel - kan brukes av andre funksjoner
  thisUtsjekking = utsjekking;

  // Vis submit-knapp
  document.getElementById('submit').innerHTML = "<input type='submit' name='submit' id='submitBestillHotell' class='button' value='Book hotell'>";
  document.getElementById("submitBestillHotell").style.visibility = "visible";

  /*var foresporsel=new XMLHttpRequest();
	foresporsel.onreadystatechange=function() {
		if (foresporsel.readyState==4 && foresporsel.status==200) {
			document.getElementById("visTotalPris").innerHTML=foresporsel.responseText;
		}
	}
	foresporsel.open("GET","phpVisTotalPris.php?hotellnavn="+thisHotellnavn+"&romtype="+thisRomtype+"&antallRom="+thisAntallrom+"&innsjekking="+thisInnsjekking+"&utsjekking="+thisUtsjekking);
	foresporsel.send();*/
}
</script>


<?php
  if (isset($_GET["hotellnavn"])) {     // Dersom du kommer fra "se hotell" og velger "book hotell" på et av hotellene,
    $hotellnavn = $_GET["hotellnavn"];  // henter den riktig hotellnavn
  } else {
    $hotellnavn = "";
  }

  $die = "Kan ikke koble til database.";


?>

<h2>Book hotell</h2>
<form method="post" id="bestill" name="bestill">
  <div id="container">
    <div class="bokser">
      <h2>Hotell</h2>
      <input type="text" id="sok" name="sok" value="<?php echo $hotellnavn ?>" placeholder="Søk i hotellnavn" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" onKeyUp="visHotell(this.value)" required><br>
      <div id="visBilde"></div>
      <div id="meldingHotellnavn">
        <?php
          $sqlSetning = "SELECT * FROM hotell;";
          $sqlResultat = mysqli_query($db,$sqlSetning);

          if ($sqlResultat) {
            $antallRader = mysqli_num_rows($sqlResultat);

            for ($i=0; $i < $antallRader; $i++) {
              $rad = mysqli_fetch_array($sqlResultat);
              $hotellnavn = $rad["hotellnavn"];
              print("<br><button class='buttonForslag' href='' id='hotellnavnValue' onClick='verdiHotell(this.value); return false' value='$hotellnavn'>$hotellnavn</button>");
            }
          } else {
            echo $die;
          }
        ?>
      </div><br>
    </div>
    <div class="bokser" id="bokserRomtype">
      <h2>Romtype</h2>
      <div id="romtype"></div>
      <div id="visPris"></div>
      <div id="visTotalPris"></div>
    </div>
    <div class="bokser" id="bokserDato">
      <h2>Dato</h2>
      Innsjekkingsdato<br>
    	<input type="text" class="datepicker" id="innsjekking" name="innsjekking" placeholder="innsjekking" onChange="setInnsjekking(this.value)" autocomplete="off"><br><br>
      Utsjekkingsdato<br>
    	<input type="text" class="datepicker" id="utsjekking" name="utsjekking" placeholder="utsjekking" onChange="visSubmit(this.value)" autocomplete="off"><br>
    </div>
  </div>
  <div id="feilmeldingBestill"></div>
  <div id="submit"></div>
<!--<input type="submit" name="submit" id="submitBestillHotell" class="button" value="Book hotell">-->
</form>


<?php
  if (isset($_GET["hotellnavn"])) {
    $hotellnavn = $_GET["hotellnavn"];
    echo "<script> verdiHotell('$hotellnavn'); </script>"; // Hvis du kommer fra "se hotell"-siden, kjører den scriptet for
  }                                                        // å vise romtype-diven osv med en gang - så man slipper å trykke
                                                           // på hotellnavnet når du allerede har valgt hotell på "se hotell"-siden
	if (isset($_POST["submit"])) {
		@$hotellnavn = $_POST["sok"];
		@$innsjekking = $_POST["innsjekking"];
		@$utsjekking = $_POST["utsjekking"];
		@$romtype = $_POST["romtype"];
		@$antallRom = $_POST["antallRom"];
    $brukernavn = $_SESSION['brukernavn'];
    $gjennomført = false;

    if (!$hotellnavn || !$innsjekking || !$utsjekking) {
      print("Alle felt må fylles ut.");
    } else if ($utsjekking <= $innsjekking) {
      print("Innsjekkingsdato kan ikke være før eller på samme dag som utsjekkingsdato.");
    } else if ($innsjekking < date("Y-m-d")) {
      print("Innsjekkingsdato kan ikke være før dagens dato.");
    } else {
      $sqlSetning = "SELECT * FROM hotell WHERE hotellnavn = '$hotellnavn'"; // Sjekk om hotellet finnes
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        $antallRader = mysqli_num_rows($sqlResultat);

        if ($antallRader == 0) {
          print("Fant ingen hoteller ved navn $hotellnavn.");
        } else {
          // SJEKK OM ALT I BESTILLINGEN ER MULIG
          $muligBestilling = false;

          for ($x=0; $x < count($romtype); $x++) {
            $sqlSetning = "SELECT COUNT(*) AS antall FROM rom WHERE hotellnavn = '$hotellnavn'
                                AND romtype = '$romtype[$x]'
                                AND romnr NOT IN (SELECT romnr FROM bestilling WHERE hotellnavn = '$hotellnavn' AND (datofra BETWEEN '$innsjekking' AND '$utsjekking'
                                OR datotil BETWEEN '$innsjekking' AND '$utsjekking'));";
            $sqlResultat = mysqli_query($db,$sqlSetning);

            if ($sqlResultat) {
              $antallRader = mysqli_num_rows($sqlResultat);
              $rad = mysqli_fetch_array($sqlResultat);
              $antall = $rad["antall"];

              if ($antall >= $antallRom[$x]) {
                $muligBestilling = true;
              } else {
                $muligBestilling = false;
                break;
              }
            } else {
              echo $die;
            }
          }
          if ($muligBestilling) {
              // HVIS ALT I BESTILLINGEN ER MULIG
            for ($x=0; $x < count($romtype); $x++) {

                  for ($i=0; $i < $antallRom[$x]; $i++) {
                      // Finn ut hvilket rom som er neste ledige rom
                    $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn'
                                            AND romtype = '$romtype[$x]'
                                            AND romnr NOT IN (SELECT romnr FROM bestilling WHERE hotellnavn = '$hotellnavn' AND (datofra BETWEEN '$innsjekking' AND '$utsjekking'
                                            OR datotil BETWEEN '$innsjekking' AND '$utsjekking'))
                                            limit 1;";
                    $sqlResultat = mysqli_query($db,$sqlSetning);

                    if ($sqlResultat) {
                      $antallRader = mysqli_num_rows($sqlResultat);

                      if ($antallRader == 0) {
                        print("Fant ingen ledige rom på $hotellnavn på denne datoen. ");
                      } else { // Book bestilling på det ledige rommet
                        for ($j=0; $j < $antallRader; $j++) {
                          $rad = mysqli_fetch_array($sqlResultat);
                          $nyttNr = $rad["romnr"];

                          $sqlSetning = "INSERT INTO bestilling (bestnr, brukernavn, datofra, datotil, hotellnavn, romnr) VALUES
                                                        ('$nyttBestnr','$brukernavn', '$innsjekking', '$utsjekking', '$hotellnavn', '$nyttNr');";
                            // FUNGERER DET IKKE SOM DET SKAL?
                            // SJEKK OM SQL-SETNINGA ER KORREKT:
                            // print("$sqlSetning");
                          $sqlResultat = mysqli_query($db,$sqlSetning);

                          if ($sqlResultat) {
                            $gjennomført = true;
                          }
                        }
                      }
                    } else {
                      echo $die;
                    }

                }
              }
            } else {
              $gjennomført = false;
              print("$hotellnavn har ikke nok ledige rom av angitt romtype");
            }
        }
      } else {
        echo $die;
      }
    }
    if ($gjennomført) {
      print("<div id='bookingGjennomført'><h2>Booking gjennomført<h2></div>");
    }
  }



  include("slutt.php");
?>
