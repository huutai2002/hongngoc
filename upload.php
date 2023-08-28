<?php
if (isset($_POST["submit"])) {
    $targetDir = "img/"; // Thư mục lưu trữ ảnh
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

    // Kiểm tra xem tệp có phải là hình ảnh thật không
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Kiểm tra nếu tệp đã tồn tại
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Kiểm tra kích thước tệp
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Cho phép chỉ một số định dạng ảnh cụ thể (có thể thay đổi)
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Kiểm tra xem $uploadOk có bị lỗi không
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            // Lưu thông tin ảnh vào cơ sở dữ liệu
            $servername = "localhost";
            $username = "your_username";
            $password = "your_password";
            $dbname = "your_database";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $imagePath = $targetFile;
            $insertQuery = "INSERT INTO images (path) VALUES ('$imagePath')";
            
            if ($conn->query($insertQuery) === TRUE) {
                echo "Image uploaded and saved to database.";
            } else {
                echo "Error: " . $insertQuery . "<br>" . $conn->error;
            }

            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
