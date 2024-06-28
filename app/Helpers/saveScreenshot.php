<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_FILES['screenshot'])
        && $_FILES['screenshot']['error'] === UPLOAD_ERR_OK
        && isset($_POST['filename'])) {

        // Obtener información del archivo
        $fileTmpPath = $_FILES['screenshot']['tmp_name'];
        $fileName = $_FILES['screenshot']['name'];
        $fileSize = $_FILES['screenshot']['size'];
        $fileType = $_FILES['screenshot']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Establecer el nuevo nombre del archivo
        var_dump($_POST['filename']);
        $newFileName = $_POST['filename'];

        // Directorio donde se guardará el archivo
        $currentDir = __DIR__;
        $uploadFileDir = str_replace('app\Helpers', 'storage\app\captures\\', $currentDir);
        $dest_path = $uploadFileDir . $newFileName;

        // Crear el directorio si no existe
        if (!file_exists($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        // Mover el archivo al directorio
        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            echo 'Archivo guardado exitosamente como ' . $newFileName;
        } else {
            echo 'Error al mover el archivo.';
        }
    } else {
        echo 'No se recibió ningún archivo o hubo un error al subirlo.';
    }
} else {
    echo 'Método de solicitud no permitido.';
}
