<?php
  include("start.php");
?>
<h2>Våre hoteller</h2>
<form method="post" id="velgSted" name="velgSted" class="formLeft">
  <?php
    $sqlSetning = "SELECT sted FROM hotell;";
    $sqlResultat = mysqli_query($db,$sqlSetning) or die ("Kan ikke hente fra database.");
    $antallRader = mysqli_num_rows($sqlResultat);

    print("<strong>Sted<br></strong>");
    for ($i=1; $i <= $antallRader; $i++) {
      $rad = mysqli_fetch_array($sqlResultat);
      $sted = $rad["sted"];
      print("<input type='checkbox' id='sted' name='sted[]'>$sted<br>");
    }
  ?><!--
  <?php
    $sqlSetning = "SELECT romtype FROM hotellromtype GROUP BY romtype;";
    $sqlResultat = mysqli_query($db,$sqlSetning) or die ("Kan ikke hente fra database.");
    $antallRader = mysqli_num_rows($sqlResultat);

    print("<strong><br>Romtype<br></strong>");
    for ($i=1; $i <= $antallRader; $i++) {
      $rad = mysqli_fetch_array($sqlResultat);
      $romtype = $rad["romtype"];
      print("<input type='checkbox' id='romtype' name='romtype'>$romtype<br>");
    }
  ?>
  <?php
    $sqlSetning = "SELECT MIN(pris) AS minPris, MAX(pris) AS maxPris FROM hotellromtype;";
    $sqlResultat = mysqli_query($db,$sqlSetning) or die ("Kan ikke hente fra database.");
    $antallRader = mysqli_num_rows($sqlResultat);

    $rad = mysqli_fetch_array($sqlResultat);
    $minPris = $rad["minPris"];
    $maxPris = $rad["maxPris"];
    print("<strong><br>Pris<br></strong>");

    print("Fra <input type='text' id='minPris' name='minPris' value='$minPris'><br>");
    print("Til <input type='text' id='maxPris' name='maxPris' value='$maxPris'>");

  ?>-->
  <input type="submit" id="submit" name="submit" class="button" value="Søk">
</form>

<?php
if (isset($_POST["submit"])) {
    $sted = $_POST["sted"];
    /*$romtype = $_POST["romtype"];
    $minPris = $_POST["minPris"];
    $maxPris = $_POST["maxPris"];*/

    for ($i=0; $i < count($sted); $i++) {
      print($sted[$i]);
    }

    if (!$sted) {
      $sqlSetning = "SELECT h.hotellnavn, h.sted, MIN(hrt.pris) AS pris, GROUP_CONCAT(hrt.romtype SEPARATOR ', ') AS romtype
                            FROM hotell as H
                            LEFT JOIN hotellromtype AS hrt ON h.hotellnavn = hrt.hotellnavn
                            GROUP BY h.hotellnavn;";
      $sqlResultat = mysqli_query($db,$sqlSetning) or die ("Kan ikke hente fra database.");
      $antallRader = mysqli_num_rows($sqlResultat);

      include("printHotell.php");
    } else {
      include("sqlTest.php");

      $sqlResultat = mysqli_query($db,$sqlSetning) or die ("Kan ikke hente fra database.");
      $antallRader = mysqli_num_rows($sqlResultat);

      include("printHotell.php");
    }
  } else {
  $sqlSetning = "SELECT h.hotellnavn, h.sted, MIN(hrt.pris) AS pris, GROUP_CONCAT(hrt.romtype SEPARATOR ', ') AS romtype
                        FROM hotell as H
                        LEFT JOIN hotellromtype AS hrt ON h.hotellnavn = hrt.hotellnavn
                        GROUP BY h.hotellnavn;";
  $sqlResultat = mysqli_query($db,$sqlSetning) or die ("Kan ikke hente fra database.");
  $antallRader = mysqli_num_rows($sqlResultat);

  include("printHotell.php");
}
include("slutt.php");
?>
