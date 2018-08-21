<?php include("start.php"); include("dynamiske_funksjoner.php"); ?>

<h3>Endre hotellromtype</h3>
<br>
<form method="post" action="" id="velgHotell" name="velgHotell" onsubmit="return validerValgtHotellnavn()">
  <select name="hotellnavn">
    <option value="">--Velg hotellnavn--</option>
    <?php listeboksEndreHotellromtypeHotell() ?>
  </select>
  <input type="submit" value="Velg hotell" name="velgHotellKnapp" id="velgHotellKnapp">
  <br>
</form>
<br>
<div id="melding"> </div>
<div id="feilmelding"> </div>
<div id="kanIkke"> </div>

<?php
if (isset($_POST['velgHotellKnapp']))
{
  @$hotellnavn=$_POST['hotellnavn'];

  if (!$hotellnavn) // det er IKKE valgt et hotellnavn
  {
    echo "Velg det hotellet du ønsker å endre hotellromtype på";
  }
  else // setter inn en select-box med romtypene til $hotellnavn
  {
    ?>
    <form method="post" action="" id="velgRomtype" name="velgRomtype" onsubmit="return validerValgtRomtype()">
      <input type="text" name="valgtHotell" value="<?php echo $hotellnavn; ?>" readonly disabled>
      <select name="romtype">
        <option value="">--Velg romtype--</option>
        <?php listeboksEndreHotellromtypeRomtype($hotellnavn) ?>
      </select>
      <input type="submit" value="Velg romtype" name="velgRomtypeKnapp" id="velgRomtypeKnapp">
      <input type="hidden" value="<?php echo $hotellnavn; ?>" name="valgtHotell" id="valgtHotell">
      <br>
    </form>
    <br>
    <div id="melding"> </div>
    <div id="feilmelding"> </div>
    <div id="kanIkke"> </div>
    <?php
  }
} // velgHotellKnapp -slutt-


if (isset($_POST['velgRomtypeKnapp']))
{
  @$hotellnavn = $_POST['valgtHotell'];
  @$romtype = $_POST['romtype'];

  if (!$romtype) // Om det IKKE er valgt romtype
  {
    echo "Du må velge en av romtypene til $hotellnavn";
  }
  else // Romtype er valgt
  {
    $sql = "SELECT * FROM hotellromtype WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";

    if ($resultat = mysqli_query($db, $sql)) // Om henting fra databasen er vellykket
    {
      $rad = mysqli_fetch_array($resultat); // Legger dataen i en array "$rad" //

      $hotellnavn = $rad['hotellnavn'];
      $romtype = $rad['romtype'];
      $pris = $rad['pris'];
      $bildefil = $rad['rombilde'];
      @$bilde = '../filer/'.$bildefil;
      $antallrom = $rad['antallrom'];


      mysqli_free_result($resultat);   // Frigjør spørreresultatet - frigjør minne //
      ?>

      <div id="rombilde">
        <?php
          if ($bildefil) {
            ?>
            <img src="<?php echo $bilde?>" width="200" height="250">
            <?php
          }
          else {
            ?>
            <img src="../filer/No-image-available.jpg" width="200" height="250">
            <?php
          }
        ?>
      </div>

      <form navn="endreHotellromtype" id="endreHotellromtype" action="" method="post" enctype="multipart/form-data" onsubmit="return validerPris()">

        Hotellnavn  <input type="text" id="uendretHotell" name="uendretHotell" value="<?php echo $hotellnavn ?>" onMouseover="musInn(this)" onMouseout="musUt()" readonly><br>
        Romtype  <input type="text" id="uendretRomtype" name="uendretRomtype" value="<?php echo $romtype ?>" onMouseover="musInn(this)" onMouseout="musUt()" readonly ><br>
        Pris: <input type="text" id="endrePris" name="endrePris" value="<?php echo $pris ?>" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()"><br> <!-- sett inn required -->
        Antall rom  <input type="text" id="uendretAntallrom" name="uendretAntallrom" value="<?php echo $antallrom ?>" onMouseover="musInn(this)" onMouseout="musUt()" readonly ><br>
        <br>
        Last opp nytt bilde: <br>
        <input type="file" name="nyttBilde" id="nyttBilde">
        <br>
        <br>
        <input type="submit" value="Endre" name="endreHotellromtypeKnapp" id="endreHotellromtypeKnapp">
        <input type="reset" value="Nullstill" id="nullstill" name="nullstill" onClick="fjernMelding()">
        <input type="hidden" name="xhotellnavn" value="<?php echo $hotellnavn ?>">
        <input type="hidden" name="xromtype" value="<?php echo $romtype ?>">
        <input type="hidden" name="xantallrom" value="<?php echo $antallrom ?>">
        <input type="hidden" name="xbilde" value="<?php echo $bilde ?>">
        <input type="hidden" name="xbildefil" value="<?php echo $bildefil ?>">
        <input type="hidden" name="xpris" value="<?php echo $pris ?>">
        <br>

      </form>
      <br>
      <div id="kanIkke"> </div><br>
      <div id="melding"> </div><br>
      <div id="feilmelding"> </div>
        <?php

    } // Romtype og hotellnavn valgt -slutt-
    else
    {
      echo "Ops, noe gikk galt...Prøv igjen senere!"; // feedback til bruker
      echo "<br>ERROR: <br>#$sql#<br>".mysqli_error($db); // Skriver ut hvorfor kobling feilet
    }

  }

}// velgRomtypeKnapp -slutt-


