<?php
    require './miniAdmin.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hermes Upload Admin</title>
    <link rel="stylesheet" href="./assets/css/uikit.min.css" />
    <script src="./assets/js/uikit.min.js"></script>

    <style>

        .container{
            padding-top: 5%;
        }

        .uk-placeholder {
            padding: 100px 30px;
        }

        .uk-notification-message{
            background-color: black;

            color:white;
        }

        *+.uk-alert {
            margin-top: 0px;
        }

        .uk-notification-message-danger {
            /* background-color: #fef4f6;
            color: #f0506e; */
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>


    <nav class="uk-navbar-container">
        <div class="uk-container">
            <div uk-navbar>
                <div class="uk-navbar-left">
                    <a class="uk-navbar-item uk-logo" href="" aria-label="Back to Home">
                        <img src="./assets/images/logo.png">
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="uk-alert-danger" uk-alert>
        <!-- <a class="uk-alert-close" uk-close></a> -->
        <div class=" uk-container">

            <p>Only 1 image at once</p>
        </div>
    </div>
    <div class="uk-container container">
        
        <div class="js-upload uk-placeholder uk-text-center">
            <span uk-icon="icon: cloud-upload"></span>
            <span class="uk-text-middle">Attach files by dropping them here or</span>
            <div uk-form-custom>
                <input type="file">
                <span class="uk-link">selecting one</span>
            </div>
        </div>
        
        <progress id="js-progressbar" class="uk-progress" value="0" max="100" hidden></progress>
        
        
        <script>
        
            var bar = document.getElementById('js-progressbar');
            var cat = document.getElementById('happy-cat');
        
            UIkit.upload('.js-upload', {
        
                // url: 'http://192.168.1.152/hermes/transmit/api/index.php',
                url: 'https://www.hap50.com/transmit/api/index.php',
                multiple: false,
                name: 'img',
                params: {
                    type: 'uploadFile'
                },
        
                beforeSend: function () {
                    console.log('beforeSend', arguments);
                },
                beforeAll: function () {
                    console.log('beforeAll', arguments);
                },
                load: function () {
                    console.log('load', arguments);
                },
                error: function () {
                    console.log('error', arguments);
                },
                complete: function () {
                    console.log('complete', arguments);
                },
        
                loadStart: function (e) {
                    console.log('loadStart', arguments);
        
                    bar.removeAttribute('hidden');
                    bar.max = e.total;
                    bar.value = e.loaded;

                    // cat.removeAttribute('hidden');
                },
        
                progress: function (e) {
                    console.log('progress', arguments);
        
                    bar.max = e.total;
                    bar.value = e.loaded;
                },
        
                loadEnd: function (e) {
                    console.log('loadEnd', arguments);
        
                    bar.max = e.total;
                    bar.value = e.loaded;
                },
        
                completeAll: function () {
                    console.log('completeAll', arguments);
        
                    setTimeout(function () {
                        bar.setAttribute('hidden', 'hidden');
                        cat.setAttribute('hidden', 'hidden');
                    }, 1000);
        
                    // alert('Upload Completed');

                    let res = JSON.parse(arguments[0].response)
                    console.log(res)
                    if(res.status == 'success'){
                        UIkit.notification({message: `Upload Completed: ${res.content}`})
                    } else{
                        UIkit.notification({message: `Upload Failed!`, status: 'danger'})
                    }
                }
        
            });
        
        </script>
        
    </div>
</body>
</html>