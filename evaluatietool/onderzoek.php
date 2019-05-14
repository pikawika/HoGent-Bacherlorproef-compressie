<?php
//header voorzien
include 'layout/header.php';
include 'db/db_actions.php';

if (isset($_POST['submit_profile_form'])) {
    save_info_about_you();
    show_start_chrome_sequence();
} else if (isset($_GET['browser']) && isset($_GET['participant_id'])) {
    if (isset($_POST['image_id'])) {
        save_post_rating_image();
    }

    if ($_GET['browser'] == "chrome") {
        show_next_iterative_photo_rating_chrome();
    }

    if ($_GET['browser'] == "safari") {
        show_next_iterative_photo_rating_safari();
    }
} else {
    show_info_about_you();
}

function save_info_about_you()
{
    //db moet bestaan
    $participant_id = create_user_and_get_user_id($_POST['gender'], $_POST['age'], $_POST['expertise'], $_POST['colorblind'], $_POST['badvision']);
    //cookie met user id instellen
    setcookie('participant_id', $participant_id, time() + (86400 * 30), "/");
}

function show_next_iterative_photo_rating_chrome()
{
    setcookie('participant_id', $_GET['participant_id'], time() + (86400 * 30), "/");
    $all_test_images = [];
    $all_real_images = [];
    $rated_images = [];
    $to_rate_test_images = [];
    $to_rate_real_images = [];

    $all_images_raw = get_all_images();
    $all_rated_images_raw = get_all_user_rated_images($_GET['participant_id']);

    while ($row = $all_images_raw->fetch_assoc()) {
        if ($row["practice_data"] == 1 && $row["chrome_not_safari"] == 1) {
            array_push($all_test_images, $row);
        }
        if ($row["practice_data"] == 0 && $row["chrome_not_safari"] == 1) {
            array_push($all_real_images, $row);
        }
    }

    while ($row = $all_rated_images_raw->fetch_assoc()) {
        array_push($rated_images, $row);
    }

    foreach ($all_test_images as $all_test_image) {
        $match = false;
        foreach ($rated_images as $rated_image) {
            if ($all_test_image['image_id'] == $rated_image['image_id']) {
                $match = true;
                break;
            }
        }

        if (!$match) {
            array_push($to_rate_test_images, $all_test_image);
        }
    }

    foreach ($all_real_images as $all_real_image) {
        $match = false;
        foreach ($rated_images as $rated_image) {
            if ($all_real_image['image_id'] == $rated_image['image_id']) {
                $match = true;
                break;
            }
        }

        if (!$match) {
            array_push($to_rate_real_images, $all_real_image);
        }
    }

    if (sizeof($to_rate_test_images) != 0) {
        $random_index = array_rand($to_rate_test_images, 1);
        show_photo_rating($to_rate_test_images[$random_index]['image_id'], $to_rate_test_images[$random_index]['path']);
        return;
    }

    if (sizeof($to_rate_real_images) != 0) {
        $random_index = array_rand($to_rate_real_images, 1);
        show_photo_rating($to_rate_real_images[$random_index]['image_id'], $to_rate_real_images[$random_index]['path']);
        return;
    }

    //laatste ratebare image bereikt
    show_start_safari_sequence();
}

