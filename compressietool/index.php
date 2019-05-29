<?php
//header en algo's voorzien
include 'layout/header.php';
include 'algoritmes/rle.php';
include 'algoritmes/huffman.php';

make_temp_dir();

if (isset($_POST['encode'])) {
    process_encode();
} else if (isset($_POST['rle-decode'])) {
    process_decode_rle();
} else if (isset($_POST['huffman-decode'])) {
    process_decode_huffman();
} else {
    show_input_screen();
}

function process_encode()
{
    if ($_FILES['bestand']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['bestand']['tmp_name'])) {
        if (pathinfo($_FILES['bestand']['name'], PATHINFO_EXTENSION) != "txt") {
            show_input_screen("Geen txt bestand geselecteerd");
            exit();
        }

        $txt_inhoud = file_get_contents($_FILES['bestand']['tmp_name']);

        $regex_enkel_ascii = '%^[ -~]+$%';

        //enkel ascii en geen nummers
        if (!preg_match($regex_enkel_ascii, $txt_inhoud) || preg_match('/\\d/', $txt_inhoud)) {
            show_input_screen("Txt bestand mag enkel Ascii tekens bevatten zonder nummers");
            exit();
        }

        //rle all
        $rlea_bestand = 'temp/encoded_rle_all.lbrlea';
        $rlea_encoder_response = rle_encode_all(file_get_contents($_FILES['bestand']['tmp_name']));
        $rlea_inhoud = $rlea_encoder_response[0];
        $rlea_origineel_aantal_karakters = $rlea_encoder_response[1];
        $rlea_encoded_aantal_karakters = $rlea_encoder_response[2];
        file_put_contents($rlea_bestand, $rlea_inhoud);
        //rle 1+
        $rle_bestand = 'temp/encoded_rle.lbrle';
        $rle_encoder_response = rle_encode(file_get_contents($_FILES['bestand']['tmp_name']));
        $rle_inhoud = $rle_encoder_response[0];
        $rle_origineel_aantal_karakters = $rle_encoder_response[1];
        $rle_encoded_aantal_karakters = $rle_encoder_response[2];
        file_put_contents($rle_bestand, $rle_inhoud);
        //huffman
        $huffman_bestand = 'temp/encoded_huffman.lbhuffman';
        $huffman_encoder_response = huffman_encode(file_get_contents($_FILES['bestand']['tmp_name']));
        $huffman_inhoud = json_encode(array_slice($huffman_encoder_response, 0, 2));
        $huffman_origineel_bits = $huffman_encoder_response[2];
        $huffman_encoded_bits = $huffman_encoder_response[3];
        file_put_contents($huffman_bestand, $huffman_inhoud);

        //toon output scherm
        show_encoded_output_screen($rlea_bestand, $rlea_origineel_aantal_karakters, $rlea_encoded_aantal_karakters, $rle_bestand, $rle_origineel_aantal_karakters, $rle_encoded_aantal_karakters, $huffman_bestand, $huffman_origineel_bits, $huffman_encoded_bits);
    } else {
        //upgeloade bestand niet correct ontvangen
        show_input_screen();
    }
}

function make_temp_dir()
{
    if (!is_dir('temp')) {
        // temp folder bestaat niet -> maken
        mkdir('temp');
    }
}

function process_decode_rle()
{
    if ($_FILES['bestand']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['bestand']['tmp_name'])) {
        if (!in_array(pathinfo($_FILES['bestand']['name'], PATHINFO_EXTENSION), ["lbrle", "lbrlea"])) {
            show_input_screen("Geen geldig RLE bestand geselecteerd");
            exit();
        }

        $decoded_rle_bestand = 'temp/decoded_rle.txt';
        $decoded_rle_inhoud = rle_decode(file_get_contents($_FILES['bestand']['tmp_name']));
        file_put_contents($decoded_rle_bestand, $decoded_rle_inhoud);

        show_decoded_output_screen($decoded_rle_bestand);
    } else {
        //upgeloade bestand niet correct ontvangen
        show_input_screen("Fout bij uploaden");
    }
}

