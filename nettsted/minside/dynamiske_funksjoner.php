<?php
function listeboksHotell()
{
  include("db.php");

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
?>
<?php
function listeboksRom() {
  include("db.php");

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

?>

<?php
function listeboksHotellRomtype()
{
  include("db.php");

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
?>
<?php
function listeboksRom2()
{
  include("db.php");

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
  include("db.php");

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
  include("db.php");

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
  include("db.php");

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

function listeboksSted()
{
  include("db.php");

  $sqlSetning="SELECT * FROM hotell;";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

  $antallRader=mysqli_num_rows($sqlResultat);

  for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $sted=$rad["sted"];


      print("<option value='$sted'>$sted</option>");
    }
}

function listeboksEndreRom()
{
  include("db.php");

  $navn=$_POST["hotellnavn"];

  $sqlSetning="SELECT romnr FROM rom;";
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

<?php

function listeboksEndreRom2() {
  include("db.php");
  $hotellnavn=$_POST["hotellnavn"];
  $romnr=$_POST["romNr"];
  $sqlSetning="SELECT * FROM hotellromtype WHERE hotellnavn = '$hotellnavn'
                      ORDER BY romtype = (SELECT romtype FROM rom WHERE hotellnavn = '$hotellnavn' AND romnr = '$romnr') DESC;";
  $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

  $antallRader=mysqli_num_rows($sqlResultat);

  for ($r=1;$r<=$antallRader;$r++)
    {
      $rad=mysqli_fetch_array($sqlResultat);
      $romtype=$rad["romtype"];

      print("<option value='$romtype'>$romtype</option>");
    }
}

?>
