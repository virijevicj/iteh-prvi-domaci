<?php

require "../dbBroker.php";
require "../model/igrac.php";

if(isset($_POST['ime']) && isset($_POST['prezime']) && isset($_POST['datum_rodjenja']) && isset($_POST['pozicija']) 
    && isset($_POST['indeks']) && isset($_POST['smer']) && isset($_POST['telefon']) &&isset($_POST['email'])  ){
        $novi_igrac = new Igrac( $_POST['ime'], $_POST['prezime'], $_POST['datum_rodjenja'], $_POST['pozicija'],
                                $_POST['indeks'], $_POST['smer'], $_POST['telefon'], $_POST['email'] );
        
        $status = Igrac::add_new_player($novi_igrac, $conn);
        if ($status){
            echo 'Success';
        }else{
            echo $status;
            echo 'Failed';
        }
    }


?>