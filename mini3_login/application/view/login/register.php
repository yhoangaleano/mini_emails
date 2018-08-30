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

            <!-- Login Form -->
            <form method="POST" action="<?php echo URL; ?>login/saveUser">
                <input type="text" id="txtUsuario" name="txtUsuario" placeholder="Usuario">
                <input type="password" id="txtContrasena" name="txtContrasena" placeholder="Contraseña">
                <input type="text" id="txtNombreCompleto" name="txtNombreCompleto" placeholder="Nombre Completo">
                <input type="email" id="txtCorreoElectronico" name="txtCorreoElectronico" placeholder="Correo Electrónico">
    
                <div class="loginButton">
                    <input id="btnGuardar" name="btnGuardar" type="submit" value="Guardar Usuario">
                </div>
                
            </form>

            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="<?php echo URL; ?>login">Ir a iniciar sesión</a>
            </div>

        </div>
    </div>

    <script>
        var url = "<?php echo URL; ?>";
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