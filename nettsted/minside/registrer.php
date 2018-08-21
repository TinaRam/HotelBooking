<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Registrer bruker</title>
    <link rel="stylesheet" href="../style.css">
  </head>

  <body>
  <center>

    <?php require_once 'db.php'; ?>


    <div class="">
      <h2>Registrering</h2>
    </div>

    <form method="post" action="" class="" id="reg">
      <?php include('feilmelding.php'); ?>

      <div class="">
        <label>Brukernavn</label>
        <input type="text" name="bruker" id="bruker" value="<?php echo $brukernavn; ?>" placeholder="velg et brukernavn" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" autocomplete="off" required>
      </div>

      <div class="">
        <label>Passord</label>
        <input type="password" name="passord1" id="passord1" placeholder="passord" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" required>
      </div>

      <div class="">
        <label>Bekreft passord</label>
        <input type="password" name="passord2" id="passord2" placeholder="gjenta passord" onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" required>
      </div>

      <div class="">
        <button type="submit" class="" name="regBruker" id="regBruker">Register</button>
        <button type="reset" class="" name="nullstill" onclick="fjernMelding()">Nullstill</button>
      </div>
      <br>
    </form>
    <br>
    <div id="feilmelding"> </div>
    <div id="melding"> </div>
  </center>

  <script src="minside.js"></script>

</body>
</html>
