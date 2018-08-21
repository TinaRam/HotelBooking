<?php
  $land = $_GET["land"];

  require_once('db.php');

  if ($land) {
    $sqlSetning = "SELECT sted FROM hotell WHERE land = '$land' GROUP BY sted;";
  } else {
    $sqlSetning = "SELECT sted FROM hotell GROUP BY sted;";
  }
  $sqlResultat = mysqli_query($db,$sqlSetning);

  if ($sqlResultat) {
    $antallRader = mysqli_num_rows($sqlResultat);

    for ($i=1; $i <= $antallRader; $i++) {
      $rad = mysqli_fetch_array($sqlResultat);
      $sted = $rad["sted"];
      print("<input type='checkbox' id='sted' name='sted[]' value='$sted'>$sted<br>");
    }
  } else {
    print("Kan ikke koble til database");
  }
?>
