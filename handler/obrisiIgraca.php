<?php
require "../dbBroker.php";
require "../model/igrac.php";

Igrac::delete_player($_POST['igrac_id'], $conn);

?>