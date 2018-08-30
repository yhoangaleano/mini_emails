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
                <img src="<?php echo URL; ?>login_libs/email.png" id="icon" alt="User Icon" />
            </div>

            <!-- Login Form -->
            <form method="POST" action="<?php echo URL; ?>login/sendRecoveryCode">
                <input type="email" id="txtCorreoElectronico" name="txtCorreoElectronico" placeholder="Correo Electrónico">
                
                <div class="loginButton">
                    <input type="submit" value="Enviar Contraseña">
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