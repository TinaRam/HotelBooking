


/* ########################################################################## */
/*
/*    NULLSTILL
/*
/* ########################################################################## */

function refreshVisHotell() {
  window.location.href="visHotell.php";
}

function refreshVisRomtyper() {
  window.location.href="visRomtype.php";
}

function refreshVisHotellromtype() {
  window.location.href="visHotellromtype.php";
}

function refreshVisRom() {
  window.location.href="visRom.php";
}


/*-------------------------   nullstill slutt   ------------------------------*/



function ting(hotellnavn) {
  $("#loading").show();
  document.getElementById("loading").style.visibility = "visible";

  var foresporsel=new XMLHttpRequest();

  foresporsel.onreadystatechange=function() {
    if (foresporsel.readyState==4 && foresporsel.status==200) {
      document.getElementById("meldingForslagRomtype").innerHTML=foresporsel.responseText;
      $("#loading").fadeOut();
    }
  }
  foresporsel.open("GET","phpSlettRom2.php?hotellnavn="+hotellnavn);
  foresporsel.send();
  document.getElementById('meldingForslagRomtype').innerHTML = "";
  document.getElementById('meldingForslagRomnr').innerHTML = "";
  document.getElementById('romtype').value = "";
  document.getElementById('romnr').value = "";
  document.getElementById("sok").value = hotellnavn;
}




  /* ########################################################################## */
  /*
  /*    HENDELSER
  /*
  /* ########################################################################## */

  function fokus(element){
    element.style.background="rgba(243, 246, 59, 0.88)";  //skifter bakgrunnsfarge ved fokus//
  }


  function mistetFokus(element){
    element.style.background="white"; //skifter bakgrunn tilbake til hvit//
  }


  function musInn(element){
    document.getElementById("melding").style.color="blue";
    document.getElementById("kanIkke").style.color="red";

/* endreHotell.php (TR)*/
    if (element==document.getElementById("uendretHotellnavn")) {
      document.getElementById("kanIkke").innerHTML="Du kan ikke endre hotellnavnet";
    }
    if (element==document.getElementById("endreSted")) {
      document.getElementById("melding").innerHTML="Skriv inn sted";
    }
    if (element==document.getElementById("endreLand")) {
      document.getElementById("melding").innerHTML="Skriv inn land";
    }
/* endreHotell.php -slutt-*/

/* endreHotellromtype.php (TR)*/
    if (element==document.getElementById("uendretHotell")) {
      document.getElementById("kanIkke").innerHTML="Du kan ikke endre hotellnavnet";
    }
    if (element==document.getElementById("uendretRomtype")) {
      document.getElementById("kanIkke").innerHTML="Du kan ikke endre romtype";
    }
    if (element==document.getElementById("endrePris")) {
      document.getElementById("melding").innerHTML="Pris må være et positiv tall, maksimalt femsifret";
    }
    if (element==document.getElementById("uendretAntallrom")) {
      document.getElementById("kanIkke").innerHTML="Antall rom blir talt opp automatisk og kan ikke endres";
    }
/* endreHotellromtype.php -slutt-*/

/* endreRomtype.php (TR)*/
    if (element==document.getElementById("endreTilRomtype")) {
      document.getElementById("melding").innerHTML="Skriv inn det du ønsker å endre romtypen til";
    }
/* endreHotellromtype.php -slutt-*/

/* endreRom.php (TR)*/
    if (element==document.getElementById("uendretHotellRom")) {
      document.getElementById("kanIkke").innerHTML="Du kan ikke endre hotellnavn";
    }
    if (element==document.getElementById("uendretRomnr")) {
      document.getElementById("kanIkke").innerHTML="Du kan ikke endre romnr";
    }
/* endreRom.php -slutt-*/

/* registrerHotellromtype.php */
    if (element==document.getElementById("xxhotellnavn")) {
      document.getElementById("melding").innerHTML = "Du kan ikke endre hotellnavn";
    }
    if (element== document.getElementById("pris")) {
      document.getElementById("melding").innerHTML = "Pris må være et positivt tall, maksimalt femsifret";
    }
    if (element==document.getElementById("bilde")) {
      document.getElementById("melding").innerHTML = "Valgfritt: Velg ønsket hotellrombilde";
    }
/* registrerHotellromtype.php -slutt-*/

    if (element==document.getElementById("brukernavn")) {
      document.getElementById("melding").innerHTML="Velg et unikt brukernavn bestående av to eller tre bokstaver";
    }
    if (element==document.getElementById("sok")) {
      document.getElementById("melding").innerHTML="Skriv inn hotellnavn eller deler av det";
    }
    if (element==document.getElementById("romnr")) {
      document.getElementById("melding").innerHTML="Skriv inn romnummeret";
    }
    if (element==document.getElementById("registrerRomtype")) {
      document.getElementById("melding").innerHTML="Skriv inn romtypen du vil registrere";
    }
    if (element==document.getElementById("rom")) {
      document.getElementById("melding").innerHTML="Skriv antall rom.";
    }
    if (element==document.getElementById("romtype")) {
      document.getElementById("melding").innerHTML="Skriv inn ønsket romtype";
    }

  } /* musINN -slutt-*/


