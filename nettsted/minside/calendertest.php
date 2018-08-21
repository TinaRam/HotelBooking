<html>
	<h4>Hotellform</h4>
	<form method="POST" name="form" id="form">
	Hotellnavn: <input type="text" id="hotellnavn" name="hotellnavn" value="grand hotel miramar"><br>
	Romtype: <input type="text" id="romtype" name="romtype" value="familierom"> <br>
	Antallrom: <input type="text" id="antallrom" name="antallrom" value="1"><br>
	<input type="submit" name="submit" value="submit" id="submit">
</form>
<h4>Dato</h4>
<form method="get" name="dateform" id="dateform">
	Datofra: <input type="date" id="datofra" name="datofra" /> <br>
	Datotil: <input type="date" id="datotil" name="datotil" /> <br>
</form>
</html>
<style>
	tbody td.calendar-day:hover{background-color:#ddd;;cursor: pointer}
	td.calendar-day.selected:hover{background-color:#94adff;;cursor: pointer}
	.selected{background-color: blue;color: #fff;font-weight: bold}
</style>

<?php
if(isset($_POST["submit"])){
	echo draw_calendar($month,$year);
}

function draw_calendar($month,$year){
	/* date settings */
	$month = (int) ($_GET['month'] ? $_GET['month'] : date('m'));
	$year = (int)  ($_GET['year'] ? $_GET['year'] : date('Y'));

	/* select month control */
	$select_month_control = '<select name="month" id="month">';
	for($x = 1; $x <= 12; $x++) {
		$select_month_control.= '<option value="'.$x.'"'.($x != $month ? '' : ' selected="selected"').'>'.date('F',mktime(0,0,0,$x,1,$year)).'</option>';
	}
	$select_month_control.= '</select>';

	/* select year control */
	$year_range = 7;
	$select_year_control = '<select name="year" id="year">';
	for($x = ($year-floor($year_range/2)); $x <= ($year+floor($year_range/2)); $x++) {
		$select_year_control.= '<option value="'.$x.'"'.($x != $year ? '' : ' selected="selected"').'>'.$x.'</option>';
	}
	$select_year_control.= '</select>';

	$monthName = date('F', mktime(0, 0, 0, $month, 10));

	/* "next month" control */
	$next_month_link = '<a href="?month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="control">Next Month >></a>';

	/* "previous month" control */
	$previous_month_link = '<a href="?month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="control"><< 	Previous Month</a>';

	/* bringing the controls together */
	$controls = '<form method="get">'.$select_month_control.$select_year_control.' <input type="submit" name="submit" value="Go" />      '.$previous_month_link.'  '.$monthName.'   '.$next_month_link.' </form>';
	echo $controls;

	/* draw table */
	$calendar = '<table cellpadding="0" cellspacing="0" class="calendar" id="table">';

	/* table headings */
	$headings = array('Mandag','Tirsdag','Onsdag','Torsdag','Fredag','Lørdag','Søndag');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';
	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,0,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++):

		/* explode date 'c' at T into date and time, then use date for sql */
		$list_day_date = date('c',mktime(0,0,0,$month,$list_day,$year));
		$list_day_date_ex = explode('T',$list_day_date);

/* Sjekk hvilke dager som er opptatt i forhold til hvor mange rom som er ønsket */
		$checkdate =$list_day_date_ex[0];
		$hotellnavn = $_POST["hotellnavn"];
		$romtype = $_POST["romtype"];
		$antallRomSok = $_POST["antallrom"];

		include("db.php");

		$sqlSetning = "SELECT COUNT(*) AS ledigeRom FROM rom WHERE hotellnavn = '$hotellnavn'
		                    AND romtype = '$romtype'
		                    AND romnr NOT IN (SELECT romnr FROM bestilling WHERE hotellnavn = '$hotellnavn' AND ('$checkdate'  BETWEEN datofra AND datotil));";
		$sqlResultat = mysqli_query($db,$sqlSetning) or die("Kan ikke koble til database");

		$rad=mysqli_fetch_array($sqlResultat);
		$ledigeRom=$rad["ledigeRom"];

		/*starter å printe dager*/
		if($ledigeRom < $antallRomSok){
			$calendar.= '<td class="calendar-day-busy">';
				/* add in the day number */
			$calendar.= '<div class="day-number" id="day-number">'.$list_day.'</div>';

			$calendar.= '</td>';
		}
		if($ledigeRom >= $antallRomSok){
			$calendar.= '<td class="calendar-day" id="calendar-day">';
			/* add in the day number */
			$calendar.= '<div class="day-number" id="day-number">'.$list_day.'</div>';

			$calendar.= '</td>';
		}

		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
		endfor;

	/* finish the rest of the days in the week */

	if($days_in_this_week < 8 && $days_in_this_week > 1):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;


	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';

	/* all done, return result */
	return $calendar;
}
?>

<script>
function selectedRow(){
var table = document.getElementById("table"),rIndex,cIndex;

var monthSelect = document.getElementById("month");
var month = monthSelect.options[monthSelect.selectedIndex].value -1;

var yearSelect = document.getElementById("year");
var year = yearSelect.options[yearSelect.selectedIndex].value;

// table rows
for(var i = 1; i < table.rows.length; i++){
		// row cells
		for(var j = 0; j < table.rows[i].cells.length; j++){
				table.rows[i].cells[j].onclick = function(){
						rIndex = this.parentElement.rowIndex;
						cIndex = this.cellIndex+1;
						console.log("Row : "+rIndex+" , Cell : "+cIndex);

						if (document.querySelector('.selected') !== null) {
    				// .. it exists
						document.querySelector('.selected').classList.remove("selected");
						this.classList.add("selected");
						}
						else{
    				// Do something if class does not exist
						/* this.classList.toggle("selected"); */
						this.classList.add("selected");
						}

						var trash = this.innerHTML;
						var fields = trash.split(">");
						var trash1 = fields[1];
						var fields1 = trash1.split("<");
						var day1 = fields1[0];
						var day = parseInt(day1,);
						var date = new Date(year, month, day+1).toISOString().slice(0,10);

						document.getElementById("datofra").value=date;
				};
			}
		}
}
selectedRow();
</script>
<style>
tr{cursor: pointer; transition: all .25s ease-in-out}
/* calendar */
table.calendar		{ border-left:1px solid #999; }
tr.calendar-row	{  }
td.calendar-day	{ min-height:80px; font-size:11px; position:relative; } * html div.calendar-day { height:80px; }
td.calendar-day-busy	{ min-height:80px; font-size:11px; position:relative; background:#FF0000;} * html div.calendar-day-busy { height:80px; }
td.calendar-day:hover	{ background:#eceff5; }
td.calendar-day-np	{ background:#eee; min-height:80px; } * html div.calendar-day-np { height:80px; }
td.calendar-day-head { background:#ccc; font-weight:bold; text-align:center; width:120px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }
div.day-number		{ background:#999; padding:5px; color:#fff; font-weight:bold; float:right; margin:-5px -5px 0 0; width:20px; text-align:center; }
/* shared */
td.calendar-day, td.calendar-day-np { width:120px; padding:5px; border-bottom:1px solid #999; border-right:1px solid #999; }
</style>