function show_next_iterative_photo_rating_safari()
{
    setcookie('participant_id', $_GET['participant_id'], time() + (86400 * 30), "/");
    $all_test_images = [];
    $all_real_images = [];
    $rated_images = [];
    $to_rate_test_images = [];
    $to_rate_real_images = [];

    $all_images_raw = get_all_images();
    $all_rated_images_raw = get_all_user_rated_images($_GET['participant_id']);

    while ($row = $all_images_raw->fetch_assoc()) {
        if ($row["practice_data"] == 1 && $row["chrome_not_safari"] == 0) {
            array_push($all_test_images, $row);
        }
        if ($row["practice_data"] == 0 && $row["chrome_not_safari"] == 0) {
            array_push($all_real_images, $row);
        }
    }

    while ($row = $all_rated_images_raw->fetch_assoc()) {
        array_push($rated_images, $row);
    }

    foreach ($all_test_images as $all_test_image) {
        $match = false;
        foreach ($rated_images as $rated_image) {
            if ($all_test_image['image_id'] == $rated_image['image_id']) {
                $match = true;
                break;
            }
        }

        if (!$match) {
            array_push($to_rate_test_images, $all_test_image);
        }
    }

    foreach ($all_real_images as $all_real_image) {
        $match = false;
        foreach ($rated_images as $rated_image) {
            if ($all_real_image['image_id'] == $rated_image['image_id']) {
                $match = true;
                break;
            }
        }

        if (!$match) {
            array_push($to_rate_real_images, $all_real_image);
        }
    }

    if (sizeof($to_rate_test_images) != 0) {
        $random_index = array_rand($to_rate_test_images, 1);
        show_photo_rating($to_rate_test_images[$random_index]['image_id'], $to_rate_test_images[$random_index]['path']);
        return;
    }

    if (sizeof($to_rate_real_images) != 0) {
        $random_index = array_rand($to_rate_real_images, 1);
        show_photo_rating($to_rate_real_images[$random_index]['image_id'], $to_rate_real_images[$random_index]['path']);
        return;
    }

    //laatste ratebare image bereikt
    show_thanks_screen();
}

function show_start_safari_sequence()
{
    $url = strtok("http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}", '?');
    $url = $url . "?browser=safari&participant_id=" . $_COOKIE['participant_id'];
    ?>
    <div class="p-5 mb-4 bg-grey text-white">
        <h1 class="mb-4 text-white">Open de volgende link in safari</h1>

        <a class="mb-2 text-white" href="<?php echo $url ?>"><?php echo $url ?></a>
    </div>
    <?php
}

function show_start_chrome_sequence()
{
    $url = strtok("http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}", '?');
    $url = $url . "?browser=chrome&participant_id=" . $_COOKIE['participant_id'];
    ?>
    <div class="p-5 mb-4 bg-grey text-white">
        <h1 class="mb-4 text-white">Open de volgende link in chrome</h1>

        <a class="mb-2 text-white" href="<?php echo $url ?>"><?php echo $url ?></a>
    </div>
    <?php
}

function show_thanks_screen()
{
    ?>
    <div class="p-5 mb-4 bg-grey text-white">
        <h1 class="mb-4 text-white">Bedankt om deel te nemen aan dit onderzoek!</h1>
    </div>
    <?php
}

function show_photo_rating($image_id, $path)
{
    ?>
    <form enctype='multipart/form-data' method="post">
        <div class="p-5 mb-4 bg-grey text-white">

            <div class="mb-5 row">
                <div class="col">
                    <img class="img_evaluation" src="<?php echo $path ?>"
                         data-zoom="<?php echo $path ?>">
                </div>
                <div class="col">
                    <p class="img_evaluation_zoomed">Beweeg met de muis over de afbeelding om in te zoomen.</p>
                </div>
                <hr>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Scherpte</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="sharpness1" name="sharpness" value="1"
                                   required>
                            <label class="form-check-label" for="sharpness1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="sharpness2" name="sharpness" value="2">
                            <label class="form-check-label" for="sharpness2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="sharpness3" name="sharpness" value="3">
                            <label class="form-check-label" for="sharpness3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="sharpness4" name="sharpness" value="4">
                            <label class="form-check-label" for="sharpness4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="sharpness5" name="sharpness" value="5">
                            <label class="form-check-label" for="sharpness5">5 (+)</label>
                        </div>
                    </div>
                    <small>Een afbeelding wordt aanschouwd als zeer scherp (5) wanneer de elementen die in focus liggen
                        veel detail bevatten en lijnen vloeiend zijn zoals ze in de echte wereld ook zijn.
                    </small>
                </div>
            </div>
            <hr>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Kleuren en contrast</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="color1" name="color" value="1"
                                   required>
                            <label class="form-check-label" for="color1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="color2" name="color" value="2">
                            <label class="form-check-label" for="color2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="color3" name="color" value="3">
                            <label class="form-check-label" for="color3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="color4" name="color" value="4">
                            <label class="form-check-label" for="color4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="color5" name="color" value="5">
                            <label class="form-check-label" for="color5">5 (+)</label>
                        </div>
                    </div>
                    <small>Een afbeelding scoort goed voor kleuren en contrast (5) als u geen artifacten waarneemt en
                        het gevoel hebt dat er geen details verloren zijn gegaan door een slecht contrast.
                    </small>
                </div>
            </div>
            <hr>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Algemene indruk</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general1" name="general" value="1"
                                   required>
                            <label class="form-check-label" for="general1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general2" name="general" value="2">
                            <label class="form-check-label" for="general2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general3" name="general" value="3">
                            <label class="form-check-label" for="general3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general4" name="general" value="4">
                            <label class="form-check-label" for="general4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="general5" name="general" value="5">
                            <label class="form-check-label" for="color5">5 (+)</label>
                        </div>
                    </div>
                    <small>Uw algemene tevredenheid met de kwaliteit van deze afbeelding.</small>
                </div>
            </div>

            <input type="hidden" name="image_id" value="<?php echo $image_id ?>">

        </div>

        <button type="submit" name="submit_iterative_photo_rating_form" value="Submit"
                class="btn btn-outline-primary w-100">
            Beoordeel de volgende afbeelding
        </button>
    </form>
    <?php
}

