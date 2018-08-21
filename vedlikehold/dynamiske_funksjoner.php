<?php
function listeboksHotell() {
  include("db.php");

  $sql = "SELECT * FROM hotell ORDER BY hotellnavn;";

  if ($result = mysqli_query($db, $sql)) {
    if(mysqli_num_rows($result) > 0){
      while($rad = mysqli_fetch_array($result)) {
        $hotellnavn = $rad['hotellnavn'];
        echo("<option value='$hotellnavn'>$hotellnavn</option>");
      }
    }
  }
}
?>

<?php
/*
  Brukes i:
  - registrerHotellromtype.php
  - registrerRom.php
  - SlettHotellromtype.php
*/
function listeboksRom() {
  include("db.php");

  $sqlSetning="SELECT * FROM romtype;";
  if ($sqlResultat=mysqli_query($db,$sqlSetning))
  {
    $antallRader=mysqli_num_rows($sqlResultat);

    for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $romtype=$rad["romtype"];

      print("<option value='$romtype'>$romtype</option>");
    }
  }
  else
  {
    echo "Ikke mulig &aring; hente data fra databasen";
  }
}



/* Henter hotellnavn i endreHotellromtype.php*/
function listeboksEndreHotellromtypeHotell()
{
    include("db.php");

    $sql = "SELECT DISTINCT(hotellnavn) FROM hotellromtype;";

    if ($result = mysqli_query($db, $sql)) {
      if(mysqli_num_rows($result) > 0){
        while($rad = mysqli_fetch_array($result)) {
          $hotellnavn = $rad['hotellnavn'];
          echo("<option value='$hotellnavn'>$hotellnavn</option>");
        }
      }
    }
  }


/* Henter romtypene til $hotellnavn i endreHotellromtype.php*/
function listeboksEndreHotellromtypeRomtype($hotellnavn)
{
    include("db.php");

    $sql = "SELECT romtype FROM hotellromtype WHERE hotellnavn = '$hotellnavn';";

    if ($result = mysqli_query($db, $sql)) {
      if(mysqli_num_rows($result) > 0){
        while($rad = mysqli_fetch_array($result)) {
          $romtype = $rad['romtype'];
          echo("<option value='$romtype'>$romtype</option>");
        }
      }
    }
  }
?>


<?php
function listeboksRom2()
{
  include("db.php");

  $sqlSetning="SELECT DISTINCT(hotellnavn) FROM rom ORDER BY hotellnavn;";
  if ($sqlResultat=mysqli_query($db,$sqlSetning))
  {
    $antallRader=mysqli_num_rows($sqlResultat);

    for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $hotellnavn=$rad["hotellnavn"];
      $romtype=$rad["romtype"];
      $romnr=$rad["romnr"];

      print("<option value='$hotellnavn'>$hotellnavn</option>");
    }
  }
  else
  {
    echo "Ikke mulig &aring; hente data fra databasen";
  }
}
?>

<?php

function listeboksRom3()
{
  include("db.php");

  $navn=$_POST["romListeboks"];

  $sqlSetning="SELECT DISTINCT(romtype) FROM rom WHERE hotellnavn='$navn' ORDER BY romtype;";
  if ($sqlResultat=mysqli_query($db,$sqlSetning))
  {
    $antallRader=mysqli_num_rows($sqlResultat);

    for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $hotellnavn=$rad["hotellnavn"];
      $romtype=$rad["romtype"];
      $romnr=$rad["romnr"];
      print("<option value='$romtype'>$romtype</option>");
    }
  }
  else
  {
    echo "Ikke mulig &aring; hente data fra databasen";
  }
}

?>

<?php
function listeboksRomtype()
{
  include("db.php");

  $sqlSetning="SELECT * FROM romtype ORDER BY romtype;";
  if ($sqlResultat=mysqli_query($db,$sqlSetning))
  {
    $antallRader=mysqli_num_rows($sqlResultat);

    for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $romtype=$rad["romtype"];
      print("<option value='$romtype'>$romtype</option>");
    }
  }
  else
  {
    echo "Ikke mulig &aring; hente data fra databasen";
  }
}



function listeboksRomnr()
{
  include("db.php");

  $sqlSetning="SELECT * FROM rom ;";
  if ($sqlResultat=mysqli_query($db,$sqlSetning))
  {
    $antallRader=mysqli_num_rows($sqlResultat);

    for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $romnr=$rad["romnr"];
      print("<option value='$romnr'>$romnr</option>");
    }
  }
  else
  {
    echo "Ikke mulig &aring; hente data fra databasen";
  }
}


function listeboksSted()
{
  include("db.php");

  $sqlSetning="SELECT DISTINCT sted FROM hotell;";
  if ($sqlResultat=mysqli_query($db,$sqlSetning)) {
    $antallRader=mysqli_num_rows($sqlResultat);

    for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $sted=$rad["sted"];
      print("<option value='$sted'>$sted</option>");
    }
  }
  else
  {
    echo "Ikke mulig &aring; hente data fra databasen";
  }
}



