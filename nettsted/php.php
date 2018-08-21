<script type="text/javascript" src="script.js"></script>
<?php
  $sok = $_GET["sok"];

  require_once('db.php');

  if (!$sok) {
    $sqlSetning = "SELECT sted FROM hotell GROUP BY sted;";
  } else {
    $sqlSetning = "SELECT sted FROM hotell WHERE sted LIKE '%$sok%' GROUP BY sted";
  }
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $antallRader = mysqli_num_rows($sqlResultat);

      for ($i=0; $i < $antallRader; $i++) {
        $rad = mysqli_fetch_array($sqlResultat);
        $sted = $rad["sted"];
        print("<br><button class='buttonForslag' href='' id='stedValue' onClick='verdi(this.value); return false' value='$sted'>$sted</button>");
      }
    } else {
      print("Kan ikke koble til database");
    }
?>