function save_post_rating_image()
{
    add_user_rating($_COOKIE['participant_id'], $_POST['image_id'], $_POST['sharpness'], $_POST['color'], $_POST['general']);
}

function show_info_about_you()
{
    ?>
    <form enctype='multipart/form-data' method="post">
        <div class="p-5 mb-4 bg-grey text-white">
            <h1 class="mb-4">Informatie over u</h1>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Geslacht</label>
                <div class="col-sm-10">
                    <select class="custom-select" name="gender" required>
                        <option value="">Gelieve een geslacht te kiezen</option>
                        <option value="male">Man</option>
                        <option value="female">Vrouw</option>
                        <option value="other">Overige</option>
                    </select>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Leeftijd</label>
                <div class="col-sm-10">
                    <input type="number" name="age" class="w-100" min="0" placeholder="Leeftijd" required/>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Expertise binnen het onderzoeksdomein</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="expertise1" name="expertise" value="1"
                                   required>
                            <label class="form-check-label" for="expertise1">Ja</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="expertise2" name="expertise" value="0">
                            <label class="form-check-label" for="expertise2">Nee</label>
                        </div>
                    </div>

                    <small>Indien u een gegronde kennis heeft van afbeeldingscompressie algoritmes, het verschil kent
                        tussen lossy en lossless algoritmes en artifacten zoals blokartifcaten kan herkennen, kiest
                        u hier voor de optie ja.
                    </small>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Kleurenblind</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="colorblind1" name="colorblind"
                                   value="1"
                                   required>
                            <label class="form-check-label" for="colorblind1">Ja</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="colorblind2" name="colorblind" value="0">
                            <label class="form-check-label" for="colorblind2">Nee</label>
                        </div>
                    </div>

                    <small>Niet zeker of u kleurenblind bent? Doe <a class="text-white" target="_blank"
                                                                     href="https://www.colour-blindness.com/colour-blindness-tests/ishihara-colour-test-plates/">hier</a>
                        een korte test.
                    </small>
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">slechtziend</label>
                <div class="col-sm-10">

                    <div class="w-100">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="badvision1" name="badvision" value="1"
                                   required>
                            <label class="form-check-label" for="badvision1">Ja</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="badvision2" name="badvision" value="0">
                            <label class="form-check-label" for="badvision2">Nee</label>
                        </div>
                    </div>

                    <small>Indien uw bril en/of lenzen u niet (of niet genoeg) helpen om goed te zien kiest u "ja". <br>Als
                        u normaal een bril draagt en deze nu niet op heeft kiest u ook voor ja.
                    </small>
                </div>
            </div>
        </div>
        <button type="submit" name="submit_profile_form" value="Submit" class="btn btn-outline-primary w-100">
            Bovenstaande gegevens zijn correct, start de beoordeling van de afbeeldingen.
        </button>
    </form>
    <?php
}

//footer voorzien
include 'layout/footer.php';