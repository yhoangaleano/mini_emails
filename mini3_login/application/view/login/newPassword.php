<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Variedades y Comunicaciones |
        <?php echo $title; ?>
    </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link href="<?php echo URL; ?>login_libs/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="<?php echo URL; ?>login_libs/login.css" rel="stylesheet">

</head>

<body>

    <div class="wrapper">
        <div id="formContent">
            <!-- Tabs Titles -->

            <div>
                <h4>
                    <b>Variedades</b> y comunicaciones
                </h4>
            </div>

            <!-- Icon -->
            <div>
                <img src="<?php echo URL; ?>login_libs/lock.png" id="icon" alt="User Icon" />
            </div>

            <!-- Login Form -->
            <form method="POST" action="<?php echo URL; ?>login/updatePasswordWithCode">
                <input type="hidden" id="txtIdUsuario" name="txtIdUsuario" placeholder="Código del Usuario" value="<?php echo $user->idUsuario; ?>">
                <input type="password" id="txtContrasena" name="txtContrasena" placeholder="Nueva Contraseña">
                <input type="password" id="txtRepetirContrasena" name="txtRepetirContrasena" placeholder="Repetir Contraseña">
                
                <div class="loginButton">
                    <input id="btnGuardar" name="btnGuardar" type="submit" value="Cambiar Contraseña" onclick="return comparePassword();">
                </div>
                
            </form>

            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="<?php echo URL; ?>login">Volver a iniciar sesión</a>
            </div>

        </div>
    </div>

    <script>
        var url = "<?php echo URL; ?>";

         function comparePassword(){
                var contrasena = document.getElementById('txtContrasena').value;
                var repetirContrasena = document.getElementById('txtRepetirContrasena').value;

                if(contrasena != repetirContrasena){
                    alert('Las contraseñas no coinciden.');
                    return false;
                }else{
                    return true;
                }

            }

    </script>

    <script src="<?php echo URL; ?>login_libs/jquery.min.js"></script>
    <script src="<?php echo URL; ?>login_libs/bootstrap.min.js"></script>

    <?php if(isset($mensaje)){ ?>

        <script>
            
            window.onload = function(){
                alert('<?php echo $mensaje; ?>');
            }

        </script>

    <?php } ?>

</body>

</html>