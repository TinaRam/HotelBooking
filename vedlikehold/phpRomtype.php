
<script type="text/javascript" src="script.js"></script>
<?php
include("db.php");

$hotellnavn = $_GET["hotellnavn"];
$sqlSetning="SELECT * FROM hotellromtype WHERE hotellnavn = '$hotellnavn';";
$sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

$antallRader=mysqli_num_rows($sqlResultat);



if ($antallRader == 0) {
  print("<br><font color='red'>Ingen registrerte romtyper. Du må registrere en hotellromtype på dette hotellet før du kan registrere et rom.</font>");
} else {
  print("Romtype <select name='romtype'>");
  print("<option value=''>Velg rom</option>");
  for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $romtype=$rad["romtype"];

      print("<option value='$romtype'>$romtype</option>");
    }
    print("</select><br>");
    print("Romnummer <input type='text' id='romnr' name='romnr' onFocus='fokus(this)' onBlur='mistetFokus(this)' onMouseover='mouseOver(this)' onMouseout='musUt()' required><br>");
    print("<input type='submit' id='submit' name='submit' value='Registrer' onclick='return registrerRom()'><br>");
}
?>
