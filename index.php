<?php
    session_start();
    require_once "convert.class.php";
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>CSV to EPP concerter</title>

        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <script src="assets/js/jquery-1.12.3.min.js"></script>
        <script src="assets/js/jquery.steps.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/dropzone.js"></script>
        <script src="assets/js/sweetalert.min.js"></script>

        <link rel="stylesheet" href="assets/css/sweetalert.css">
        <link rel="stylesheet" href="assets/css/steps.css">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body>
        <div class="title">CVS to EPP converter</div>
        <div id="example-basic">
            <h3> Dodaj plik do konwersji</h3>
            <section>
                <form id="myDropzone" class="dropzone"></form>
            </section>
            <h3>Konwersja</h3>
            <section>
                <div id="test">
                    <?php
                    if (isset($_POST['fileName']) && !empty($_POST['fileName']))
                    {
                        $thread = str_replace('"', '', $_POST['fileName']);
                        convert($thread);
                        $_POST['fileDownload'] = $_POST['fileName'];
                        $_POST['fileName'] = null;
                    }
                    ?>
                </div>
            </section>
            <h3>Pobierz gotowy plik</h3>
            <section class="last">
            <img src="assets/img/download.png" alt="download">
            <div class="arrow bounce"></div>
            </section>
        </div>
    </body>

    </html>
