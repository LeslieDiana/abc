<?php
// empty=si no existe o si esta vacío
if (!empty($_POST)) { // Si EXISTE la variable POST; Donde $_POST = significa 
    $alert = '';    // variable vacia
    if (empty($_POST['nombre']) || empty($_POST['apePaterno']) || empty($_POST['apeMaterno']) || empty($_POST['correo']) || empty($_POST['clave']) ||  empty($_POST['rol'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else { // de lo contrario nos conectamos a la base de datos

        $nombre = $_POST['nombre'];
        $apPaterno = $_POST['apePaterno'];
        $apMaterno = $_POST['apeMaterno'];
        $email  = $_POST['correo'];
        $clave  = md5($_POST['clave']);
        $rol    = $_POST['rol'];

        $conection = mysqli_connect("localhost", "root", "", "inmuebless");
        $query = mysqli_query($conection, "SELECT * FROM cliente WHERE nombre = '$nombre' OR correo = '$email' ");
        $result = mysqli_fetch_array($query);

        if ($result > 1) {
            $alert = '<p class="msg_error">El correo o el usuario ya existe.</p>';
        } else {

            $query_insert = mysqli_query($conection, "INSERT INTO cliente(nombre,apePaterno,apeMaterno,correo,clave,rol)
																	VALUES('$nombre','$apPaterno','$apMaterno','$email','$clave','$rol')");

            if ($query_insert) {
                $alert = '<p class="msg_save">Usuario creado correctamente.</p>';
            } else {
                $alert = '<p class="msg_error">Error al crear el usuario.</p>';
            }
        }
    }
}

?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAPI - ADMIN</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <?php include("header.php"); ?>

    <div id="contenedor-admin">
        <?php include("contenedor-menu.php"); ?>

        <div class="contenedor-principal">
            <div id="nuevo-usuario">
                <section id="container">

                    <div class="form_register">
                        <h1>Registro Personal</h1>
                        <hr>
                        <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

                        <form action="" method="post">
                            <label for="nombre">Nombre <span class="required">*</span></label>
                            <input type="text" name="nombre" id="nombre" placeholder="Nombres">

                            <label for="apePaterno">Apellido Paterno <span class="required">*</span></label>
                            <input type="text" name="apePaterno" id="apePaterno" placeholder="Apellido Paterno">

                            <label for="apeMaterno">Apellido Materno <span class="required">*</span></label>
                            <input type="text" name="apeMaterno" id="apeMaterno" placeholder="Apellido Materno">

                            <label for="correo">Correo electrónico <span class="required">*</span></label>
                            <input type="email" name="correo" id="correo" placeholder="Correo electrónico">

                            <label for="clave">Clave <span class="required">*</span></label>
                            <input type="password" name="clave" id="clave" placeholder="Clave de acceso">

                            <label for="rol">Tipo Usuario</label>

                            <?php
                            $conection = mysqli_connect("localhost", "root", "", "inmuebless");
                            $query_rol = mysqli_query($conection, "SELECT * FROM rol WHERE id_rol =3");
                            mysqli_close($conection);
                            $result_rol = mysqli_num_rows($query_rol);

                            ?>

                            <select class="label1" name="rol" id="rol">
                                <?php
                                if ($result_rol > 0) {
                                    while ($rol = mysqli_fetch_array($query_rol)) {
                                ?>
                                        <option value="<?php echo $rol["id_rol"]; ?>"><?php echo $rol["rol"] ?></option>
                                <?php
                                        # code...
                                    }
                                }
                                ?>
                            </select>

                            <input type="submit" value="Crear Cliente" class="btn_save">
                        </form>
                    </div>
                </section>

            </div>
        </div>
    </div>
</body>

<script>
    $('#link-nuevo-cliente').addClass('pagina-activa');
</script>

</html>