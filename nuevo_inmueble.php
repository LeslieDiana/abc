<?php
if (!empty($_POST)) {
    $alert = '';
    if (empty($_POST['titulo']) || empty($_POST['descripcion']) || empty($_POST['tipoinmueble']) || empty($_POST['ubicacion']) || empty($_POST['habitaciones']) || empty($_POST['banios']) || empty($_POST['pisos']) || empty($_POST['garage']) || empty($_POST['dimensiones']) || empty($_POST['precio']) || empty($_POST['nombre_propietario']) || empty($_POST['telefono_propietario'])) { {
            $alert = '<p class="msg_error">Todos los campos son obligatorios.</p>';
        }
    } else {

        $titulo = $_POST['titulo'];
        $descripcion = $_POST['descripcion'];
        $tipo = $_POST['tipoinmueble'];
        $ubicacion = $_POST['ubicacion'];
        $habitaciones = $_POST['habitaciones'];
        $banios = $_POST['banios'];
        $pisos = $_POST['pisos'];
        $garage = $_POST['garage'];
        $dimensiones = $_POST['dimensiones'];
        $precio = $_POST['precio'];
        $foto_p =  $_FILES['foto_principal']['tmp_name'];

        $foto_principal = addslashes(file_get_contents($foto_p));

        $propietario = $_POST['nombre_propietario'];
        $telefono_propietario = $_POST['telefono_propietario'];

        $conection = mysqli_connect("localhost", "root", "", "inmuebless");
        $query = mysqli_query($conection, "SELECT * FROM inmueble WHERE titulo = '$titulo' OR descripcion = '$descripcion' ;");
        $result = mysqli_fetch_array($query);

        if ($result > 1) {
            $alert = '<p class="msg_error">El inmueble ya existe. </p>';
        } else {

            $query_insert = mysqli_query($conection, "INSERT INTO inmueble(titulo,fecha_alta, descripcion, tipoinmueble, ubicacion, habitaciones, banios, pisos, garage, dimensiones, precio, foto_principal, propietario, telefono_propietario)
																	VALUES('$titulo',CURRENT_TIMESTAMP, '$descripcion', '$tipo', '$ubicacion', '$habitaciones', '$banios', '$pisos', '$garage', '$dimensiones', '$precio', '$foto_principal',  '$propietario', '$telefono_propietario');");

            if ($query_insert) {
                $alert = '<p class="msg_save">Inmueble añadido correctamente.</p>';
            } else {
                $alert = '<p class="msg_error">Error al añadir inmueble.</p>';
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
            <div id="nueva-propiedad">
                <h2>Nuevo Inmueble</h2>
                <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
                <hr>

                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" method="POST">
                    <div class="fila-una-columna">
                        <label for="titulo">Título de la Propiedad</label>
                        <input type="text" name="titulo" required class="input-entrada-texto">
                    </div>

                    <div class="fila-una-colummna">
                        <label for="descripcion">Descripción de la Propiedad</label>
                        <textarea name="descripcion" id="" cols="30" rows="10" class="input-entrada-texto"></textarea>
                    </div>
                    <div class="fila">
                        <div class="box">
                            <label for="tipoinmueble">Selecione el tipo de inmueble</label>
                            <select name="tipoinmueble" id="tipoinmueble" class="input-entrada-texto">
                                <?php
                                include("conexion.php");
                                $query = "SELECT * FROM tipoinmueble";
                                $resultado_tipos = mysqli_query($conn, $query);
                                ?>
                                <?php while ($row = mysqli_fetch_assoc($resultado_tipos)) : ?>
                                    <option value="<?php echo $row['id_tipoInmueble'] ?>">
                                        <?php echo $row['tipo'] ?>
                                    </option>
                                <?php endwhile ?>
                            </select>
                        </div>
                        <div class="box">
                            <label for="ubicacion">Ubicación</label>
                            <input type="text" name="ubicacion" class="input-entrada-texto">
                        </div>
                    </div>
                    <h2>Detalles de la casa </h2>
                    <div class="fila">

                        <div class="box">
                            <label for="habitaciones">Habitaciones</label>
                            <input type="text" name="habitaciones" class="input-entrada-texto">
                        </div>

                        <div class="box">
                            <label for="baños">Baños</label>
                            <input type="text" name="banios" class="input-entrada-texto">
                        </div>

                        <div class="box">
                            <label for="pisos">Pisos</label>
                            <input type="text" name="pisos" class="input-entrada-texto">
                        </div>
                        <div class="box">
                            <label for="garage">Garage</label>
                            <input type="text" name="garage" class="input-entrada-texto">
                        </div>
                    </div>
                    <h2> ..</h2>
                    <div class="fila">
                        <div class="box">
                            <label for="dimensiones">Dimensiones</label>
                            <input type="text" name="dimensiones" class="input-entrada-texto">
                        </div>
                        <div class="box">
                            <label for="precio">Precio (Alquiler o Venta)</label>
                            <input type="text" name="precio" class="input-entrada-texto" required>
                        </div>
                    </div>
                    <div>
                        <h2>Galeria de fotos</h2>
                        <label for="foto1" class="btn-fotos"> Foto Principal</label>
                        <output id="list" class="contenedor-foto-principal">
                            <img src="<?php echo $foto['foto_principal'] ?>" alt="">
                        </output>
                        <input type="file" id="foto1" accept="image/*" name="foto_principal" style="display:none">
                        <input type="submit" value="Agregar más imágenes" name="agreimagenes" class="btn-accion">
                    </div>
                    <h2>Ubicación y datos del Propietario</h2>
                    <div class="fila">
                        <div class="box">
                            <label for="propietario">Nombre del propietario</label>
                            <input type="text" name="nombre_propietario" class="input-entrada-texto">
                        </div>

                    </div>
                    <div class="fila">
                        <div class="box">
                            <label for="telefono_propietario">Teléfono del propietario</label>
                            <input type="text" name="telefono_propietario" class="input-entrada-texto">
                        </div>
                    </div>
                    <hr>
                    <input type="submit" value="Agregar Propiedad" name="agregar" class="btn-accion">

                </form>

            </div>
        </div>

        <script>
            $('#link-add-propiedad').addClass('pagina-activa');
        </script>

        <script src="subirfoto.js"></script>
        <script src="scriptFotos.js"></script>
</body>

</html>