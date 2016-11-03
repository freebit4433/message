<?php
/**
 * Created by wenhao.zhang
 * Date: 2016/11/2
 * Time: 22:56
 * Describe: 微信授权登陆封装的类
 */
namespace Home\Controller;
use Think\Controller;

class wechatOauthController extends Controller{

    private $appId = 'wx552c7d04009c6b02';
    private $appSecret = 'd4624c36b6795d1d99dcf0547af5443d';

    public function getUserBaseInfo(){

    }

    public function getUserMoreInfo(){
        //getCode
        $data1 = array(
            'appid' => $this->appId,
            'redirect_uri' => urlencode('http://mika85489.vicp.cc' .U('Index/index')),
            'response_type' => 'code',
            'scope' => 'snsapi_userinfo',
            'state' => 'test.state.com',
        );
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize';
        $url .= '?' . http_build_query($data1) . '#wechat_redirect';
        header('location: ' . $url);
        //code 2 accessToken

        //accessToken & openId 2 userinfo

    }

    public function redirectUri(){
        echo "test";
    }







}



?>