<?php

require "../dbBroker.php";
require "../utakmica.php";

if(isset($_POST['domacin']) && isset($_POST['gost']) && isset($_POST['domacin_broj_poena']) && isset($_POST['gost_broj_poena']) 
    && isset($_POST['datum_odigravanja']) && isset($_POST['vreme_odigravanja']) ){
        $nova_utakmica = new Utakmica( $_POST['domacin'], $_POST['gost'], $_POST['domacin_broj_poena'], $_POST['gost_broj_poena'],
                                $_POST['datum_odigravanja'], $_POST['vreme_odigravanja']);
        
        $status = Utakmica::add_game($nova_utakmica, $conn);
        if ($status){
            echo 'Success';
        }else{
            echo $status;
            echo 'Failed';
        }
    }


?>