function process_decode_huffman()
{
    if ($_FILES['bestand']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['bestand']['tmp_name'])) {
        if (pathinfo($_FILES['bestand']['name'], PATHINFO_EXTENSION) != "lbhuffman") {
            show_input_screen("Geen geldig huffman bestand geselecteerd");
            exit();
        }

        $huffman_string = json_decode(file_get_contents($_FILES['bestand']['tmp_name']))[0];
        $huffman_lookup = json_decode(file_get_contents($_FILES['bestand']['tmp_name']))[1];

        $decoded_huffman_bestand = 'temp/decoded_huffman.txt';
        $decoded_huffman_inhoud = huffman_decode($huffman_string, $huffman_lookup);
        file_put_contents($decoded_huffman_bestand, $decoded_huffman_inhoud);

        show_decoded_output_screen($decoded_huffman_bestand);
    } else {
        //upgeloade bestand niet correct ontvangen
        show_input_screen("Fout bij uploaden");
    }
}


function show_input_screen($error = false)
{
    ?>
    <form method="post" enctype="multipart/form-data">
        <?php if ($error) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Oeps!</strong> <?php echo $error ?>
            </div>
        <?php endif; ?>
        <div class="p-5 mb-4 bg-primary text-white">
            <h1 class="mb-4">Bachelorproef POC: compressietool</h1>

            <div class="custom-file">
                <input type="file" class="custom-file-input" id="bestand" name="bestand" required>
                <label class="custom-file-label" for="bestand">Kies bestand</label>
                <small> Gelieve een .txt bestand te selecteren bestaande uit enkel letters voor encodering of een .lb*
                    bestand voor
                    decodering.
                </small>
            </div>

            <a href="input/demo_input.zip" class="btn btn-info mt-3" download>Download de demo tekstbestanden &darr;</a>

        </div>

        <button class="btn btn-outline-primary w-100 mb-3" type="submit" name="encode" value="yes">Bestand encoderen
        </button>
        <button class="btn btn-outline-primary w-100 mb-3" type="submit" name="rle-decode" value="yes">RLE decoderen
        </button>
        <button class="btn btn-outline-primary w-100" type="submit" name="huffman-decode" value="yes">Huffman
            decoderen
        </button>

    </form>
    <?php
}

function show_decoded_output_screen($file_url)
{
    ?>
    <div class="p-5 mb-4 bg-primary text-white">
        <h1 class="mb-4">Decoding geslaagd</h1>

        <a href="<?php echo $file_url ?>" class="btn btn-info" download>Download decoded bestand &darr;</a>

    </div>
    <a class="btn btn-outline-primary w-100 mb-3" href=".">Keer terug naar eerste pagina
    </a>
    <?php
}

function show_encoded_output_screen($rlea_url, $rlea_origineel_aantal_karakters, $rlea_encoded_aantal_karakters, $rle_url, $rle_origineel_aantal_karakters, $rle_encoded_aantal_karakters, $huffman_url, $huffman_origineel_bits, $huffman_encoded_bits)
{
    ?>
    <div class="p-5 mb-4 bg-primary text-white">
        <h1 class="mb-4">Encoding geslaagd</h1>

        <h3>RLE all encoded</h3>
        <p>
            <b>Origineel aantal karakters: </b> <?php echo $rlea_origineel_aantal_karakters ?>
            <br>
            <b>Encoded aantal karakters: </b> <?php echo $rlea_encoded_aantal_karakters ?>
        </p>
        <a href="<?php echo $rlea_url ?>" class="btn btn-info" download>Download &darr;</a>
        <hr>

        <h3>RLE encoded</h3>
        <p>
            <b>Origineel aantal karakters: </b> <?php echo $rle_origineel_aantal_karakters ?>
            <br>
            <b>Encoded aantal karakters: </b> <?php echo $rle_encoded_aantal_karakters ?>
        </p>
        <a href="<?php echo $rle_url ?>" class="btn btn-info" download>Download &darr;</a>
        <hr>

        <h3>Huffman encoded</h3>
        <p>
            <b>Origineel aantal bits: </b> <?php echo $huffman_origineel_bits ?>
            <br>
            <b>Encoded aantal bits (exclusief lookup table): </b> <?php echo $huffman_encoded_bits ?>
        </p>
        <a href="<?php echo $huffman_url ?>" class="btn btn-info" download>Download &darr;</a>
        <br>
        <small>Lookup table en encoding string opgeslagen als json en dus een niet representabele bestandsgrootte voor dit compressie-algoritme</small>
    </div>
    <a class="btn btn-outline-primary w-100 mb-3" href=".">Keer terug naar eerste pagina
    </a>
    <?php
}

//footer voorzien
include 'layout/footer.php';