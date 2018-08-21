function getInfo() {
  document.getElementById("info").style.display = "block";
}
function fjernInfo() {
  document.getElementById("info").style.display = "none";
}

function fokus(element){
  element.style.background="rgba(243, 246, 59, 0.88)";  //skifter bakgrunnsfarge ved fokus//
}


function mistetFokus(element){
  element.style.background="white"; //skifter bakgrunn tilbake til hvit//
}


function musInn(element){
  document.getElementById("melding").style.color="blue";

  if (element==document.getElementById("brukernavn")) {
    document.getElementById("melding").innerHTML="Velg et unikt brukernavn bestående av to eller tre bokstaver";
  }
  if (element==document.getElementById("sok")) {
    document.getElementById("melding").innerHTML="Skriv inn stedsnavn eller deler av det";
  }
  if (element==document.getElementById("sted")) {
    document.getElementById("melding").innerHTML="Skriv inn stedsnavn eller deler av det";
  }

}


function musUt() {
  document.getElementById("melding").innerHTML="";
}



// function settFokus(element) {
//   element.focus();
// }


function fjernMelding() {
   document.getElementById("melding").innerHTML="";
   document.getElementById("feilmelding").innerHTML="";
}
function vis(sok) {
	var foresporsel=new XMLHttpRequest();

	foresporsel.onreadystatechange=function() {
		if (foresporsel.readyState==4 && foresporsel.status==200) {
			document.getElementById("meldingForslag").innerHTML=foresporsel.responseText;
		}
	}
	foresporsel.open("GET","php.php?sok="+sok);
	foresporsel.send();
  document.getElementById('meldingForslag').innerHTML = "";
}
function visRom(sok) {
	var foresporsel=new XMLHttpRequest();

	foresporsel.onreadystatechange=function() {
		if (foresporsel.readyState==4 && foresporsel.status==200) {
			document.getElementById("meldingHotellnavn").innerHTML=foresporsel.responseText;
		}
	}
	foresporsel.open("GET","phpRom.php?sok="+sok);
	foresporsel.send();
  document.getElementById('meldingHotellnavn').innerHTML = "";
}
function visSted(land) {
  var foresporsel=new XMLHttpRequest();

	foresporsel.onreadystatechange=function() {
		if (foresporsel.readyState==4 && foresporsel.status==200) {
			document.getElementById("by").innerHTML=foresporsel.responseText;
		}
	}
	foresporsel.open("GET","phpLand.php?land="+land);
	foresporsel.send();
  document.getElementById('by').innerHTML = "";
}
function verdi(verdi) {
  var value = document.getElementById('stedValue').value;
  document.getElementById("sok").value = verdi;
  document.getElementById("submit").click();
}
function verdiHotell(verdi) {
  var value = document.getElementById('hotellnavnValue').value;
  document.getElementById("sok").value = verdi;
  document.getElementById("submit").click();
}
function redirect(verdi) {
  window.location.href = 'seRomtyper.php';
}
function value(verdi) {
  document.getElementById("sok").value = verdi;
}
