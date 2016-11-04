<?php
/**
 * Created by wenhao.zhang
 * Date: 2016/11/2
 * Time: 22:56
 * Describe: ΢微信授权登陆封装的类
 */
namespace Home\Controller;
use Think\Controller;
//use Oauth\Wechat\WechatOauth;

define( "COOKIE_USER_INFO", 'wxuserinfo' );
define("COOKIE_USER_MORE_INFO", 'wxusermoreinfo');

class WeixinOauthController extends Controller{
    private $appId = 'wx552c7d04009c6b02';
    private $appSecret = 'd4624c36b6795d1d99dcf0547af5443d';

    public function getUserBaseInfo(){
        $user_info = cookie(COOKIE_USER_INFO);
        $user_info_array = unserialize( $user_info );
        if(empty($user_info_array)){
            $this->_jumpToWechatOauth('snsapi_base');
        }
    }

    public function getUserMoreInfo(){
        //从cookie里面读取以前微信授权后拿到的用户信息
        $user_info = cookie(COOKIE_USER_MORE_INFO);
        $user_info_array = unserialize( $user_info );
        if(empty($user_info_array)){
            //cookie里面没有用户数据，则调起微信授权
            $this->_jumpToWechatOauth('snsapi_userinfo');
            //can not run here,jump to wechat oauth page.
        }else{
            //todo
            //判断用户是否注册，模拟注册和模拟登陆在这个处理

            return $user_info_array;
        }

    }

    public function oauthBaseCallback($code,$state=''){
        //code 2 access_token
        if(isset($code)){
            $data = $this->_getAccessToken($code);
            //access_token & openid 2 userinfo
            dump($data);


        }else{
            $this->error('获取授权失败!','User/index');
        }
    }

    public function oauthMoreCallback($code,$state=''){
        if(isset($code)){
            //code 2 access_token
            $access_token_data = $this->_getAccessToken($code);
            //access_token & openid 2 userinfo
            $user_info = $this->_getUserInfoByOauth($access_token_data);



        }else{
            $this->error('获取授权失败!','User/index');
        }
    }

    private function _jumpToWechatOauth($scope){
        $api = 'https://open.weixin.qq.com/connect/oauth2/authorize';
        switch($scope){
            case 'snsapi_base':{
                $redirect_uri = 'http://mika85489.vicp.cc/tpproject/message/index.php/Home/WeixinOauth/oauthBaseCallback';
                break;
            }
            case 'snsapi_userinfo':{
                $redirect_uri = 'http://mika85489.vicp.cc/tpproject/message/index.php/Home/WeixinOauth/oauthMoreCallback';
                break;
            }
        }
        $query_data = array(
            'appid' => $this->appId,
            'redirect_uri' => $redirect_uri,
            'response_type' => 'code',
            'scope' => $scope,
            'state' => 'test.state.1',
        );
        $api .= '?' . http_build_query($query_data) . '#wechat_redirect';
        header('location: ' . $api);
    }

    private function _getAccessToken($code){
        $api = 'https://api.weixin.qq.com/sns/oauth2/access_token';
        $query_data = array(
            'appid' => $this->appId,
            'secret' => $this->appSecret,
            'code' => $code,
            'grant_type' => 'authorization_code'
        );
        $api .= '?' . http_build_query($query_data);
        $re = file_get_contents($api);
        return json_decode($re);
    }

    private function _getUserInfoByOauth($data){
        $api = 'https://api.weixin.qq.com/sns/userinfo';
        $query_data = array(
            'access_token' => $data['access_token'],
            'openid' => $data['openid'],
            'lang' => 'zh_CN'
        );
        $api .= '?' . http_build_query($query_data);
        $user_info = file_get_contents($api);
        return json_decode($user_info);
    }






}



?>