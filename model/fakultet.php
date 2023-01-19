<?php

    class Fakultet{
        public $id;
        public $naziv;

        public function __construct($naziv){
            $this->naziv = $naziv;
        }

        public static function get_all_teams(mysqli $conn){
            $query = "SELECT * FROM fakultet";
            return $conn->query($query);
        }
    }

?>