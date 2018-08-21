<?php
include("start.php");
include('dynamiske_funksjoner.php');
?>

<h3>Endre romtype</h3>

<form method="get" action="" id="velgEndreRomtype" name="velgEndreRomtype">
  <select name="valgtRomtype" id="valgtRomtype">
    <option value="">--Velg romtype--</option>
    <?php listeboksRomtype(); ?>
  </select>
  <input type="submit"  value="Velg" name="velgRomtypeKnapp" id="velgRomtypeKnapp"  onclick="return validerRomtype()">
</form>


<?php
if (isset($_GET["velgRomtypeKnapp"]))
{
  $romtype = $_GET['valgtRomtype'];

  if ($romtype)
  {
    $sql = "SELECT * FROM romtype WHERE romtype='$romtype'"; // forespørsel //
    if ($resultat = mysqli_query($db,$sql))
    {
      $rad = mysqli_fetch_array($resultat);

      $romtype = $rad['romtype'];
    }
    else
    {
      echo "Ikke mulig å hente fra database";
    }

    ?>
    <br>
    <form navn="endreRomtype" id="endreRomtype" action="" method="post">
      Endre til: <input type="text" id="endreTilRomtype" name="endreTilRomtype" value="<?php echo $romtype ?>" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" required><br>
      <input type="submit" value="Endre romtype" name="endreRomtypeKnapp" id="endreRomtypeKnapp" onclick="return validerNyRomtype()">
      <input type="reset" value="Nullstill" id="nullstill" name="nullstill">
      <br>
    </form>

   <?php

    if (isset($_POST['endreRomtypeKnapp']))
    {
      $nyRomtype = $_POST['endreTilRomtype'];

      include('validering.php');
      $gyldigRomtype=validerNyRomtype($nyRomtype);

      if ($gyldigRomtype)
      {
        $sql = "UPDATE romtype SET romtype='$nyRomtype' WHERE romtype='$romtype'";

        if (mysqli_query($db, $sql))
        {
          echo "<br>Romtype: <b>$romtype</b> er nå endret til <i><b>$nyRomtype</b></i>.";
        }
        else
        {
          echo "Endring feilet! Kunne ikke oppdatere i databasen";
        }
      }
    }
  }
  else {
    echo "Velg hvilken romtype du vil endre";
  }
} // velgRomtypeKnapp -slutt-
?>
<div id="kanIkke"> </div><br>
<div id="melding"> </div><br>
<div id="feilmelding"> </div>


<?php include("slutt.php"); ?>