function musUt() {
  document.getElementById("melding").innerHTML="";
  document.getElementById("kanIkke").innerHTML="";
}

function fjern() {
  document.getElementById("infoTekst").innerHTML="";
}


function fjernMelding() {
  document.getElementById("melding").innerHTML="";
  document.getElementById("feilmelding").innerHTML="";
  document.getElementById("kanIkke").innerHTML="";
}
/*-------------------------   hendelser slutt   ------------------------------*/




/* ########################################################################## */
/*
/*    Validering
/*
/* ########################################################################## */


// Validerer at feltene er fylt ut i registrerHotell.php //
// At sted og land kun inneholder bokstaver //
function registrerHotellValidate() {

  var hotellnavn = document.forms["registrerHotell"]["hotellnavn"].value;
  var land = document.forms["registrerHotell"]["land"].value;
  var sted = document.forms["registrerHotell"]["sted"].value;
  var gyldigHotellnavn;
  var gyldigStedsnavn;
  var gyldigLandnavn;
  var feilmelding;
  var bokstaver=/^[a-zA-ZøæåÆØÅ ]+$/;


  if (!hotellnavn || !sted || !land)
  {
    feilmelding="Alle feltene må fylles ut! <br> ";

    gyldigHotellnavn=false;
    gyldigStedsnavn=false;
    gyldigLandnavn=false;
  }
  else if (!land.match(bokstaver))
  {
    feilmelding= "Land kan kun inneholde bokstaver! <br> ";
    gyldigLandnavn=false;
  }
  else if (!sted.match(bokstaver))
  {
    feilmelding= "Sted kan kun inneholde bokstaver! <br> ";
    gyldigStedsnavn=false;
  }
  else {
    gyldigHotellnavn=true;
    gyldigStedsnavn=true;
    gyldigLandnavn=true;
  }

  if (!gyldigHotellnavn || !gyldigStedsnavn || !gyldigLandnavn) {
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }
}



// Validering av romtype i registrerRomtype.php //
function registrerRomtypeValider() {
  document.getElementById("feilmelding").style.color = "red";
  var romtype = document.forms["registrerRomtype"]["romtype"].value;
  var feilmelding;

  if (!romtype) {
    feilmelding="Skriv inn romtype! <br> ";
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }
}

// Validerer registrerRom.php //
// Sjekker om feltene er fylt ut og om pris er et positivt tall //
function registrerRom() {
  document.getElementById("feilmelding").style.color = "red";

  var feilmelding = "Alle feltene må fylles ut.";
  var hotellnavn = document.forms["registererRom"]["hotellnavn"].value;
  var romtype = document.forms["registererRom"]["romtype"].value;
  var romnr = document.forms["registererRom"]["romnr"].value;
  var feilmelding;
  var gyldigRom;
  var tall=/^[0-9]+$/;

  if (!hotellnavn) {
    feilmelding="Velg et hotell!<br>";
    gyldigRom=false;
  }
  else if (!romtype) {
    feilmelding="Velg en romtype!<br>";
    gyldigRom=false;
  }
  else if (!romnr) {
    feilmelding="Skriv inn ønsket romnr!<br>";
    gyldigRom=false;
  }
  else if (!romnr.match(tall) || romnr > 99999) {
    feilmelding="Romnummeret må være et positivt tall og være maksimalt 5 siffer!<br>";
    gyldigRom=false;
  }
  else {
    gyldigRom=true;
  }

  if (!gyldigRom) {
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }

}


