-- Database: hotell

-- MySQL
-- For å få et skript som kan kjøres flere ganger,
-- og som fungerer enten tabellen finnes eller ikke:


-- SELECT * FROM hotell;
-- SELECT * FROM romtype;
-- SELECT * FROM hotellromtype;
-- SELECT * FROM rom;
-- SELECT * FROM bruker;
-- SELECT * FROM admin;
-- SELECT * FROM bestilling;

DROP TABLE IF EXISTS inaktiv_bestilling;
DROP TABLE IF EXISTS bestilling;
DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS bruker;
DROP TABLE IF EXISTS rom;
DROP TABLE IF EXISTS hotellromtype;
DROP TABLE IF EXISTS hotell;
DROP TABLE IF EXISTS romtype;




CREATE TABLE hotell
(
    hotellnavn   VARCHAR(100) NOT NULL,
    sted         VARCHAR(100) NOT NULL,
    land         VARCHAR(100) NOT NULL,
    bilde        VARCHAR(100),

    CONSTRAINT hotellPK PRIMARY KEY (hotellnavn)
);


INSERT INTO hotell (hotellnavn, sted, land, bilde) VALUES
('grand hotel oslo', 'oslo', 'norge', 'grandhoteloslo.jpg'),
('hotel klubben tønsberg', 'tønsberg', 'norge', 'hotelklubbentønsberg.jpg'),
('radisson blu gardermoen', 'ullensaker', 'norge', 'radissonblu.jpg'),
('farris bad larvik', 'larvik', 'norge', 'farrisbad.jpg'),
('the mark', 'new york', 'USA', 'themark.jpg'),
('la fonda hotel', 'malaga', 'spania', 'lafondahotel.jpg'),
('grand hotel miramar', 'malaga', 'spania', 'granhotelmiramar.jpg'),
('hotel don paco', 'malaga', 'spania', 'hoteldonpaco.jpg'),
('the gotham hotel', 'new york', 'usa', 'thegothamhotel.jpg'),
('hotel grand prix', 'mexico by', 'mexico', 'hotelgrandprix.jpg'),
('tokyo plaza hotel', 'tokyo', 'japan', 'tokyoplazahotel.jpg'),
('olivia plaza hotel', 'barcelona', 'spania', 'oliviaplazahotel.jpg'),
('dila hotel', 'istanbul', 'tyrkia', 'dilahotel.jpg'),
('meme suites', 'roma', 'italia', 'memesuites.jpg');




CREATE TABLE romtype
(
    romtype   VARCHAR(100) NOT NULL,

    CONSTRAINT romtypePK PRIMARY KEY (romtype)
);


INSERT INTO romtype (romtype) VALUES
('enkeltrom'),
('økonomirom'),
('fitnessrom'),
('jungelrom'),
('bunkers'),
('dobbeltrom'),
('familierom'),
('suite');


CREATE TABLE hotellromtype
(
  hotellnavn   VARCHAR(100) NOT NULL,
  romtype      VARCHAR(100) NOT NULL,
  pris         DECIMAL UNSIGNED,
  rombilde     VARCHAR(100),
  antallrom    INTEGER DEFAULT 0,

  CONSTRAINT hotellromtypePK PRIMARY KEY (hotellnavn, romtype),
  CONSTRAINT hotellromtype_hotellFK FOREIGN KEY (hotellnavn) REFERENCES hotell (hotellnavn),
  CONSTRAINT hotellromtype_romtypeFK FOREIGN KEY (romtype) REFERENCES romtype (romtype) ON UPDATE CASCADE
);


INSERT INTO hotellromtype (hotellnavn, romtype, pris, rombilde) VALUES
('grand hotel oslo', 'enkeltrom', 4000, 'gho_enkelt.jpg'),
('grand hotel oslo', 'dobbeltrom', 5500, 'gho_dobbelt.jpg'),
('grand hotel oslo', 'suite', 15000, 'gho_suite.jpg'),

('farris bad larvik', 'dobbeltrom', 3400, 'fb_dobbelt.jpg'),
('farris bad larvik', 'suite', 20000, 'fb_suite.jpg'),
('farris bad larvik', 'familierom', 4000, 'fb_familie.jpg'),

