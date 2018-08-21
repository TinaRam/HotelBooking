<?php
  $sted = $_GET["sted"];
  
  include("db.php");

  if (!$sted) {
    $sqlSetning = "SELECT sted FROM hotell GROUP BY sted;";
  } else {
    $sqlSetning = "SELECT sted FROM hotell WHERE sted LIKE '%$sted%' GROUP BY sted;";
  }
  $sqlResultat = mysqli_query($db,$sqlSetning);

  if ($sqlResultat) {
    $antallRader = mysqli_num_rows($sqlResultat);

    for ($i=1; $i <= $antallRader; $i++) {
      $rad = mysqli_fetch_array($sqlResultat);
      $sted = $rad["sted"];
      print("<br><button type='button' class='buttonForslag' id='sted' onClick='pressSted(this.value)' value='$sted'>$sted</button>");
    }
  } else {
    print("Kan ikke koble til database");
  }
?>

