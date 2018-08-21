<?php
include("start.php");
?>

<h3>Endre Hotell</h3>

<form method="post" action="" id="endreHotell" name="endreHotell">
  Hotell
  <select name="listeboksHotell" id="listeboksHotell" class="listeboksHotell">
    <?php include("dynamiske_funksjoner.php"); listeboksHotell(); ?>
  </select>  <br/>
  <input type="submit"  value="Endre Hotell" name="endreHotellKnapp" id="endreHotellKnapp">
  <input type="reset" value="Nullstill" id="nullstill" name="nullstill" /> <br />
</form>

<?php
  if (isset($_POST ["endreHotellKnapp"])){
    $listeboksHotell=$_POST["listeboksHotell"];

      include("db.php");

      $sqlSetning="SELECT * FROM hotell WHERE hotellnavn='$listeboksHotell';";
      $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

      $rad=mysqli_fetch_array($sqlResultat);
      $hotellnavn=$rad["hotellnavn"];
      $sted=$rad["sted"];
      $land=$rad["land"];
      $bilde=$rad["bilde"];

      print ("<form method='post' action='' id='endreHotellSkjema' enctype='multipart/form-data' name='endreHotellSkjema'>");
      print ("Hotellnavn: <input type='text' value='$hotellnavn' name='hotellnavn' id='hotellnavn' readonly /> <br />");
      print ("Sted: <input type='text' value='$sted' name='sted' id='sted' required /> <br />");
      print ("Land: <input type='text' value='$land' name='land' id='land' required /> <br>");
      print ("Bilde: <input type='file' id='fil' name='fil' size='' value=''/> <br>");
      print ("<input type='submit' value='Submit' name='endreHotellKnapp2' id='endreHotellKnapp2'>");
      print ("</form>");
      print ("Brukt bilde: <img src='../filer/$bilde'");
      print ("<div id='feilmelding'/>");
    }
  if (isset($_POST ["endreHotellKnapp2"])){
      $stedSkjema=$_POST ["sted"];
      $landSkjema=$_POST["land"];
      $hotellnavnSkjema=$_POST["hotellnavn"];
      $filSkjema=$_FILES['fil'];

      if (!$stedSkjema || !$hotellnavnSkjema || !$landSkjema){
          print ("Alle feltene må fylles ut");
        }
      else
        {
          include("db.php");

          $sqlSetning="SELECT * FROM hotell WHERE hotellnavn='$hotellnavnSkjema';";
          $sqlResultat=mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; hente data fra databasen");

          $rad=mysqli_fetch_array($sqlResultat);
          $hotellnavn=$rad["hotellnavn"];
          $sted=$rad["sted"];
          $land=$rad["land"];
          $bilde=$rad["bilde"];

          unlink("../filer/$bilde") or die("");


            $fil=$_FILES['fil'];
            $fileName=$_FILES['fil']['name'];
            $fileTmpName=$_FILES['fil']['tmp_name'];
            $fileSize=$_FILES['fil']['size'];
            $fileError=$_FILES['fil']['error'];
            $fileType=$_FILES['fil']['type'];

            $fileExt=explode('.',$fileName);
            $fileActualExt=strtolower(end($fileExt));

            $allowed=array('jpg','jpeg','png',);

            if(in_array($fileActualExt,$allowed)){
              if($fileError===0){
                if($fileSize<1000000){
                  $fileDestination='../filer/'.$fileName;
                  move_uploaded_file($fileTmpName,$fileDestination);

                  $sqlSetning1="UPDATE hotell SET sted='$stedSkjema', land='$landSkjema', bilde='$fileName' WHERE hotellnavn='$hotellnavnSkjema';";
                  mysqli_query($db,$sqlSetning1) or die("ikke mulig å registrere data i databasen");

                  print("Bildet er lastet opp");
                }
                else{
                  print("filstørelsen er for stor");
                }
              }
              else{
                print("det var en feil med opplastingen av bildet ditt");
              }
            }
            else{
              print("du kan ikke laste opp filer av den typen");
            }
          }
        }
?>

<?php
include("slutt.php");
?>
