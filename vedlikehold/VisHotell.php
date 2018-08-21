<?php
include("start.php");
include("dynamiske_funksjoner.php");
?>

<h2> Viser alle hoteller </h2>
<br>
<form method="post" action="" name="visHotell" id="visHotell">
  Vis heller hoteller på et bestemt sted:<br>
  <select name="sted" id="sted">
        <option value="">--Velg sted--</option>
            <?php	listeboksSted(); 	?>
        </select>
  <input type="submit" name="submit" id="submit" value="Vis" onclick="return validerVisHotell()">
  <input type="submit" name="nullstill" id="nullstill" value="Nullstill" onclick="refreshVisHotell()">
</form>
<br>
<div id="melding"></div><br>
<div id="feilmelding"></div><br>

<?php

if (isset($_POST["submit"]))
{

  $sted = $_POST["sted"];

  if (!$sted) {
    echo "Du må velge et sted!";
  }
  else {

  $sql = "SELECT * FROM hotell WHERE sted = '$sted';";
  if ($result = mysqli_query($db, $sql))
  {
      if(mysqli_num_rows($result) > 0)
      {
        echo "<table class='visTabell'>";
          echo "<tr>";
              echo "<th>Hotellbilde</th>";
              echo "<th>Hotellnavn</th>";
              echo "<th>Sted</th>";
              echo "<th>Land</th>";
          echo "</tr>";
        while($rad = mysqli_fetch_array($result))
        {
            $bilde = $rad['bilde'];

            echo "<tr>";
                echo "<td width='202'>";
                ?>
                <img src="../filer/<?php echo $bilde;?>" alt="Hotellbilde kommer.." width="200" height="250">
                <?php
                echo "</td>";
                echo "<td>" . $rad['hotellnavn'] . "</td>";
                echo "<td>" . $rad['sted'] . "</td>";
                echo "<td>" . $rad['land'] . "</td>";
            echo "</tr>";
        }
        echo("</table>");

        // Frigjør datastrukturen som lagrer et spørreresultat
        mysqli_free_result($result);
      }
      else {
        print("Fant ingen hoteller med navnet $hotellnavn.");
      }
  }
  }
}
else
{
	  $sql = "SELECT * FROM hotell;";
    if ($result = mysqli_query($db, $sql))
    {
        if (mysqli_num_rows($result) > 0)
        {
          echo "<table class='visTabell'>";
            echo "<tr>";
                echo "<th>Hotellbilde</th>";
                echo "<th>Hotellnavn</th>";
                echo "<th>Sted</th>";
                echo "<th>Land</th>";
            echo "</tr>";
          while($rad = mysqli_fetch_array($result))
          {
            $bilde = $rad['bilde'];

            echo "<tr>";
                echo "<td width='202'>";
                ?>
                <img src="../filer/<?php echo $bilde;?>" alt="Hotellbilde kommer.." width="200" height="250">
                <?php
                echo "</td>";
                echo "<td>" . $rad['hotellnavn'] . "</td>";
                echo "<td>" . $rad['sted'] . "</td>";
                echo "<td>" . $rad['land'] . "</td>";
            echo "</tr>";
          }
          echo("</table>");

        // Frigjør datastrukturen som lagrer et spørreresultat
        mysqli_free_result($result);
      }
    }

}


include("slutt.php"); ?>
