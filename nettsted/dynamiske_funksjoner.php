<?php
include("db.php");

function listeboksHotell()
{

  $sqlSetning="SELECT * FROM hotell ORDER BY hotellnavn;";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

  $antallRader=mysqli_num_rows($sqlResultat);

  for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $hotellnavn=$rad["hotellnavn"];
      $sted=$rad["sted"];

      print("<option value='$hotellnavn'>$hotellnavn</option>");
    }
}

function listeboksAntall() {

  for ($r = 1; $r <= 10; $r++)
    {
      print("<option value='$r'>$r</option>");
    }
}
function listeboksPris() {

  for ($r = 500; $r <= 10000; $r += 500)
    {
      print("<option value='$r'>$r</option>");
    }
}
function listeboksRom() {

  $sqlSetning="SELECT * FROM romtype;";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

  $antallRader=mysqli_num_rows($sqlResultat);

  for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $romtype=$rad["romtype"];

      print("<option value='$romtype'>$romtype</option>");
    }
}
function listeboksRomnummer() {
  $hotellnavn = $_POST["hotellnavn"];

  $sqlSetning="SELECT * FROM rom WHERE hotellnavn = '$hotellnavn';";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

  $antallRader=mysqli_num_rows($sqlResultat);

  for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $romnr=$rad["romnr"];

      print("<option value='$romnr'>$romnr</option>");
    }
}
function listeboksSlettRom_on_hotell()
{

  $hotellnavn=$_POST["hotellnavn"];

  $sqlSetning="SELECT DISTINCT(romtype) FROM rom WHERE hotellnavn='$hotellnavn';";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

  $antallRader=mysqli_num_rows($sqlResultat);

  for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $antallrom=$rad["antallrom"];
      $hotellnavn=$rad["hotellnavn"];
      $romtype=$rad["romtype"];

      print("<option value='$romtype'>$romtype</option>");
    }
}

function listeboksSlettRom_on_romtype()
{

  $hotellnavn=$_POST["hotellnavn"];
  $romtype=$_POST["romtype"];

  $sqlSetning="SELECT * FROM rom WHERE hotellnavn='$hotellnavn' AND romtype='$romtype' ;";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

  $antallRader=mysqli_num_rows($sqlResultat);

  for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $romnr=$rad["romnr"];
      $hotellnavn=$rad["hotellnavn"];
      $romtype=$rad["romtype"];

      print("<option value='$romnr'>$romnr</option>");
    }
}

function listeboksHotellRomtype1()
{

  $sqlSetning="SELECT * FROM hotellromtype ORDER BY hotellnavn;";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

  $antallRader=mysqli_num_rows($sqlResultat);

  for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $antallrom=$rad["antallrom"];
      $hotellnavn=$rad["hotellnavn"];
      $romtype=$rad["romtype"];

      print("<option>$hotellnavn</option>");
    }
}

function listeboksSlettRom()
{
  // include("db.php");

  $sqlSetning="SELECT * FROM rom WHERE hotellnavn='$hotellnavn' AND romtype='$romtype';";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

  $antallRader=mysqli_num_rows($sqlResultat);

  for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $antallrom=$rad["antallrom"];
      $hotellnavn=$rad["hotellnavn"];
      $romtype=$rad["romtype"];

      print("<option value='$antallrom'>$antallrom</option>");
    }
}
?>
<?php
function listeboksRom2()
{
  // include("db.php");

  $sqlSetning="SELECT DISTINCT(hotellnavn) FROM rom ORDER BY hotellnavn;";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

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
?>
<?php
function listeboksRom3()
{
  // include("db.php");

  $navn=$_POST["romListeboks"];

  $sqlSetning="SELECT DISTINCT(romtype) FROM rom WHERE hotellnavn='$navn' ORDER BY romtype;";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

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
?>

<?php
function listeboksRomtype()
{
  // include("db.php");

  $sqlSetning="SELECT * FROM romtype ORDER BY romtype;";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

  $antallRader=mysqli_num_rows($sqlResultat);

  for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $romtype=$rad["romtype"];

      print("<option value='$romtype'>$romtype</option>");
    }
}

function listeboksRomnr()
{
  // include("db.php");

  $sqlSetning="SELECT * FROM rom ;";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

  $antallRader=mysqli_num_rows($sqlResultat);

  for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $romnr=$rad["romnr"];


      print("<option value='$romnr'>$romnr</option>");
    }
}
?>