if (isset($_POST['endreHotellromtypeKnapp']))
{
  $hotellnavn=$_POST ["xhotellnavn"];
  $romtype=$_POST ["xromtype"];
  $antallrom=$_POST ["xantallrom"];
  $bilde=$_POST ["xbilde"];
  $bildefil=$_POST['xbildefil'];
  $xpris=$_POST ["xpris"];
  $pris=$_POST["endrePris"];
  $uendretBilde=true;

  @$filnavn = $_FILES['nyttBilde']['name']; // bilde.jpg
  @$type = $_FILES['nyttBilde']['type']; // image/jpg
  @$tmp_name = $_FILES['nyttBilde']['tmp_name']; // url til der filen er nå (midlertidlig)
  @$error = $_FILES['nyttBilde']['error']; // error=0: Ingen feil!  error=1: Feil ved opplastning av fil!
  @$size = $_FILES['nyttBilde']['size']; // filstørrelse (f.eks. 1352022)

  $filnavn = preg_replace('/[æøåÆØÅ]+/', '', $filnavn);

  // Hvis det er lastet opp et nytt bilde... //
  if (!$filnavn)
  {
      // Inget bilde, ingen handling //
  }
  else
  {
    $sqlSetning = "SELECT hotell.bilde, hotellromtype.rombilde
                      FROM hotell JOIN hotellromtype
                      WHERE bilde = '$filnavn'
                      OR rombilde = '$filnavn'
                      limit 1;";
    $sqlResultat = mysqli_query($db,$sqlSetning);

    if ($sqlResultat) {
      $antallRader = mysqli_num_rows($sqlResultat);

      if ($antallRader != 0) {
        $x = 0;

        while (true) {
          $bildenavn = $x.$filnavn;

          $sqlSetning = "SELECT hotell.bilde, hotellromtype.rombilde
                            FROM hotell JOIN hotellromtype
                            WHERE bilde = '$bildenavn'
                            OR rombilde = '$bildenavn'
                            limit 1;";
          $sqlResultat = mysqli_query($db,$sqlSetning);

          if ($sqlResultat) {
            $antallRader = mysqli_num_rows($sqlResultat);

            if ($antallRader == 0) {
              $filnavn = $bildenavn;
              break;
            } else {
              $x++;
            }
          } else {
            echo $die;
          }
        }}
      }




    $gyldigFormat = array('image/jpg', 'image/jpeg', 'image/gif', 'image/png'); // Bildeformater som tillates //

    if (in_array($type, $gyldigFormat))
    { /* in_array() sjekker om parameter1(filendelse på opplastet bilde) er i arrayet med gyldige formater (parameter2) */

      if ($error === 0) // Ingen feil ved opplastning..
      {

        $url = "../filer/".$filnavn;

        if (move_uploaded_file($tmp_name, $url)) // lagrer bildet på server og om vellykket, endres url i databasen//
        {
            $sql = "UPDATE hotellromtype
                    SET rombilde='$filnavn'
                    WHERE hotellnavn='$hotellnavn' AND romtype='$romtype';";

            if (mysqli_query($db, $sql)) // Bildet lagret på server, url i db oppdatert//
            {
              if ($bildefil) {
                unlink($bilde); //Sletter det gamle bildet fra server //
              }
                $bilde=NULL;
                $filnavn=NULL;

              $uendretBilde=false;
            }
            else {
              echo "Kunne ikke lagre opplastet bilde i databasen";
            }
        }
        else
        {
          echo "Kunne ikke lagre bildet på server.";
        }
      }
      else {
        echo "Noe gikk galt under opplastningen av bilde...<br>
              Vennligst prøv igjen senere.";
      }
    }
    else {
      echo "Opplastet bilde må være av typen jpg/jpeg/gif/png <br>";
    }
  } // Om det lastes opp et nytt bilde -slutt-


  if (!is_numeric($pris) || $pris < 0) //Om pris ikke er tall eller er et negativt tall//
  {
    echo "Pris må være et positivt tall.";
  }
  elseif ($pris == $xpris) {
    // prisen er ikke endret, oppdatering unødvendig
    if (!$uendretBilde) { //men bildet er endret, vis det
      ?>
      <img src="<?php echo $url?>" width="200" height="250">
      <?php
      echo "bildet endret!";
    }
  }
  else { // Oppdaterer pris i databasen

    $sql = "UPDATE hotellromtype
            SET pris='$pris'
            WHERE hotellnavn='$hotellnavn' AND romtype='$romtype'";
    if (mysqli_query($db, $sql)) {
        echo "<font color='green'> <br>Endring vellykket!</font><br><br>
              <font color='green'> Følgende er registrert: </font><br>
              Hotellnavn: <b>$hotellnavn</b><br>
              Romtype: <b>$romtype</b><br>
              Pris: <b>$pris</b><br>
              Antall rom: <b>$antallrom</b><br>";

              if (!$uendretBilde) { //men bildet er endret, vis det
                ?>
                <img src="<?php echo $url?>" width="200" height="250">
                <?php
                echo "bildet endret!";
              }

    }
    else {
        echo "<br>Kunne ikke endre hotell<br> ". mysqli_error($db);
    }
  }

}// endreHotellromtypeKnapp -slutt-

?>

<?php include("slutt.php"); ?>
