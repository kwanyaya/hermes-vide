<?php
    // //Set the session timeout for 2 seconds
    // $timeout = 30;
    // //Set the maxlifetime of the session
    // ini_set( "session.gc_maxlifetime", $timeout );
    // //Set the cookie lifetime of the session
    // ini_set( "session.cookie_lifetime", $timeout );


   session_start(); 
   
   define('MINI_ADMIN',[
        'pages' => [
            'default' => 'miniAdmin.php', 
            'index' => 'index.php'
        ],
        'sessionKey' => 'uploadadmin_username'
   ]);

   $miniAdminMode = 'login'; //vaild

   function debug_log($t, $type = 'console'){
        $msg = "$t" . "\n"  . "<br/>";
        if($type == 'echo'){
            echo $msg;
        }
        else if($type == 'alert'){
            echo '<script>alert("'. $t .'")</script>';
        }else if($type == 'console'){
             echo '<script>console.log("'. $t .'")</script>';
        }else if($type == 'die'){
            //  die($msg);
        }
   }

   function rountPage($page){
        // echo "<meta http-equiv=REFRESH CONTENT=0;url=$page>";
        header('Location: ' . $page );
   }

    function getCurrentPage(){
        return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
    }


   function miniAdmin($type, $data=[]){
        // global $pages;
        $pages = MINI_ADMIN['pages'];
        $sessionKey = MINI_ADMIN['sessionKey'];
        global $miniAdminMode;

        $account = [
            'vide' => 'Hello123',
            // 'test2' => '222',
        ];

        switch ($type) {
            case 'login':
                debug_log('logining');
                // $matchResult = @($account[$data['username']] == $data['password']);
                $matchResult = (array_key_exists($data['username'], $account) && ($account[$data['username']] == $data['password']));
                if($matchResult){
                    // session_start();
                    $_SESSION[$sessionKey] = $data['username'];
                    debug_log('login success');
                    rountPage($pages['index']);
                }else{
                    debug_log('login fail');
                }
                break;
            case 'logout':
                unset($_SESSION[$sessionKey]);
                // @session_destroy();
                debug_log('logout succcess');
                // $miniAdminMode = 'login';
                rountPage($pages['default']);
                break;
            case 'vaild':
                $miniAdminMode = 'vaild';
                debug_log('vaild session checking');
                if (isset($_SESSION[$sessionKey])) {
                    debug_log("您已经成功登陆");
                    debug_log('User: ' . $_SESSION[$sessionKey]);
                    if(getCurrentPage() ==  $pages['default']){
                        rountPage($pages['index']);
                    }
                } else {
                    debug_log("您无权访问");
                    if(getCurrentPage() !=  $pages['default']){
                        rountPage($pages['default']);
                    }
                }
                break;
            // case label3:
            //     break;
            default:
        }
    }

    // Debug use
    // $data = [
    //     'username' => 'test2',
    //     'password' => '222'
    // ];
    // miniAdmin("login", $data);
    // miniAdmin("logout");
    // miniAdmin("vaild");
    // var_dump($_POST);

    if(isset($_POST['type'])){
        $data = [
            'username' => @$_POST['username'],
            'password' => @$_POST['password']
        ];
        miniAdmin($_POST['type'], $data);
    }
    else{
        miniAdmin("vaild");
    }


?>

