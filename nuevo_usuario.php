<?php
if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['nombre']) || empty($_POST['apPaterno']) || empty($_POST['apMaterno']) || empty($_POST['direccion']) || empty($_POST['rol']) || empty($_POST['correo']) || empty($_POST['telefono']) || empty($_POST['clave'])) {
        $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
    } else {

        $nombre = $_POST['nombre'];
        $apPaterno = $_POST['apPaterno'];
        $apMaterno = $_POST['apMaterno'];
        $direccion = $_POST['direccion'];
        $rol    = $_POST['rol'];
        $email  = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $clave  = md5($_POST['clave']);
        $conection = mysqli_connect("localhost", "root", "", "inmuebless");
        $query = mysqli_query($conection, "SELECT * FROM usuario WHERE nombre = '$nombre' OR correo = '$email' ");
        $result = mysqli_fetch_array($query);

        if ($result > 1) {
            $alert = '<p class="msg_error">El correo o el usuario ya existe.</p>';
        } else {

            $query_insert = mysqli_query($conection, "INSERT INTO usuario(nombre,apPaterno,apMaterno,direccion,rol,telefono,correo,clave)
																	VALUES('$nombre','$apPaterno','$apMaterno','$direccion','$rol','$email','$telefono','$clave')");

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
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" placeholder="Nombres">

                            <label for="apPaterno">Apellido Paterno</label>
                            <input type="text" name="apPaterno" id="apPaterno" placeholder="Apellido Paterno">

                            <label for="apMaterno">Apellido Materno</label>
                            <input type="text" name="apMaterno" id="apMaterno" placeholder="Apellido Materno">

                            <label for="direccion">Direccion</label>
                            <input type="text" name="direccion" id="direccion" placeholder="Direccion">

                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" id="telefono" placeholder="Teléfono">


                            <label for="rol">Tipo Usuario</label>

                            <?php
                            $conection = mysqli_connect("localhost", "root", "", "inmuebless");
                            $query_rol = mysqli_query($conection, "SELECT * FROM rol");
                            mysqli_close($conection);
                            $result_rol = mysqli_num_rows($query_rol);

                            ?>

                            <select name="rol" id="rol">
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

                            <label for="correo">Correo electrónico</label>
                            <input type="email" name="correo" id="correo" placeholder="Correo electrónico">
                            <label for="clave">Clave</label>
                            <input type="password" name="clave" id="clave" placeholder="Clave de acceso">
                            <input type="submit" value="Crear usuario" class="btn_save">
                        </form>
                    </div>
                </section>
                </form>

            </div>
        </div>
    </div>
</body>

<script>
    $('#link-nuevo-usuario').addClass('pagina-activa');
</script>

</html>