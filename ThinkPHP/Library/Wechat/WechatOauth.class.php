<?php
/**
 * Created by wenhao.zhang
 * Date: 2016/11/3
 * Time: 15:07
 */
namespace Think\Wechat;

class WechatOauth {
    private $appId = 'wx552c7d04009c6b02';
    private $appSecret = 'd4624c36b6795d1d99dcf0547af5443d';



    public function jumpToWechatOauth(){
        $api = 'https://open.weixin.qq.com/connect/oauth2/authorize';
        $query_data = array(
            'appid' => $this->appId,
            //todo modify redirect_url
            'redirect_uri' => 'http://mika85489.vicp.cc/index.php/Home/WeixinOauth/oauthCallback',
            'response_type' => 'code',
            'scope' => 'snsapi_userinfo',
            'state' => 'test.state',
        );
        $api .= '?' . http_build_query($query_data) . '#wechat_redirect';
        header('location: ' . $api);
    }

}











?>