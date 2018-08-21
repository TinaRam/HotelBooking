
<!--
SELECT b.datofra, b.datotil, b.hotellnavn, rom.romtype, b.romnr FROM `bestilling` AS b
		JOIN rom ON rom.hotellnavn = 'grand hotel oslo' AND rom.romnr = b.romnr
		WHERE b.datofra BETWEEN '2014-06-18' AND '2014-06-24'
    OR b.datotil BETWEEN '2014-06-18' AND '2014-06-24'
    AND b.hotellnavn = 'grand hotel oslo';
-->
<form method="post" id="bestill" name="bestill">
	<input type="text" id="hotellnavn" name="hotellnavn" placeholder="hotellnavn"><br>
	<input type="date" id="innsjekking" name="innsjekking" placeholder="innsjekking"><br>
	<input type="date" id="utsjekking" name="utsjekking" placeholder="utsjekking"><br>
	<input type="text" id="romtype" name="romtype" placeholder="romtype"><br>
	<input type="submit" name="submit">
</form>
<?php
	if (isset($_POST["submit"])) {
		$hotellnavn = $_POST["hotellnavn"];
		$innsjekking = $_POST["innsjekking"];
		$utsjekking = $_POST["utsjekking"];
		$romtype = $_POST["romtype"];

		include("db.php");

		$sqlSetning = "SELECT b.datofra, b.datotil, b.hotellnavn, b.romnr, (SELECT romtype FROM rom WHERE hotellnavn = '$hotellnavn' AND romnr = b.romnr) AS romtype FROM bestilling AS b
											WHERE datofra BETWEEN '$innsjekking' AND '$utsjekking'
											OR datotil BETWEEN '$innsjekking' AND '$utsjekking'
											AND hotellnavn = '$hotellnavn'
											AND (SELECT romtype FROM rom WHERE hotellnavn = '$hotellnavn' AND romnr = b.romnr) = '$romtype';";

		$sqlResultat = mysqli_query($db,$sqlSetning) or die("Kan ikke koble til database");

		$antallRader = mysqli_num_rows($sqlResultat);
		$rad = mysqli_fetch_array($sqlResultat);
		$tattRomnr = $rad["romnr"];

		if ($antallRader == 0) {
			$sqlSetning = "SELECT * FROM hotellromtype WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype';";
			$sqlResultat = mysqli_query($db,$sqlSetning) or die("Kan ikke koble til database");
			$antallRader = mysqli_num_rows($sqlResultat);

			if ($antallRader == 0) {
				print("Ingen hoteller matcher ditt søk.");
			} else {
				$sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype'";
				$sqlResultat = mysqli_query($db,$sqlSetning) or die("Kan ikke koble til database");
				$antallRader = mysqli_num_rows($sqlResultat);

				if ($antallRader == 0) {
					print("Ingen hoteller matcher ditt søk.");
				} else {
					for ($i=0; $i < $antallRader; $i++) {
						$rad = mysqli_fetch_array($sqlResultat);
						$romnr = $rad["romnr"];

						if ($romnr == $tattRomnr) {
							print("Rom tatt");
						} else {
							print("rom ledig");
							$i = $antallRader;

							$sqlSetning = "INSERT INTO bestilling (brukernavn, datofra, datotil, hotellnavn, romnr) VALUES
																			('minside', '$innsjekking', '$utsjekking', '$hotellnavn', '$romnr');";

							mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; registrere data i databasen");
						}
					}
				}
			}
		} else {
			$sqlSetning = "SELECT * FROM rom WHERE hotellnavn = '$hotellnavn' AND romtype = '$romtype'";
			$sqlResultat = mysqli_query($db,$sqlSetning) or die("Kan ikke koble til database");
			$antallRader = mysqli_num_rows($sqlResultat);

			if ($antallRader == 0) {
				print("Ingen hoteller matcher ditt søk.");
			} else {
				for ($i=0; $i < $antallRader; $i++) {
					$rad = mysqli_fetch_array($sqlResultat);
					$romnr = $rad["romnr"];

					if ($romnr == $tattRomnr) {
						print("Rom tatt");
					} else {
						print("rom ledig");
						$i = $antallRader;

						$sqlSetning = "INSERT INTO bestilling (brukernavn, datofra, datotil, hotellnavn, romnr) VALUES
																		('minside', '$innsjekking', '$utsjekking', '$hotellnavn', '$romnr');";

						mysqli_query($db,$sqlSetning) or die ("ikke mulig &aring; registrere data i databasen");
					}
				}
			}
		}

	}
?>
