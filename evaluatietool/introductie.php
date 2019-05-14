<?php
//header voorzien
include 'layout/header.php';
?>
    <div class="p-5 mb-4 bg-grey text-white">
        <h1 class="mb-4">Een woordje uitleg</h1>
        <p class="mb-4">Na deze video toch nog vragen? Stel ze mij gerust!</p>
        <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tqx-hmzO4kQ" allowfullscreen></iframe>
        </div>
    </div>
    <button type="button" class="btn btn-outline-primary w-100" onclick="window.location.href='onderzoek.php'">Alles is duidelijk, start het onderzoek!
    </button>
<?php
//footer voorzien
include 'layout/footer.php';