('hotel klubben tønsberg', 'enkeltrom', 2000, 'hkt_enkelt.jpg'),
('hotel klubben tønsberg', 'dobbeltrom', 3200, 'hkt_dobbelt.jpg'),
('hotel klubben tønsberg', 'familierom', 3800, 'hkt_familie.jpg'),

('hotel grand prix', 'enkeltrom', 3300, 'hgp_enkelt.jpg'),
('hotel grand prix', 'suite', 4200, 'hgp_suite.jpg'),
('hotel grand prix', 'familierom', 3800, 'hgp_familie.jpg'),


('the mark', 'dobbeltrom', 6000, 'tm_dobbelt.jpg'),
('the mark', 'suite', 10000, 'tm_suite.jpg'),

('la fonda hotel', 'dobbeltrom', 5000, 'lfh_dobbelt.jpg'),
('la fonda hotel', 'suite', 9000, 'lfh_suite.jpg'),
('la fonda hotel', 'familierom', 5500, 'lfh_familie.jpg'),

('grand hotel miramar', 'enkeltrom', 2800, 'ghm_enkelt.jpg'),
('grand hotel miramar', 'dobbeltrom', 4500, 'ghm_dobbelt.jpg'),
('grand hotel miramar', 'familierom', 6000, 'ghm_familie.jpg'),

('hotel don paco', 'dobbeltrom', 3200, 'hdp_dobbelt.jpg'),
('hotel don paco', 'familierom', 3800, 'hdp_familie.jpg'),

('the gotham hotel', 'enkeltrom', 2000, 'tgh_enkelt.jpg'),
('the gotham hotel', 'dobbeltrom', 3000, 'tgh_dobbelt.jpg'),
('the gotham hotel', 'suite', 3800, 'tgh_suite.jpg'),

('tokyo plaza hotel', 'enkeltrom', 3200, 'tph_enkelt.jpg'),
('tokyo plaza hotel', 'familierom', 4700, 'tph_familie.jpg'),

('dila hotel', 'enkeltrom', 500, 'dh_enkelt.jpg'),
('dila hotel', 'dobbeltrom', 2300, 'dh_dobbelt.jpg'),
('dila hotel', 'suite', 4200, 'dh_suite.jpg'),
('dila hotel', 'familierom', 3800, 'dh_familie.jpg'),

('olivia plaza hotel', 'enkeltrom', 1800, 'oph_enkelt.jpg'),
('olivia plaza hotel', 'dobbeltrom', 3200, 'oph_dobbelt.jpg'),
('olivia plaza hotel', 'suite', 5500, 'oph_suite.jpg'),
('olivia plaza hotel', 'familierom', 3800, 'oph_familie.jpg'),

('meme suites', 'enkeltrom', 1000, 'ms_enkelt.jpg'),
('meme suites', 'dobbeltrom', 1500, 'ms_dobbelt.jpg'),

('radisson blu gardermoen', 'enkeltrom', 2000, 'rbg_enkelt.jpg'),
('radisson blu gardermoen', 'dobbeltrom', 5900, 'rbg_dobbelt.jpg'),
('radisson blu gardermoen', 'suite', 7100, 'rbg_suite.jpg'),
('radisson blu gardermoen', 'familierom', 5900, 'rbg_familie.jpg');




CREATE TABLE rom
(
  hotellnavn   VARCHAR(100) NOT NULL,
  romtype      VARCHAR(100) NOT NULL,
  romnr        INTEGER NOT NULL,

  CONSTRAINT romPK PRIMARY KEY (hotellnavn, romnr),
  CONSTRAINT rom_hotellromtypeFK FOREIGN KEY (hotellnavn, romtype) REFERENCES hotellromtype (hotellnavn, romtype) ON UPDATE CASCADE
);


INSERT INTO rom (hotellnavn, romtype, romnr) VALUES
('grand hotel oslo', 'enkeltrom', 101),
('grand hotel oslo', 'enkeltrom', 102),
('grand hotel oslo', 'enkeltrom', 103),
('grand hotel oslo', 'enkeltrom', 104),
('grand hotel oslo', 'enkeltrom', 105),
('grand hotel oslo', 'enkeltrom', 106),
('grand hotel oslo', 'enkeltrom', 107),
('grand hotel oslo', 'enkeltrom', 108),
('grand hotel oslo', 'enkeltrom', 109),

