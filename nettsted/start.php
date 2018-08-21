<!DOCTYPE html>
<html lang="no" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Nettsted</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="script.js"></script>
    <link rel="stylesheet" href="./minside/jquery/jquery-ui.css">
    <script src="./minside/jquery/jquery.js"></script>
    <script src="./minside/jquery/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  </head>
  <body>

    <!-- jquery-kalender -->
    <script>
    $( function() {
     $( ".datepicker" ).datepicker({ minDate: 0, maxDate: "+1Y" });
    } );
    </script>

    <header>
      <h1>Bjarum Hotels</h1>
    </header>
    <aside>
      <ul>
        <li><a href="seHoteller.php">Se hoteller</a></li>
        <li><a href="seRomtyper.php">Se romtyper</a></li>
        <li><a href="finnRom.php">Finn ledig hotellrom</a></li>
        <li><a href="index.php">Avansert søk</a></li>
      </ul>
      <h3>Min side</h3>
      <ul>
        <li><a href="minside/index.php">Min side</a></li>
        <li><a href="minside/registrer.php">Registrer bruker</a></li>
      </ul>
    </aside>
    <section>
