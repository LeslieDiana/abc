<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="estilo.css">
    <title>SAWPI - Admin</title>
</head>

<body>
    <?php include("header.php"); ?>

    <div id="contenedor-admin">
        <?php include("contenedor-menu.php"); ?>

        <div class="contenedor-principal">
            <div id="lista-usuario">
                <h2>Listado del Clientes</h2>
                <hr>
                <div class="contenedor-tabla">
                    <form action="buscar_cliente.php" method="get" class="form_search">
                        <input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
                        <input type="submit" value="Buscar" class="btn_search">
                    </form>

                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                        <?php
                        $conection = mysqli_connect("localhost", "root", "", "inmuebless");
                        $query = mysqli_query($conection, "SELECT cliente.id_cliente, cliente.nombre, cliente.apePaterno, cliente.apeMaterno, cliente.correo, rol.rol FROM cliente cliente INNER JOIN rol rol ON cliente.rol = rol.id_rol WHERE estatus = 1");
                        mysqli_close($conection);

                        $result = mysqli_num_rows($query);
                        if ($result > 0) {
                                $i=0;
                            while ($data = mysqli_fetch_array($query)) {
                                $i=$i+1;

                        ?>
                                <tr>
                                    <td><?php  echo $i ?></td>
                                    <td><?php echo $data["nombre"]; ?></td>
                                    <td><?php echo $data["apePaterno"]; ?></td>
                                    <td><?php echo $data["apeMaterno"]; ?></td>
                                    <td><?php echo $data["correo"]; ?></td>
                                    <td><?php echo $data['rol'] ?></td>
                                    <td>
                                        <a class="link_edit" href="editar_cliente.php?id=<?php echo $data["id_cliente"]; ?>">Editar</a>

                                        <?php if ($data["id_cliente"] != 1) { ?>
                                            |
                                            <a class="link_delete" href="eliminar_confirmar_cliente.php?id=<?php echo $data["id_cliente"]; ?>">Eliminar</a>
                                        <?php } ?>

                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>
                </section>
            </div>
        </div>
        <script>
            $('#link-listado-cliente').addClass('pagina-activa');
        </script>

        <script src="script.js"></script>
</body>