<?php
if (isset($_POST['login'])) {
    $login = trim($_POST['login']);
}
if (isset($_POST['password'])) {
    $password = trim($_POST['password']);
}
$login = stripcslashes($login);
$login = htmlspecialchars($login);
$password = stripcslashes($password);
$password = htmlspecialchars($password);

$err = "";
if ($login == "" || $password == "")
    $err = "Заполните все поля";

if ($err != "") { //Есть какие либо ошибки
    echo $err;
    exit;
}

$mysqli = new mysqli ("localhost","abstract_wp402","((2S20D7p7","abstract_wp402");
$mysqli -> query ("SET NAMES 'utf-8'");

if ($selectDB = $mysqli -> query ("SELECT * FROM `as_admin_auth`")) {
//if ($selectDB = $mysqli -> query ("SELECT * FROM `as_admin_auth` WHERE `login` = '$login' AND `password` = '$password'")) {
    $result = $selectDB -> fetch_assoc();
    $login_DB = $result['login'];
    $password_DB = $result['password'];
    $selectDB->close();

    if ($login == $login_DB && $password == $password_DB) {
        $dir = $_SERVER['DOCUMENT_ROOT']."/wp-content/themes/archtheme/images/";
        $count_files = 0;
        $dir_list = scandir($dir);
        $count_files = count($dir_list);
        $count_project = 0;

        for ($j = 0; $j < $count_files; $j++) {
            $value = 'project'.$j;
            if (in_array($value,$dir_list)) {
                $count_project++;
            }
        }

        $load_img = '';
        $edit_block = '';
        $add_block = '
            <div class="row" style="margin-left: 0; margin-right: 0;">
                <div class="col-sm-offset-5 col-sm-2">
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalAddProject">
                        Добавить проект
                    </button>
                </div>
            </div>
            <br>
            <div class="modal fade" id="myModalAddProject" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Добавление проекта</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form method="post" class="auth-form col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="addTypeProject" class="form-control-label">Тип проекта:</label>
                                            <select id="addTypeProject" data-toggle="dropdown">
                                                <option value="1" selected>Общественный</option>
                                                <option value="2">Жилой</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="addNameProject" class="form-control-label">Название проекта:</label>
                                            <input type="text" class="form-control" name="addName" id="addNameProject" placeholder="Введите название проекта">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="addDescProject" class="form-control-label">Описание проекта:</label>
                                            <textarea id="addDescProject" name="addDesc" class="form-control" cols="30" rows="6" placeholder="Введите описание проекта"></textarea>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-left: 0; margin-right: 0;">
                                        <form method="post" class="col-xs-12" enctype="multipart/form-data">
                                            <div class="row" style="margin-left: 0; margin-right: 0;">
                                                <div class="col-xs-12">
                                                    <div class="row">
                                                        <input type="file" class="btn col-xs-12" multiple="multiple" name="picture" style="margin-top: 10px;" value="Добавить изображение">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button type="button" class="btn btn-primary" id="addProject">Добавить</button>
                        </div>
                    </div>
                </div>
            </div>
        ';

        for ($i = 0; $i < $count_project; $i++) {
            $j = $i+1;
            $name_get = file_get_contents('wp-content/themes/archtheme/images/project' . $j . '/name.txt', FILE_USE_INCLUDE_PATH);
            $desc_get = file_get_contents('wp-content/themes/archtheme/images/project' . $j . '/desc.txt', FILE_USE_INCLUDE_PATH);
            $type_get = file_get_contents('wp-content/themes/archtheme/images/project' . $j . '/type.txt', FILE_USE_INCLUDE_PATH);

            $dir = "wp-content/themes/archtheme/images/project".$j."/";
            $count_files = 0;
            $dir_list = scandir($dir);
            $count_files = count($dir_list);
            $mass_images = [];
            $mass_name_images = [];
            foreach ($dir_list as $key => $value) {
                if (preg_match('/\(\d+\)\./',$value) && preg_match('/\((?P<digit>\d+\))/',$value,$matches)) {
                    $mass_images[$matches['digit']] = $value;
                    $mass_name_images[] = $matches['digit'];
                }
            }
            sort($mass_images, SORT_NATURAL | SORT_FLAG_CASE);
            foreach ($mass_images as $key => $value) {
                $mass_images[$key] = 'wp-content/themes/archtheme/images/project' . $j . '/'.$value;
            }

            $edit_block .= '
                        <div class="row" style="margin-left: 0; margin-right: 0;">
                            <div class="row" style="margin-left: 0; margin-right: 0;">
                                <div class="col-sm-12">
                                    <h4 style="margin-bottom: 15px; margin-left: -16px;">' . $name_get . '</h4>
                                </div>
                            </div>
                            <div class="row" style="margin-left: 0; margin-right: 0;">
                                <form method="post" class="project-form col-sm-12">
                                    <div class="row" style="margin-left: 0; margin-right: 0;">
                                        <div class="col-sm-6">
                                            <div class="row" style="margin-left: 0; margin-right: 0;">
                                                <label for="type_project' . $j . '" class="form-control-label">Тип проекта:</label>
                                                <select id="type_project' . $j . '" data-toggle="dropdown">
                                                    ';
                                                    if ($type_get == 1) {
                                                        $edit_block .= '
                                                            <option value="1" selected>Общественный</option>
                                                            <option value="2">Жилой</option>
                                                        ';
                                                    } else if ($type_get == 2) {
                                                        $edit_block .= '
                                                            <option value="1">Общественный</option>
                                                            <option value="2" selected>Жилой</option>
                                                        ';
                                                    }
                                                    $edit_block .= '
                                                </select>
                                            </div>
                                            <div class="row" style="margin-left: 0; margin-right: 0;">
                                                <label for="name_project' . $j . '" class="form-control-label">Название проекта:</label>
                                                <input type="text" class="form-control" id="name_project' . $j . '" value="' . $name_get . '">
                                            </div>
                                            <br>
                                            <div class="row" style="margin-left: 0; margin-right: 0;">
                                                <label for="desc_project' . $j . '" class="form-control-label">Описание проекта:</label>
                                                <textarea class="form-control common" id="desc_project' . $j . '" style="min-height: 200px; padding: 15px;">' . $desc_get . '</textarea>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="row" style="margin-left: 0; margin-right: 0;">
                                                <button type="button" class="btn btn-primary" style="margin-top: 60px; margin-left: 10px;" id="save' . $j . '">Сохранить</button>
                                            </div>
                                            <div class="row" style="margin-left: 0; margin-right: 0;">
                                                <form method="post" class="col-xs-12" enctype="multipart/form-data">
                                                    <div class="row" style="margin-left: 0; margin-right: 0;">
                                                        <div class="col-xs-8">
                                                            <div class="row">
                                                                <input type="file" class="btn col-xs-12" multiple="multiple" name="picture" style="margin-top: 30px;" value="Добавить изображение">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <div class="row">
                                                                <button type="button" class="btn btn-primary col-xs-12" style="margin-top: 30px;" id="add_img' . $j . '">Загрузить</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <br>
                                            <div class="row" style="margin-left: 0; margin-right: 0;">
                                                ';
                                                foreach ($mass_images as $key => $value) {
                                                    $edit_block .= '
                                                        <a class="col-lg-3 col-md-4 col-sm-6 col-xs-6 list_img_project" data-fancybox="group" style="height: 80px;" href="'.$value.'">
                                                            <img src="'.$value.'" alt>
                                                        </a>
                                                    ';
                                                }
                                                $edit_block .= '
                                            </div>
                                        </div> 
                                    </div>
                                </form>
                            </div>
                        </div>
                        <br>
            ';
        }

        $scripts = '        
                        <style>
                            .hiddendiv  {
                               font-family: Arial, sans-serif;
                               overflow: hidden;
                               display: none;
                               white-space: pre-wrap;
                               min-height: 50px;
                               padding: 5px;
                               word-wrap: break-word;
                            }
                        </style>
                        <script>
                            $(function () {
                              var txt = $(\'#desc_project\'),
                                  hiddenDiv = $(document.createElement(\'div\')),
                                  content = null;
                            
                              txt.addClass(\'txtstuff\');
                              hiddenDiv.addClass(\'hiddendiv common\');
                            
                              $(\'body\').append(hiddenDiv);
                            
                              txt.on(\'keyup\', function () {
                            
                                content = $(this).val();
                            
                                content = content.replace(/\\n/g, \'<br>\');
                                hiddenDiv.html(content + \'<br class="lbr">\');
                            
                                $(this).css(\'height\', hiddenDiv.height());
                            
                              });
                            });
                        </script>
                        <script type="text/javascript">
                            ';
            for ($i = 0; $i < $count_project; $i++) {
            $j = $i + 1;
            $mass_save_button_ajax .= '
                            $(\'#save' . $j . '\').click(function () {
                                event.preventDefault();
                                changeProject(' . $j . ');
                            });
                            $(\'#add_img' . $j . '\').on(\'click\', function ( event ) {
                                event.stopPropagation();
                                event.preventDefault();
                                addImagesInProject(' . $j . ');
                            });
                           ';
            }
            $body_ajax = '
                            var files; 
                            $(\'input[type=file]\').on(\'change\', function(){
                                files = this.files;
                            });
                            $(\'#addProject\').on(\'click\', function () {
                                addProject();
                            });
                            
                            function addProject () {
                                var type_project = $(\'#addTypeProject\').val ();
                                var name_project = $(\'#addNameProject\').val ();
                                var desc_project = $(\'#addDescProject\').val ();
                        
                                $.ajax({
                                    url:        \'add_project.php\',
                                    type:       \'POST\',
                                    cache:      false,
                                    data:       {\'type_project\':type_project,\'name_project\':name_project, \'desc_project\':desc_project},
                                    dataType:   \'html\',
                                    success: function(data) {
                                        if (data != false) {
                                            alert(\'Проект успешно добавлен! \');
                                        } else {
                                            if (data == false) {
                                                alert ("Ошибка данных!");
                                            }
                                            else {
                                                switch (data) {
                                                    case "Ошибка данных":
                                                        alert("Ошибка данных!");
                                                        break;
                                                    default:
                                                        alert("Ошибка данных!");
                                                }
                                            }
                                        }
                                    }
                                });
                                addProjectImg();
                            }
                            function addProjectImg () {
                                if( typeof files == \'undefined\' ) return;
                            
                                var data = new FormData();
                            
                                $.each( files, function( key, value ){
                                    data.append( key, value );
                                });
                            
                                data.append( \'my_file_upload\', 1 );
                                
                                $.ajax({
                                    url:        \'add_new_project_images.php\',
                                    type:       \'POST\',
                                    cache:      false,
                                    data:       data,
                                    dataType:   \'json\',
                                    processData : false,
                                    contentType : false,
                                    success     : function( respond, status, jqXHR ){
                                        if( typeof respond.error === \'undefined\' ){
                                            var files_path = respond.files;
                                            var html = \'\';
                                            $.each( files_path, function( key, val ){
                                                 html += val +\'\';
                                            } )
                            
                                            alert( html );
                                        }
                                        else {
                                            console.dir(\'ОШИБКА: \' + respond.error );
                                        }
                                    },
                                    // функция ошибки ответа сервера
                                    error: function( jqXHR, status, errorThrown ){
                                        console.log( \'ОШИБКА AJAX запроса: \' + status, jqXHR );
                                    }
                                });
                            }
                            function changeProject (num) {
                                var name_project = $(\'#name_project\'+num).val ();
                                var desc_project = $(\'#desc_project\'+num).val ();
                                var type_project = $(\'#type_project\'+num).val ();
                        
                                $.ajax({
                                    url:    	\'save_project.php\',
                                    type:		\'POST\',
                                    cache: 		false,
                                    data:   	{\'name_project\':name_project, \'desc_project\':desc_project,\'type_project\':type_project,\'num\':num},
                                    dataType:	\'html\',
                                    success: function(data) {
                                        if (data != false) {
                                            $(\'#name_project\'+num).css ("background-color", "#60fc8c");
                                            $(\'#desc_project\'+num).css ("background-color", "#60fc8c");
                                            $(\'#type_project\'+num).css ("background-color", "#60fc8c");
                                        } else {
                                            if (data == false) {
                                                $(\'#name_project\'+num).css ("background-color", "#f7b4b4");
                                                $(\'#desc_project\'+num).css ("background-color", "#f7b4b4");
                                                $(\'#type_project\'+num).css ("background-color", "#f7b4b4");
                                                alert ("Ошибка данных!");
                                            }
                                            else {
                                                switch (data) {
                                                    case "Ошибка данных":
                                                        $(\'#name_project\'+num).css ("background-color", "#f7b4b4");
                                                        $(\'#desc_project\'+num).css ("background-color", "#f7b4b4");
                                                        $(\'#type_project\'+num).css ("background-color", "#f7b4b4");
                                                        alert("Ошибка данных!");
                                                        break;
                                                    default:
                                                        $(\'#name_project\'+num).css ("background-color", "#f7b4b4");
                                                        $(\'#desc_project\'+num).css ("background-color", "#f7b4b4");
                                                        $(\'#type_project\'+num).css ("background-color", "#f7b4b4");
                                                        alert("Ошибка данных!");
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                            function addImagesInProject (num) {
                                if( typeof files == \'undefined\' ) return;
                            
                                var data = new FormData();
                            
                                $.each( files, function( key, value ){
                                    data.append( key, value );
                                });
                            
                                data.append( \'my_file_upload\', 1 );
                                data.append( \'num_project\', num );
                                
                                $.ajax({
                                    url:    	\'add_img_in_project.php\',
                                    type:		\'POST\',
                                    cache: 		false,
                                    data:   	data,
                                    dataType:	\'json\',
                                    processData : false,
                                    contentType : false,
                                    success     : function( respond, status, jqXHR ){
                                        if( typeof respond.error === \'undefined\' ){
                                            var files_path = respond.files;
                                            var html = \'\';
                                            $.each( files_path, function( key, val ){
                                                 html += val +\'\';
                                            } )
                            
                                            alert( html );
                                        }
                                        else {
                                            console.dir(\'ОШИБКА: \' + respond.error );
                                        }
                                    },
                                    // функция ошибки ответа сервера
                                    error: function( jqXHR, status, errorThrown ){
                                        console.log( \'ОШИБКА AJAX запроса: \' + status, jqXHR );
                                    }
                                });
                            }


        ';
        $data = $add_block.$load_img.$edit_block.$scripts.$mass_save_button_ajax.$body_ajax.'</script>';
        echo $data;
    }
} else {
    $selectDB->close();
    echo "Неправильный логин или пароль";
}

?>