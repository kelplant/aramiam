<?php
namespace ZendeskApiBundle\Services;

/**
 * Class CurlWrap
 * @package CoreBundle\Services
 */
class CurlWrap
{
    /**
     * @param $url
     * @param $json
     * @param $paramsZendeskApi
     * @param $action
     * @return mixed
     */
    public function curlWrap($url, $json, $paramsZendeskApi, $action)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_URL, $paramsZendeskApi['url'].$url);
        curl_setopt($ch, CURLOPT_USERPWD, $paramsZendeskApi['user']."/token:".$paramsZendeskApi['key']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $action);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output);
    }
}