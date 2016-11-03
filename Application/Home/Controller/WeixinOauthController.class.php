<?php
/**
 * Created by wenhao.zhang
 * Date: 2016/11/2
 * Time: 22:56
 * Describe: ΢微信授权登陆封装的类
 */
namespace Home\Controller;
use Think\Controller;
use Think\Wechat\WechatOauth;

define( "COOKIE_USER_INFO", 'wxuserinfo' );
define("COOKIE_USER_MORE_INFO", 'wxusermoreinfo');

class WeixinOauthController extends Controller{



    public function getUserBaseInfo(){

    }

    public function getUserMoreInfo(){
        //从cookie里面读取以前微信授权后拿到的用户信息
        $user_info = cookie(COOKIE_USER_MORE_INFO);
        $user_info_array = unserialize( $user_info );
        if(empty($user_info_array)){
            //cookie里面没有用户数据，则调起微信授权
            $wechat_oauth = new WechatOauth();
            $wechat_oauth->jumpToWechatOauth();
            //can not run here,jump to wechat oauth page.
        }else{
            //todo
            //判断用户是否注册，模拟注册和模拟登陆在这个处理

            return $user_info_array;
        }

    }

    public function oauthCallback($code,$state=''){
        echo "test";
        //code 2 access_token

        //access_token & openid 2 userinfo


    }

    private function _getAccessToken(){

    }







}



?>