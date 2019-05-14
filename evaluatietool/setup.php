<?php
include 'db/db_actions.php';

delete_tables();

create_tables();

//map afbeeldingen naar db
foreach (glob('evaluatie_afbeeldingen/testreeks/*.*') as $path) {
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $filename = pathinfo($path, PATHINFO_FILENAME);
    $chrome_not_safari = ($extension == "jpg" || $extension == "webp") ? 1 : 0;
    $practice_data = 1;
    create_image_record($filename, $extension, $path, $practice_data, $chrome_not_safari);
}

//map afbeeldingen naar db
foreach (glob('evaluatie_afbeeldingen/evaluatiereeks/*.*') as $path) {
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $filename = pathinfo($path, PATHINFO_FILENAME);
    $chrome_not_safari = ($extension == "jpg" || $extension == "webp") ? 1 : 0;
    $practice_data = 0;
    create_image_record($filename, $extension, $path, $practice_data, $chrome_not_safari);
}


echo "done!";