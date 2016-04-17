<?php
namespace CoreBundle\Services;

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
     * @return mixed
     */
    public function curlWrapPost($url, $json, $paramsZendeskApi)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_URL, $paramsZendeskApi['url'].$url);
        curl_setopt($ch, CURLOPT_USERPWD, $paramsZendeskApi['user']."/token:".$paramsZendeskApi['key']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        curl_close($ch);
        $decoded = json_decode($output);
        return $decoded;
    }

    /**
     * @param $url
     * @param $paramsZendeskApi
     * @return mixed
     */
    public function curlWrapDelete($url, $paramsZendeskApi)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_URL, $paramsZendeskApi['url'].$url);
        curl_setopt($ch, CURLOPT_USERPWD, $paramsZendeskApi['user']."/token:".$paramsZendeskApi['key']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        curl_close($ch);
        $decoded = json_decode($output);
        return $decoded;
    }

    /**
     * @param $url
     * @param $json
     * @param $paramsZendeskApi
     * @return mixed
     */
    public function curlWrapPut($url, $json, $paramsZendeskApi)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_URL, $paramsZendeskApi['url'].$url);
        curl_setopt($ch, CURLOPT_USERPWD, $paramsZendeskApi['user']."/token:".$paramsZendeskApi['key']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output = curl_exec($ch);
        curl_close($ch);
        $decoded = json_decode($output);
        return $decoded;
    }
}