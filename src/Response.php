<?php

namespace Eskirex\Component\HTTP;

class Response
{
    /**
     * @var Array
     */
    public $header;


    public function header(Array $header)
    {
        if (is_array($header)) {
            foreach ($header as $key => $item) {
                if (strtolower($key) === 'status') {
                    header(http_response_code($item), true, $item);
                } else {
                    header("$key:$item", true);
                }
            }
        }
        
        return $this;
    }


    public function send($data)
    {
        echo $data;
    }
}