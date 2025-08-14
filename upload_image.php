<?php
include 'error_log.php';

$uploadDir = './assets/images/profiles/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tmpPath = $_FILES['image']['tmp_name'];
    $fileType = mime_content_type($tmpPath);

    if (strpos($fileType, 'image/') === 0) {
        session_start();
        $id = $_SESSION['idUser'];
        $newFileName = $id . '.png';
        $destPath = $uploadDir . $newFileName;

        $image = false;

        if (in_array($fileType, ['image/jpeg', 'image/jpg'])) {
            $image = imagecreatefromjpeg($tmpPath);

            // Corregir orientación usando EXIF
            if (function_exists('exif_read_data')) {
                $exif = @exif_read_data($tmpPath);
                if (!empty($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $image = imagerotate($image, 180, 0);
                            break;
                        case 6:
                            $image = imagerotate($image, -90, 0);
                            break;
                        case 8:
                            $image = imagerotate($image, 90, 0);
                            break;
                    }
                }
            }
        } elseif ($fileType == 'image/png') {
            $image = imagecreatefrompng($tmpPath);
        } elseif ($fileType == 'image/gif') {
            $image = imagecreatefromgif($tmpPath);
        } elseif ($fileType == 'image/webp') {
            $image = imagecreatefromwebp($tmpPath);
        } elseif ($fileType == 'image/heic' || $fileType == 'image/heif') {
            if (class_exists('Imagick')) {
                try {
                    $imagick = new Imagick();
                    $imagick->readImage($tmpPath);
                    $imagick->setImageOrientation(imagick::ORIENTATION_TOPLEFT); // Resetea orientación
                    $imagick->setImageFormat('png');
                    $imagick->writeImage($destPath);
                    echo json_encode(["status" => "success"]);
                    exit;
                } catch (Exception $e) {
                    echo json_encode(["status" => "fail1", "error" => $e->getMessage()]);
                    exit;
                }
            } else {
                echo json_encode(["status" => "fail2", "error" => "Imagick no disponible para HEIC."]);
                exit;
            }
        }

        if ($image !== false) {
            if (imagepng($image, $destPath, 6)) {
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "fail3"]);
            }
            imagedestroy($image);
        } else {
            echo json_encode(["status" => "fail4"]);
        }
    } else {
        echo json_encode(["status" => "fail5"]);
    }
} else {
    echo json_encode(["status" => "fail6"]);
}
?>