('grand hotel oslo', 'dobbeltrom', 201),
('grand hotel oslo', 'dobbeltrom', 202),
('grand hotel oslo', 'dobbeltrom', 203),
('grand hotel oslo', 'dobbeltrom', 204),
('grand hotel oslo', 'dobbeltrom', 205),
('grand hotel oslo', 'dobbeltrom', 206),

('grand hotel oslo', 'suite', 301),
('grand hotel oslo', 'suite', 302),
('grand hotel oslo', 'suite', 303),

('hotel klubben tønsberg', 'enkeltrom', 101),
('hotel klubben tønsberg', 'enkeltrom', 102),
('hotel klubben tønsberg', 'enkeltrom', 103),
('hotel klubben tønsberg', 'enkeltrom', 104),
('hotel klubben tønsberg', 'enkeltrom', 105),

('hotel klubben tønsberg', 'dobbeltrom', 201),
('hotel klubben tønsberg', 'dobbeltrom', 202),
('hotel klubben tønsberg', 'dobbeltrom', 203),
('hotel klubben tønsberg', 'dobbeltrom', 204),
('hotel klubben tønsberg', 'dobbeltrom', 205),
('hotel klubben tønsberg', 'dobbeltrom', 206),

('hotel klubben tønsberg', 'familierom', 401),
('hotel klubben tønsberg', 'familierom', 402),
('hotel klubben tønsberg', 'familierom', 403),
('hotel klubben tønsberg', 'familierom', 404),
('hotel klubben tønsberg', 'familierom', 405),

('farris bad larvik', 'dobbeltrom', 201),
('farris bad larvik', 'dobbeltrom', 202),
('farris bad larvik', 'dobbeltrom', 203),
('farris bad larvik', 'dobbeltrom', 204),
('farris bad larvik', 'dobbeltrom', 205),

('farris bad larvik', 'suite', 301),
('farris bad larvik', 'suite', 302),
('farris bad larvik', 'suite', 303),
('farris bad larvik', 'suite', 304),
('farris bad larvik', 'suite', 305),
('farris bad larvik', 'suite', 306),
('farris bad larvik', 'suite', 307),

('farris bad larvik', 'familierom', 401),
('farris bad larvik', 'familierom', 402),

('the mark', 'dobbeltrom', 201),
('the mark', 'dobbeltrom', 202),
('the mark', 'dobbeltrom', 203),
('the mark', 'dobbeltrom', 204),
('the mark', 'dobbeltrom', 205),

('the mark', 'suite', 301),
('the mark', 'suite', 302),
('the mark', 'suite', 303),

('la fonda hotel', 'dobbeltrom', 201),
('la fonda hotel', 'dobbeltrom', 202),
('la fonda hotel', 'dobbeltrom', 203),
('la fonda hotel', 'dobbeltrom', 204),
('la fonda hotel', 'dobbeltrom', 205),
('la fonda hotel', 'dobbeltrom', 206),
('la fonda hotel', 'dobbeltrom', 207),
('la fonda hotel', 'dobbeltrom', 208),
('la fonda hotel', 'dobbeltrom', 209),
('la fonda hotel', 'dobbeltrom', 210),

('la fonda hotel', 'suite', 301),

('la fonda hotel', 'familierom', 401),
('la fonda hotel', 'familierom', 402),
('la fonda hotel', 'familierom', 403),
('la fonda hotel', 'familierom', 404),
('la fonda hotel', 'familierom', 405),

('grand hotel miramar', 'enkeltrom', 101),
('grand hotel miramar', 'enkeltrom', 102),
('grand hotel miramar', 'enkeltrom', 103),
('grand hotel miramar', 'enkeltrom', 104),
('grand hotel miramar', 'enkeltrom', 105),
('grand hotel miramar', 'enkeltrom', 106),
('grand hotel miramar', 'enkeltrom', 107),
('grand hotel miramar', 'enkeltrom', 108),

