<?php

    class Utakmica{
        public $id;
        public $domacin_id;
        public $gost_id;
        public $domacin_broj_poena;
        public $gost_broj_poena;
        public $datum_odigravanja;
        public $vreme_odigravanja;
        

        public function __construct($domacin_id, $gost_id, $domacin_broj_poena, $gost_broj_poena, $datum_odigravanja, $vreme_odigravanja){
            $this->domacin_id = $domacin_id;
            $this->gost_id = $gost_id;
            $this->domacin_broj_poena = $domacin_broj_poena;
            $this->gost_broj_poena = $gost_broj_poena;
            $this->datum_odigravanja = $datum_odigravanja;
            $this->vreme_odigravanja = $vreme_odigravanja;
        }
        
    
        public static function get_all_games(mysqli $conn){
            $query = "SELECT a.utakmica_id, domacin, domacin_broj_poena, gost_broj_poena, gost, datum_odigravanja, vreme_odigravanja
            FROM
            (SELECT u.utakmica_id, f.naziv AS domacin, u.domacin_broj_poena, datum_odigravanja, vreme_odigravanja
            FROM utakmica u
            INNER JOIN fakultet f ON u.domacin_id = f.fakultet_id)a
            INNER JOIN 
            (SELECT u.utakmica_id, f.naziv AS gost, u.gost_broj_poena
            FROM utakmica u
            INNER JOIN fakultet f ON u.gost_id = f.fakultet_id)b
            ON a.utakmica_id = b.utakmica_id
            ORDER BY utakmica_id
            ";

            return $conn->query($query);
        }
        

        public static function get_score(mysqli $conn){
            $query = "SELECT a.broj_utakmica, b.broj_pobeda, a.broj_utakmica - b.broj_pobeda AS broj_poraza
            FROM
            (SELECT COUNT(*) AS broj_utakmica
            FROM utakmica)a
            CROSS JOIN
            (SELECT COUNT(*) AS broj_pobeda
            FROM utakmica
            WHERE (domacin_id = 1 AND domacin_broj_poena > gost_broj_poena) OR (gost_id = 1 AND gost_broj_poena > domacin_broj_poena))b 
            ";

            return $conn->query($query);
        
        }

        public static function get_stats(mysqli $conn){
        $query = "SELECT fon_domacin + fon_gost AS fon_poeni, domacin + gost AS protivnik_poeni, (fon_domacin + fon_gost) - (domacin + gost) AS kos_razlika
        FROM
        (SELECT SUM(domacin_broj_poena) AS fon_domacin, SUM(gost_broj_poena) AS gost
        FROM utakmica
        WHERE domacin_id = 1)a
        CROSS JOIN
        (SELECT SUM(domacin_broj_poena) AS domacin, SUM(gost_broj_poena) AS fon_gost
        FROM utakmica
        WHERE gost_id = 1)b
        ";
        return $conn->query($query);
        }
    
        public static function add_game(Utakmica $utakmica, mysqli $conn){
            $domacin = Utakmica::get_team($utakmica->domacin_id, $conn);
            $domacin_niz = $domacin->fetch_array();
            $domacin_id = $domacin_niz["fakultet_id"];

            $gost = Utakmica::get_team($utakmica->gost_id, $conn);
            $gost_niz = $gost->fetch_array();
            $gost_id = $gost_niz["fakultet_id"];

            $query = "INSERT INTO utakmica (domacin_id, gost_id, domacin_broj_poena, gost_broj_poena, datum_odigravanja, vreme_odigravanja)
                        VALUES ($domacin_id, $gost_id, $utakmica->domacin_broj_poena, $utakmica->gost_broj_poena,
                         '$utakmica->datum_odigravanja', '$utakmica->vreme_odigravanja')";
             return $conn->query($query);
        }


        public static function get_last_game(mysqli $conn){
            $q = "SELECT a.utakmica_id, domacin, domacin_broj_poena, gost_broj_poena, gost, datum_odigravanja, vreme_odigravanja
            FROM
            (SELECT u.utakmica_id, f.naziv AS domacin, u.domacin_broj_poena, datum_odigravanja, vreme_odigravanja
            FROM utakmica u
            INNER JOIN fakultet f ON u.domacin_id = f.fakultet_id)a
            INNER JOIN 
            (SELECT u.utakmica_id, f.naziv AS gost, u.gost_broj_poena
            FROM utakmica u
            INNER JOIN fakultet f ON u.gost_id = f.fakultet_id)b
            ON a.utakmica_id = b.utakmica_id
            ORDER BY  utakmica_id DESC LIMIT 1";
            return $conn->query($q);
        }

        public static function get_team($naziv, mysqli $conn){
            $query = "SELECT fakultet_id
                        FROM fakultet
                        WHERE naziv LIKE '$naziv'";
            return $conn->query($query);

        }

    }
    

?>
