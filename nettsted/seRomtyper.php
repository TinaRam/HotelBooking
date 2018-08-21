<?php
  include("start.php");
  require_once('dynamiske_funksjoner.php');
  require_once('db.php');
  $die = "Kan ikke koble til database";
?>
<h2>Se romtyper</h2>
<form method="post" id="seRomtyper" name="seRomtyper" class="formLeft">
  <input type="text" id="sok" name="sok" placeholder="Søk i hotellnavn" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" onKeyUp="visRom(this.value)" required><br>
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
  <input type="submit" name="submit" id="submit" value="Se romtyper" class="button"><br>
</form>
<?php
  if(isset($_POST["submit"])) {
    $hotellnavn = $_POST["sok"];

    if (!$hotellnavn) {
      print("Vennligst velg hotell.");
    } else {
      $sqlSetning = "SELECT hrt.hotellnavn, h.sted, GROUP_CONCAT(hrt.romtype SEPARATOR ', ') AS romtype, h.bilde FROM hotellromtype AS hrt
                       INNER JOIN hotell AS h ON h.hotellnavn = hrt.hotellnavn
                       WHERE hrt.hotellnavn = '$hotellnavn'
                       GROUP BY h.hotellnavn;";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        $antallRader = mysqli_num_rows($sqlResultat);
        $rad = mysqli_fetch_array($sqlResultat);
        $romtype = $rad["romtype"];
        $sted = $rad["sted"];
        $bilde = $rad["bilde"];

        if ($antallRader == 0) {
          print("<div id='hotellSok'>Dette hotellet tilbyr ingen rom for øyeblikket.</div>");
        } else {
          print("<div class='hotell'>");
          print("<h2>$hotellnavn</h2>");
          print("<h4>$sted</h4>");
          print("<img src='../filer/$bilde'><br><br>");
          print("$hotellnavn tilbyr disse romtypene:<br><br>");

          $sqlSetning = "SELECT romtype, rombilde FROM hotellromtype WHERE hotellnavn = '$hotellnavn';";
          $sqlResultat = mysqli_query($db,$sqlSetning);

          if ($sqlResultat) {
            $rader = mysqli_num_rows($sqlResultat);

            print("<table id='rombildeTabell'>");
            print("<tr>");
            $x = 0;
            for ($j=0; $j < $rader; $j++) {
              if ($x == 2) {
                print("</tr><tr>");
                $x = 0;
              }
              $row = mysqli_fetch_array($sqlResultat);
              $romtype = $row["romtype"];
              $rombilde = $row["rombilde"];
              print("<td><strong>$romtype</strong><br><img class='romtypeBilde' src='../filer/$rombilde'></td>");
              $x++;
            }
            print("</tr>");
            print("</table>");
          } else {
            echo $die;
          }
          print("</div>");
        }
      } else {
        echo $die;
      }
    }
  }

  include("slutt.php");
?>
