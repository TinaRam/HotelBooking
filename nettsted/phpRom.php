<script type="text/javascript" src="script.js"></script>
<?php
  $sok = $_GET["sok"];
  require_once('db.php');

  if (!$sok) {
    $sqlSetning = "SELECT * FROM hotell;";
  } else {
    $sqlSetning = "SELECT * FROM hotell WHERE hotellnavn LIKE '%$sok%'";
  }
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $antallRader = mysqli_num_rows($sqlResultat);

      for ($i=0; $i < $antallRader; $i++) {
        $rad = mysqli_fetch_array($sqlResultat);
        $hotellnavn = $rad["hotellnavn"];
        print("<br><button class='buttonForslag' href='' id='hotellnavnValue' onClick='verdiHotell(this.value); return false' value='$hotellnavn'>$hotellnavn</button>");
      }
    } else {
      print("Kan ikke koble til database");
    }
?>
