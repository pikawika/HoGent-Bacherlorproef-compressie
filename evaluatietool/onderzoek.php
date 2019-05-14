<?php
//header voorzien
include 'layout/header.php';
include 'db/db_actions.php';

if (isset($_POST['submit_profile_form'])) {
    save_info_about_you();
    show_iterative_photo_rating();
} else if (isset($_POST['submit_iterative_photo_rating_form'])) {
    show_iterative_photo_rating();
} else {
    show_info_about_you();
}

function save_info_about_you()
{
    //TODO
}

function decide_next_iterative_photo_rating()
{
    //todo uit db: ids
    $all_test_images = ["1.png", "2.png", "3.png"];
    //todo uit db: ids
    $rated_test_images = [];
    //todo uit db: ids
    $all_real_images = ["2.png", "3.png"];
    //todo uit db: ids
    $rated_real_images = [];

    $to_rate_test_images = array_values(array_diff($all_test_images, $rated_test_images));
    $to_rate_real_images = array_values(array_diff($all_real_images, $rated_real_images));

    if (sizeof($to_rate_test_images) == sizeof($rated_test_images) && sizeof($to_rate_test_images) != 0) {
        show_testing_image_sequence_warning();
        return;
    }

    if (empty($to_rate_test_images)) {
        show_iterative_photo_rating($to_rate_test_images[array_rand($to_rate_test_images)]);
        return;
    }
}

function show_testing_image_sequence_warning()
{
    //TODO
}

function show_logged_image_sequence_warning()
{
    //TODO
}

function show_iterative_photo_rating()
{
    //TODO: nu maar temp voor te tonen aan tom.
    ?>
    <form enctype='multipart/form-data' method="post">
        <div class="p-5 mb-4 bg-grey text-white">

            <div class="mb-5 row">
                <div class="col">
                    <img class="img_evaluation" src="evaluatie_afbeeldingen/evaluatiereeks/1.jpg"
                         data-zoom="evaluatie_afbeeldingen/evaluatiereeks/1.jpg">
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
                            <input class="form-check-input" type="radio" id="focus1" name="focus" value="1"
                                   required>
                            <label class="form-check-label" for="focus1">1 (-)</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="focus2" name="focus" value="2">
                            <label class="form-check-label" for="focus2">2</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="focus3" name="focus" value="3">
                            <label class="form-check-label" for="focus3">3</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="focus4" name="focus" value="4">
                            <label class="form-check-label" for="focus4">4</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="focus5" name="focus" value="5">
                            <label class="form-check-label" for="focus5">5 (+)</label>
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


        </div>

        <button type="submit" name="submit_iterative_photo_rating_form" value="Submit"
                class="btn btn-outline-primary w-100">
            Beoordeel de volgende afbeelding
        </button>
    </form>
    <?php
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
                            <input class="form-check-input" type="radio" id="expertise1" name="expertise" value="yes"
                                   required>
                            <label class="form-check-label" for="expertise1">Ja</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="expertise2" name="expertise" value="no">
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
                            <input class="form-check-input" type="radio" id="generalblind1" name="colorblind"
                                   value="yes"
                                   required>
                            <label class="form-check-label" for="colorblind1">Ja</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="colorblind2" name="colorblind" value="no">
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
                            <input class="form-check-input" type="radio" id="badvision1" name="badvision" value="yes"
                                   required>
                            <label class="form-check-label" for="badvision1">Ja</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="badvision2" name="badvision" value="no">
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