<?php
include("start.php");
include('dynamiske_funksjoner.php');
?>


<h3>Endre rom</h3>

<form method="post" action="" id="velgHotellEndreRom" name="velgHotellEndreRom" onsubmit="return validerHotellEndreRom()">
  <select name="valgtHotellnavn" id="valgtHotellnavn">
    <option value="">--Velg hotell--</option>
    <?php listeboksHotellnavnEndreRom(); ?>
  </select>
  <input type="submit"  value="Velg" name="velgHotellnavnKnapp" id="velgHotellnavnKnapp">
</form>
<br>
<div id="kanIkke"> </div>
<div id="melding"> </div>
<div id="feilmelding"> </div>

<?php
if (isset($_POST["velgHotellnavnKnapp"]))
{
  $hotellnavn = $_POST["valgtHotellnavn"];

  if ($hotellnavn)
  {
    ?>
      <form method="post" name="velgRomnrEndreRom" id="velgRomnrEndreRom" onsubmit="return validerRom()">
        <input type="text" name="valgtHotellnavnUendret" value="<?php echo $hotellnavn; ?>" readonly>

        <select name="valgtRomnr" id="valgtRomnr">
          <option value="">--Velg romnr--</option>
          <?php listeboksRomnrEndreRom($hotellnavn);?>
        </select>
        <input type="submit"  value="Velg" name="velgRomnrKnapp" id="velgRomnrKnapp">
      </form>
      <br>
      <div id="kanIkke"> </div>
      <div id="melding"> </div>
      <div id="feilmelding"> </div>
      <?php

  } //hotellnavn valgt -slutt-
  else
  {
    echo "Du må velge hotellnavn";
  }

} // velgHotellnavnKnapp -slutt-



if (isset($_POST['velgRomnrKnapp']))
{
  $romnr = $_POST['valgtRomnr'];
  $hotellnavn = $_POST['valgtHotellnavnUendret'];

  $sql = "SELECT romtype FROM hotellromtype WHERE hotellnavn = '$hotellnavn'";
  if ($resultat=mysqli_query($db,$sql)) {
    // code...
  }
  else {
    echo "<br>ERROR:<br> #$sql#<br> ". mysqli_error($db);
  }
    ?>
      <form navn="endreRom" id="endreRom" action="" method="post">

        Hotellnavn  <input type="text" id="uendretHotellRom" name="uendretHotellRom" value="<?php echo $hotellnavn ?>" onMouseover="musInn(this)" onMouseout="musUt()" readonly><br>
        Romnr  <input type="text" id="uendretRomnr" name="uendretRomnr" value="<?php echo $romnr ?>" onMouseover="musInn(this)" onMouseout="musUt()" readonly><br>
        Endre romtype til:
          <select name="valgtRomtype" id="valgtRomtype">
            <option value="">--Velg ny romtype--</option>
            <?php
              while ($rad=mysqli_fetch_array($resultat)) {
              $nyRomtype=$rad["romtype"];
            ?>
              <option value='<?php echo $nyRomtype ?>'><?php echo $nyRomtype ?></option>
              <?php
            }
            ?>
          </select>
        <br>
        <input type="hidden" name="varHotellnavn" value="<?php echo $hotellnavn; ?>">
        <input type="hidden" name="varRomnr" value="<?php echo $romnr; ?>">
        <input type="submit" value="Endre rom" name="endreRomKnapp" id="endreRomKnapp">
        <input type="reset" value="Nullstill" id="nullstill" name="nullstill" onClick="fjernMelding()">
      </form>
      <br>
      <div id="kanIkke"> </div>
      <div id="melding"> </div>
      <div id="feilmelding"> </div>


    <?php

} // velgRomnrKnapp -slutt-

if (isset($_POST['endreRomKnapp']))
{
  $hotellnavn = $_POST['varHotellnavn'];
  $romnr = $_POST['varRomnr'];
  $nyRomtype = $_POST['valgtRomtype'];

  $sql = "UPDATE rom
          SET romtype = '$nyRomtype'
          WHERE hotellnavn = '$hotellnavn'
          AND romnr = '$romnr'";
  if (mysqli_query($db,$sql))
  {
    echo "Endring vellykket! <br>";
    echo "Romnr: <strong>$romnr</strong> på <strong>$hotellnavn</strong> er nå romtypen $nyRomtype";
  }
  else
  {
    echo "feil ved oppdatering av rom-tabellen <br>";
    echo "<br>ERROR:<br> #$sql#<br> ". mysqli_error($db);
  }

} // endreRomKnapp -slutt-


 include("slutt.php"); ?>
