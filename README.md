## 概览

一个简单的微信授权工具

## 环境要求

支持的环境如下：

+ PHP >= 8.0

## 安装

推荐使用 PHP 包管理工具 [Composer](https://getcomposer.org/) 安装 SDK：

```shell
composer require module-wechat/oauth
```

## 快速使用
以下代码示例向您展示了助手的调用方法：

```php
<?php

require 'vendor/autoload.php';
use ModuleWechat\Oauth\WechatOauthServer;

// 第一种 .env 中配置appid和secret
WECHAT_APPID=appid
WECHAT_SECRET=secret

$wechat = new WechatOauthServer();

// 第二种 参数传递
$wechat = new WechatOauthServer('appid','secret');

// 获取收取url scope 默认 snsapi_base
$wechat->getAuthUrl('redirect_uri','scope');

// 获取授权access_token
$wechat->getOauthToken('code');
// 返回示例
{
  "access_token": "ACCESS_TOKEN",
  "expires_in": 7200,
  "refresh_token": "REFRESH_TOKEN",
  "openid": "OPENID",
  "unionid": "UNIONID",
  "is_snapshotuser": 1
}

// 获取用户信息
$wechat->getUserInfo('openid','access_token');
// 返回示例
{   
  "openid": "OPENID",
  "nickname": NICKNAME,
  "sex": 1,
  "province":"PROVINCE",
  "city":"CITY",
  "country":"COUNTRY",
  "headimgurl":"https://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46",
  "privilege":[ "PRIVILEGE1" "PRIVILEGE2"     ],
  "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
}

// 获取基础access_token
$wechat->getAccessToken();
// 返回示例
{
  "access_token": "ACCESS_TOKEN",
  "expires_in": 7200
}

// 获取jssdk的临时票据 ticket
$wechat->getTicket('access_token');
// 返回示例
{
  "ticket": "ticket",
  "expires_in": 7200,
  "errcode": "errcode",
  "errmsg": "errmsg"
}

// 获取jssdk的配置
$wechat->getJssdk('url','ticket');
// 返回示例
{
  "nonceStr": "nonceStr",
  "appId": "appId",
  "timestamp": "timestamp",
  "signature": "signature",
  "url": "url"
}

```