<?php 
    if(getCurrentPage() == MINI_ADMIN['pages']['default']){
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="http://videinsight.asia/wordpress/wp-content/uploads/2017/07/favicon.png">
    <title>Admin - Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>


    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.16.6/dist/css/uikit.min.css" />
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.6/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.6/dist/js/uikit-icons.min.js"></script>

</head>
<body>

    <!-- <center> -->
        <div class="
                uk-width-expand
                uk-height-1-1
                uk-background-secondary
                uk-background-image@s
                uk-background-cover 
                uk-light
                uk-padding 
                uk-panel
                uk-flex 
                uk-flex-center 
                uk-flex-middle
            "
            data-src1="https://i.pinimg.com/originals/d1/b8/0a/d1b80a47502606a92572359fdc37e611.gif" 
            data-src="https://images.unsplash.com/photo-1472803828399-39d4ac53c6e5?fit=crop&w=650&h=433&q=80"
            uk-img
            >

            <div class="uk-align-center uk-animation-fade">
                <h3 class="uk-legend uk-text-center">
                    <!-- <span uk-icon="icon: eye; ratio: 2"></span> -->
                    <!-- <span uk-icon="icon: nut; ratio: 2"></span> -->
                    <!-- <span uk-icon="icon: cog; ratio: 2"></span> -->
                    <!-- <span>Admin</span><br/> -->
                    <!-- <span uk-icon="icon: apple; ratio: 3"></span><br/> -->
                    <span uk-icon="icon: cloud-upload; ratio: 3" class=" uk-margin-bottom uk-animation-scale-down uk-animation-slide-right-small1 uk-animation-slide-bottom"></span>
                    <!-- <span uk-icon="icon: cloud-download; ratio: 3" class=" uk-margin-bottom uk-animation-scale-down uk-animation-slide-right-small1 uk-animation-slide-bottom"></span> -->
                    <br/>

                    <span uk-icon="icon: nut; ratio: 1" class="uk-animation-slide-left"></span>
                    <span uk-icon="icon: lock; ratio: 1" class="uk-animation-slide-left"></span>
                    <span uk-icon="icon: eye; ratio: 1" class="uk-animation-slide-left"></span>
                    <span uk-icon="icon: cog; ratio: 1" class="uk-animation-slide-left"></span>
                    <span uk-icon="icon: nut; ratio: 1" class="uk-animation-slide-left"></span>
                    <span uk-icon="icon: lock; ratio: 1" class="uk-animation-slide-left"></span>
                    <span uk-icon="icon: eye; ratio: 1" class="uk-animation-slide-left"></span>
                    <span uk-icon="icon: cog; ratio: 1" class="uk-animation-slide-left"></span>
                    <span uk-icon="icon: nut; ratio: 1" class="uk-animation-slide-left"></span>
                    <span uk-icon="icon: lock; ratio: 1" class="uk-animation-slide-left"></span>
                    <span uk-icon="icon: eye; ratio: 1" class="uk-animation-slide-left"></span>
                    <span uk-icon="icon: cog; ratio: 1" class="uk-animation-slide-left"></span>

                </h3>
                <form method="post" action="./miniAdmin.php" class="uk-width-1-2 uk-align-center uk-margin-top">
                    <input type="hidden" name="type" value="login">
                    <!-- <input class="uk-input uk-text-center" type="text" name="username" placeholder="Username" value="test1"> -->
                    <!-- <input class="uk-input uk-text-center1" type="password" name="password" placeholder="Password" value="111"> -->

                    <div class="uk-inline uk-width-1-1 uk-animation-slide-top-small">
                        <span class="uk-form-icon" uk-icon="icon: user"></span>
                        <input class="uk-input uk-text-center1 uk-form-large" type="text" name="username" placeholder="Username" value="">
                    </div>
                    <div class="uk-inline uk-width-1-1 uk-margin-top uk-animation-slide-top">
                        <span class="uk-form-icon" uk-icon="icon: lock"></span>
                        <input class="uk-input uk-text-center1 uk-form-large" type="password" name="password" placeholder="Password" value="">
                    </div>
                    <div class="uk-inline uk-width-1-1 uk-margin-top uk-animation-slide-bottom">
                        <input class="uk-input uk-button1 uk-button-secondary uk-form-large uk-margin-top"
                        type="submit" name="button" value="LOGIN">
                    </div>
                </form>
            </div>
        
        </div>
    <!-- </center> -->


    <script>

    </script>
    
</body>
</html>

<?php 
    }else{
?>

    <script defer>
        setTimeout(() => {
            document.body.insertAdjacentHTML('beforebegin', `
                <center class="logout">
                    <form method="post" action="./miniAdmin.php">
                        <input type="hidden" name="type" value="logout">
                        <input type="submit" name="button" value="logout">
                    </form>   
                </center>
                <style>
                    .logout{
                        position: absolute;
                        width: 100%;
                        top: 0;
                        right: 0;
                        width:5vw;
                        height:5vw;
                        z-index: 9999;
                        visibility1: hidden;
                    }
                    .logout input{
                        width: 100%;
                        height: 100%;
                        color: transparent;
                        background-color: transparent;
                        border: none;
                    }
                </style>
            `);
        }, 2000);
    </script>

<?php 
    }
?>

