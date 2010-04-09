<?php

require_once 'SaltShaker.php';

class UriGeller_Encoder 
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
    
    public function encode($data)
    {
        $serialized = $this->serialize($data);
        $compressed = $this->compress($serialized);
        $crypted    = $this->crypt($compressed);
        
        return $crypted;
    }
    
    private function serialize($data)
    {
        return json_encode((array) $data);
    }
    
    private function compress($data)
    {
        $deflated    = gzdeflate($data);
        $sixtyFourd  = base64_encode($deflated);
        $urlEncoded  = urlencode($sixtyFourd);
        
        return $urlEncoded;
    }
    
    private function crypt($data)
    {
        if (!$this->saltShaker)  {
            $this->saltShaker = new UriGeller_SaltShaker(array('salt' => $this->secret));
        }

        return $this->saltShaker->salt($data);
    }
}