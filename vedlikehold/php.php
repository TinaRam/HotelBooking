<script type="text/javascript" src="script.js"></script>
<?php
  $sok = $_GET["sok"];

  include("db.php");

  if (!$sok) {
    $sqlSetning = "SELECT hotellnavn FROM hotell GROUP BY hotellnavn;";
  } else {
    $sqlSetning = "SELECT hotellnavn FROM hotell WHERE hotellnavn LIKE '%$sok%' GROUP BY hotellnavn";
  }
    $sqlResultat = mysqli_query($db,$sqlSetning) or die ("Kan ikke koble til database.");
    $antallRader = mysqli_num_rows($sqlResultat);

    for ($i=0; $i < $antallRader; $i++) {
      $rad = mysqli_fetch_array($sqlResultat);
      $hotellnavn = $rad["hotellnavn"];
      print("<br><button class='buttonForslag' id='slettHotell' onClick='verdi(this.value); return false' value='$hotellnavn'>$hotellnavn</button>");
    }

?>
