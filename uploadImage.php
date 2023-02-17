<?php

function uploadImage($image)
{
    $filename = $image['name'];
    $valid_ext = array('png', 'jpeg', 'jpg');
    $photoExt1 = explode('.', $filename);
    $photoExt2 = strtolower($photoExt1[1]);

    $newFileName = $photoExt1[0] . time() . '.' . $photoExt2;

    $location = '../upload/' . $newFileName;
    $img_loc = 'upload/' . $newFileName;

    $file_type = pathinfo($location, PATHINFO_EXTENSION);
    $file_ext = strtolower($file_type);
    if (in_array($file_ext, $valid_ext)) {
        $compressed = move_uploaded_file($image['tmp_name'], $location);
        if ($compressed) {
            $resp = [
                'success' => true,
                'message' => ['Image uploaded successfully'],
                'data' => $img_loc
            ];
            return $resp;
        } else {
            $resp = [
                'success' => false,
                'message' => ['Image not uploaded'],
                'data' => null
            ];
            return $resp;
        }
    } else {
        $resp = [
            'success' => false,
            'message' => ['Invalid image format'],
            'data' => null
        ];
        return $resp;
    }
}

function compress_image($src, $dest, $quality)
{
    $info = getimagesize($src);

    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($src);
    } elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($src);
    } elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($src);
    } else {
        die('Unknown image file format');
    }
    //compress and save file to jpg
    imagejpeg($image, $dest, $quality);

    //return destination file
    return true;
}
