<?php

    require_once 'connect.php';

    $db = new database();

    $car = $db->query("SELECT * FROM `one`");
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">
        <div class="row">
            <table class="table">

                <thead class="thead-dark">
                    <tr>
                        <th scope="col" class="number">№</th>
                        <th scope="col" class="marka">Марка</th>
                        <th scope="col" class="data">Дата производства</th>
                        <th scope="col" class="colour">Цвет</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        $count = 0;
                        foreach ($car as $key => $value) {
                            $count++;
                            ?>
                                <tr>
                                    <th class="number"><?= $count ?></th>
                                    <td class="marka"><?= $value['name'] ?></td>
                                    <td class="data"><?= $value['date'] ?></td>
                                    <td class="colour"><?= $value['colour'] ?></td>
                                </tr>
                            <?php
                        }
                    ?>
                </tbody>

            </table>

            <div class="input-group">
                <select class="custom-select" id="inputGroupSelect04">
                    <?php $count = 0;
                    foreach ($car as $key => $value) {
                        $count++; ?>
                        <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                    <?php } ?>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="del">Удалить</button>
                </div>
            </div>

            <div id="text">

            </div>

        </div>
    </div>
    <script src="js/JQuery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $('#del').click(function () {
            event.preventDefault();
            var idRow = $('#inputGroupSelect04').val ();
            $.ajax({
                url:    	'sql.php',
                type:		'POST',
                cache: 		false,
                data:   	{'id':idRow},
                dataType:	'json',
                success: function(data) {
                    console.dir(data);
                    document.write("<?php $counter='"+data+"' ?>");
                }
            });
        });
    </script>
<?php print_r($counter);?>
</body>
</html>
