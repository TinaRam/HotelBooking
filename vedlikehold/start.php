<?php
  require_once 'db.php';

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }


  // Sjekker om bruker er logget inn, ellers sendes h*n tilbake til loggInn.php //
  // else if: sjekker om innlogget brukernavn er noe annet enn admin //
  if (!isset($_SESSION['brukernavn'])) {
  	header('location: loggInn.php');
  }
  else if ($_SESSION['brukernavn'] !== 'admin') {
    header('location: loggInn.php');
  }



  // Sjekker om brukeren har trykket på "logg ut"-knappen, om h*n har det logges bruker ut og sendes til loggInn.php på vedlikehold //
  if (isset($_GET['loggUt'])) {
  	session_destroy();
  	unset($_SESSION['brukernavn']);
  	header("location: loggInn.php");
  }
?>


<!DOCTYPE html>
<html lang="no" dir="ltr">

  <head>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300" rel="stylesheet">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js"></script>
    <title>Vedlikehold</title>

    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
    <script src="meny.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
  </head>

  <!-- Henter funksjon for å sjekke hvilken side vi er på -->
  <body onload="hvilkenSide()">
<div class="wrapper">

    <header>
      <aside>
        <i class="fas fa-users-cog fa-2x"></i>
        <!--Innloggings info-->
        <?php  if (isset($_SESSION['brukernavn'])) : ?>
          <p>Innlogget som: <strong><?php echo $_SESSION['brukernavn']; ?></strong></p>
          <p><a href="index.php?loggUt='1'">Logg ut</a></p>
        <?php endif ?>
      </aside>
      <h1><i class="fas fa-cog"></i>Bjarum Hotels' vedlikeholds-applikasjon</h1>
    </header>



    <!-- Dropdown meny -->
<div class"menygrid">
  <menu id="meny">

    <a href="index.php">
      <button type="button" class="dropbtn" id="hjemKnapp"><i class="fas fa-home"></i> HJEM</button></a>

    <div class="dropdown">
      <button type="button" class="dropbtn" id="regKnapp" onclick="visRegAlt()"> REGISTRER </button>
      <div class="dropdown-content" id="registrere">
        <a href="registrerHotell.php">Registrer hotell</a>
        <a href="registrerRomtype.php">Registrer romtype</a>
        <a href="registrerHotellromtype.php">Registrer hotellromtype</a>
        <a href="registrerRom.php">Registrer rom</a>
      </div>
    </div>


    <div class="dropdown">
      <button type="button" class="dropbtn" id="viseKnapp" onclick="visViseAlt()"> VIS </button>
      <div class="dropdown-content" id="vise">
        <a href="visHotell.php">Vis hotell</a>
        <a href="visRomtype.php">Vis romtype</a>
        <a href="visHotellromtype.php">Vis hotellromtype</a>
        <a href="visRom.php">Vis rom</a>
      </div>
    </div>

    <div class="dropdown">
      <button type="button" class="dropbtn" id="endreKnapp" onclick="visEndreAlt()"> ENDRE </button>
      <div class="dropdown-content" id="endre">
          <a href="endreHotell.php">Endre hotell</a>
          <a href="endreRomtype.php">Endre romtype</a>
          <a href="endreHotellromtype.php">Endre hotellromtype</a>
          <a href="endreRom.php">Endre rom</a>
      </div>
    </div>


    <div class="dropdown">
      <button type="button" class="dropbtn" id="sletteKnapp" onclick="visSletteAlt()"> SLETTE </button>
      <div class="dropdown-content" id="slette">
          <a href="SlettHotell.php">Slett hotell</a>
          <a href="SlettRomtype.php">Slett romtype</a>
          <a href="SlettHotellromtype.php">Slett hotellromtype</a>
          <a href="SlettRom.php">Slett rom</a>
      </div>
    </div>

    <a href="registrertekunder.php">
      <button type="button" class="dropbtn" id="kunderKnapp">KUNDER</button></a>

    <a href="registrerteBestillinger.php">
      <button type="button" class="dropbtn" id="bestillingerKnapp">BESTILLINGER</button></a>

  </menu>
</div>



    <section>

      <!-- varslinger / notifications-->
      <?php if (isset($_SESSION['success'])) : ?>
        <div class="feil success" >
          <h3>
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
          </h3>
        </div>
      <?php endif ?>
