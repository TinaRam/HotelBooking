<?php
  include("start.php");
  require_once("db.php");
?>
  <h2>Registrerte bestillinger</h2>
  <h3>Aktive bestillinger</h3>

<?php
  $sqlSetning = "SELECT * FROM bestilling;";
  $sqlResultat = mysqli_query($db,$sqlSetning);

  if ($sqlResultat) {
    $antallRader = mysqli_num_rows($sqlResultat);

    print("<table class='visTabell'>");
    print("<tr>
            <th>Bestillingsnummer</th>
            <th>Brukernavn</th>
            <th>Innsjekking</th>
            <th>Utsjekking</th>
            <th>Hotellnavn</th>
            <th>Romnummer</th>
          </tr>");
    for ($i=1; $i <= $antallRader; $i++) {
      $rad = mysqli_fetch_array($sqlResultat);

      $radnr = $rad["radnr"];
      $brukernavn = $rad["brukernavn"];
      $datotil = $rad["datotil"];
      $datofra = $rad["datofra"];
      $hotellnavn = $rad["hotellnavn"];
      $romnr = $rad["romnr"];

      print("<tr>
              <td>$radnr</td>
              <td>$brukernavn</td>
              <td>$datofra</td>
              <td>$datotil</td>
              <td>$hotellnavn</td>
              <td>$romnr</td>
            </tr>");
    }
    print("</table>");
  } else {
    print("Kan ikke koble til database");
  }

  ?>

  <h3>Tidligere bestillinger</h3>

<?php
  $sqlSetning = "SELECT * FROM inaktiv_bestilling;";
  $sqlResultat = mysqli_query($db,$sqlSetning);

  if ($sqlResultat) {
    $antallRader = mysqli_num_rows($sqlResultat);

    print("<table class='visTabell'>");
    print("<tr>
            <th>Bestillingsnummer</th>
            <th>Brukernavn</th>
            <th>Innsjekking</th>
            <th>Utsjekking</th>
            <th>Hotellnavn</th>
            <th>Romnummer</th>
          </tr>");
    for ($i=1; $i <= $antallRader; $i++) {
      $rad = mysqli_fetch_array($sqlResultat);

      $radnr = $rad["radnr"];
      $brukernavn = $rad["brukernavn"];
      $datotil = $rad["datotil"];
      $datofra = $rad["datofra"];
      $hotellnavn = $rad["hotellnavn"];
      $romnr = $rad["romnr"];

      print("<tr>
              <td>$radnr</td>
              <td>$brukernavn</td>
              <td>$datofra</td>
              <td>$datotil</td>
              <td>$hotellnavn</td>
              <td>$romnr</td>
            </tr>");
    }
    print("</table>");
  } else {
    print("Kan ikke koble til database");
  }
  include("slutt.php");
?>
