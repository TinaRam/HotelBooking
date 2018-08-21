<style>
</style>
<?php
for ($r=1; $r <= $antallRader; $r++) {
  $rad=mysqli_fetch_array($sqlResultat);
  $hotellnavn=$rad["hotellnavn"];
  $sted=$rad["sted"];
  $land=$rad["land"];
  $pris=$rad["pris"];
  $romtype=$rad["romtype"];
  $bilde=$rad["bilde"];

  print("<form method='post' action='bestillHotell.php?hotellnavn=$hotellnavn' class='hotell'>");
  print("<h2>$hotellnavn</h2>");
  print("<h4>$land, $sted</h4>");
  print("<div id='images' height=100>");
  print("<img style='float: left; width: 200px; ' src='../../filer/$bilde'><br><br>");

  $sql = "SELECT rombilde FROM hotellromtype WHERE hotellnavn = '$hotellnavn';";
  $resultat = mysqli_query($db,$sql);

  if ($resultat) {
    $rader = mysqli_num_rows($resultat);

    for ($j=0; $j < $rader; $j++) {
      $rad = mysqli_fetch_array($resultat);
      $rombilde = $rad["rombilde"];
      print("<img style='float: left; width: 100px; height: 100px;' src='../../filer/$rombilde'><br><br>");

    }
    print("</div>");




  } else {
    print("Kan ikke koble til database");
  }

  print("Hotellet tilbyr ");
  if ($romtype) {
    print("<strong>$romtype</strong>");
  } else {
    print("ingen rom for øyeblikket");
  }
  print("<div id='prisOgKnapp'><h3>");
  if ($pris) {
    print("Kr pr natt <br> <span class='pris'> $pris,-</span><br><br>");
    print("<input type='submit' name='submit' id='submit' class='button' value='Book hotell'>");
  } else {
    print("");
  }
  print("</h3>");
  print("</div>");
  print("</form>");


}
?>
