<?php
namespace  ZendeskApiBundle\Services;

interface CurlWrapInterface
{
    public function curlWrap($url, $json, $paramsZendeskApi, $action);
}