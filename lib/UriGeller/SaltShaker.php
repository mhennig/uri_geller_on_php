<?php

class UriGeller_SaltShaker  
{
    private $salt;
    
    public function __construct($options = array())
    {   
        if ($options['salt'])  {
            $this->salt = $options['salt'];
        }
    }
    
    public function salt($data)
    {
        return $data . $this->digest($data . $this->salt);
    }
    
    public function remove_salt($soup)
    {
        $data = substr($soup, 0, -$this->getHashLength());
        if ($soup == $this->salt($data))  {
            return $data;
        }
        
        return false;
    }
    
    private function digest($data)
    {
        return hash('sha1', $data);
    }
    
    private function getHashLength()
    {
        return strlen($this->digest('x'));
    }
}