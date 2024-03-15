<?php include("controladores.php"); ?>

<!doctype html>
<html lang="en">

<head>
    <title>Aplicación TODO LIST </title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>

<body>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header,
        footer {
            background-color: #007bff;
            color: white;
            padding: 10px 0;
            text-align: center;
        }

        main {
            padding: 20px;
        }

        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }

        .form-control {
            border-radius: 4px;
        }

        .list-group-item {
            padding: 15px;
            border-bottom: 1px solid #ccc;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        .my-modal {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            max-width: 600px;
        }

        .modal-header {
            padding-bottom: 10px;
            border-bottom: 1px solid #ccc;
        }

        .modal-title {
            margin: 0;
        }

        .modal-body {
            padding: 10px 0;
        }

        .modal-footer {
            padding-top: 10px;
            border-top: 1px solid #ccc;
            text-align: right;
        }

        #btn_reiniciar_filtro {
            width: auto;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: 600;
            border-radius: 5px;
            background-color: brown;
            color: white;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #btn_reiniciar_filtro:hover {
            background-color: red;
        }

        .header {
            font-weight: 600;
            color: red;
            border: none;
        }
    </style>


    <header>
        <h4 class="text-center">ToDo<span class="header">List</span></h4>
    </header>
    <main class="container">
        <br>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">Buscar tarea por nombre:</div>
                    <input type="text" class="form-control mt-2" name="buscar_tarea" id="buscar_tarea" placeholder="Buscar tarea por nombre...">
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">Buscar tarea por fecha:</div>
                    <input type="date" class="form-control mt-2" name="fecha_busqueda" id="fecha_busqueda" placeholder="Buscar tarea por fecha">
                    <input type="button" class="btn btn-primary btn-sm" id="btn_reiniciar_filtro" value="Reiniciar filtro">
                </div>
            </div>
        </div>
        <br>

        <div class="card">
            <div class="card-header">
                Tareas pendientes
            </div>
            <div class="card-body">

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="tarea" class="form-label ">Tarea:</label>
                        <input type="text" class="form-control" name="tarea" id="tarea" aria-describedby="helpId" placeholder="Escriba su tarea" required>
                        <br />
                        <input name="agregar_tarea" id="agregar_tarea" class="btn btn-primary" type="submit" value="Agregar tarea">
                        <!-- barra de búsqueda de tareas-->

                    </div>
                </form>
            </div>

            <ul class="list-group">
                <?php foreach ($registros_pendientes as $registro) { ?>
                    <li class="list-group-item" data-fecha="<?php echo substr($registro['fecha_entrada'], 0, 10); ?>">
                        <form action="" method="post">
                            <input type="hidden" name="id" id="id" value="<?php echo $registro['id']; ?>">

                            <!-- Marcar tarea como completada cambiando la columna de "completado" de 0 a 1-->
                            &nbsp; <button class="btn btn-success btn-sm" type="submit" name="completado" value="<?php echo $registro['id']; ?>" onclick="return confirm('¿Seguro que quieres marcar esta tarea como confirmada?')">
                                Hecho</button>
                            &nbsp; <span class="float-start ">&nbsp; <?php echo $registro['tarea']; ?></span>
                            <span class="float-end">&nbsp; <?php echo $registro['fecha_entrada']; ?></span>

                            <!-- Botón para abrir el formulario flotante de modificación -->
                            <input type="hidden" name="id_modificar" id="id_modificar">
                            &nbsp; <button type="button" class="btn btn-warning btn-sm" onclick="openModal('<?php echo $registro['id']; ?>', '<?php echo $registro['tarea']; ?>')">Editar</button>


                            <!-- dar funcionalidad al botón de eliminar-->
                            &nbsp; <button type="submit" name="eliminar_tarea" value="<?php echo $registro['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar esta tarea?')">Eliminar</button>
                        </form>
                    </li>
                <?php } ?>
            </ul>

        </div>
        <br>

        <div class="card">
            <div class="card-header">
                Tareas completadas
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <?php foreach ($registros_completados as $registro) { ?>
                        <li class="list-group-item <?php if ($registro['completado']) echo 'completado'; ?>" data-fecha="<?php echo substr($registro['fecha_entrada'], 0, 10); ?>">
                            <span>&nbsp; <?php echo $registro['tarea']; ?></span>
                            <span class="float-end">&nbsp; Entrada Pendiente: <?php echo $registro['fecha_entrada']; ?></span> <br>
                            <span class="float-end text-muted">&nbsp; Entrada completada: <?php echo date('Y-m-d H:i:s'); ?></span>
                            <form action="" method="post">
                                &nbsp; <button type="submit" name="eliminar_tarea" value="<?php echo $registro['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que quieres eliminar esta tarea?')">X</butoon>
                            </form>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <!-- Formulario flotante para modificar tarea -->
        <div class="modal" id="modal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Tarea</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form_editar_tarea" action="controladores.php" method="post">
                            <div class="mb-3">
                                <label for="tarea_modificada" class="form-label">Tarea:</label>
                                <input type="text" class="form-control" name="tarea_modificada" id="tarea_modificada" aria-describedby="helpId" placeholder="Escriba su tarea" required>
                                <input type="hidden" name="id_modificar" id="id_modificar_hidden">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <br>
    </main>
    <footer>
        <h4 class="text-center">ToDo<span class="header">List</span></h4>
    </footer>
    <!-- Bootstrap JavaScript Libraries -->



    <script>
        // Función para modificar una tarea

        function openModal(id, tarea) {
            console.log(tarea);
            document.getElementById('id_modificar_hidden').value = id;
            document.getElementById('tarea_modificada').value = tarea;
            var myModal = new bootstrap.Modal(document.getElementById('modal'));
            myModal.show();
        }

        //Implementación de la barra de búsqueda por nombre

        const inputBusqueda = document.getElementById('buscar_tarea');
        const listaTareas = document.getElementsByClassName('list-group-item');

        inputBusqueda.addEventListener('keyup', (event) => {
            const textoBusqueda = event.target.value.toLowerCase();
            for (const tarea of listaTareas) {
                const nombreTarea = tarea.textContent.toLowerCase();
                if (nombreTarea.includes(textoBusqueda)) {
                    tarea.style.display = 'block';
                } else {
                    tarea.style.display = 'none';
                }
            }
        });

        //implementación de la barra de búsqueda por fecha
        const inputFecha = document.getElementById('fecha_busqueda');

        inputFecha.addEventListener('change', (event) => {
            const fechaSeleccionada = event.target.value;
            for (const tarea of listaTareas) {
                const fechaTarea = tarea.dataset.fecha;
                const esCompletado = tarea.classList.contains('completado');
                if (fechaTarea === fechaSeleccionada && esCompletado) {
                    tarea.style.display = 'block';
                } else {
                    tarea.style.display = 'none';
                }
            }
        });


        // Evento para restaurar la visibilidad de todas las tareas cuando se borra el valor del campo de fecha
        const btnReiniciarFiltro = document.getElementById('btn_reiniciar_filtro');

        btnReiniciarFiltro.addEventListener('click', () => {
            location.reload(); // Recarga la página actual
        });
    </script>

</body>

</html>