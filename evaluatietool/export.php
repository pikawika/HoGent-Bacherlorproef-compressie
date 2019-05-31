<?php
include 'db/db_actions.php';
include 'layout/header.php';

make_temp_dir();

make_csv_files();

show_download_screen();

function show_download_screen()
{
    ?>
    <div class="p-5 mb-4 bg-primary text-white text-center">
        <h1 class="mb-4">Export voltooid!</h1>
        <a href="temp/images.csv" class="btn btn-info w-100 mb-3" download>Download images.csv &darr;</a>
        <a href="temp/participants.csv" class="btn btn-info w-100 mb-3" download>Download participants.csv &darr;</a>
        <a href="temp/ratings.csv" class="btn btn-info w-100 mb-3" download>Download ratings.csv &darr;</a>
    </div>
    <?php
}


function make_temp_dir()
{
    if (!is_dir('temp')) {
        // temp folder bestaat niet -> maken
        mkdir('temp');
    }
}

function make_csv_files()
{
    //participants
    $file = fopen("temp/participants.csv", "w");
    fputcsv($file, array('participant_id', 'gender', 'age', 'expertise', 'colorblind', 'bad_vision'));
    $records = get_all_participants();
    while ($row = mysqli_fetch_assoc($records)) {
        fputcsv($file, $row);
    }
    fclose($file);

    //images
    $file = fopen("temp/images.csv", "w");
    fputcsv($file, array('image_id', 'filename', 'extension', 'path', 'practice_data', 'chrome_not_safari', 'filesize'));
    $records = get_all_images();
    while ($row = mysqli_fetch_assoc($records)) {
        fputcsv($file, $row);
    }
    fclose($file);

    //ratings
    $file = fopen("temp/ratings.csv", "w");
    fputcsv($file, array('participant_id', 'image_id', 'sharpness', 'color_contrast', 'general'));
    $records = get_all_ratings();
    while ($row = mysqli_fetch_assoc($records)) {
        fputcsv($file, $row);
    }
    fclose($file);
}

include 'layout/footer.php';