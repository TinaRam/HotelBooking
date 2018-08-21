<?php include("start.php"); include("dynamiske_funksjoner.php");?>


<h3>Endre hotell</h3>

<form method="post" action="" id="velgEndreHotell" name="velgEndreHotell">
  <select name="hotellnavn">
    <option value="">--Velg hotellnavn--</option>
    <?php listeboksEndreHotell() ?>
  </select>
  <input type="submit" value="Velg" name="velgEndreHotellKnapp" id="velgEndreHotellKnapp" onclick="return validerValgtHotell()">
  <br>
</form>
<br>
<span id="kanIkke"> </span>
<span id="melding"> </span><br>
<span id="feilmelding"> </span><br>


<?php

if (isset($_POST["velgEndreHotellKnapp"]))
{

    @$hotellnavn=$_POST['hotellnavn'];

    if (!$hotellnavn)
    {
      echo "Du må velge et hotellnavn!";
    }
    else
    {

      $sql = "SELECT * FROM hotell WHERE hotellnavn='$hotellnavn'"; // forespørsel //

      $resultat = mysqli_query($db,$sql); // Henter resultat fra database forespørsel //
      $rad = mysqli_fetch_array($resultat); // Legger dataen i en array "$rad" //

      $hotellnavn = $rad[0];
      $sted = $rad[1];
      $land = $rad[2];
      $bilde =$rad[3];
      $serverBilde = '../filer/'.$bilde;

      // Free result set?
      mysqli_free_result($resultat);


      ?>
      <div id="hotellbilde">
        <?php
          if ($bilde) {
            ?>
            <img src="<?php echo $serverBilde?>" width="200" height="250">
            <?php
          }
          else {
            ?>
            <img src="../filer/No-image-available.jpg" width="200" height="250">
            <?php
          }
        ?>
      </div>

      <form navn="endreHotell" id="endreHotell" action="" method="post" enctype="multipart/form-data">

        Hotellnavn  <input type="text" id="uendretHotellnavn" name="uendretHotellnavn" value="<?php echo $hotellnavn ?>" onMouseover="musInn(this)" onMouseout="musUt()" readonly disabled><br>
        Sted: <input type="text" id="endreSted" name="endreSted" value="<?php echo $sted ?>" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" required><br>
        Land: <input type="text" id="endreLand" name="endreLand" value="<?php echo $land ?>" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" required><br>
        <br>
        Last opp nytt bilde: <br>
        <input type="file" name="nyttBilde" id="nyttBilde">
        <br>
        <br>
        <input type="submit" value="Endre hotell" name="endreHotellKnapp" id="endreHotellKnapp" onclick="return endreHotellvalidate()">
        <input type="reset" value="Nullstill" id="nullstill" name="nullstill" onClick="fjernMelding()">
        <br>
        <input type="hidden" name="xhotellnavn" value="<?php echo $hotellnavn ?>">
        <input type="hidden" name="xsted" value="<?php echo $sted ?>">
        <input type="hidden" name="xland" value="<?php echo $land ?>">
        <input type="hidden" name="xbilde" value="<?php echo $bilde ?>">
      </form>

        <?php
    } // om det er valgt et hotellnavn -slutt-

} // Om velgHotellKnappen er trykket på -slutt-


if (isset($_POST["endreHotellKnapp"]))
{
  // REGISTRERE NY HOTELLDATA//
  $hotellnavn=$_POST ["xhotellnavn"];
  $sted=$_POST ["xsted"];
  $land=$_POST ["xland"];
  $bilde=$_POST ["xbilde"];
  $bildeurl="../filer/".$bilde;
  $uendretBilde=true;

  $nyttSted=$_POST["endreSted"];

  $nyttLand=$_POST["endreLand"];

  @$filnavn = $_FILES['nyttBilde']['name']; // bilde.jpg
  @$type = $_FILES['nyttBilde']['type']; // image/jpg
  @$tmp_name = $_FILES['nyttBilde']['tmp_name']; /* url til der filen er nå (midlertidlig) */
  @$error = $_FILES['nyttBilde']['error']; // error=0: Ingen feil!  error=1: Feil ved opplastning av fil!
  @$size = $_FILES['nyttBilde']['size']; // /*filstørrelse (f.eks. 1352022)*/

  $filnavn = preg_replace('/[æøåÆØÅ]+/', '', $filnavn);

  // Validerer feltene -->
    include("validering.php");
    $gyldigSted=validerSted($nyttSted);
    $gyldigLand=validerLand($nyttLand);
  // <-- Validering slutt



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
    { /* in_array() sjekker om parameter1(filendelse på opplastet bilde) er i arrayet med gyldige formater (parameter2)*/

      if ($error === 0) // Ingen feil ved opplastning..
      {

        $url = "../filer/".$filnavn;

        if (move_uploaded_file($tmp_name, $url)) // lagrer bildet på server og om vellykket, endres url i databasen//
        {
            $sql = "UPDATE hotell
                    SET bilde='$filnavn'
                    WHERE hotellnavn='$hotellnavn'";

            if (mysqli_query($db, $sql)) // Bildet lagret på server, url i db oppdatert//
            {
              if ($bilde) { // Om det finnes et bilde på server fra før //
                unlink($bildeurl); //Sletter det gamle bildet fra server //
              }

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




  if ($sted == $nyttSted && $land == $nyttLand) {
    //om ikke noe annet i form'et er endret,
    if (!$uendretBilde) { //men bildet er endret, så vis bilde //
      ?>
      <img src="<?php echo $url?>" width="200" height="250"><br>
      <?php
      echo "bildet endret!";
    }

  }
  elseif ($gyldigSted && $gyldigLand) // Oppdaterer hotell-tabellen med sted og land //
  {
    $sql = "UPDATE hotell
            SET sted='$nyttSted', land='$nyttLand'
            WHERE hotellnavn='$hotellnavn'";
    if (mysqli_query($db, $sql)) {
        echo "<font color='green'> <br>Endring vellykket!</font><br><br>
              <font color='green'> Følgende er registrert: </font><br>
              Hotellnavn: <b>$hotellnavn</b><br>
              Sted: <b>$nyttSted</b><br>
              Land: <b>$nyttLand</b><br>";

              if (!$uendretBilde) { // om bildet også er endret
                ?>
                <img src="<?php echo $url?>" width="200" height="250"><br>
                <?php
                echo "bildet endret!";
              }
    }
    else {
        echo "<br>Kunne ikke endre hotell<br> ". mysqli_error($db);
    }

  }

  if ($sted == $nyttSted && $land == $nyttLand && $uendretBilde) {
    echo "Ingen nye verdier, dermed ingen endring!";
  }


} // Om endreHotellKnappen er trykket på -slutt-


?>


<?php include("slutt.php"); ?>
