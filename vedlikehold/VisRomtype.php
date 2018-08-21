<?php include("start.php"); include("dynamiske_funksjoner.php");?>


    <h2> Viser alle romtyper </h2>
    <br>

<form method="post" action="" name="visHotellromtype" id="visHotellromtype">
  Vis heller romtypene til et bestemt hotell:<br>
  <select name="hotellnavn" id="hotellnavn">
    <option value="">--Velg hotell--</option>
    <?php	listeboksHotell(); 	?>
  </select>
  <input type="submit" name="submit" id="submit" value="Vis romtyper" onclick="return validerVisRomtype()">
  <input type="submit" name="nullstill" id="nullstill" value="Nullstill" onclick="refreshVisRomtyper()">
</form>
<br>
<div id="melding"></div><br>
<div id="feilmelding"></div><br>


<?php

if (isset($_POST ["submit"]))
{
$hotellnavn=$_POST ["hotellnavn"];


$SQLselect="SELECT * FROM hotellromtype WHERE hotellnavn='$hotellnavn';";
if ($SQLresult=mysqli_query($db,$SQLselect))
{

$AntallRader=mysqli_num_rows($SQLresult);

    if (!$AntallRader) {
        print("Fant ingen romtyper på hotellet <strong>$hotellnavn</strong>.");
    }
    else {

echo("<table class='visTabell'>");
echo("<tr> <th>Romtypene til $hotellnavn</th> </tr>");

for ($r=1;$r<=$AntallRader;$r++)
	{
	$rad=mysqli_fetch_array($SQLresult);
	$romtype=$rad["romtype"];

	echo("<tr> <td>$romtype</td> </tr>");
	}
echo("</table>");
        }
}
else
{
  echo "Ikke kontakt med database";
}
}
elseif (isset($_POST ['reset']))
{

$SQLselect="SELECT * FROM romtype;";
if ($SQLresult=mysqli_query($db,$SQLselect)) {

$AntallRader=mysqli_num_rows($SQLresult);

echo("<table class='visTabell'>");
echo("<tr> <th>Romtype</th> </tr>");

for ($r=1;$r<=$AntallRader;$r++)
    {
    $rad=mysqli_fetch_array($SQLresult);
    $romtype=$rad["romtype"];

    echo("<tr> <td>$romtype</td> </tr>");
    }
echo("</table>");
}
else
{
  echo "string";
}
}
else
{
$SQLselect="SELECT * FROM romtype;";
if ($SQLresult=mysqli_query($db,$SQLselect))
{
$AntallRader=mysqli_num_rows($SQLresult);
echo("<table class='visTabell'>");
echo("<tr> <th>Romtype</th> </tr>");

for ($r=1;$r<=$AntallRader;$r++)
	{
	$rad=mysqli_fetch_array($SQLresult);
	$romtype=$rad["romtype"];

	echo("<tr> <td>$romtype</td> </tr>");
	}
echo("</table>");
}
else {
    echo "Ikke kontakt med database";
}
}



include("slutt.php")
?>
