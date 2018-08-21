<?php
  include("start.php");
  require_once("db.php");
?>

<h2>Registrer romtype</h2>

<div id="regRomType">

<form method="post" action="" id="registrerRomtype" name="registrerRomtype">
  Romtype <input type="text" id="romtype" name="romtype" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" required><br>
<br>
  <div id="melding"></div>
  <div id="feilmelding"></div>
  <div id="kanIkke"></div>

  <div class="knapp"><input type="submit" id="submit" name="submit" value="Registrer" onclick="return registrerRomtypeValider()"><br></div>
</form>
</div>



<?php
  if (isset($_POST["submit"])) {
    $romtype = $_POST["romtype"];
    $vellykket=false;

    include('validering.php');
    $gyldigRomtype=validerRegRomtype($romtype);

    if ($gyldigRomtype) {
      $sqlSetning = "SELECT * FROM romtype WHERE romtype = '$romtype';";
      $sqlResultat = mysqli_query($db,$sqlSetning);

      if ($sqlResultat) {
        $antallRader = mysqli_num_rows($sqlResultat);

        if ($antallRader != 0) {
          print("Romtypen finnes allerede.");
        } else {
          $sqlSetning = "INSERT INTO romtype VALUES ('$romtype')";
          mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; registrere data i databasen");
          print("Romtypen <strong>$romtype</strong> er registrert!");
          $vellykket=true;
        }
      } else {
        print("Kan ikke koble til database");
      }
    }

    if ($vellykket) {
      $SQLselect="SELECT * FROM romtype;";
      if ($SQLresult=mysqli_query($db,$SQLselect)) {
        $AntallRader=mysqli_num_rows($SQLresult);

        print("<br><br></p>Registrerte romtyper:</p>");

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
    else {
      $SQLselect="SELECT * FROM romtype;";
      if ($SQLresult=mysqli_query($db,$SQLselect)) {
        $AntallRader=mysqli_num_rows($SQLresult);

        print("<br><br></p>Romtyper som finnes fra før:</p>");

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
  }
  else
  {
    $SQLselect="SELECT * FROM romtype;";
    if ($SQLresult=mysqli_query($db,$SQLselect)) {
      $AntallRader=mysqli_num_rows($SQLresult);

      print("</p>Romtyper som finnes fra før:</p>");

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

  include("slutt.php");
?>
