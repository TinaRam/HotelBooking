<?php

  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }


  // Sjekker om bruker er logget inn, ellers sendes h*n tilbake til loggInn.php  //
  // else if: sjekker om innlogget brukernavn er noe annet enn admin //
  if (!isset($_SESSION['brukernavn'])) {
  	header('location: loggInn.php');
  }
  else if ($_SESSION['brukernavn'] === 'admin') {
    header('location: loggInn.php');
  }

  // Sjekker om brukeren har trykket på "logg ut"-knappen, om h*n har det logges bruker ut og sendes til index.php på nettsted //
  if (isset($_GET['loggUt'])) {
  	session_destroy();
  	unset($_SESSION['brukernavn']);
  	header("location: loggInn.php");
  }
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Min Side</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="jquery/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <script src="jquery/jquery.js"></script>
    <script src="jquery/jquery-ui.js"></script>
  </head>

  <script>
  $( function() {
   $( ".datepicker" ).datepicker({ minDate: 0, maxDate: "+1Y" });
  } );
  </script>

  <header>
    <h1>~ Min Side ~</h1>
  </header>

  <aside>

    <!-- Innloggings info -->
    <?php  if (isset($_SESSION['brukernavn'])) : ?>
      <p>Innlogget som: <strong><?php echo $_SESSION['brukernavn']; ?></strong></p>
      <p><a href="index.php?loggUt='1'">Logg ut!</a></p>
    <?php endif ?>

    <ul>
      <li><a href="finnRom.php">Finn ledig hotellrom</a></li>
      <li><a href="avansertSok.php">Avansert søk</a></li>
    </ul>
    <h3>Min side</h3>
    <ul>
      <li><a href="bestillHotell.php">Bestill hotell</a></li>
      <li><a href="seBestillinger.php">Se || slett || endre hotellbestillinger</a></li>
    </ul>
  </aside>

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

<?php require_once 'db.php'; ?>
