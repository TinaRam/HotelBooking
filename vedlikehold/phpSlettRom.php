<script type="text/javascript" src="script.js"></script>

<?php include("db.php");

$romtype=$_GET["romtype"];
$hotellnavn=$_GET["hotellnavn"];
$sqlSetning="SELECT * FROM rom WHERE romtype='$romtype' AND hotellnavn = '$hotellnavn' ;";
$sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

$antallRader=mysqli_num_rows($sqlResultat);

if ($antallRader == 0) {
  print("<option value=''>Velg romnr</option>");
}

else {

    for ($r=1;$r<=$antallRader;$r++)
      {
        $rad=mysqli_fetch_array($sqlResultat);
        $romnr=$rad["romnr"];

        print("<option value='$romnr'>$romnr</option>");
      }
}

?>