('grand hotel miramar', 'dobbeltrom', 201),
('grand hotel miramar', 'dobbeltrom', 202),

('grand hotel miramar', 'familierom', 401),

('hotel don paco', 'dobbeltrom', 201),
('hotel don paco', 'dobbeltrom', 202),
('hotel don paco', 'dobbeltrom', 203),
('hotel don paco', 'dobbeltrom', 204),
('hotel don paco', 'dobbeltrom', 205),
('hotel don paco', 'dobbeltrom', 206),
('hotel don paco', 'dobbeltrom', 207),
('hotel don paco', 'dobbeltrom', 208),
('hotel don paco', 'dobbeltrom', 209),
('hotel don paco', 'dobbeltrom', 210),

('hotel don paco', 'familierom', 401),
('hotel don paco', 'familierom', 402),

('the gotham hotel', 'enkeltrom', 101),
('the gotham hotel', 'enkeltrom', 102),
('the gotham hotel', 'enkeltrom', 103),
('the gotham hotel', 'enkeltrom', 104),

('the gotham hotel', 'dobbeltrom', 201),
('the gotham hotel', 'dobbeltrom', 202),
('the gotham hotel', 'dobbeltrom', 203),
('the gotham hotel', 'dobbeltrom', 204),
('the gotham hotel', 'dobbeltrom', 205),
('the gotham hotel', 'dobbeltrom', 206),
('the gotham hotel', 'dobbeltrom', 207),
('the gotham hotel', 'dobbeltrom', 208),
('the gotham hotel', 'dobbeltrom', 209),

('the gotham hotel', 'suite', 301),
('the gotham hotel', 'suite', 302),
('the gotham hotel', 'suite', 303),
('the gotham hotel', 'suite', 304),
('the gotham hotel', 'suite', 305),

('tokyo plaza hotel', 'enkeltrom', 101),
('tokyo plaza hotel', 'enkeltrom', 102),
('tokyo plaza hotel', 'enkeltrom', 103),
('tokyo plaza hotel', 'enkeltrom', 104),
('tokyo plaza hotel', 'enkeltrom', 105),
('tokyo plaza hotel', 'enkeltrom', 106),
('tokyo plaza hotel', 'enkeltrom', 107),
('tokyo plaza hotel', 'enkeltrom', 108),
('tokyo plaza hotel', 'enkeltrom', 109),
('tokyo plaza hotel', 'enkeltrom', 110),

('tokyo plaza hotel', 'familierom', 401),
('tokyo plaza hotel', 'familierom', 402),

('dila hotel', 'enkeltrom', 101),
('dila hotel', 'enkeltrom', 102),
('dila hotel', 'enkeltrom', 103),
('dila hotel', 'enkeltrom', 104),
('dila hotel', 'enkeltrom', 105),
('dila hotel', 'enkeltrom', 106),
('dila hotel', 'enkeltrom', 107),
('dila hotel', 'enkeltrom', 108),
('dila hotel', 'enkeltrom', 109),
('dila hotel', 'enkeltrom', 110),
('dila hotel', 'enkeltrom', 111),
('dila hotel', 'enkeltrom', 112),

('dila hotel', 'dobbeltrom', 201),
('dila hotel', 'dobbeltrom', 202),
('dila hotel', 'dobbeltrom', 203),
('dila hotel', 'dobbeltrom', 204),
('dila hotel', 'dobbeltrom', 205),

('dila hotel', 'suite', 301),
('dila hotel', 'suite', 302),
('dila hotel', 'suite', 303),
('dila hotel', 'suite', 304),
('dila hotel', 'suite', 305),

('dila hotel', 'familierom', 401),

('hotel grand prix', 'enkeltrom', 101),
('hotel grand prix', 'enkeltrom', 102),
('hotel grand prix', 'enkeltrom', 103),
('hotel grand prix', 'enkeltrom', 104),
('hotel grand prix', 'enkeltrom', 105),
('hotel grand prix', 'enkeltrom', 106),
('hotel grand prix', 'enkeltrom', 107),
('hotel grand prix', 'enkeltrom', 108),
('hotel grand prix', 'enkeltrom', 109),
('hotel grand prix', 'enkeltrom', 110),
('hotel grand prix', 'enkeltrom', 111),
('hotel grand prix', 'enkeltrom', 112),

