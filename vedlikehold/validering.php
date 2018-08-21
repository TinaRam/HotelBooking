<?php

/* Validerer sted i endreHotell.php */
/* Sjekker at feltet er fylt ut */
/* Sjekker at stedet KUN inneholder bokstaver*/
/* Parameter: $nyttSted = verdien som sjekkes */
function validerSted($nyttSted) {

  $gyldigSted=true;

  if (!$nyttSted)
  {
    $gyldigSted=false;
    echo "Sted må fylles ut!";
  }
  elseif (!preg_match("/^[a-zA-ZæÆøØåÅ ]*$/", $nyttSted))
  {
    $gyldigSted=false;
    echo "Sted skal kun inneholde bokstaver. (med unntak av bindestrek og mellomrom) <br>";
  }
  else
  {
    return $gyldigSted;
  }
}


/* Validerer land i endreHotell.php */
/* Sjekker at feltet er fylt ut */
/* Sjekker at landet KUN inneholder bokstaver*/
/* Parameter: $nyttLand = verdien som sjekkes */
function validerLand($nyttLand) {

  $gyldigLand=true;

  if (!$nyttLand)
  {
    $gyldigLand=false;
    echo "Land må fylles ut!";
  }
  elseif (!preg_match("/^[a-zA-ZæÆøØåÅ ]*$/", $nyttLand))
  {
    $gyldigLand=false;
    echo "Land skal kun inneholde bokstaver. <br>";
  }
  else
  {
    return $gyldigLand;
  }
}

/* Validerer hotellnavn i registrerHotell.php */
/* Sjekker at feltet er fylt ut */
/* Sjekker at input ikke inneholder tegn som #$%&?= osv..*/
function validerHotellnavn($hotellnavn) {

  $gyldigNavn=true;

  if (!$hotellnavn)
  {
    $gyldigNavn=false;
    echo "Hotellnavn må fylles ut!";
  }
  elseif (!preg_match("/^[0-9a-zA-ZæÆøØåÅ & -]*$/", $hotellnavn))
  {
    $gyldigNavn=false;
    echo "Hotellnavnet kan ikke inneholde spesialtegn med unntak av - og & <br>";
  }
  else
  {
    return $gyldigNavn;
  }
}


/* Validerer sted i registrerHotell.php */
/* Sjekker at feltet er fylt ut */
/* Sjekker at input kun inneholder bokstaver inkl. ø æ å*/
function validerStedet($sted) {

  $gyldigSted=true;

  if (!$sted)
  {
    $gyldigSted=false;
    echo "Sted må fylles ut!";
  }
  elseif (!preg_match("/^[a-zA-ZæÆøØåÅ ]*$/", $sted))
  {
    $gyldigSted=false;
    echo "Sted kan kun inneholde bokstaver! <br>";
  }
  else
  {
    return $gyldigSted;
  }
}


/* Validerer land i registrerHotell.php */
/* Sjekker at feltet er fylt ut */
/* Sjekker at input kun inneholder bokstaver inkl. ø æ å*/
function validerLandet($land) {

  $gyldigLand=true;

  if (!$land)
  {
    $gyldigLand=false;
    echo "Sted må fylles ut!";
  }
  elseif (!preg_match("/^[a-zA-ZæÆøØåÅ ]*$/", $land))
  {
    $gyldigLand=false;
    echo "Land kan kun inneholde bokstaver. <br>";
  }
  else
  {
    return $gyldigLand;
  }
}


/* Validerer romtype i registrerRomtype.php */
/* Sjekker at feltet er fylt ut */
/* Sjekker at input kun inneholder bokstaver inkl. ø æ å og - & */
function validerRegRomtype($romtype) {

  $gyldigRomtype=true;

  if (!$romtype)
  {
    $gyldigRomtype=false;
    echo "Du må skrive inn en ny romtype!";
  }
  elseif (!preg_match("/^[0-9a-zA-ZæÆøØåÅ & -]*$/", $romtype))
  {
    $gyldigRomtype=false;
    echo "Romtype kan kun inneholde bokstaver med unntak av - og &! <br>";
  }
  else
  {
    return $gyldigRomtype;
  }
}


/* Validerer romtype i endreRomtype.php */
/* Sjekker at feltet er fylt ut */
/* Sjekker at input består av KUN bokstaver, inkl: æ, ø, å*/
/* Parameter: $nyRomtype = verdien som sjekkes */
function validerNyRomtype($nyRomtype) {

  $gyldigRomtype=true;

  if (!$nyRomtype)
  {
    $gyldigRomtype=false;
    echo "Romtype må fylles ut!";
  }
  elseif (!preg_match("/^[0-9a-zA-ZæÆøØåÅ & -]*$/", $nyRomtype))
  {
    $gyldigRomtype=false;
    echo "Romtype kan kun inneholde bokstaver med unntak av - og &!  <br>";
  }
  else
  {
    return $gyldigRomtype;
  }
}






?>
