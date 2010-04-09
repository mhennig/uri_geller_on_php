<?php

require dirname(__FILE__ ) . '/../lib/UriGeller.php';

class UriGellerTest extends PHPUnit_Framework_TestCase
{
    protected $encoder, $decoder, $data;
    
    public function setUp()
    {
        $this->encoder = new UriGeller_Encoder(array('secret' => 'my-secret'));
        $this->decoder = new UriGeller_Decoder(array('secret' => 'my-secret'));
        $this->data    = array('name' => 'Matthias Hennig', 'age' => 10, 'birthdate' => true);
    }
    
    // Means: "it generates same output for same input"
    public function testSameOutputForSameInput()
    {
        $firstTry  = UriGeller::encode($this->data, 'my-secret');
        $secondTry = UriGeller::encode($this->data, 'my-secret');
        $this->assertEquals($firstTry, $secondTry);
    }
    
    // Means: "it spits out what came in"
    public function testInputEqualsOutputLoop()
    {
        $encodedThenDecoded = UriGeller::decode(UriGeller::encode($this->data));
        $this->assertEquals($this->data, $encodedThenDecoded);
    }
    
    // Means: "it can not decode when data was changed"
    public function testDataIntegrity()
    {
        $encoded = UriGeller::encode($this->data);
        $decoded = UriGeller::decode("changed " . $encoded);
        $this->assertNull($decoded);
    }
    
    // Means: "it can not decode with a wrong secret"
    public function testDataSecurity()
    {
        $encoded = UriGeller::encode($this->data, 'not-the-standard-key');
        $decoded = UriGeller::decode($encoded, 'try-a-random-key');
        $this->assertNull($decoded);
    }
    
    // @todo
    // Means "it produces strings that are url-conform"
    public function testUrlConformity()
    {
        $encoded = UriGeller::encode($this->data);
        $this->assertEquals($encoded, $encoded);
    }
}