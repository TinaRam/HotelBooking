<?php
  include("start.php");
  require_once("dynamiske_funksjoner.php");
  require_once("db.php");
?>
<script type="text/javascript">

function mouseOver(element) {
    document.getElementById("melding").style.color="blue";

    if (element==document.getElementById("romnr")) {
      document.getElementById("melding").innerHTML="Skriv inn romnummeret.<br> Må være et positivt tall, maksimalt femsifret";
    }
}
</script>
<h2>Registrer rom</h2>
<form method="post" id="registererRom" name="registererRom">
  Hotellnavn <select name="hotellnavn" id="hotellnavn" onChange="ting(this.value)" >
                <option value=''>Velg hotell</option>
                <?php	listeboksHotell(); 	?>
              </select><br>
  <div id="romtype">
  Romtype <select name="romtype" id="romtype2" onChange="" >
            <option value=''>--velg romtype--</option>
          </select>
        <br>
  Romnummer <input type="text" id="romnr" name="romnr" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover='mouseOver(this)' onMouseout='musUt()' required><br>

  <input type="submit" id="submit" name="submit" value="Registrer" onclick="return registrerRom()"><br>
  </div>
</form>
<br>

<?php
if (isset($_POST["submit"])) {
  $hotellnavn = $_POST["hotellnavn"];
  @$romtype = $_POST["romtype"];
  $romnr = $_POST["romnr"];

  if (!$hotellnavn || !$romtype || !$romnr) {
    print("Alle feltene må fylles inn.");
  } else if (!is_numeric($romnr)) {
    print("Romnummer må være et tall.");
  } else if ($romnr < 1) {
    print("Romnummer kan ikke være lavere enn 1.");
  } else {
    $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn' AND romnr = '$romnr';";
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $antallRader = mysqli_num_rows($sqlResultat);

      if ($antallRader != 0) {
        print("Hotellet har allerede dette rommet.");
      } else {
        $sqlSetning = "INSERT INTO rom VALUES ('$hotellnavn','$romtype','$romnr')";
        $sqlResultat = mysqli_query($db,$sqlSetning);

        if ($sqlResultat) {
          print("$hotellnavn er registrert med $romtype med romnummer $romnr");
        } else {
          print("Kan ikke koble til database");
        }
      }
    } else {
      print("Kan ikke koble til database");
    }
  }
}

?>
<div id="melding"></div>
<div id="feilmelding"></div>
<div id="kanIkke"></div>

<?php

include("slutt.php"); ?>
<script>
function ting(hotellnavn) {
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
function removeRomnr(romnr) {

  document.getElementById('romnr').innerHTML = "";
}
</script>
