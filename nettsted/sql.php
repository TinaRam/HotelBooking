<?php
  $sqlSetning = "SELECT h.hotellnavn, h.sted, h.land, (SELECT GROUP_CONCAT(pris SEPARATOR ',  ') FROM hotellromtype WHERE hotellnavn = h.hotellnavn) AS pris, (SELECT GROUP_CONCAT(romtype SEPARATOR ', ') FROM hotellromtype WHERE hotellnavn = h.hotellnavn) AS romtype, h.bilde
                        FROM hotell as H
                        LEFT JOIN hotellromtype AS hrt ON h.hotellnavn = hrt.hotellnavn
                        WHERE (pris >= $minPris AND pris <= $maxPris OR pris IS NULL)";


  $r = 1;
  $y = 1;
  $x = 1;
  $z = 0;

  for ($i=0; $i < count($sted); $i++) {
    if ($r == 1) {
      $sqlSetning .= " AND ";
      $sqlSetning .= " ( ";
      $r = 0;
      $z = 1;
    } else {
      $sqlSetning .= " OR ";
    }
    $sqlSetning .= " sted  = '$sted[$i]' ";
  }
  for ($i=0; $i < count($romtype); $i++) {
    if ($y == 1) {
      if ($r == 0) {
        $sqlSetning .= " ) ";
      }
      $sqlSetning .= " AND ";
      $sqlSetning .= " ( ";
      $y = 0;
      $z = 1;
    } else {
      $sqlSetning .= " OR ";
    }
    $sqlSetning .= " romtype  = '$romtype[$i]' ";
  }
  for ($i=0; $i < count($land); $i++) {
    if ($x == 1) {
      if ($r == 0) {
        $sqlSetning .= " ) ";
      }
      $sqlSetning .= " AND ";
      $sqlSetning .= " ( ";
      $x = 0;
      $z = 1;
    } else {
      $sqlSetning .= " OR ";
    }
    $sqlSetning .= " land  = '$land[$i]' ";
  }
  if ($z == 1) {
    $sqlSetning .= " ) ";
  }
  $sqlSetning .= " GROUP BY h.hotellnavn ";
?>