('hotel grand prix', 'suite', 301),
('hotel grand prix', 'suite', 302),
('hotel grand prix', 'suite', 303),
('hotel grand prix', 'suite', 304),
('hotel grand prix', 'suite', 305),

('hotel grand prix', 'familierom', 401),
('hotel grand prix', 'familierom', 402),
('hotel grand prix', 'familierom', 403),
('hotel grand prix', 'familierom', 404),
('hotel grand prix', 'familierom', 405),
('hotel grand prix', 'familierom', 406),
('hotel grand prix', 'familierom', 407),
('hotel grand prix', 'familierom', 408),

('olivia plaza hotel', 'enkeltrom', 101),
('olivia plaza hotel', 'enkeltrom', 102),
('olivia plaza hotel', 'enkeltrom', 103),

('olivia plaza hotel', 'dobbeltrom', 201),
('olivia plaza hotel', 'dobbeltrom', 202),
('olivia plaza hotel', 'dobbeltrom', 203),
('olivia plaza hotel', 'dobbeltrom', 204),
('olivia plaza hotel', 'dobbeltrom', 205),
('olivia plaza hotel', 'dobbeltrom', 206),

('olivia plaza hotel', 'suite', 301),
('olivia plaza hotel', 'suite', 302),

('olivia plaza hotel', 'familierom', 401),
('olivia plaza hotel', 'familierom', 402),

('meme suites', 'enkeltrom', 101),
('meme suites', 'enkeltrom', 102),

('meme suites', 'dobbeltrom', 201),

('radisson blu gardermoen', 'enkeltrom', 101),
('radisson blu gardermoen', 'enkeltrom', 102),
('radisson blu gardermoen', 'enkeltrom', 103),
('radisson blu gardermoen', 'enkeltrom', 104),
('radisson blu gardermoen', 'enkeltrom', 105),
('radisson blu gardermoen', 'enkeltrom', 106),

('radisson blu gardermoen', 'dobbeltrom', 201),
('radisson blu gardermoen', 'dobbeltrom', 202),
('radisson blu gardermoen', 'dobbeltrom', 203),
('radisson blu gardermoen', 'dobbeltrom', 204),
('radisson blu gardermoen', 'dobbeltrom', 205),

('radisson blu gardermoen', 'suite', 301),
('radisson blu gardermoen', 'suite', 302),
('radisson blu gardermoen', 'suite', 303),

('radisson blu gardermoen', 'familierom', 401);


UPDATE hotellromtype AS h
   SET antallrom = (
       SELECT COUNT(romnr)
        FROM rom AS r
        WHERE h.hotellnavn = r.hotellnavn AND h.romtype = r.romtype
);


CREATE TABLE bruker
(
  brukernavn    VARCHAR(55) NOT NULL,
  passord       VARCHAR(55) NOT NULL,

  CONSTRAINT brukerPK PRIMARY KEY (brukernavn)
);

INSERT INTO bruker (brukernavn, passord) VALUES
('minside', 'minside'),
('pernille', 'pernille'),
('eivind', 'eivind'),
('daniel', 'daniel'),
('alex', 'alex'),
('tina', 'tina');




CREATE TABLE admin
(
  brukernavn    VARCHAR(55) NOT NULL,
  passord       VARCHAR(55) NOT NULL,

  CONSTRAINT adminPK PRIMARY KEY (brukernavn)
);

INSERT INTO admin (brukernavn, passord) VALUES
('admin', 'admin');



CREATE TABLE bestilling
(
  radnr        INTEGER AUTO_INCREMENT,
  bestnr       INTEGER,
  brukernavn   VARCHAR(55) NOT NULL,
  datofra      DATE NOT NULL,
  datotil      DATE,
  hotellnavn   VARCHAR(100) NOT NULL,
  romnr        INTEGER NOT NULL,


  CONSTRAINT bestillingPK PRIMARY KEY (radnr),
  CONSTRAINT bestilling_brukerFK FOREIGN KEY (brukernavn) REFERENCES bruker (brukernavn),
  CONSTRAINT bestilling_romFK FOREIGN KEY (hotellnavn, romnr) REFERENCES rom(hotellnavn, romnr)
);

