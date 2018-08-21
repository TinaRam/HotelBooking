<?php include("start.php"); ?>
<center><h2>Aktive bestillinger</h2></center>
<p>Trykk på et hotellnavn for å endre eller kansellere rombestillingen, eller på "Slett bestilling" for å slette hele bestillingen</p><br>
<?php
  $brukernavn = $_SESSION["brukernavn"];
  require_once("db.php");

  $setning = "SELECT bestnr FROM bestilling WHERE brukernavn = '$brukernavn' GROUP BY bestnr ORDER BY bestnr DESC;";
  $resultat = mysqli_query($db,$setning);

  if ($resultat) {
    $rader = mysqli_num_rows($resultat);

    for ($j=0; $j < $rader; $j++) {
      $row = mysqli_fetch_array($resultat);
      $bestnr = $row["bestnr"];


        $sqlSetning = "SELECT b.radnr, b.bestnr, b.datofra, b.datotil, datediff(b.datotil, b.datofra) AS antallNetter, b.hotellnavn, COUNT(b.romnr) AS antallRom,
                              r.romtype, hrt.pris AS prisPerRom, COUNT(b.romnr) * hrt.pris * datediff(b.datotil, b.datofra) AS totalPris
                              FROM bestilling AS b
                              JOIN rom AS r ON b.hotellnavn = r.hotellnavn AND b.romnr = r.romnr
                              JOIN hotellromtype AS hrt on b.hotellnavn = hrt.hotellnavn AND r.romtype = hrt.romtype
                              WHERE brukernavn = '$brukernavn'
                              AND bestnr = '$bestnr'
                              GROUP BY b.hotellnavn, b.datofra, b.datotil, r.romtype
                              ORDER BY b.datofra, b.datotil, b.hotellnavn;";
        $sqlResultat = mysqli_query($db,$sqlSetning);

        if ($sqlResultat) {
          $antallRader = mysqli_num_rows($sqlResultat);

          print("<center><h4>Bestnr. $bestnr</h4></center>");
          print("<table class='visTabell'>");
          print("<tr><th>Innsjekking</th><th>Utsjekking</th><th>Antall netter</th><th>Hotell</th><th>Romtype</th><th>Antall rom</th><th>Pris pr rom pr natt</th><th>Pris totalt</th></tr>");
		  
		  $sum = 0;
          for ($i=1; $i <= $antallRader; $i++) {
            $rad = mysqli_fetch_array($sqlResultat);

            $radnr = $rad["radnr"];
            $bestnr = $rad["bestnr"];
            $innsjekking = $rad["datofra"];
            $utsjekking = $rad["datotil"];
            $antallNetter = $rad["antallNetter"];
            $hotellnavn = $rad["hotellnavn"];
            $antallRom = $rad["antallRom"];
            $romtype = $rad["romtype"];
            $prisPerRom = $rad["prisPerRom"];
            $totalPris = $rad["totalPris"];
			
			$sum += $totalPris;

            print("<tr>
                    <td>$innsjekking</td>
                    <td>$utsjekking</td>
                    <td>$antallNetter</td>
                    <td><a href='endreBestillingVidere.php?radnr=$radnr&hotellnavn=$hotellnavn&antallRom=$antallRom'>$hotellnavn</a></td>
                    <td>$romtype</td>
                    <td>$antallRom</td>
                    <td>$prisPerRom</td>
                    <td>$totalPris</td>
                  </tr>");
				  
			
          }
		  if ($antallRader > 1) {
				print("<tr><td><strong>SUM</strong></td><td></td><td></td><td></td><td></td><td></td><td></td><td><strong>$sum</strong></td></tr>");
			}
          print("</table>");
          ?>
            <form method="post" onSubmit="return confirm('Er du sikker på at du vil slette bestillingen? Det kan ikke gjøres om!');">
            <input type="hidden" name="bestillingsnummer" value="<?php echo $bestnr ?>">
            <input type="submit" name="submit" class="button red" value="Slett bestilling">
            </form><br><br>
          <?php
        } else {
          print("Kan ikke koble til database");
        }
    }
  } else {
    echo $die;
  }

?>
  <br><br><center><h2>Tidligere bestillinger</h2></center>
<?php
  $sqlSetning = "SELECT b.radnr, b.datofra, b.datotil, datediff(b.datotil, b.datofra) AS antallNetter, b.hotellnavn, COUNT(b.romnr) AS antallRom,
                        r.romtype, hrt.pris AS prisPerRom, COUNT(b.romnr) * hrt.pris * datediff(b.datotil, b.datofra) AS totalPris
                        FROM inaktiv_bestilling AS b
                        JOIN rom AS r ON b.hotellnavn = r.hotellnavn AND b.romnr = r.romnr
                        JOIN hotellromtype AS hrt on b.hotellnavn = hrt.hotellnavn AND r.romtype = hrt.romtype
                        WHERE brukernavn = '$brukernavn'
                        GROUP BY b.hotellnavn, b.datofra, b.datotil, r.romtype
                        ORDER BY b.datofra, b.datotil, b.hotellnavn;";
  $sqlResultat = mysqli_query($db,$sqlSetning);
  if ($sqlResultat) {
    $antallRader = mysqli_num_rows($sqlResultat);

    print("<table class='visTabell'>");
    print("<tr><th>Innsjekking</th><th>Utsjekking</th><th>Antall netter</th><th>Hotell</th><th>Romtype</th><th>Antall rom</th><th>Pris pr rom pr natt</th><th>Pris totalt</th></tr>");
    for ($i=1; $i <= $antallRader; $i++) {
      $rad = mysqli_fetch_array($sqlResultat);

      $radnr = $rad["radnr"];
      $innsjekking = $rad["datofra"];
      $utsjekking = $rad["datotil"];
      $antallNetter = $rad["antallNetter"];
      $hotellnavn = $rad["hotellnavn"];
      $antallRom = $rad["antallRom"];
      $romtype = $rad["romtype"];
      $prisPerRom = $rad["prisPerRom"];
      $totalPris = $rad["totalPris"];

      print("<tr>
              <td>$innsjekking</td>
              <td>$utsjekking</td>
              <td>$antallNetter</td>
              <td>$hotellnavn</td>
              <td>$romtype</td>
              <td>$antallRom</td>
              <td>$prisPerRom</td>
              <td>$totalPris</td>
            </tr>");
    }
    print("</table>");
  } else {
    print("Kan ikke koble til database");
  }

  if (isset($_POST["submit"])) {
    $bestnr = $_POST["bestillingsnummer"];

    $sqlSetning = "DELETE FROM bestilling WHERE bestnr = '$bestnr';";
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      print("<h2>Bestilling slettet<h2>");
    } else {
      echo $die;
    }
  }
  include("slutt.php");
?>
