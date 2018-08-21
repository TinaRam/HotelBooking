<?php
  error_reporting(0);
  ini_set('display_errors', 0);
  include("start.php");
  require_once('../dynamiske_funksjoner.php');
  require_once('db.php');
  $die = "Kan ikke koble til database";
?>
<h2>Våre hoteller</h2>

<form method="post" id="velgSted" name="velgSted" class="formLeft">
  Sorter etter <select id="sorter" name="sorter">
                  <option value="h.hotellnavn">Hotellnavn</option>
                  <option value="pris ASC">Pris lav-høy</option>
                  <option value="pris DESC">Pris høy-lav</option>
                </select><br><br>
  <?php
    $sqlSetning = "SELECT land FROM hotell GROUP BY land;";
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $antallRader = mysqli_num_rows($sqlResultat);

      print("<strong>Land<br></strong>");
      for ($i=1; $i <= $antallRader; $i++) {
        $rad = mysqli_fetch_array($sqlResultat);
        $land = $rad["land"];
        print("<input type='radio' name='land[]' onChange='visSted(this.value)' value='$land'>$land<br>");
      }

      print("<strong><br>By<br></strong>");
    } else {
      echo $die;
    }
  ?>
  <div id="by">
    <?php
      $sqlSetning = "SELECT sted FROM hotell GROUP BY sted;";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        $antallRader = mysqli_num_rows($sqlResultat);

        for ($i=1; $i <= $antallRader; $i++) {
          $rad = mysqli_fetch_array($sqlResultat);
          $sted = $rad["sted"];
          print("<input type='checkbox' id='sted' name='sted[]' value='$sted'>$sted<br>");
        }
      } else {
        echo $die;
      }
    ?>
  </div>
    <?php
    $sqlSetning = "SELECT romtype FROM hotellromtype GROUP BY romtype;";
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $antallRader = mysqli_num_rows($sqlResultat);

      print("<strong><br>Romtype<br></strong>");
      for ($i=1; $i <= $antallRader; $i++) {
        $rad = mysqli_fetch_array($sqlResultat);
        $romtype = $rad["romtype"];
        print("<input type='checkbox' id='romtype' name='romtype[]' value='$romtype'>$romtype<br>");
      }

      $sqlSetning = "SELECT MIN(pris) AS minPris, MAX(pris) AS maxPris FROM hotellromtype;";
      $sqlResultat = mysqli_query($db,$sqlSetning) or die ("Kan ikke hente fra database.");
      $antallRader = mysqli_num_rows($sqlResultat);

      $rad = mysqli_fetch_array($sqlResultat);
      $minPris = $rad["minPris"];
      $maxPris = $rad["maxPris"];
      print("<strong><br>Pris<br></strong>");

      print("Fra kr <span id='prisMin'></span>");
      print("<div class='slidecontainer'>");
      print("<input type='range' min='$minPris' max='$maxPris' value='$minPris' class='slider' id='minPris' name='minPris''>");
      print("</div>");

      print("Til kr <span id='prisMax'></span>");
      print("<div class='slidecontainer'>");
      print("<input type='range' min='$minPris' max='$maxPris' value='$maxPris' class='slider' id='maxPris' name='maxPris''>");
      print("</div><br>");
    } else {
      echo $die;
    }
  ?>
  <input type="submit" id="submit" name="submit" class="button" value="Søk">
  <form method="post">
    <input type="submit" id="submitReset" name="submitReset" class="button" value="Nullstill søk">
  </form>
</form>

<script>
  var minSlider = document.getElementById("minPris");
  var minOutput = document.getElementById("prisMin");

  var maxSlider = document.getElementById("maxPris");
  var maxOutput = document.getElementById("prisMax");

  minOutput.innerHTML = minSlider.value; // Viser default verdi
  maxOutput.innerHTML = maxSlider.value;

  // Oppdaterer verdien når man drar slideren
  minSlider.oninput = function() {
      minOutput.innerHTML = this.value;
  }
  maxSlider.oninput = function() {
      maxOutput.innerHTML = this.value;
  }
</script>

<?php
if (isset($_POST["submit"])) {
    $sted = $_POST["sted"];
    $romtype = $_POST["romtype"];
    $land = $_POST["land"];
    $minPris = $_POST["minPris"];
    $maxPris = $_POST["maxPris"];
    $sorter = $_POST["sorter"];

    include("../sql.php");

    $sqlSetning .= " ORDER BY $sorter ";

    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $antallRader = mysqli_num_rows($sqlResultat);

      if ($antallRader == 0 ) {
        print("<div id='hotellSok'>Beklager, her var det ingenting... prøv et annet søk.</div>");
      } else {
        include("printHotell.php");
      }
    } else {
      echo $die;
    }
  } else {
    $sqlSetning = "SELECT h.hotellnavn, h.sted, h.land, (SELECT GROUP_CONCAT(pris SEPARATOR ',  ') FROM hotellromtype WHERE hotellnavn = h.hotellnavn) AS pris, (SELECT GROUP_CONCAT(romtype SEPARATOR ', ') FROM hotellromtype WHERE hotellnavn = h.hotellnavn) AS romtype, h.bilde
                          FROM hotell as H
                          LEFT JOIN hotellromtype AS hrt ON h.hotellnavn = hrt.hotellnavn
                          GROUP BY h.hotellnavn
                          ORDER BY h.hotellnavn;";
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $antallRader = mysqli_num_rows($sqlResultat);

      include("printHotell.php");
    } else {
      echo $die;
    }
  }

include("slutt.php");
?>
