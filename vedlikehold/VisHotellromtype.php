<?php include("start.php"); include('dynamiske_funksjoner.php'); ?>

  <h2> Viser alle hotellromtyper </h2>
  <br>
  <form method="post" action="" name="velgHotellromtype" id="velgHotellromtype">
    Vis heller hotellromtyper for et bestemt hotell<br>
    <select name="hotellnavn" id="hotellnavn">
      <option value="">--velg hotellnavn--</option>
        <?php	listeboksHotell(); ?>
   </select>
    <input type="submit" name="submit" id="submit" value="Vis" onclick="return validerVisHotellromtype()">
    <input type="submit" name="nullstill" value="Nullstill" onclick="refreshVisHotellromtype()">
</form>
<br>
<div id="feilmelding"></div><br>


<?php

//# SUBMIT #
if (isset($_POST ["submit"]))
{
  $hotellnavn=$_POST ["hotellnavn"];

  if (!$hotellnavn) {
    echo "Du må velge et hotell!";
  }
  else
  {
    $SQLselect="SELECT * FROM hotellromtype WHERE hotellnavn='$hotellnavn';";
    $SQLresult=mysqli_query($db,$SQLselect) or die ("Ikke mulig å hente fra db.");

    $AntallRader=mysqli_num_rows($SQLresult);

    $AntallRader=mysqli_num_rows($SQLresult);

        if (!$AntallRader)
        {
            print("Fant ingen rom på dette hotellet <strong>$hotellnavn</strong>.");
        }
        else
        {

          print("<table class='visTabell'>");
          print("<tr>
                <th>Hotellnavn</th>
                <th>Rombilde</th>
                <th>Romtype</th>
                <th>Pris</th>
                <th>Antall Rom</th>
          	  </tr>");

          for ($r=1;$r<=$AntallRader;$r++)
          {
          	$rad=mysqli_fetch_array($SQLresult);
          	$hotellnavn=$rad["hotellnavn"];
          	$romtype=$rad["romtype"];
          	$pris=$rad["pris"];
          	$rombilde=$rad["rombilde"];
          	$antallrom=$rad["antallrom"];

          	print("<tr>
            <td>$hotellnavn</td>
            <td class='bilderad'> <img src='../filer/$rombilde' alt='Hotellrombilde kommer..' height='250' width='208'></td>
            <td>$romtype</td>
            <td>$pris</td>
            <td>$antallrom</td>
            </tr>");
          }
          echo("</table>");
        }
    }


} // #submit slutt#
else
{
  //# ALLE #
  $SQLselect="SELECT * FROM hotellromtype;";
  if ($SQLresult=mysqli_query($db,$SQLselect)) {
    $AntallRader=mysqli_num_rows($SQLresult);

    print("<table class='visTabell'>");
    print("<tr>
        <th>Hotellnavn</th>
        <th>Rombilde</th>
        <th>Romtype</th>
        <th>Pris</th>
        <th>Antall Rom</th>
        </tr>");

    for ($r=1;$r<=$AntallRader;$r++)
      {
      $rad=mysqli_fetch_array($SQLresult);
      $hotellnavn=$rad["hotellnavn"];
      $romtype=$rad["romtype"];
      $pris=$rad["pris"];
      $rombilde=$rad["rombilde"];
      $antallrom=$rad["antallrom"];

    print("<tr>
      <td>$hotellnavn</td>
      <td class='bilderad'> <img src='../filer/$rombilde' alt='Hotellrombilde kommer..' height='250' width='208'></td>
      <td>$romtype</td>
      <td>$pris</td>
      <td>$antallrom</td>
    </tr>");
      }
    echo("</table>");

  }
  else {
    echo "Kunne ikke hente fra databasen";
    echo mysqli_error($db);
  }

  //#alle#
}


include("slutt.php")
?>