// Validerer at man har valgt et hotellnavn i endreHotell.php //
function validerValgtHotell()
{
  var velgHotell=document.forms.velgEndreHotell.hotellnavn.value;
  var feilmelding;

  if (!velgHotell) {
    feilmelding="Velg det hotellet du vil endre på! <br> ";
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }
}



// Validerer at man har fylt ut alle feltene i endreHotell.php //
function endreHotellvalidate() {
    document.getElementById("feilmelding").style.color = "red";

    var endreSted = document.forms["endreHotell"]["endreSted"].value;
    var endreLand = document.forms["endreHotell"]["endreLand"].value;
    var feilmelding;
    var gyldigHotell;
    var bokstaver=/^[a-zA-ZøæåÆØÅ ]+$/;

    if (!endreSted) {
      feilmelding="Skriv inn sted!<br>";
      gyldigHotell=false;
    }
    else if (!endreLand) {
      feilmelding="Skriv inn land!<br>";
      gyldigHotell=false;
    }
    else if (!endreSted.match(bokstaver)) {
      feilmelding="Sted kan kun inneholde bokstaver!<br>";
      gyldigHotell=false;
    }
    else if (!endreLand.match(bokstaver)) {
      feilmelding="Land kan kun inneholde bokstaver!<br>";
      gyldigHotell=false;
    }
    else {
      gyldigHotell=true;
    }

    if (!gyldigHotell) {
      document.getElementById("feilmelding").style.color="red";
      document.getElementById("feilmelding").innerHTML=feilmelding;
      return false;
    }
    else {
      return true;
    }
}






// Validerer at man har valgt et hotellnavn i endreRom.php //
function validerHotellEndreRom()
{
  var hotellnavn=document.getElementById("valgtHotellnavn").value;
  var feilmelding;

  if (!hotellnavn) {
    feilmelding="Velg det hotellet du vil endre rom på! <br> ";
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }
}

// Validerer at man har valgt et romnr i endreRom.php //
function validerRom()
{
  var romnr=document.getElementById("valgtRomnr").value;
  var feilmelding;

  if (!romnr) {
    feilmelding="Velg romnr til rommet du vil endre! <br> ";
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }
}


// Validerer at man har valgt en romtype i endreRomtype.php //
function validerRomtype()
{
  var romtype=document.getElementById("valgtRomtype").value;
  var feilmelding;

  if (!romtype) {
    feilmelding="Velg den romtypen du vil endre! <br> ";
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }
}

// Validerer at man har fylt ut ny romtype i endreRomtype.php //
function validerNyRomtype()
{
  var nyRomtype=document.getElementById("endreTilRomtype").value;
  var feilmelding;

  if (!romtype) {
    feilmelding="Skriv inn romtype! <br> ";
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }
}


// Validerer at man har valgt hotellnavn i endreHotellromtype.php //
function validerValgtHotellnavn()
{
  var hotellnavn=document.forms.velgHotell.hotellnavn.value;
  var feilmelding;

  if (!hotellnavn) {
    feilmelding="Du må velge hotell! <br> ";
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }
}


// Validerer at man har valgt romtype i endreHotellromtype.php //
function validerValgtRomtype()
{
  var romtype=document.forms.velgRomtype.romtype.value;
  var feilmelding;

  if (!romtype) {
    feilmelding="Du må velge romtype! <br> ";
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }
}

