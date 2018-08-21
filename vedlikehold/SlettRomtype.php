<?php
include("start.php");
include('dynamiske_funksjoner.php');
?>


<h2> Slett romtype </h2>
<br>
<form action="" method="get" name="seEtterUbrukteRomtyper" >
  Du kan kun slette romtyper som ikke er i bruk. <br>
  <input type="submit" name="finnRomtyper" value="Finn romtyper som ikke er i bruk">
</form>
<br>


<?php

  if (isset($_GET['finnRomtyper']))
  {

    function finnUbrukteRomtyper() {
      global $db;
      $ingenRomtyper; //deklarerer variablen

      $sql = "SELECT * FROM romtype WHERE romtype NOT IN (SELECT romtype FROM hotellromtype);";
      if ($result = mysqli_query($db, $sql)) //Hvis databasen responderer
      {
        if(mysqli_num_rows($result) > 0) // Hvis spørring returnerer ubrukte romtype/er
        {
          echo "Romtyper som kan slettes:";
          return $ingenRomtyper=1; // returnerer at det finnes romtyper man kan slette
        }
        else {
          return $ingenRomtyper=0; // returnerer at det ikke ble funnet noe å slette
        }
      }
      else {
        echo "Ikke mulig å få kontakt med databasen";
        echo "<br>ERROR: <br>#$sql#<br>".mysqli_error($db);
      }
    }

    $ingenRomtyper=finnUbrukteRomtyper(); // Ser etter ubrukte romtyper (dynamiske_funksjoner.php)

    if ($ingenRomtyper === 1) // Hvis det finnes ubrukte romtyper
    {
      ?>
      <form class="" action="" method="post" id="ubrukteRomtyper" name="ubrukteRomtyper">
        <select name="velgRomtype" id="velgRomtype" required>
          <option value="">--Velg romtype du vil slette--</option>
          <?php listeboksUbrukteRomtyper(); ?>
        </select>
        <input type="submit" value="Slett romtype" name="slettRomtypeKnapp" id="slettRomtypeKnapp" onclick="return slettromtypeV()">
      </form>
      <br>
      <div id="melding"></div>
      <div id="feilmelding"></div>
      <?php

      if (isset($_POST['slettRomtypeKnapp'])) // Hvis slette-knappen er trykket på
      {
        $romtype = $_POST['velgRomtype'];

        if ($romtype) // Sletter valgt romtype fra romtype-tabellen
        {
          $sql = "DELETE FROM romtype WHERE romtype='$romtype';";
          if (mysqli_query($db, $sql))
          {
            echo "Sletting vellykket! <br>";
            echo "Romtypen <strong>$romtype</strong> er nå slettet.";
          }
          else {
            echo "Ops, noe gikk galt... Prøv igjen senere.";
            echo "<br>ERROR: <br>#$sql#<br>".mysqli_error($db);
          }

        }
        else // Ingen romype er valgt, gi feedback til bruker
        {
          echo "Velg den romtypen du vil slette!";
        }
      }

    }
    else // Det finnes ikke ubrukte romtyper
    {
      echo "<font color='green'> <b>Alle romtypene er i bruk, ingenting å slette...</b></font>";
    }
  }

?>


<? include("slutt.php") ?>
