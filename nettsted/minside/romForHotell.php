
<?php
  $hotellnavn = $_GET["verdi"];

  require_once("db.php");

  $sqlSetning = "SELECT romtype FROM hotellromtype WHERE hotellnavn = '$hotellnavn';";
  $sqlResultat = mysqli_query($db,$sqlSetning);

  if ($sqlResultat) {
    $antallRader = mysqli_num_rows($sqlResultat);

    if ($antallRader == 0) {
      print("Ingen rom tilgjengelig");
    } else {
      print("<table width=100% id='romtypeTabell'>");
      print("<tr><th>Romtype</th><th>Antall rom</th><th>Pris pr natt</th></tr>");
      for ($i=0; $i < $antallRader; $i++) {
        $rad = mysqli_fetch_array($sqlResultat);
        $romtype = $rad["romtype"];
        print("<tr><td><input type='text' class='vanligTekst' name='romtype[]' id='romtype' value='$romtype' readonly></td>");
        print("<td><select name='antallRom[]' id='antallRom' onChange='setRomtype(this.value, \"$romtype \");'>");

        $sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
        $sqlResult = mysqli_query($db,$sqlSetning);

        if ($sqlResult) {
          $rader = mysqli_num_rows($sqlResult);
          for ($j=0; $j < $rader + 1; $j++) {
            print("<option value='$j'>$j</option>");
          }
          print("</select></td>");
        }

        $sqlSetning = "SELECT pris FROM hotellromtype WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
        $sqlRes = mysqli_query($db,$sqlSetning);

        if ($sqlRes) {
          $rad = mysqli_fetch_array($sqlRes);
          $pris = $rad["pris"];
          print("<td><input type='text' class='vanligTekst' name='pris[]' id='pris' value='$pris' readonly></td></tr>");
        }

      }
      print("</table>");
    }
  } else {
    print("Kan ikke koble til database");
  }

?>
