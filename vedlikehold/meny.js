/* -------------------------------------------------------------------------- */
/*    DROPDOWN MENY MED KLIKK     -egen koding-
/*
/*    Viser/skjuler meny-valgene når man klikker på meny-knappen
/*    Sjekker om noen av de andre meny-valgene er aktive om de har class="vis"
/*    Fjerner evt. class="vis" slik at man kun har en sub-meny åpent om gangen
/*
/*    Siste kodeblokk:
/*    Lukker meny-valg om man klikker ellers i vinduet
/* -------------------------------------------------------------------------- */


function visRegAlt() {

  var viseMeny = document.getElementById('vise');
  var endreMeny = document.getElementById('endre');
  var sletteMeny = document.getElementById('slette');

  if (viseMeny.classList.contains('vis') || endreMeny.classList.contains('vis') || sletteMeny.classList.contains('vis')) {
    viseMeny.classList.remove('vis');
    endreMeny.classList.remove('vis');
    sletteMeny.classList.remove('vis');
    document.getElementById("registrere").classList.toggle("vis");
  }
  else {
    document.getElementById("registrere").classList.toggle("vis");
  }
}


function visViseAlt() {

  var registrereMeny = document.getElementById('registrere');
  var endreMeny = document.getElementById('endre');
  var sletteMeny = document.getElementById('slette');

  if (registrereMeny.classList.contains('vis') || endreMeny.classList.contains('vis') || sletteMeny.classList.contains('vis')) {
    registrereMeny.classList.remove('vis');
    endreMeny.classList.remove('vis');
    sletteMeny.classList.remove('vis');
    document.getElementById("vise").classList.toggle("vis");
  }
  else {
    document.getElementById("vise").classList.toggle("vis");
  }
}

function visEndreAlt() {

  var registrereMeny = document.getElementById('registrere');
  var viseMeny = document.getElementById('vise');
  var sletteMeny = document.getElementById('slette');

  if (registrereMeny.classList.contains('vis') || viseMeny.classList.contains('vis') || sletteMeny.classList.contains('vis')) {
    registrereMeny.classList.remove('vis');
    viseMeny.classList.remove('vis');
    sletteMeny.classList.remove('vis');
    document.getElementById("endre").classList.toggle("vis");
  }
  else {
    document.getElementById("endre").classList.toggle("vis");
  }
}



function visSletteAlt() {

  var registrereMeny = document.getElementById('registrere');
  var viseMeny = document.getElementById('vise');
  var endreMeny = document.getElementById('endre');

  if (registrereMeny.classList.contains('vis') || viseMeny.classList.contains('vis') || endreMeny.classList.contains('vis')) {
    registrereMeny.classList.remove('vis');
    viseMeny.classList.remove('vis');
    endreMeny.classList.remove('vis');
    document.getElementById("slette").classList.toggle("vis");
  }
  else {
    document.getElementById("slette").classList.toggle("vis");
  }
}



/* Lukker meny-valg når man klikker ellers i vindu/skjermen */
window.onclick = function(klikk) {  // Om det klikkes i vinduet //

  if (!klikk.target.matches('.dropbtn')) {  // Hvis klikket IKKE er på menyknapp med sub-meny //

    var subMeny = document.getElementsByClassName("dropdown-content");
    var i;

    for (i = 0; i < subMeny.length; i++) {

      var aktivSubMeny = subMeny[i];

      if (aktivSubMeny.classList.contains('vis')) {
        aktivSubMeny.classList.remove('vis');
      }
    }

  }
}




/* window.location.pathname; Gir filnavn, f.eks. "/reg_oppg.php"  */

/* -------------------------------------------------------------------------- */
/*    CURRENT TAB      -egen koding-
/*
/*    Sjekker hvilken side man er på og hvilket meny-valg siden tilhører.
/*
/* -------------------------------------------------------------------------- */

function hvilkenSide() {

  var url = window.location.pathname;

  var registrere = document.getElementById('registrere');
  var vise = document.getElementById('vise');
  var endre = document.getElementById('endre');
  var slette = document.getElementById('slette');

  if (url === '/web-prg2-2018-04/vedlikehold/registrerHotell.php' || url === '/web-prg2-2018-04/vedlikehold/registrerRomtype.php' ||
      url === '/web-prg2-2018-04/vedlikehold/registrerHotellromtype.php' || url === '/vedlikehold/registrerRom.php')  {
      document.getElementById("regKnapp").classList.toggle("aktivTab");
  }
  else if (url === '/web-prg2-2018-04/vedlikehold/visHotell.php' || url === '/web-prg2-2018-04/vedlikehold/visRomtype.php' ||
      url === '/web-prg2-2018-04/vedlikehold/visHotellromtype.php' || url === '/web-prg2-2018-04/vedlikehold/visRom.php') {
      document.getElementById("viseKnapp").classList.toggle("aktivTab");
  }
  else if (url === '/web-prg2-2018-04/vedlikehold/endreHotell.php' || url === '/web-prg2-2018-04/vedlikehold/endreRomtype.php' ||
      url === '/web-prg2-2018-04/vedlikehold/endreHotellromtype.php' || url === '/web-prg2-2018-04/vedlikehold/endreRom.php') {
      document.getElementById("endreKnapp").classList.toggle("aktivTab");
  }
  else if (url === '/web-prg2-2018-04/vedlikehold/SlettHotell.php' || url === '/web-prg2-2018-04/vedlikehold/SlettRomtype.php' ||
      url === '/web-prg2-2018-04/vedlikehold/SlettHotellromtype.php' || url === '/web-prg2-2018-04/vedlikehold/SlettRom.php') {
      document.getElementById("sletteKnapp").classList.toggle("aktivTab");
  }
  else if (url === '/web-prg2-2018-04/vedlikehold/registrertekunder.php') {
    document.getElementById("kunderKnapp").classList.toggle("aktivTab");
  }
  else if (url === '/web-prg2-2018-04/vedlikehold/registrerteBestillinger.php') {
      document.getElementById("bestillingerKnapp").classList.toggle("aktivTab");
  }
  else if (url === '/web-prg2-2018-04/vedlikehold/index.php') {
      document.getElementById("hjemKnapp").classList.toggle("aktivTab");
  }

}

/* var url = window.location.pathname;console.log(url);                     */
/*------------------------- slutt current tab ------------------------------*/





/* -------------------------------------------------------------------------- */
/*    Sletting kan ikke angres, er du sikker?
/*
/*    Sender en "Er du sikker?" bekreftelses boks
/*    når man trykker på slette-knappen
/* -------------------------------------------------------------------------- */

function sikker() {
  return confirm ('Sletting kan ikke angres, er du sikker?');
}


/* -------------------------------------------------------------------------- */
/*
/*    HENDELSER
/*
/*    element = this
/*
/* -------------------------------------------------------------------------- */


function fokus(element){
  element.style.background="rgba(243, 246, 59, 0.88)";  //skifter bakgrunnsfarge ved fokus//
}


function mistetFokus(element){
  element.style.background="white"; //skifter bakgrunn tilbake til hvit//
}


function musInn(element){
  document.getElementById("melding").style.color="blue";

  if (element==document.getElementById("bruker_navn")) {
    document.getElementById("melding").innerHTML="Skriv inn brukernavnet ditt";
  }
  if (element==document.getElementById("passordet")) {
    document.getElementById("melding").innerHTML="Skriv inn passordet ditt";
  }

}


function musUt() {
  document.getElementById("melding").innerHTML="";
}




function fjernMelding() {
   document.getElementById("melding").innerHTML="";
   document.getElementById("feilmelding").innerHTML="";
}






























/**/
