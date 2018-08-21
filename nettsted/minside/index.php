<?php
include('start.php');

// Sjekker om bestilling-tabellen har noen bestillinger som skal flyttes til inaktiv_bestilling-tabellen //
$sql = 'SELECT * FROM bestilling WHERE DATEDIFF(CURDATE(), datotil) >= 0;';
if ($res=mysqli_query($db,$sql))
{
  if(mysqli_num_rows($res) > 0)
  {
    $sql1 = 'INSERT INTO inaktiv_bestilling
    SELECT *
    FROM bestilling
    WHERE radnr IN
      (SELECT radnr
       FROM bestilling
       WHERE DATEDIFF(CURDATE(), datotil) >= 0);';
    if (mysqli_query($db,$sql1))
    {
      $sql2 = 'DELETE FROM bestilling
      WHERE radnr IN
        (SELECT radnr FROM inaktiv_bestilling);';
      if (mysqli_query($db,$sql2)) {
      }
    }
    else
    {
      echo "Ops...noe gikk galt. Vennligst prøv igjen!";
    }
  }
  else {
    // Ingenting som trenger å flyttes //
  }
}
else
{
  echo "Ikke kontakt med database.";
}
?>

<img src="../../filer/511397.jpg" alt="" width="100%">

<link rel="stylesheet" type="text/css" href="style.css">
<script type="text/javascript" src="meny.js"></script>

<?php include("slutt.php"); ?>
