<script type="text/javascript" src="script.js"></script>

<?php include("db.php");

$sokEtterBruker=$_GET["brukernavn"];
$sqlSetning="SELECT brukernavn FROM bruker WHERE brukernavn LIKE '%$sokEtterBruker%';";
$sqlResultat=mysqli_query($db,$sqlSetning);

if ($sqlResultat) {
  $antallRader=mysqli_num_rows($sqlResultat);
}

else {
  print ("Kan ikke koble til database");
}

if ($antallRader == 0) {
  print("Ingen treff");
}

else {

  print ("Treff i <strong>bruker</strong>-tabellen:<br><br>");
  print ("<table class='visTabell'");
  print ("<tr><td><strong>Brukernavn</strong></td></tr>");

    for ($r=1;$r<=$antallRader;$r++)
      {
        $rad=mysqli_fetch_array($sqlResultat);
        $sokEtterBruker=$rad["brukernavn"];

        print ("<tr><td>$sokEtterBruker</td></tr>");

      }
        print ("</table>");
}

?>
