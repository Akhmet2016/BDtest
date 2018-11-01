<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Auth</title>
    <link rel="stylesheet" href="wp-content/themes/archtheme/css/bootstrap.css">
    <link rel="stylesheet" href="wp-content/themes/archtheme/css/superfish.css">
    <link rel="stylesheet" href="wp-content/themes/archtheme/css/style.css">
</head>
<body style="overflow: auto !important; background: white">
    <div class="wrapper">
        <div class="container">
            <div class="row" style="margin-left: 0; margin-right: 0;">
                <div class="col-sm-10">
                    <h2 style="margin-top: 12px; margin-bottom: 17px;">Админинстрирование сайта alvar-ar.com</h2>
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
                        Войти
                    </button>
                </div>
            </div>
            <div class="row" style="margin-left: 0; margin-right: 0;">
                <div class="edit-block col-sm-12" id="edit-block">

                </div>
            </div>
            <div class="modal fade bd-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Авторизация</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <form method="post" class="auth-form col-sm-12">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="login" class="form-control-label">Имя пользователя:</label>
                                            <input type="text" class="auth-form-login-input form-control" name="login" id="login" placeholder="Введите логин">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label for="password" class="form-control-label">Пароль:</label>
                                            <input type="password" class="auth-form-password-input form-control" name="password" id="password" placeholder="Введите пароль">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                            <button type="button" class="btn btn-primary" id="send">Войти</button>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="auth-div">
                <form method="post" class="auth-form">
                    <div class="auth-form-login">
                        <input type="text" class="auth-form-login-input" name="login" id="login" placeholder="Введите логин">
                    </div>
                    <div class="auth-form-password">
                        <input type="password" class="auth-form-password-input" name="password" id="password" placeholder="Введите пароль">
                    </div>
                    <div class="auth-form-password">
                        <textarea rows="4" type="textarea" class="auth-form-info-input" name="info" id="info"></textarea>
                    </div>
                    <div class="auth-form-submit">
                        <input type="submit" name="submit" class="auth-form-submit-input" id="send" value="Отправить">
                    </div>
                </form>
            </div>-->
        </div>
    </div>
    <script src="wp-content/themes/archtheme/js/jquery.min.js"></script>
    <script src="wp-content/themes/archtheme/js/fancybox-slider.js"></script>
    <script>
        $(document).ready(function () {
            $("[data-fancybox]").fancybox({
                // Options will go here
            });
        })
    </script>
    <script src="wp-content/themes/archtheme/js/jquery.min.js"></script>
    <script src="wp-content/themes/archtheme/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="wp-content/themes/archtheme/css/fancybox-style.css">
    <script src="wp-content/themes/archtheme/js/superfish.js"></script>
    <script src="wp-content/themes/archtheme/js/main.js"></script>
    <script type="text/javascript">
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').focus()
        })
        $('.dropdown-toggle').dropdown();
    </script>
    <script type="text/javascript">
        $('#send').click(function () {
            event.preventDefault();
            var login = $('#login').val ();
            var password = $('#password').val ();

            $.ajax({
                url:    	'auth_lk.php',
                type:		'POST',
                cache: 		false,
                data:   	{'login':login, 'password':password},
                dataType:	'html',
                success: function(data) {
                    if (data != false) {
                        $('#login').val ("");
                        $('#password').val ("");
                        $('#login').css ("background-color", "#60fc8c");
                        $('#password').css ("background-color", "#60fc8c");
                        $('#edit-block').html(data);
                        $('#myModal').hide();
                        $('.modal-backdrop').hide();
                    } else {
                        if (data == false) {
                            $('#login').css ("background-color", "#f7b4b4");
                            $('#password').css ("background-color", "#f7b4b4");
                            alert ("Неправильный логин или пароль!");
                        }
                        else {
                            switch (data) {
                                case "Заполните все поля":
                                    $('#login').css ("background-color", "#f7b4b4");
                                    $('#password').css ("background-color", "#f7b4b4");
                                    alert("Заполните все поля!");
                                    break;
                                case "Неправильный логин или пароль":
                                    $('#login').css ("background-color", "#f7b4b4");
                                    $('#password').css ("background-color", "#f7b4b4");
                                    alert("Неправильный логин или пароль!");
                                    break;
                                default:
                                    $('#login').css ("background-color", "#f7b4b4");
                                    $('#password').css ("background-color", "#f7b4b4");
                                    alert("Ошибка данных!");
                            }
                        }
                    }

                }
            });
        });
    </script>
</body>
</html>