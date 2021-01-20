<?php

namespace Octopusz\AliyunSms;

use Octopusz\Sms\Core\DefaultAcsClient;
use Octopusz\Sms\Core\Profile\DefaultProfile;
use Octopusz\Sms\Core\Config;
use Octopusz\Sms\Core\Regions\EndpointConfig;
use Octopusz\Sms\Request\V20170525\QueryInterSmsIsoInfoRequest;
use Octopusz\Sms\Request\V20170525\QuerySendDetailsRequest;
use Octopusz\Sms\Request\V20170525\SendBatchSmsRequest;
use Octopusz\Sms\Request\V20170525\SendInterSmsRequest;
use Octopusz\Sms\Request\V20170525\SendSmsRequest;
use Octopusz\Sms\Core\Regions\EndpointProvider;
use Octopusz\Sms\Core\Regions\Endpoint;

/**
 * Class AliyunIot
 * @package Octopusz\AliyunIot
 */
Config::load();

class AliyunSms
{
    private $_accessKey = '';
    private $_accessSecret = '';
    private $_client = '';


    /**
     * AliyunIot constructor.
     * @param $accessKey
     * @param $accessSecret
     */
    public function __construct($accessKeyId, $accessSecret)
    {
        $this->_accessKey = $accessKeyId;
        $this->_accessSecret = $accessSecret;
        $iClientProfile = DefaultProfile::getProfile("cn-hangzhou", $this->_accessKey, $this->_accessSecret);
        DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", "Dysmsapi", "dysmsapi.aliyuncs.com");
        $this->_client = new DefaultAcsClient($iClientProfile);
    }

    /**
     * 发送验证信息
     * @param $code
     * @param $templateCode
     * @param $phoneNumbers
     * @param $signName
     * @param null $resourceOwnerAccount
     * @param null $templateParam
     * @param null $resourceOwnerId
     * @param null $smsUpExtendCode
     * @return mixed|\SimpleXMLElement
     */
    public function sendSms($code,$templateCode, $phoneNumbers, $signName, $resourceOwnerAccount = null, $templateParam = null, $resourceOwnerId = null, $smsUpExtendCode = null)
    {
        $request = new SendSmsRequest();
        $request->setTemplateCode($templateCode);
        $request->setPhoneNumbers($phoneNumbers);
        $request->setSignName($signName);
        $request->setResourceOwnerAccount($resourceOwnerAccount);
        $request->setTemplateParam(json_encode(array(  // 短信模板中字段的值
            "code" => $code,
        ), JSON_UNESCAPED_UNICODE));
        $request->setResourceOwnerId($resourceOwnerId);
        $request->setSmsUpExtendCode($smsUpExtendCode);
        return $this->_client->getAcsResponse($request);

    }

    /**
     * 发送共享
     * @param $phone
     * @param $content
     * @param $templateCode
     * @param $phoneNumbers
     * @param $signName
     * @param null $resourceOwnerAccount
     * @param null $templateParam
     * @param null $resourceOwnerId
     * @param null $smsUpExtendCode
     * @return mixed|\SimpleXMLElement
     */
    public function sendShareSms($phone, $content, $templateCode, $phoneNumbers, $signName, $resourceOwnerAccount = null, $templateParam = null, $resourceOwnerId = null, $smsUpExtendCode = null)
    {
        $request = new SendSmsRequest();
        $request->setTemplateCode($templateCode);
        $request->setPhoneNumbers($phoneNumbers);
        $request->setSignName($signName);
        $request->setResourceOwnerAccount($resourceOwnerAccount);
        $request->setTemplateParam(json_encode(array(  // 短信模板中字段的值
            "phone" => $phone,
            "content" => $content,
        ), JSON_UNESCAPED_UNICODE));
        $request->setResourceOwnerId($resourceOwnerId);
        $request->setSmsUpExtendCode($smsUpExtendCode);
        return $this->_client->getAcsResponse($request);

    }

    /**
     * 阿里云发送短信
     * @param $phone
     * @param $content
     * @param $templateCode
     * @param $phoneNumbers
     * @param $signName
     * @param null $templateParam
     * @param null $resourceOwnerAccount
     * @param null $resourceOwnerId
     * @param null $smsUpExtendCode
     * @return mixed|\SimpleXMLElement
     */
    public function smsSend($templateCode, $phoneNumbers, $signName,  $templateParam = null, $resourceOwnerAccount = null, $resourceOwnerId = null, $smsUpExtendCode = null)
    {
        $request = new SendSmsRequest();
        $request->setTemplateCode($templateCode);
        $request->setPhoneNumbers($phoneNumbers);
        $request->setSignName($signName);
        $request->setResourceOwnerAccount($resourceOwnerAccount);
        $request->setTemplateParam($templateParam);
        $request->setResourceOwnerId($resourceOwnerId);
        $request->setSmsUpExtendCode($smsUpExtendCode);
        return $this->_client->getAcsResponse($request);

    }
}
