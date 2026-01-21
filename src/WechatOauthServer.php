<?php
declare(strict_types=1);

namespace ModuleWechat\Oauth;

use ModuleWechat\Common\Config\ConfigUtil;
use ModuleWechat\Common\Config\Request;
use ModuleWechat\Common\Helper\MpOauthInterface;
use ModuleWechat\Common\Server;
use ModuleWechat\Common\WechatServer;

class WechatOauthServer implements MpOauthInterface
{
    protected ConfigUtil $config;
    protected Request $http;
    public function __construct(WechatServer $server)
    {
        $this->config = $server->config;
        $this->http = $server->http;
    }

    /**
     * 获取授权跳转地址
     * @param $redirect_uri
     * @param $scope
     * @param $state
     * @return string
     */
    public function getAuthUrl($redirect_uri, $scope = 'snsapi_base', $state = 'STATE')
    {
        $appid = $this->config->getAppid();
        return sprintf('https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=%s&state=%s#wechat_redirect',$appid,$redirect_uri,$scope,$state);
    }

    /**
     * 换取用户授权凭证
     * @param $code
     * @return mixed
     */
    public function getOauthToken($code)
    {
        return $this->http->request('sns/oauth2/access_token',[
            'appid' => $this->config->getAppid(),
            'secret' => $this->config->getSecret(),
            'code' => $code,
            'grant_type' => 'authorization_code'
        ]);
    }

    /**
     * 获取授权用户信息
     * @param $openid
     * @param $access_token
     * @return mixed
     */
    public function getUserInfo($openid, $access_token)
    {
        return $this->http->request('sns/userinfo',[
            'access_token' => $access_token,
            'openid' => $openid
        ]);
    }

    /**
     * JS-SDK配置
     * @param $url
     * @param $ticket
     * @return array
     */
    public function getJssdk($url, $ticket)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $nonce = substr(str_shuffle($pool),0,10);
        $time = time();
        $str = sprintf('jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s',$ticket,$nonce,$time,$url);
        return [
            'nonceStr' => $nonce,
            'appId' => $this->config->getAppid(),
            'timestamp' => $time,
            'signature' => sha1($str),
            'url' => $url
        ];
    }
}