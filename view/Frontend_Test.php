
<?php
if (!is_dir('uploads')) {
    mkdir('uploads', 0777, true);
}

foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
    $filename = basename($_FILES['files']['name'][$key]);
    $target = "uploads/" . $filename;
    move_uploaded_file($tmp_name, $target);
}
echo "Upload Successful";
?>

<?php
$files = array_values(array_diff(scandir("uploads"), array('.', '..')));
echo json_encode($files);
?>

<?php
if (isset($_GET['file'])) {
    $file = "uploads/" . basename($_GET['file']);
    if (file_exists($file)) {
        unlink($file);
        echo "Deleted Successfully";
    } else {
        echo "File not found!";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Folder Explorer</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        .container { max-width: 600px; margin: 20px auto; }
        .upload-box { padding: 10px; border: 2px dashed #ccc; margin-bottom: 20px; }
        .gallery { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; }
        .img-box { position: relative; width: 100px; height: 100px; border: 1px solid #ddd; cursor: pointer; }
        .img-box img { width: 100%; height: 100%; object-fit: cover; }
        .delete-btn { position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; cursor: pointer; }
        .preview-modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); justify-content: center; align-items: center; }
        .preview-modal img { max-width: 80%; max-height: 80%; }
    </style>
</head>
<body>

<div class="container">
    <h2>Interactive Folder Explorer</h2>

    <!-- Upload Form -->
    <div class="upload-box">
        <input type="file" id="fileInput" multiple>
        <button onclick="uploadFiles()">Upload</button>
    </div>

    <!-- Gallery Display -->
    <div class="gallery" id="gallery"></div>
</div>

<!-- Image Preview Modal -->
<div class="preview-modal" id="previewModal" onclick="this.style.display='none'">
    <img id="previewImage">
</div>

<script>
    function fetchFiles() {
        fetch('./Frontend_Test.php')
            .then(response => response.json())
            .then(data => {
                let gallery = document.getElementById("gallery");
                gallery.innerHTML = "";
                data.forEach(file => {
                    let div = document.createElement("div");
                    div.className = "img-box";
                    div.innerHTML = `<img src="uploads/${file}" onclick="previewImage('uploads/${file}')">
                                    <button class="delete-btn" onclick="deleteFile('${file}')">X</button>`;
                    gallery.appendChild(div);
                });
            });
    }

    function uploadFiles() {
        let files = document.getElementById("fileInput").files;
        let formData = new FormData();
        for (let i = 0; i < files.length; i++) {
            formData.append("files[]", files[i]);
        }

        fetch("./Frontend_Test.php", { method: "POST", body: formData })
            .then(response => response.text())
            .then(() => { fetchFiles(); });
    }

    function deleteFile(filename) {
        fetch("delete.php?file=" + filename, { method: "GET" })
            .then(response => response.text())
            .then(() => { fetchFiles(); });
    }

    function previewImage(src) {
        document.getElementById("previewImage").src = src;
        document.getElementById("previewModal").style.display = "flex";
    }

    window.onload = fetchFiles;
</script>

</body>
</html>

