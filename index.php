<?php
require_once(__DIR__ . "/transmit/api/config/conf.php");
if (isset($_GET[DB_FILE_COL])) {
    $uid = $_GET[DB_FILE_COL];
    $uid = htmlspecialchars($_GET[DB_FILE_COL]);
    $uid = str_replace("&lt;", "", $uid);
    $uid = str_replace("&gt;", "", $uid);

    // $uid = str_replace(".uid", ".png", $uid);

    $target_domain = RES_LINK;
    $file_type = FILE_INFO['type'];
    $file_ext = FILE_INFO['ext'];
    $html_title = SHARE_INFO['html_title'];
    $share_title = SHARE_INFO['share_title'];
    $share_description = SHARE_INFO['share_description'];
    $download_file_name = SHARE_INFO['download_file_name'];

    $file_array = handleFiles($uid);
    
    $file_name = "uploads/". $uid;


    $assets_img_path = "offline_assets/images/";
    // URL link on social media
    $share_link = $target_domain . "share/index.php?" . DB_FILE_COL . "=" . $uid;
    // Image for favicon
    $icon_link = $target_domain . $assets_img_path . "favicon.png";
    // Image for website thumbnail
    $upload_link = $target_domain . "uploads/" . $uid;
    // $upload_link = $target_domain . "uploads/" . $file_array[0];
} else {
    echo '';
    exit();
}

function handleFiles($uid)
{
    $temp_file_name = $uid . '.' . FILE_INFO['ext'];
    if (count(REQ_FILE_KEYS) == 1 && REQ_FILE_KEYS[0] == FILE_INFO['type']) {
        return [$temp_file_name];
    } else {
        $temp_files = array();
        foreach (FILE_KEYS as $fik) {
            $diff = trim($fik, FILE_INFO['type']);
            if (!$diff) {
                $temp_files[] = $temp_file_name;
            } else {
                $temp_files[] = $uid . '_' . $diff . '.' . FILE_INFO['ext'];
            }
        }
        return $temp_files;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta property="og:url" content="<?php echo ($share_link); ?>" />

    <meta property="og:type" content="article" />

    <meta property="og:title" content="<?php echo ($share_title); ?>" />

    <meta property="og:description" content="<?php echo ($share_link); ?>" />

    <meta property="og:image" content="<?php echo ($share_icon_link); ?>" />

    <meta property="og:image:width" content="150" />

    <meta property="og:image:height" content="150" />

    <link rel="icon" type="image/png" href="<?php echo ($icon_link); ?>" />

    <title><?php echo ($html_title); ?></title>

    <link rel="stylesheet" href="./offline_assets/css/uikit.min.css" />
    <script src="./offline_assets/js/uikit.min.js"></script>
    <!-- <script src="./offline_assets/js/uikit-icons.min.js"></script> -->

    <style>
        @font-face {
            font-family: Oratortd;
            src: url(transmit\assets\font\OratorStd.otf);
        }

        @font-face {
            font-family: SourceCodePro-Regular;
            src: url(transmit\assets\font\SourceCodePro-Regular.ttf);
        }


        * {
            outline: 1px red solid;
        }

        body {
            background-color: rgb(255, 103, 29);
            max-width: 500px;
            display: flex;
        }

        img {
            object-fit: cover;
        }

        ::-webkit-scrollbar {
            display: none;
        }

        .blocktouch {
            pointer-events: none;
        }

        .container {
            width: 500px !important;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            display: flex;
        }

        .logo-container {
            padding-top: 5%;
        }

        .file-container {
            padding-top: 5%;
        }

        .media-container {
            border: 2px black solid;
        }

        .media-container li,
        .media-container img {
            width: 100% !important;
        }

        .msg {
            text-align: center;
            font-size: 15px;
            padding: 10px;
            font-weight: 600;
            font-family: Oratortd, sans-serif;
        }
    </style>
</head>

<body>
    <div uk-height-viewport="offset-top: true" class="container uk-width-large uk-background-cover uk-margin-auto" uk-img>
        <div class="logo-container uk-width-1-2 uk-align-center" onclick="home()">
            <img class="blocktouch uk-width-expand" src="transmit\assets\images\big-logo.png" alt="Logo">
        </div>

        <div class="file-container">

            <?php
            if (count($file_array) == 1 && file_exists($file_name)) {
            ?>
                    <div class="msg">
                        <p>
                            Your photo is ready.
                            Long press the photo or click the Download button to download the digital copy.
                        </p>
                    </div>
                    <div class="media-container uk-align-center uk-width-3-4">
                        <?php
                        if ($file_type == 'img') {
                        ?>
                            <img class="pure-img uk-width-expand" src="<?php echo ($upload_link); ?>" alt="">
                        <?php
                        }
                        ?>
                    </div>

                    <div class="share-container uk-flex uk-flex-center uk-margin-large-top">
                        <!-- Download -->
                        <div class="container">
                            <a data-auto-download id="download-file" class="uk-display-block" href="<?php echo ($upload_link); ?>" target="_blank" download="<?php echo ($download_file_name); ?>">
                                <img class="blocktouch uk-width-expand" src="transmit\assets\images\download.png" alt="">
                            </a>
                        </div>
                    </div>
            <?php
                } else {
                    echo '<div class="msg">
                <p>Your photo is being processed. Please wait for a moment.<br>
                It will be ready in 20-30 minutes after you take the photo.</p>
              </div>';
                }
            ?>

        </div>

    </div>

    <script type="text/javascript">
        function home() {
            location.reload()
        }

        function to404() {
            let file_type = "<?php echo $file_type; ?>"
            file_type = (file_type == 'img') ? "image" : file_type;
            alert(`Your ${file_type} is not found !`)
            alert(`Your <?php echo $upload_link; ?> is not found !`)
            // document.body.innerHTML = '';
        }

        var downloadLink = document.getElementById('download-file');
        var mediaContainer = document.querySelector('.media-container');

        var pressTimer;

        function startPressTimer() {
            pressTimer = setTimeout(function() {

                downloadLink.click();
            }, 1000);
        }

        function cancelPressTimer() {
            clearTimeout(pressTimer);
        }

        mediaContainer.addEventListener('mousedown', startPressTimer);
        mediaContainer.addEventListener('touchstart', startPressTimer);

        mediaContainer.addEventListener('mouseup', cancelPressTimer);
        mediaContainer.addEventListener('touchend', cancelPressTimer);
        mediaContainer.addEventListener('touchcancel', cancelPressTimer);
    </script>

</body>

</html>