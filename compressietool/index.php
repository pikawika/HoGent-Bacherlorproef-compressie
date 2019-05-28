<?php
//header en algo's voorzien
include 'layout/header.php';
include 'algoritmes/rle.php';
include 'algoritmes/huffman.php';

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
    make_temp_dir();
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
        $rlea_inhoud = rle_encode_all(file_get_contents($_FILES['bestand']['tmp_name']));
        file_put_contents($rlea_bestand, $rlea_inhoud);
        //rle 1+
        $rle_bestand = 'temp/encoded_rle.lbrle';
        $rle_inhoud = rle_encode(file_get_contents($_FILES['bestand']['tmp_name']));
        file_put_contents($rle_bestand, $rle_inhoud);

        //toon output scherm
        show_encoded_output_screen($rlea_bestand, $rle_bestand);
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
        show_input_screen();
    }
}

function process_decode_huffman()
{
    //todo
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

        <a href="<?php echo $file_url ?>" class="text-white" download>Download decoded bestand</a>

    </div>
    <a class="btn btn-outline-primary w-100 mb-3" href=".">Keer terug naar eerste pagina
    </a>
    <?php
}

function show_encoded_output_screen($rlea_url, $rle_url)
{
    ?>
    <div class="p-5 mb-4 bg-primary text-white">
        <h1 class="mb-4">Decoding geslaagd</h1>

        <a href="<?php echo $rlea_url ?>" class="text-white" download>Download RLE all encoded bestand</a>
        <br>
        <a href="<?php echo $rle_url ?>" class="text-white" download>Download RLE encoded bestand</a>
        <br>
    </div>
    <a class="btn btn-outline-primary w-100 mb-3" href=".">Keer terug naar eerste pagina
    </a>
    <?php
}

//footer voorzien
include 'layout/footer.php';