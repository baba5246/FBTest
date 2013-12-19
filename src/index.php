<?php
include_once('signed_request.php');
require 'facebook.php';
//●●はさきほどメモしたID等を入れてください
$facebook = new Facebook(array('appId' => '1401797273398300',
                              'secret' => 'cfc1ee8f9e3a513a64cf71b56b0c38b5',
                              'cookie' => true,
                        ));
$fb_user = $facebook->getUser();
//いいねを押しているかどうか判別
  if ( isset($_POST['signed_request']) ) {
    $fb_data = parse_signed_request($_POST['signed_request'], '1401797273398300');
    if( $fb_data['page']['liked'] ){
                //いいねとは別にアプリの権限認証をしているかどうか確認する
                //されていなければ、権限認証画面へ転送する
        if (!$fb_user) {
                //scopeの部分はどこまで権限がほしいか任意設定できる
        $par = array('scope' => 'publish_stream','redirect_uri' => 'https://www.facebook.com/veve5246');
        $fb_login_url = $facebook->getLoginUrl($par);
                //javascriptで転送させないと、間にfacebookのロゴが出てくる減少が起こる
        echo "<script type='text/javascript'>top.location.href = '$fb_login_url';</script>";
        }
      include_once('fan.php');
    } else {
      include_once('notfan.php');
    }
  }
?>
