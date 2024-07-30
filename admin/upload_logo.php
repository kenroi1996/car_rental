<?php
if (isset($_POST['submit'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["logo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["logo"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size (optional)
    if ($_FILES["logo"]["size"] > 500000) { // 500KB limit
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // if everything is ok, try to upload file
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["logo"]["name"])) . " has been uploaded.";

            // Save the file path in a database or a configuration file
            // For demonstration, we'll use a configuration file

            // Open the config file to update the logo path
            $config_file = 'config.php';
            $new_logo_path = "<?php\n\$logo_path = '" . $target_file . "';\n";
            file_put_contents($config_file, $new_logo_path);
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
