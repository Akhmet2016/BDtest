<?php
require_once 'connect.php';
$db = new database();

if (isset($_POST['id'])) {
    $id = trim($_POST['id']);
//    $db->query("DELETE FROM `one` WHERE `id` = $id");
    $car = $db->query("SELECT * FROM `one`");
    echo json_encode($car);
}



