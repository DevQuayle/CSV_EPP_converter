const App = {
    stepsInit: function () {
        $("#example-basic").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",

            autoFocus: true,
            onStepChanging: function (event, currentIndex, newIndex) {
                if (newIndex == 1 && currentIndex == 0) { // z 1 do 2 kroku
                    if (App.sendingFile) {
                        return true;
                    } else {
                        swal({
                            title: "Błąd!",
                            text: "Aby kontynułować musisz dodać plik",
                            type: "error",
                            confirmButtonText: "OK"
                        });
                        return false;
                    }
                } else {

                    if (newIndex == 2 && currentIndex == 1) {
                        var err = $('.err');
                        if (err.length) {
                            swal({
                                title: "Błąd!",
                                text: " Coś poszło nie tak, sprawdź błędy",
                                type: "error",
                                confirmButtonText: "OK"
                            });
                            return false;
                        }
                    }
                    return true;
                }
            },
            onFinishing: function(){
               window.location.replace("download.php");
                return true;
            },
            labels: {

                next: "Następny",
                previous: "Poprzedni",
                finish: "POBIERZ PLIK",


            }
        });
    },
    addDropZone: function () {
        Dropzone.autoDiscover = false;
        var accept = ".csv, .txt";
        $('#myDropzone').dropzone({
            url: 'upload.php',
            maxFiles: 1,
            addRemoveLinks: true,
            acceptedFiles: accept,
            dictMaxFilesExceeded: "Nie możesz załadować więcej jak 1 plik",
            dictRemoveFile: "Usuń plik",
            dictInvalidFileType: "Nie możesz dodawać plików tego typu.",



            success: function (file) {
                if (file.name) {
                    $.get("upload.php", function (data, status) {
                        if (status == 'success') {
                            $.ajax({
                                url: "index.php",
                                type: 'POST',
                                data: {
                                    fileName: data,
                                },
                                success: function (result) {
                                    var result = $("<div>").html(result).find('#test');
                                    $('#test').html(result);

                                }
                            });
                        }
                    });
                    App.sendingFile = true;
                    if (file.previewElement) {
                        return file.previewElement.classList.add("dz-success");
                    }
                    return true;

                }
            },
            reset: function () {

                $.ajax({
                    url: "index.php",
                    type: 'POST',
                    data: {
                        fileName: null,
                    },
                    success: function (result) {
                        App.sendingFile = false;
                    }
                });
            }
        });


    },
    init: function () {
        document.addEventListener('DOMContentLoaded', () => {
            App.sendingFile = false;

            App.stepsInit();
            App.addDropZone();
        }, false);

        window.onload = () => {};

        window.onresize = () => {

        };
    }
}

App.init();
