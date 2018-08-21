<?php
include("start.php");
include("dynamiske_funksjoner.php");
?>


    <h2> Viser alle rom</h2>
    <br>
<form method="post" action="" name="visRom" id="visRom">
Vis heller rommene til et bestemt hotell: <br>
  <select name="hotellnavn" id="hotellnavn">
    <option value="">--velg hotell--</option>
    <?php listeboksHotell(); 	?>
  </select>
            <input type="submit" name="submit" id="submit" value="Vis" onclick="return validerVisRom()">
            <input type="submit" name="reset" id="reset" value="Nullstill" onClick="refreshVisRom()">
</form>
<br>
<div id="feilmelding"></div><br>
<div id="melding"></div><br>


<?php

if (isset($_POST ["submit"]))
{
  $hotellnavn=$_POST ["hotellnavn"];

  if (!$hotellnavn) {
    echo "Du må velge et hotell!";
  }
  else {

    $SQLselect="SELECT * FROM rom WHERE hotellnavn='$hotellnavn';";
    $SQLresult=mysqli_query($db,$SQLselect) or die ("Ikke mulig å hente fra db.");

    $AntallRader=mysqli_num_rows($SQLresult);

      if (!$AntallRader) {
          print("Fant ingen rom på dette hotellet <strong>$hotellnavn</strong>.");
      }
      else {

      echo("<table class='visTabell'");
      echo("<tr> <th>Hotellnavn</th><th>Romtype</th><th>Romnummer</th> </tr>");

      for ($r=1;$r<=$AntallRader;$r++)
        {
        $rad=mysqli_fetch_array($SQLresult);
        $hotellnavn=$rad["hotellnavn"];
        $romtype=$rad["romtype"];
        $romnr=$rad["romnr"];

        echo("<tr> <td>$hotellnavn</td><td>$romtype</td><td>$romnr</td> </tr>");
        }
  echo("</table>");
      }
    }
  }
  elseif (isset($_POST ['reset'] ))
  {
  include("db.php");


  $SQLselect="SELECT * FROM rom;";
  $SQLresult=mysqli_query($db,$SQLselect) or die ("Ikke mulig å hente fra db.");

  $AntallRader=mysqli_num_rows($SQLresult);

  echo("<table class='visTabell'");
  echo("<tr> <th>Hotellnavn</th><th>Romtype</th><th>Romnummer</th> </tr>");

      for ($r=1;$r<=$AntallRader;$r++)
        {
        $rad=mysqli_fetch_array($SQLresult);
        $hotellnavn=$rad["hotellnavn"];
        $romtype=$rad["romtype"];
        $romnr=$rad["romnr"];

        echo("<tr> <td>$hotellnavn</td><td>$romtype</td><td>$romnr</td> </tr>");
        }
  echo("</table>");
  } else {

  include("db.php");


  $SQLselect="SELECT * FROM rom;";
  $SQLresult=mysqli_query($db,$SQLselect) or die ("Ikke mulig å hente fra db.");

  $AntallRader=mysqli_num_rows($SQLresult);

  echo("<table class='visTabell'");
  echo("<tr> <th>Hotellnavn</th><th>Romtype</th><th>Romnummer</th> </tr>");

      for ($r=1;$r<=$AntallRader;$r++)
        {
        $rad=mysqli_fetch_array($SQLresult);
        $hotellnavn=$rad["hotellnavn"];
        $romtype=$rad["romtype"];
        $romnr=$rad["romnr"];

        echo("<tr> <td>$hotellnavn</td><td>$romtype</td><td>$romnr</td> </tr>");
        }
  echo("</table>");
}



include("slutt.php")
?>
