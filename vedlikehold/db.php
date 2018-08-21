<?php

$host="localhost";
$user="web-prg2-2018-04";
$password="26737";
$database="web-prg2-2018-04";


/* AMPPS Hodepina*/
// $host="127.0.0.1";
// $user="root";
// $password="mysql";
// $database="hotell";

$db=mysqli_connect($host,$user,$password,$database);
if (!$db)
{
  exit('Ikke kontakt med database');
}

mysqli_set_charset($db, 'utf-8'); // Setter char-set utf8 //



/* Registrering og Logg inn */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// variabel deklarasjon //
$brukernavn = "";
$feilmelding = array();


// Innlogging //
if (isset($_POST['loggInn'])) {
  $brukernavn = mysqli_real_escape_string($db, $_POST['bruker_navn']);
  $passord = mysqli_real_escape_string($db, $_POST['passordet']);

// Validering: Sjekker at ikke noen av input feltene er tomme //
// Sjekker at brukernavn finnes i databasen //
// Sjekker at passordet er riktig //
  if (empty($brukernavn)) {
  	array_push($feilmelding, "Brukernavn er påkrevd");
  }
  elseif (empty($passord)) {
    array_push($feilmelding, "Passord er påkrevd");
  }
  else {
    $sql="SELECT * FROM admin WHERE brukernavn='$brukernavn'";
    if ($res=mysqli_query($db,$sql))
    {
      if (mysqli_num_rows($res) == 0)
      {
        array_push($feilmelding, "Ugyldig brukernavn");
      }
      else
      {
        $verdi=mysqli_fetch_array($res);
        $pass=$verdi['passord'];

        if ($pass != $passord)
        {
          array_push($feilmelding, "Feil passord!");
        }
      }
    }
  }


// Registrerer om det ikke er noen feil fra valideringa //
  if (count($feilmelding) == 0) {
  	$sqlSetning = "SELECT * FROM admin WHERE brukernavn='$brukernavn' AND passord='$passord'";
  	$resultat = mysqli_query($db, $sqlSetning);

  	if (mysqli_num_rows($resultat) == 1) {
  	  $_SESSION['brukernavn'] = $brukernavn;
  	  $_SESSION['success'] = "Hei, $brukernavn!";
  	  header('location: index.php');
  	}

    // Free result set
    mysqli_free_result($resultat);
  }
}

/*array_push($feilmelding, "Det som skal settes inn") Setter feilmelding inn i feilmelding-arrayet*/
/*The array_push() function inserts one or more elements to the end of an array.*/

?>