INSERT INTO bestilling (bestnr, brukernavn, datofra, datotil, hotellnavn, romnr) VALUES
(1000, 'minside', '2018.06.14', '2018.07.01', 'grand hotel oslo', 101),
(1001, 'minside', '2018.08.25', '2018.08.26', 'dila hotel', 101),
(1002, 'tina', '2018.06.14', '2018.06.15', 'the gotham hotel', 301),
(1003, 'tina', '2018.06.30', '2018.07.01', 'grand hotel miramar', 201),
(1004, 'tina', '2018.05.30', '2018.05.31', 'grand hotel miramar', 201),
(1005, 'tina', '2018.09.17', '2018.09.20', 'the mark', 301),
(1006, 'tina', '2018.12.16', '2018.12.17', 'olivia plaza hotel', 301),
(1007, 'pernille', '2018.07.14', '2018.07.15', 'radisson blu gardermoen', 301),
(1008, 'pernille', '2018.09.15', '2018.09.22', 'the mark', 302),
(1009, 'pernille', '2018.05.28', '2018.05.30', 'the mark', 302),
(1010, 'daniel', '2018.09.17', '2018.09.20', 'the mark', 303),
(1011, 'daniel', '2018.11.14', '2018.11.15', 'hotel don paco', 401),
(1012, 'minside', '2018.06.14', '2018.06.15', 'tokyo plaza hotel', 101),
(1013, 'minside', '2018.06.15', '2018.06.16', 'tokyo plaza hotel', 401),
(1014, 'minside', '2018.10.14', '2018.11.14', 'meme suites', 101),
(1015, 'minside', '2017.10.14', '2017.11.14', 'meme suites', 101),
(1016, 'minside', '2018.11.14', '2018.11.15', 'radisson blu gardermoen', 301);


-- Tabell for å putte bestillinger etter utsjekkdato --
CREATE TABLE inaktiv_bestilling
(
  radnr        INTEGER AUTO_INCREMENT,
  bestnr       INTEGER,
  brukernavn   VARCHAR(55) NOT NULL,
  datofra      DATE NOT NULL,
  datotil      DATE,
  hotellnavn   VARCHAR(100) NOT NULL,
  romnr        INTEGER NOT NULL,

  CONSTRAINT inaktiv_bestillingPK PRIMARY KEY (radnr)
);



-- TRIGGERE --

DELIMITER $$

-- Trigger som fyres etter INSERT på rom-tabellen --
DROP TRIGGER IF EXISTS rom_a_ins_trg $$

CREATE TRIGGER rom_a_ins_trg
  AFTER INSERT ON rom
  FOR EACH ROW
BEGIN
  UPDATE hotellromtype AS h
  SET antallrom = (
      SELECT COUNT(romnr)
      FROM rom AS r
      WHERE h.hotellnavn = r.hotellnavn AND h.romtype = r.romtype
      );
END $$


-- Trigger som fyres etter UPDATE på rom-tabellen --
DROP TRIGGER IF EXISTS rom_a_upd_trg $$

CREATE TRIGGER rom_a_upd_trg
  AFTER UPDATE ON rom
  FOR EACH ROW
BEGIN
  UPDATE hotellromtype AS h
  SET antallrom = (
      SELECT COUNT(romnr)
      FROM rom AS r
      WHERE h.hotellnavn = r.hotellnavn AND h.romtype = r.romtype
      );
END $$


-- Trigger som fyres etter DELETE på rom-tabellen --
DROP TRIGGER IF EXISTS rom_a_del_trg $$

CREATE TRIGGER rom_a_del_trg
  AFTER DELETE ON rom
  FOR EACH ROW
BEGIN
  UPDATE hotellromtype AS h
  SET antallrom = (
      SELECT COUNT(romnr)
      FROM rom AS r
      WHERE h.hotellnavn = r.hotellnavn AND h.romtype = r.romtype
      );
END $$

DELIMITER ;

-- TRIGGERE SLUTT --