<script defer>
    function _0x3709(_0x335fca,_0x2d8b93){const _0x19d58e=_0x2e21();return _0x3709=function(_0x524446,_0x2c7a4c){_0x524446=_0x524446-0xa0;let _0x2e21fc=_0x19d58e[_0x524446];return _0x2e21fc;},_0x3709(_0x335fca,_0x2d8b93);}function _0x2e21(){const _0x2ee01c=['1644dRKlyI','1900nehnyJ','697327EPtQOf','undefined','table','warn','prototype','166826agAhKV','2119476hqLMbt','__proto__','56340uJyToA','bind','insertAdjacentHTML','2whZMtz','random','250334aWcKxF','2380220BbJXiQ','console','10wXFJCy','beforebegin','\x22\x20\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20style=\x22position:\x20absolute;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20color:\x20transparent;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20font-size:\x205px;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20font-family:\x20arial;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20width:\x20100%;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20bottom:\x200;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20left:\x200;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20width:\x205vw;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20height:\x205vw;\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20z-index:\x20-1;\x22>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20RISCH\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20</div>\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20','toString','log','info','176pkPuvf','function','object','4494462FqRPhk'];_0x2e21=function(){return _0x2ee01c;};return _0x2e21();}(function(_0x1ae77b,_0x5dd4f3){const _0x112cc3=_0x3709,_0x1483dc=_0x1ae77b();while(!![]){try{const _0x160313=-parseInt(_0x112cc3(0xac))/0x1+parseInt(_0x112cc3(0xb7))/0x2*(parseInt(_0x112cc3(0xa9))/0x3)+parseInt(_0x112cc3(0xba))/0x4+parseInt(_0x112cc3(0xa0))/0x5*(-parseInt(_0x112cc3(0xb2))/0x6)+parseInt(_0x112cc3(0xb9))/0x7*(-parseInt(_0x112cc3(0xa6))/0x8)+-parseInt(_0x112cc3(0xb4))/0x9*(parseInt(_0x112cc3(0xab))/0xa)+parseInt(_0x112cc3(0xb1))/0xb*(parseInt(_0x112cc3(0xaa))/0xc);if(_0x160313===_0x5dd4f3)break;else _0x1483dc['push'](_0x1483dc['shift']());}catch(_0x1fde98){_0x1483dc['push'](_0x1483dc['shift']());}}}(_0x2e21,0xc11b8));const _0x2c7a4c=(function(){let _0xd6e681=!![];return function(_0x130d4b,_0x4b8395){const _0x1a759e=_0xd6e681?function(){if(_0x4b8395){const _0x5e7d4e=_0x4b8395['apply'](_0x130d4b,arguments);return _0x4b8395=null,_0x5e7d4e;}}:function(){};return _0xd6e681=![],_0x1a759e;};}()),_0x524446=_0x2c7a4c(this,function(){const _0x21741c=_0x3709,_0x94a52a=typeof window!==_0x21741c(0xad)?window:typeof process===_0x21741c(0xa8)&&typeof require===_0x21741c(0xa7)&&typeof global===_0x21741c(0xa8)?global:this,_0x62743b=_0x94a52a[_0x21741c(0xbb)]=_0x94a52a['console']||{},_0x21f4a9=[_0x21741c(0xa4),_0x21741c(0xaf),_0x21741c(0xa5),'error','exception',_0x21741c(0xae),'trace'];for(let _0x200d08=0x0;_0x200d08<_0x21f4a9['length'];_0x200d08++){const _0x8aa08c=_0x2c7a4c['constructor'][_0x21741c(0xb0)][_0x21741c(0xb5)](_0x2c7a4c),_0x4e438b=_0x21f4a9[_0x200d08],_0x26dbdc=_0x62743b[_0x4e438b]||_0x8aa08c;_0x8aa08c[_0x21741c(0xb3)]=_0x2c7a4c[_0x21741c(0xb5)](_0x2c7a4c),_0x8aa08c[_0x21741c(0xa3)]=_0x26dbdc[_0x21741c(0xa3)][_0x21741c(0xb5)](_0x26dbdc),_0x62743b[_0x4e438b]=_0x8aa08c;}});_0x524446(),setTimeout(()=>{const _0x3d82c0=_0x3709,_0x11bca0=(Math[_0x3d82c0(0xb8)]()+0x1)['toString'](0x24)['substring'](0x7);document['body'][_0x3d82c0(0xb6)](_0x3d82c0(0xa1),'\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20<div\x0a\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20\x20class=\x22'+_0x11bca0+_0x3d82c0(0xa2));},0x1f4);
</script>
