<?php
require "../dbBroker.php";
require "../model/admin.php";

$admin = new Admin($_POST['email'], $_POST['lozinka']);
$odgovor = Admin::login($admin, $conn);
if ($odgovor->num_rows == 1){
    echo 'Success';
}else{
    echo 'Failed';
}
?>
