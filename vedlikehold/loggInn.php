<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Logg inn på Vedlikehold</title>
    <link rel="stylesheet" href="style.css">
  </head>

  <body>
    <center>

    <?php require_once 'db.php'; ?>

      <div id="logginnV">
        <h2>Logg inn</h2>
      </div>

      <form method="post" action="" class="">

        <?php include('feilmelding.php'); ?>

        <div class="">
          <label>Brukernavn</label>
          <input type="text" name="bruker_navn" id="bruker_navn" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" required>
        </div>

        <div class="">
          <label>Passord</label>
          <input type="password" name="passordet" id="passordet" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" required>
        </div>
        <br>
        <div class="">
          <button type="submit" class="" name="loggInn">Logg inn</button>
          <button type="reset" class="" name="nullstill" onclick="fjernMelding()">Nullstill</button>
        </div>

      </form>
      <br>
      <div id="feilmelding"> </div>
      <div id="melding"> </div>

    </center>

    <script src="meny.js"></script>

  </body>
  </html>
