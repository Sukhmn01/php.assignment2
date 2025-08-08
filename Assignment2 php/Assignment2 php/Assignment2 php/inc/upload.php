<?php
function uploadImage($field) {
    if (isset($_FILES[$field]) && $_FILES[$field]['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array(strtolower($ext), $allowed)) {
            return ['error' => 'Invalid image format.'];
        }

        $target = 'uploads/' . uniqid() . '.' . $ext;
        if (move_uploaded_file($_FILES[$field]['tmp_name'], $target)) {
            return ['path' => $target];
        } else {
            return ['error' => 'Image upload failed.'];
        }
    }
    return ['path' => null];
}
