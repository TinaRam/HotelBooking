<?php
  include("start.php");
  require_once('dynamiske_funksjoner.php');
?>

<h3>Registrer hotellromtype</h3>
<br>
<form method="post" id="velgRegistrerHotellromtype" name="velgRegistrerHotellromtype" enctype="multipart/form-data">
  <select name="hotellnavn" id="hotellnavn">
    <option value=''>--Velg hotellnavn--</option>
      <?php	 listeboksHotell(); 	?>
  </select>
  <input type="submit" id="submit" name="velgHotell" value="Velg hotell" onclick="return validerIkkeTomtFelt()"><br>
</form>
<br>


<?php
if (isset($_POST['velgHotell']))
{
  $hotellnavn = $_POST['hotellnavn'];

  if (!$hotellnavn)
  {
    echo "Du må velge et hotell";
  }
  else {
    $sql = "SELECT * FROM romtype
            WHERE romtype NOT IN
              (SELECT romtype FROM hotellromtype WHERE hotellnavn = '$hotellnavn');";

    if ($sqlResultat=mysqli_query($db,$sql))
    {
      $antallRader=mysqli_num_rows($sqlResultat);

      if ($antallRader > 0)
      {
        ?>
        <form method="post" id="registrerHotellromtype" name="registrerHotellromtype" enctype="multipart/form-data">
          Hotellnavn <input type="text" id="xxhotellnavn" name="xxhotellnavn" value="<?php echo $hotellnavn?>" readonly disabled> <br>
          Romtype <select name="romtype" id="romtype">
                      <?php
                      for ($r=1;$r<=$antallRader;$r++)
                      {
                        $rad=mysqli_fetch_array($sqlResultat);
                        $romtype=$rad["romtype"];

                        print("<option value='$romtype'>$romtype</option>");
                      }
                      ?>
                      </select><br>
          Pris på rom <input type="text" id="pris" name="pris"  onFocus="fokus(this)" onBlur="mistetFokus(this)" onMouseover="musInn(this)" onMouseout="musUt()" required><br>
          Bilde <input type="file" name="bilde" id="bilde" onMouseover="musInn(this)" onMouseout="musUt()"><br>
          <br>
          <input type="submit" id="submit" name="submit" value="Registrer" onclick="return registrerHotellromtypeValider()">
          <input type="reset" id="nullstill" name="nullstill" value="Nullstill"><br>
          <input type="hidden" id="qhotell" name="qhotell" value="<?php echo $hotellnavn ?>"><br>
        </form>
        <br>
        <div id="kanIkke"> </div><br>
        <div id="melding"></div><br>
        <div id="feilmelding"></div><br>

        <?php
      }
      else {
        echo "Det finnes ingen romtyper som ikke allerede er registrert på $hotellnavn";
        echo "Ønsker du å <a href='registrerRomtype.php'>registrere en ny romtype</a>?  ";
      }
    }
    else {
      echo "Ikke mulig &aring; hente data fra databasen";
    }
  }
} // velg hotell -slutt-


if (isset($_POST["submit"])) {
  $hotellnavn = $_POST["qhotell"];
  $romtype = $_POST["romtype"];
  $pris = $_POST["pris"];
  $bilde = $_FILES["bilde"];
  $filnavn = $bilde['name'];

  $filnavn = preg_replace('/[æøåÆØÅ]+/', '', $filnavn);


  if (!$hotellnavn || !$romtype || $pris == " ") {
    print("Alle feltene må fylles inn.");
  } else if (!is_numeric($pris)) {
    print("Pris må være et tall.");
  } else if ($pris < 0) {
    print("Pris kan ikke være et negativt tall.");
  } else {
    require_once('db.php');
    $sql = "SELECT * FROM hotellromtype WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
    $sqlResultat = mysqli_query($db,$sql);

    if ($sqlResultat) {

        if ($filnavn) {
          $sqlSetning = "SELECT hotell.bilde, hotellromtype.rombilde
                            FROM hotell JOIN hotellromtype
                            WHERE bilde = '$filnavn'
                            OR rombilde = '$filnavn'
                            limit 1;";
          $sqlResultat = mysqli_query($db,$sqlSetning);

          if ($sqlResultat) {
            $antallRader = mysqli_num_rows($sqlResultat);

            if ($antallRader != 0) {
              $x = 0;

              while (true) {
                $bildenavn = $x.$filnavn;

                $sqlSetning = "SELECT hotell.bilde, hotellromtype.rombilde
                                  FROM hotell JOIN hotellromtype
                                  WHERE bilde = '$bildenavn'
                                  OR rombilde = '$bildenavn'
                                  limit 1;";
                $sqlResultat = mysqli_query($db,$sqlSetning);

                if ($sqlResultat) {
                  $antallRader = mysqli_num_rows($sqlResultat);

                  if ($antallRader == 0) {
                    $filnavn = $bildenavn;
                    break;
                  } else {
                    $x++;
                  }
                } else {
                  echo $die;
                }
              }}

              $type = $bilde['type']; // image/jpg
              $tmp_name = $bilde['tmp_name']; // url til der filen er nå (midlertidlig)
              $error = $bilde['error']; // error=0: Ingen feil!  error=1: Feil ved opplastning av fil!
              $size = $bilde['size']; // filstørrelse (f.eks. 1352022)

              $bildeformat = explode('.', $filnavn); // Deler f.eks. bjarvinUS.png --> 'bjarvinUS' og 'png'
              $filendelse = strtolower(end($bildeformat)); // små bokstaver fordi format kan skrives både som jpg og JPG. end() henter den siste verdien i et array.

              // Bildeformater som tillates //
              $gyldigFormat = array('jpg', 'jpeg', 'gif', 'png');

              if (in_array($filendelse, $gyldigFormat)) {
                $sqlSetning = "INSERT INTO hotellromtype (hotellnavn, romtype, pris, rombilde) VALUES ('$hotellnavn','$romtype', '$pris','$filnavn')";
                $sqlResultat = mysqli_query($db,$sqlSetning);

                if ($sqlResultat) {
                  $url="../filer/".$filnavn;
                  move_uploaded_file($tmp_name, $url) or die ("En feil oppstod: Kunne ikke lagre bilde");
                  print("<img src='$url' alt='opplastet bilde' width='200' height='250'><br><br>");
                  print("<strong>$hotellnavn</strong> er nå registrert med romtypen <strong>$romtype</strong> med prisen: <strong>$pris kr</strong>");
                } else {
                  print("Ikke mulig &aring; registrere data i databasen");
                }

              } else {
                print("Bildet er i ugyldig format. ");
              }
          } else {
            echo $die;
          }
        } else {
          $sqlSetning = "INSERT INTO hotellromtype (hotellnavn, romtype, pris) VALUES ('$hotellnavn','$romtype', '$pris')";
          $sqlResultat = mysqli_query($db,$sqlSetning);

          if ($sqlResultat) {
            print("<strong>$hotellnavn</strong> er nå registrert med romtypen <strong>$romtype</strong> med pris <strong>$pris kr</strong>");
          } else {
            print("Ikke mulig å registrere i database.");
          }
        }

    }
  }
}
?>

<div id="kanIkke"> </div><br>
<div id="melding"></div><br>
<div id="feilmelding"></div><br>



<?php
include("slutt.php"); ?>
