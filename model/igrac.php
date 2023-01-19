<?php

    class Igrac{
        public $id;
        public $ime;
        public $prezime;
        public $datum_rodjenja;
        public $pozicija;
        public $indeks;
        public $smer;
        public $telefon;
        public $email;

        public function __construct( $ime, $prezime, $datum_rodjenja, $pozicija, $indeks, $smer, $telefon, $email){           
            $this->ime = $ime;
            $this->prezime = $prezime;
            $this->datum_rodjenja = $datum_rodjenja;
            $this->pozicija = $pozicija;
            $this->indeks = $indeks;
            $this->smer = $smer;
            $this->telefon = $telefon;
            $this->email = $email;
        }
    
        public static function get_all_players(mysqli $conn){
            // $query = "SELECT i.igrac_id, ime, prezime, pozicija, poeni, skokovi, asistencije, ukradene, izgubljene, blokade, minuti, broj_utakmica
            // FROM igrac i 
            // INNER JOIN
            // (SELECT igrac_id, ROUND (AVG(poeni),2) AS poeni , ROUND (AVG(skokovi),2) AS skokovi, ROUND (AVG(asistencije), 2) AS asistencije,
            //     ROUND (AVG(ukradene_lopte), 2) AS ukradene, ROUND(AVG(izgubljene_lopte),2) AS izgubljene , ROUND (AVG(blokade),2) AS blokade,
            //      ROUND(AVG(odigrani_minuti),2) AS minuti, COUNT(igrac_id) AS broj_utakmica
            // FROM igrac_statistika
            // GROUP BY igrac_id
            // ORDER BY igrac_id) a
            // ON i.igrac_id = a.igrac_id";
            $query = "select * from igrac";
            return $conn->query($query);
        }
        
        public static function get_player_stats($id, mysqli $conn){
            $query = "SELECT ROUND (AVG(poeni),2) AS poeni , ROUND (AVG(skokovi),2) AS skokovi, ROUND (AVG(asistencije), 2) AS asistencije,
                ROUND (AVG(ukradene_lopte), 2) AS ukradene, ROUND(AVG(izgubljene_lopte),2) AS izgubljene , ROUND (AVG(blokade),2) AS blokade,
                ROUND(AVG(odigrani_minuti),2) AS minuti
                FROM igrac_statistika
                WHERE igrac_id = {$id}";
            return $conn->query($query);
        }

        public static function add_new_player(Igrac $igrac, mysqli $conn){
            $query = "INSERT INTO igrac (ime, prezime, datum_rodjenja, pozicija, indeks, smer, telefon, email)
            VALUES ('$igrac->ime', '$igrac->prezime', '$igrac->datum_rodjenja', '$igrac->pozicija', '$igrac->indeks', '$igrac->smer', '$igrac->telefon', '$igrac->email')";
            return $conn->query($query);
        }

        public static function get_last_player(mysqli $conn){
            $query = "SELECT * FROM igrac ORDER BY igrac_id DESC LIMIT 1";
            return $conn->query($query);
        }

        public static function delete_player($id, mysqli $conn){
            $query = "DELETE FROM igrac WHERE igrac_id = $id ";
            return $conn->query($query);
        }

    }
    

?>
