<?php
function uploadImage($field) {
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($ext), $allowed)) {
            return ['error' => 'Invalid image format.'];
        }

        // Ensure uploads folder ends with slash
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true); // create folder if missing
        }

        $target = $uploadDir . uniqid() . '.' . $ext;
        if (move_uploaded_file($_FILES[$field]['tmp_name'], $target)) {
            error_log("Image uploaded successfully to $target");
            return ['path' => $target];
        } else {
            error_log("Failed to move uploaded file for field $field");
            return ['error' => 'Image upload failed.'];
        }
    }
    return ['path' => null];
}
