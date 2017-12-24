<?php

namespace Eskirex\Component\HTTP;

use Eskirex\Component\Dotify\Dotify;
use Eskirex\Component\HTTP\Traits\ParseHttpTrait;

class Request
{
    use ParseHttpTrait;


    public function post($get = false)
    {
        return self::getPost($get);
    }


    public function get($get = false)
    {
        return self::getGet($get);
    }


    public function method()
    {
        return self::getMethod();
    }


    public function agent()
    {
        return self::getAgent();
    }


    public function query($get = false)
    {
        return self::getQuery($get);
    }


    public function scheme()
    {
        return self::getScheme();
    }


    public function domain()
    {
        return self::getDomain();
    }


    public function segment($get = false)
    {
        return self::getsSegment($get);
    }


    public function header($get = false)
    {
        return self::getHeader($get);
    }


    public function ipAddressV4()
    {
        return self::extractAddress(FILTER_FLAG_IPV4);
    }


    public function ipAddressV6()
    {
        return self::extractAddress(FILTER_FLAG_IPV6);
    }


    public function device()
    {
        return self::getDevice();
    }


    public function os()
    {
        return self::getOs();
    }


    public function browser()
    {
        return self::getBrowser();
    }
}