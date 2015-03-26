<?php

$target_path = "img/Pmovie/";

$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 

if ($_FILES['uploadedfile']['error'] !== UPLOAD_ERR_OK) {
   die("Uppladdningen misslyckades: " . $_FILES['uploadedfile']['error']);
}
$info = getimagesize($_FILES['uploadedfile']['tmp_name']);
if ($info === FALSE) {
   die("Unable to determine image type of uploaded file");
}
if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
   die("The file is not gif/jpeg/png, and is therefor not allowed.");
}
elseif(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
    echo "Filen ".  basename( $_FILES['uploadedfile']['name']). 
    " har laddats upp och finns i katalogen.";
} 