function listeboksEndreRom()
{
  include("db.php");

  $navn=$_POST["hotellnavn"];

  $sqlSetning="SELECT romnr FROM rom;";
  if ($sqlResultat=mysqli_query($db,$sqlSetning))
  {
    $antallRader=mysqli_num_rows($sqlResultat);

    for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $romnr=$rad["romnr"];

      print("<option value='$romnr'>$romnr</option>");
    }
  }
  else
  {
    echo "Ikke mulig &aring; hente data fra databasen";
  }

}

?>

<?php

function listeboksEndreRom2() {
  include("db.php");
  $hotellnavn=$_POST["hotellnavn"];
  $romnr=$_POST["romNr"];
  $sqlSetning="SELECT * FROM hotellromtype WHERE hotellnavn = '$hotellnavn'
                      ORDER BY romtype = (SELECT romtype FROM rom WHERE hotellnavn = '$hotellnavn' AND romnr = '$romnr') DESC;";
  if ($sqlResultat=mysqli_query($db,$sqlSetning)) {
    $antallRader=mysqli_num_rows($sqlResultat);

    for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $romtype=$rad["romtype"];

      print("<option value='$romtype'>$romtype</option>");
    }
  }
  else
  {
    echo "Ikke mulig &aring; hente data fra databasen";
  }
}


function listeboksSlettRom()
{
  include("db.php");

  $sqlSetning="SELECT romnr FROM rom;";
  if ($sqlResultat=mysqli_query($db,$sqlSetning))
  {
    $antallRader=mysqli_num_rows($sqlResultat);
    for ($r=1;$r<=$antallRader;$r++)
      {
        $rad=mysqli_fetch_array($sqlResultat);
        $romnr=$rad["romnr"];

        print("<option value='$romnr'>$romnr</option>");
      }
  }
  else
  {
    echo "Ikke mulig &aring; hente data fra databasen";
  }
}



function listeboksEndreHotell() {
  include("db.php");

  $sql = "SELECT * FROM hotell ORDER BY hotellnavn;";

  if ($result = mysqli_query($db, $sql)) {
    if(mysqli_num_rows($result) > 0){
      while($rad = mysqli_fetch_array($result)) {
        $hotellnavn = $rad['hotellnavn'];
        echo("<option value='$hotellnavn'>$hotellnavn</option>");
      }
    }
  }
}


// Listeboks hotellnavn i endreRom.php //
function listeboksHotellnavnEndreRom()
{
  include('db.php');

  $sql = "SELECT DISTINCT(hotellnavn) FROM rom";
  if ($result = mysqli_query($db, $sql)) {
    if(mysqli_num_rows($result) > 0){
      while($rad = mysqli_fetch_array($result)) {
        $hotellnavn = $rad['hotellnavn'];
        echo("<option value='$hotellnavn'>$hotellnavn</option>");
      }
    }
  }
}

// Listeboks romnr i endreRom.php //
function listeboksRomnrEndreRom($hotellnavn) {
  include("db.php");

  $sql = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn'";
  if ($result = mysqli_query($db, $sql)) {
    if(mysqli_num_rows($result) > 0){
      while($rad = mysqli_fetch_array($result)) {
        $romnr = $rad['romnr'];
        echo("<option value='$romnr'>$romnr</option>");
      }
    }
    else {
      print("<option>Ingen rom tilgjengelig</option>");
    }
  }
}

function listeboksRomtypeEndreRom($hotellnavn, $romnr) {
  include("db.php");


  $sql = "SELECT * FROM rom WHERE hotellnavn = $hotellnavn AND romnr = $romnr";
  if ($result = mysqli_query($db, $sql)) {
    if(mysqli_num_rows($result) > 0){
      while($rad = mysqli_fetch_array($result)) {
        $romtype = $rad['romtype'];
        echo("<option value='$romtype'>$romtype</option>");
      }
    }
  }
}


/* Listeboks ubrukte romtyper til slettRomtype.php */
function listeboksUbrukteRomtyper() {
  include("db.php");

  $sql = "SELECT * FROM romtype WHERE romtype NOT IN (SELECT romtype FROM rom);";
  if ($result = mysqli_query($db, $sql)) //Hvis databasen responderer
  {
    if(mysqli_num_rows($result) > 0) // Hvis spørring returnerer ubrukte romtype/er
    {
      while($rad = mysqli_fetch_array($result))
      {
        $romtype = $rad['romtype'];
        echo("<option value='$romtype'>$romtype</option>");
      }
    }
  }
  else {
    echo "Ikke mulig å få kontakt med databasen";
  }
}

?>
