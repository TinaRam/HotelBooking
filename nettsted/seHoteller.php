<?php
  include("start.php");
  require_once('db.php');
  $die = "Kan ikke koble til database";
?>
<h2>Se hoteller</h2>
<form method="post" id="seHotell" name="seHotell" class="formLeft">
  <input type="text" id="sok" name="sok" placeholder="Søk i stedsnavn" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" onKeyUp="vis(this.value)" required><br>
  <div id="meldingForslag">
    <?php
      $sqlSetning = "SELECT sted FROM hotell GROUP BY sted;";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        $antallRader = mysqli_num_rows($sqlResultat);

        for ($i=0; $i < $antallRader; $i++) {
          $rad = mysqli_fetch_array($sqlResultat);
          $sted = $rad["sted"];
          print("<br><button class='buttonForslag' href='' id='stedValue' onClick='verdi(this.value); return false' value='$sted'>$sted</button>");
        }
      } else {
        echo $die;
      }
    ?>
  </div>
  <br>
  <input type="submit" id="submit" name="submit" value="Søk" class="button"><br>
</form>
<?php

  if (isset($_POST["submit"])) {
    $sok = $_POST["sok"];

    if (!$sok) {
      print("Vennligst velg sted.");
    } else {
      $sqlSetning = "SELECT hrt.hotellnavn, h.sted, GROUP_CONCAT(hrt.romtype SEPARATOR ', ') AS romtype, h.bilde FROM hotellromtype AS hrt
                       INNER JOIN hotell AS h ON h.hotellnavn = hrt.hotellnavn
                       WHERE sted LIKE '%$sok%'
                       GROUP BY h.hotellnavn;;";
      $sqlResultat = mysqli_query($db, $sqlSetning);

      if ($sqlResultat) {
        $antallRader = mysqli_num_rows($sqlResultat);

        if ($antallRader < 1) {
          print("<div id='hotellSok'>Fant ingen hoteller på/i $sok. Prøv et annet søk.</div>");
        } else {
          for ($i=1; $i <= $antallRader; $i++) {
            $rad = mysqli_fetch_array($sqlResultat);
            $hotellnavn = $rad["hotellnavn"];
            $sted = $rad["sted"];
            $romtype = $rad["romtype"];
            $bilde = $rad["bilde"];


            print("<div class='hotell'>");
            print("<h2>$hotellnavn</h2>");
            print("<h4>$sted</h4>");
            print("<img src='../filer/$bilde'><br><br>");
            print("Dette hotellet tilbyr <strong>$romtype</strong>");
            print("</div>");
          }
        }
      } else {
        echo $die;
      }
    }
  }

  include("slutt.php");
?>
