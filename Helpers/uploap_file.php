<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivos</title>
</head>
<body>
    <h2>Subir Archivo</h2>
    <form action="subir_archivo.php" method="post" enctype="multipart/form-data">
        <label for="archivo">Selecciona un archivo:</label>
        <input type="file" name="archivo" id="archivo" required>
        <input type="submit" value="Subir Archivo">
    </form>
</body>
</html>
