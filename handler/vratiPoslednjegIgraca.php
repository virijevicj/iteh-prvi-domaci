<?php

require "../dbBroker.php";
require "../model/igrac.php";

$status = Igrac::get_last_player($conn);
if($status){
    echo $status->fetch_column();
}else{
    echo $status;
    echo "Failed";
}

?>