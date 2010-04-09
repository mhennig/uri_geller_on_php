<?php

require_once 'UriGeller/Encoder.php';
require_once 'UriGeller/Decoder.php';

class UriGeller
{   
    
    public static function encode($data, $secret = null)
    {
        $encoder = new UriGeller_Encoder(array('secret' => $secret));
        
        return $encoder->encode($data);
    }
    
    public static function decode($soup, $secret = null)
    {
        $decoder = new UriGeller_Decoder(array('secret' => $secret));
        
        return $decoder->decode($soup);
    }
}
