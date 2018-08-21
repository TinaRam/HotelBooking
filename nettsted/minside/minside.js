// hendelser //

// element=this //

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
  if (element==document.getElementById("bruker")) {
    document.getElementById("melding").innerHTML="Skriv inn ønsket brukernavn";
  }
  if (element==document.getElementById("passord1")) {
    document.getElementById("melding").innerHTML="Skriv inn et personlig passord";
  }
  if (element==document.getElementById("passord2")) {
    document.getElementById("melding").innerHTML="Gjenta valgt passord";
  }
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



// function settFokus(element) {
//   element.focus();
// }


function fjernMelding() {
   document.getElementById("melding").innerHTML="";
   document.getElementById("feilmelding").innerHTML="";
}
