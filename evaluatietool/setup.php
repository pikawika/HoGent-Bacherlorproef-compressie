<?php
include 'db/db_actions.php';
include 'layout/header.php';

delete_tables();

create_tables();

//map afbeeldingen naar db
foreach (glob('evaluatie_afbeeldingen/testreeks/*.*') as $path) {
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $filename = pathinfo($path, PATHINFO_FILENAME);
    $chrome_not_safari = ($extension == "jpg" || $extension == "webp") ? 1 : 0;
    $practice_data = 1;
    $filesize = filesize($path);
    create_image_record($filename, $extension, $path, $practice_data, $chrome_not_safari, $filesize);
}

//map afbeeldingen naar db
foreach (glob('evaluatie_afbeeldingen/evaluatiereeks/*.*') as $path) {
    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $filename = pathinfo($path, PATHINFO_FILENAME);
    $chrome_not_safari = ($extension == "jpg" || $extension == "webp") ? 1 : 0;
    $practice_data = 0;
    $filesize = filesize($path);
    create_image_record($filename, $extension, $path, $practice_data, $chrome_not_safari, $filesize);
}


echo '<div class="p-5 mb-4 bg-primary text-white text-center">';
echo '<h1 class="mb-4">Setup done!</h1>';
echo '<a href="index.php" class="btn btn-info w-100 mb-3">Start onderzoek</a>';
echo '</div>';

include 'layout/footer.php';