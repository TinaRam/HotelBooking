<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Logg inn på Min Side</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  </head>

  <body style="font-family: 'Montserrat', sans-serif;">

    <?php require_once 'db.php'; ?>

      <div class="logginn">

        <center>
        <h2>Logg inn</h2>


        <form method="post" action="" class="" id="loggInn">

        <?php include('feilmelding.php'); ?>

        <div class="">
          <label>Brukernavn</label>
          <input type="text" name="bruker_navn" id="bruker_navn" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" required>
        </div>

        <div class="">
          <label>Passord</label>
          <input type="password" name="passordet" id="passordet" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" required>
        </div>

        <div class="">
          <button type="submit" class="" name="loggInn">Logg inn</button>
          <button type="reset" class="" name="nullstill" onclick="fjernMelding()">Nullstill</button>
        </div>
        <br>
        <br>
        <a href="./registrer.php"> Registrer ny bruker</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../index.php">Gå til nettsted</a>

        </form>
        <br>
        <div id="feilmelding"> </div>
        <div id="melding"> </div>
        </center>

      </div>


    <script src="minside.js"></script>

  </body>
  </html>
