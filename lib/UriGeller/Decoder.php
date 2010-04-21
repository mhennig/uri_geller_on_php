<?php

require_once 'SaltShaker.php';

class UriGeller_Decoder 
{
    private 
        $secret = "my-secret-phrase",
        $saltShaker = null;
    
    public function __construct($options = array())
    {
        if (isset($options['secret']))  {
            $this->secret = $options['secret'];
        }
    }
    
    public function decode($soup)
    {
        $data = null;
        if ($compressed = $this->decrypt($soup))  {
            $serialized = $this->extract($compressed);
            $data       = $this->unserialize($serialized);
        }  
        
        return $data;
    }
    
    private function unserialize($data)
    {
        return (array) json_decode($data);
    }
    
    private function extract($soup)
    {
        $unescaped   = $this->unescape($soup);
        $compressed  = base64_decode($unescaped);
        $data        = gzuncompress($compressed);
        return $data;
    }
    
    private function unescape($soup)
    {
        return strtr($soup, '-_,', '+/=');
    }
    
    private function decrypt($soup)
    {
        if ($this->saltShaker == null)  {
            $this->saltShaker = new UriGeller_SaltShaker(array('salt' => $this->secret));
        }
        return $this->saltShaker->remove_salt($soup);
    }
}