// Validerer pris i endreHotellromtype.php //
function validerPris()
{
  var pris=document.getElementById("endrePris").value;
  var feilmelding;
  var gyldigPris=true;

  if (!pris) {
    feilmelding= "Feltet pris må fylles ut! <br> ";
    gyldigPris=false;
  }
  else if (pris < 0) {
    feilmelding= "Prisen må være at positivt tall! <br> ";
    gyldigPris=false;
  }
  else if (pris > 99999) {
    feilmelding= "Pris må være realistisk, hold deg under 100.000! <br> ";
    gyldigPris=false;
  }
  else if (/\D/.test(pris)) {
    feilmelding= "Prisen kan kun inneholde siffer! <br> ";
    gyldigPris=false;
  }

  if (gyldigPris) {
    return true;
  }
  else {
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
}

// Validerer at man har valgt sted i visHotell.php //
function validerVisHotell()
{
  var sted=document.forms.visHotell.sted.value;
  var feilmelding;

  if (!sted) {
    feilmelding="Du må velge sted! <br> ";
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }
}


// Validerer om man har valgt hotell i visRomtype.php //
function validerVisRomtype()
{
  var hotellnavn=document.forms.visHotellromtype.hotellnavn.value;
  var feilmelding;

  if (!hotellnavn) {
    feilmelding="Velg hotell fra listeboksen for å se romtypene til et bestemt hotell! <br> ";
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }
}


// Validerer om man har valgt hotell i visHotellromtype.php //
function validerVisHotellromtype()
{
  var hotellna=document.forms.velgHotellromtype.hotellnavn.value;
  var feilmelding;

  if (!hotellna) {
    feilmelding="Velg et hotell fra listeboksen! <br> ";
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }
}


// Validerer at man har valgt hotell i visRom.php //
function validerVisRom()
{
  var hotellrom=document.forms.visRom.hotellnavn.value;
  var feilmelding;

  if (!hotellrom) {
    feilmelding="Du må velge et hotell! <br> ";
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }
}

// Validerer at man har valgt hotell i SlettHotell.php //
function slettHotellValidering() {
  document.getElementById("feilmelding").style.color = "red";

  var hotellnavn = document.forms.slettHotellForm.hotellnavn.value;

  var feilmelding = "Hotellnavn må fylles ut";

  if (!hotellnavn) {
    document.getElementById("feilmelding").innerHTML = feilmelding;
    return false;
  }
  return true;
}

// Validerer slettRomtype.php //
function slettromtypeV() {
  document.getElementById("feilmelding").style.color = "red";

  var feilmelding = "Du må velge en romtype!";
  var velgRomtype = document.forms["ubrukteRomtyper"]["velgRomtype"].value;

  if (!velgRomtype) {
    document.getElementById("feilmelding").innerHTML = feilmelding;
    return false;
  }
  return confirm("Sletting kan ikke angres, er du sikker?");
}

// Validerer registrertehoteller.php //
function sok() {
  document.getElementById("infoTekst").style.color = "blue";

  var infoTekst = "Skriv inn brukernavn eller deler av det for å søke.";
  var sokEtterBruker = document.forms["sokeSkjema"]["sokEtterBruker"].value;

  if (!sokEtterBruker) {
    document.getElementById("infoTekst").innerHTML = infoTekst;
    return false;
  }
  return true;
}


// Validerer at det er valgt hotell i registrerHotellromtype.php //
function validerIkkeTomtFelt()
{
  document.getElementById("feilmelding").style.color = "red";

  var feilmelding = "Du må velge et hotell!";
  var navn = document.forms.velgRegistrerHotellromtype.hotellnavn.value;

  if (!navn) {
    document.getElementById("feilmelding").innerHTML = feilmelding;
    return false;
  }
  else {
    return true;
  }
}


// Validerer at feltene er fylt ut i registrerHotellromtype.php //
// og at pris er et positivt tall //
function registrerHotellromtypeValider() {

  var romtype = document.forms["registrerHotellromtype"]["romtype"].value;
  var pris = document.forms["registrerHotellromtype"]["pris"].value;
  var feilmelding;
  var gyldigPris=true;

  if (!pris) {
    feilmelding= "Feltet pris må fylles ut! <br> ";
    gyldigPris=false;
  }
  else if (pris < 0) {
    feilmelding= "Pris kan ikke være et negativt tall.! <br> ";
    gyldigPris=false;
  }
  else if (pris > 99999) {
    feilmelding= "Pris må være realistisk, hold deg under 100.000! <br> ";
    gyldigPris=false;
  }
  else if (/\D/.test(pris)) {
    feilmelding= "Prisen kan kun inneholde siffer! <br> ";
    gyldigPris=false;
  }

  if (!gyldigPris || !romtype) {
    document.getElementById("feilmelding").style.color="red";
    document.getElementById("feilmelding").innerHTML=feilmelding;
    return false;
  }
  else {
    return true;
  }
}
