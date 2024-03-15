<?php

/* require_once("pdoconfig.php"); */

try {
    $conn = new PDO('mysql:host=localhost;dbname=php', 'fcastro', '08431433');
} catch (PDOException $pe) {
    die("ERROR: no se ha podido conectar a la BD " . $pe->getMessage());
}

//Agregar nueva tarea
if (isset($_POST['agregar_tarea'])) {
    $tarea = $_POST['tarea'];
    $sql = "INSERT INTO tareas (tarea) VALUES ('$tarea')";
    $sentencia = $conn->prepare($sql);
    $sentencia->execute();
    header('Location: index.php'); //redirige a index
}

// Eliminar tarea
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['eliminar_tarea'])) {
        //eliminar tarea como existente
        $id_tarea_a_eliminar = $_POST['eliminar_tarea'];
        $sql = "DELETE FROM tareas WHERE id = :id";
        $sentencia = $conn->prepare($sql);
        $sentencia->bindParam(':id', $id_tarea_a_eliminar);
        $sentencia->execute();
        // Redirigir a index.php después de eliminar la tarea
        header("Location: index.php");
        exit(); // Detener la ejecución del script después de la redirección

    }
    //Marcar tarea como completada
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $completado = ($_POST['completado']) ? 1 : 0;
        $sql = "UPDATE tareas SET completado=? WHERE id =?";
        $sentencia = $conn->prepare($sql);
        $sentencia->execute([$completado, $id]);
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
    // Modificar tarea en el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['id_modificar']) && isset($_POST['tarea_modificada'])) {
            $id = $_POST['id_modificar'];
            $tarea = $_POST['tarea_modificada'];
            $sql = "UPDATE tareas SET tarea=? WHERE id =?";
            $sentencia = $conn->prepare($sql);
            if ($sentencia->execute([$tarea, $id])) {
                echo "Tarea modificada correctamente";
            } else {
                echo "Error al modificar la tarea";
            };
            // Redirigir a la página principal después de modificar la tarea
            header("Location: index.php?actualizado=true");
            exit();
        }
    }
}




$sql = "SELECT * FROM tareas";
$registros = $conn->query($sql);

$sql = "SELECT * FROM tareas WHERE completado = 0";
$registros_pendientes = $conn->query($sql);


$sql = "SELECT * FROM tareas WHERE completado = 1";
$registros_completados = $conn->query($sql);
