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

mysqli_set_charset($db, 'utf-8'); // Setter char-set utf-8 //


/* Registrering og Logg inn */
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// variabel deklarasjon //
$brukernavn = "";
$feilmelding = array();


// Registrer bruker //
if (isset($_POST['regBruker'])) {

  // Henter input fra registreringsskjema på en sikker måte//
  $brukernavn = $_POST['bruker'];
  $passord1 = $_POST['passord1'];
  $passord2 = $_POST['passord2'];

  // Validering: Sjekker at ingen av input-feltene er tomme eller at brukernavn finnes fra før//
  if (empty($brukernavn)) {
     array_push($feilmelding, "Brukernavn må fylles ut");
  } else {
    $sql="SELECT * FROM bruker WHERE brukernavn='$brukernavn'";
    $res=mysqli_query($db,$sql) or die("Kunne ikke koble til database.<br>error: ". mysqli_error($db));

    if (mysqli_num_rows($res) != 0) {
      array_push($feilmelding, "Valgt brukernavn eksisterer allerede. Velg et annet brukernavn.");
    }
  }

  if (empty($passord1)) {
     array_push($feilmelding, "Passord må fylles ut");
  }

  if ($passord1 != $passord2) {
	   array_push($feilmelding, "Du har tastet inn to ulike passord!");
  }

  // Registrerer dersom det ikke er noen feil fra valideringa //
  if (count($feilmelding) == 0) {
  	$sql= "INSERT INTO bruker VALUES('$brukernavn', '$passord1')";
  	$result=mysqli_query($db, $sql) or die("Registrering feilet!<br>error: ". mysqli_error($db));

  	$_SESSION['brukernavn'] = $brukernavn;
  	$_SESSION['success'] = "Hei $brukernavn!";
  	header('location: index.php');

    // Free result set
    mysqli_free_result($result);
  }
}

// Innlogging //
if (isset($_POST['loggInn'])) {
  $brukernavn = mysqli_real_escape_string($db, $_POST['bruker_navn']);
  $passord = mysqli_real_escape_string($db, $_POST['passordet']);
  // $passord = md5($passord);

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
    $sql="SELECT * FROM bruker WHERE brukernavn='$brukernavn'";
    $res=mysqli_query($db,$sql) or die("Kunne ikke koble til database.<br>error: ". mysqli_error($db));

    if (mysqli_num_rows($res) == 0) {
      array_push($feilmelding, "Ingen brukere registrert med brukernavn &quot;$brukernavn&quot;.<br> <a href='registrer.php' style='color: #952e2d'><b>Registrere ny bruker?</b></a>");
    } else {
      $verdi=mysqli_fetch_array($res);
      $pass=$verdi['passord'];

      if ($pass != $passord) {
        array_push($feilmelding, "Feil passord!");
      }
    }
  }


// Registrerer om det ikke er noen feil fra valideringa //
  if (count($feilmelding) == 0) {
  	$sqlSetning = "SELECT * FROM bruker WHERE brukernavn='$brukernavn' AND passord='$passord'";
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
