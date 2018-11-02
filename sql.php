<?php
require_once 'connect.php';
$db = new database();

if (isset($_POST['id'])) {
    $id = trim($_POST['id']);
    $car = $db->query("SELECT * FROM `one`");
    $array = [];

    $count = 0;
    foreach ($car as $key => $value) {
        $count++;
        $array[] .= '<tr class="cars">
                        <th class="number">'.$count.'</th>
                        <td class="marka">'.$value['name'].'</td>
                        <td class="data">'.$value['date'].'</td>
                        <td class="colour">'.$value['colour'].'</td>
                    </tr>';
    }
    echo json_encode($array);
}



