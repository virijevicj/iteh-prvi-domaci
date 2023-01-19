<?php
    class Admin{
        public $email;
        public $lozinka;

        public function __construct($email, $lozinka){
            $this->email = $email;
            $this->lozinka = $lozinka;
        }

        public static function login(Admin $admin, mysqli $conn){
            $query = "SELECT COUNT(*) AS br_redova
                        FROM db_kkfon.admin
                        WHERE email LIKE '$admin->email' AND lozinka LIKE '$admin->lozinka'
                        GROUP BY email, lozinka
            ";
            return $conn->query($query);
        }
    }


?>