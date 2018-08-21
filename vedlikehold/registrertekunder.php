<?php
  include("start.php");
  require_once("db.php");
?>

<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<h2 id='overskrift'>Liste over alle registrerte kunder</h2>
<?php


  $sqlSetning = "SELECT * FROM bruker";
  $sqlResultat = mysqli_query($db,$sqlSetning);

  if ($sqlResultat) {
    $antallRader = mysqli_num_rows($sqlResultat);

    print("<table class='visTabell' id='tabell'>"); /* la til id=tabell*/
    print("<tr><th>Brukernavn</th></tr>");

    for ($i = 1; $i <= $antallRader; $i++) {
      $rad = mysqli_fetch_array($sqlResultat);
      $brukernavn = $rad["brukernavn"];
      print("<tr><td>$brukernavn</td></tr>");
    }
    print("</table>");
  } else {
    print("Kan ikke koble til database");
  }	



  include("slutt.php");
?>
