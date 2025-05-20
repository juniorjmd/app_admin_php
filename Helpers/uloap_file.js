document.getElementById('uploadForm').addEventListener('submit', function(event) {
    event.preventDefault();

    var fileInput = document.getElementById('fileInput');
    var file = fileInput.files[0];
    var formData = new FormData();
    formData.append('file', file);
    formData.append('action', 'upload_file'); // Acción de AJAX

    var xhr = new XMLHttpRequest();
    xhr.open('POST', ajaxurl, true); // `ajaxurl` es una variable global en WordPress para la URL de admin-ajax.php

    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('uploadStatus').innerHTML = '<p>Archivo subido con éxito.</p>';
        } else {
            document.getElementById('uploadStatus').innerHTML = '<p>Ocurrió un error al subir el archivo.</p>';
        }
    };

    xhr.send(formData);
});

