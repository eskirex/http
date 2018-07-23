<?php

namespace Eskirex\Component\HTTP\Traits;

use Eskirex\Component\Dotify\Dotify;
use Eskirex\Component\HTTP\Exceptions\RuntimeException;

trait ParseHttpTrait
{
    protected static function getPost($get = false)
    {
        if (!isset($_POST) || empty($_POST)) {
            return null;
        }

        $data = new Dotify($_POST);

        if ($get !== false) {
            return $data->get($get);
        }

        return $data->get();
    }


    protected static function getGet($get = false)
    {
        if (!isset($_GET) || empty($_GET)) {
            return null;
        }

        $data = new Dotify($_GET);

        if ($get !== false) {
            return $data->get($get);
        }

        return $data->all();
    }


    protected static function getMethod()
    {
        if (!isset($_SERVER['REQUEST_METHOD']) || empty($_SERVER['REQUEST_METHOD'])) {
            return null;
        }

        return ucfirst($_SERVER['REQUEST_METHOD']);
    }


    protected static function getAgent()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT']) || empty($_SERVER['HTTP_USER_AGENT'])) {
            return null;
        }

        return $_SERVER['HTTP_USER_AGENT'];
    }


    protected static function getQuery($get = false)
    {
        $parsedUrl = self::getUrl(true);
        if(!isset($parsedUrl['query'])){
            return null;
        }

        parse_str($parsedUrl['query'], $query);

        $data = new Dotify($query);

        if ($get !== false) {
            return $data->get($get);
        }

        return $data->all();
    }


    protected static function getScheme()
    {
        if (isset($_SERVER['REQUEST_SCHEME']) && !empty($_SERVER['REQUEST_SCHEME'])) {
            return $_SERVER['REQUEST_SCHEME'];
        }

        $parsedUrl = new Dotify(self::getUrl(true));

        return $parsedUrl->get('scheme');
    }


    protected static function getDomain()
    {
        $parsedUrl = new Dotify(self::getUrl(true));

        return $parsedUrl->get('host');
    }


    protected static function getsSegment($get = false)
    {
        $parsedUrl = new Dotify(self::getUrl(true));

        $request = substr($parsedUrl->get('path'), 1);
        $request = trim($request);
        $request = explode('/', $request);
        $request = array_values(array_filter($request));

        if (empty($request)) {
            return null;
        }

        $data = new Dotify($request);

        if ($get !== false) {
            return $data->get($get);
        }

        return $data->all();
    }


    protected static function getHeader($get = false)
    {
        if (empty(getallheaders())) {
            return null;
        }

        $data = new Dotify(getallheaders());

        if ($get !== false) {
            return $data->get($get);
        }

        return $data->all();
    }


    protected static function getUrl($parse = false)
    {
        if (!self::getMethod()) {
            return null;
        }

        $protocol = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
        $phpSelf = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
        $pathInfo = $_SERVER['PATH_INFO'] ?? '';
        $relateURL = $_SERVER['REQUEST_URI'] ?? $phpSelf . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : $pathInfo);
        $serverName = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'];

        $full = $protocol . $serverName . $relateURL;

        return $parse ? parse_url($full) : $full;
    }


    protected static function extractAddress($ipVersion)
    {
        $address = self::getIpAddress();
        if (filter_var($address, FILTER_VALIDATE_IP, $ipVersion)) {
            return $address;
        }

        return false;
    }


    protected static function getIpAddress()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') === false
                ? $_SERVER['HTTP_X_FORWARDED_FOR']
                : explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
            return $_SERVER['HTTP_X_FORWARDED'];
        }

        if (!empty($_SERVER['HTTP_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_FORWARDED_FOR'];
        }

        if (!empty($_SERVER['HTTP_FORWARDED'])) {
            return $_SERVER['HTTP_FORWARDED'];
        }

        if (!empty($_SERVER['REMOTE_ADDR'])) {
            return $_SERVER['REMOTE_ADDR'];
        }

        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            return $_SERVER["HTTP_CF_CONNECTING_IP"];
        }

        return false;
    }


    protected static function getDevice()
    {
        $userAgent = strtolower(self::getAgent());
        if (strpos($userAgent, 'windows nt')) {
            return 'PC';
        }
        if (strpos($userAgent, 'mac os')) {
            return 'PC';
        }
        if (strpos($userAgent, 'iphone')) {
            return 'Mobile';
        }
        if (strpos($userAgent, 'android')) {
            return 'Mobile';
        }
        if (strpos($userAgent, 'ipad')) {
            return 'Pad';
        }

        return 'Unknown';
    }


    protected static function getOs()
    {
        $userAgent = strtolower(self::getAgent());
        if (preg_match('/win/i', $userAgent)) {
            return 'Windows';
        }
        if (preg_match('/mac/i', $userAgent)) {
            return 'MAC';
        }
        if (preg_match('/linux/i', $userAgent)) {
            return 'Linux';
        }
        if (preg_match('/unix/i', $userAgent)) {
            return 'Unix';
        }
        if (preg_match('/bsd/i', $userAgent)) {
            return 'BSD';
        }
        if (preg_match('/iphone/i', $userAgent)) {
            return 'iOS';
        }
        if (preg_match('/android/i', $userAgent)) {
            return 'Android';
        }
        if (preg_match('/ipad/i', $userAgent)) {
            return 'iOS';
        }

        return 'Unknown';
    }


    protected static function getBrowser()
    {
        $userAgent = strtolower(self::getAgent());

        if (preg_match('/MSIE/i', $userAgent)) {
            return 'MSIE';
        }
        if (preg_match('/Firefox/i', $userAgent)) {
            return 'Firefox';
        }
        if (preg_match('/Chrome/i', $userAgent)) {
            return 'Chrome';
        }
        if (preg_match('/Safari/i', $userAgent)) {
            return 'Safari';
        }
        if (preg_match('/Opera/i', $userAgent)) {
            return 'Opera';
        }

        return 'Unknown';
    }
}