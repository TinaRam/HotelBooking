<?php
  include("start.php");
  require_once('../dynamiske_funksjoner.php');
  require_once('db.php');
  $die = "Kan ikke koble til database";
?>
<h2>Finn ledig rom</h2>
<form method="post" id="bestill" name="bestill">
  <div id="container">
    <div class="bokser">
      <h2>Hotell</h2>
      <input type="text" id="sok" name="sok" placeholder="Søk i hotellnavn" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" onKeyUp="visHotell(this.value)" required><br>
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
      <select name="romtype" id="romtype" onChange="setRomtype(this.value)">
        <option value=''>Velg romtype</option>
        <?php
          $sqlSetning = "SELECT romtype FROM romtype;";
          $sqlResultat=mysqli_query($db,$sqlSetning);

          if ($sqlResultat) {
            $antallRader=mysqli_num_rows($sqlResultat);

            for ($r=1;$r<=$antallRader;$r++) {
              $rad=mysqli_fetch_array($sqlResultat);
              $romtype=$rad["romtype"];

              print("<option value='$romtype'>$romtype</option>");
            }
          } else {
            echo $die;
          }
        ?>
      </select>
      <div id="rombilde"></div>
      <div id="visLedigeRom"></div>
    </div>
    <div class="bokser" id="bokserDato">
      <h2>Dato</h2>
      Innsjekkingsdato<br>
    	<input type="text" id="innsjekking" class="datepicker" name="innsjekking" placeholder="innsjekking" onChange="setInnsjekking(this.value)" autocomplete="off"><br><br>
      Utsjekkingsdato<br>
    	<input type="text" id="utsjekking" class="datepicker" name="utsjekking" placeholder="utsjekking" onChange="visSubmit(this.value)" autocomplete="off"><br>
    </div>
  </div>
  <div id="feilmeldingBestill"></div>
</form>
<?php
  include("slutt.php");
?>
<script>
function setRomtype(romtype) {
  thisRomtype = romtype;
  document.getElementById("innsjekking").value = "";
  document.getElementById("utsjekking").value = "";
  document.getElementById("visLedigeRom").innerHTML = "";
  document.getElementById("bokserDato").style.visibility = "visible";

  var foresporsel=new XMLHttpRequest();

	foresporsel.onreadystatechange=function() {
		if (foresporsel.readyState==4 && foresporsel.status==200) {
			document.getElementById("rombilde").innerHTML=foresporsel.responseText;
		}
	}
	foresporsel.open("GET","visRombilde.php?hotellnavn="+thisHotellnavn+"&romtype="+thisRomtype);
	foresporsel.send();
}

function setInnsjekking(innsjekking) {
  thisInnsjekking = innsjekking;
  document.getElementById("utsjekking").value = "";
  document.getElementById("visLedigeRom").innerHTML = "";
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
  thisHotellnavn = verdi;
  var value = document.getElementById('hotellnavnValue').value;

  meldingHotellnavn.innerHTML = "<br><a class='buttonForslag' href='finnRom.php' id='hotellnavnValue' value=''>Velg annet hotell</a>";

  document.getElementById("sok").value = thisHotellnavn;

  var foresporsel=new XMLHttpRequest();

	foresporsel.onreadystatechange=function() {
		if (foresporsel.readyState==4 && foresporsel.status==200) {
			document.getElementById("romtype").innerHTML=foresporsel.responseText;
		}
	}
	foresporsel.open("GET","../romForFinnHotell.php?hotellnavn="+thisHotellnavn);
	foresporsel.send();
  document.getElementById("romtype").innerHTML = "";

  document.getElementById("bokserRomtype").style.visibility = "visible";

  visBilde(verdi);
}

function visBilde(verdi) {
  var foresporsel=new XMLHttpRequest();

	foresporsel.onreadystatechange=function() {
		if (foresporsel.readyState==4 && foresporsel.status==200) {
			document.getElementById("visBilde").innerHTML=foresporsel.responseText;
		}
	}
	foresporsel.open("GET","visBilder.php?verdi="+verdi);
	foresporsel.send();
}

function visSubmit(utsjekking) {
  thisUtsjekking = utsjekking;

  var foresporsel=new XMLHttpRequest();

	foresporsel.onreadystatechange=function() {
		if (foresporsel.readyState==4 && foresporsel.status==200) {
			document.getElementById("visLedigeRom").innerHTML=foresporsel.responseText;
		}
	}
	foresporsel.open("GET","finnLedigRom.php?hotellnavn="+thisHotellnavn+"&romtype="+thisRomtype+"&innsjekking="+thisInnsjekking+"&utsjekking="+thisUtsjekking);
	foresporsel.send();
}

</script>
