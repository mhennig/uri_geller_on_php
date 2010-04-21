<?php

require dirname(__FILE__ ) . '/../lib/UriGeller.php';

class UriGellerTest extends PHPUnit_Framework_TestCase
{
    protected $encoded, $decoded, $secret;
    
    public function setUp()
    {
        $this->secret  = "test-123";
        $this->decoded = array("name" => "John Doe", "score" => "1001", "deposit" => "98.76", "comment" => "ÄÖÜäöü123=", "birthdate" => "1979/05/07");
        $this->encoded = "eyJjb21tZW50IjoiXHUwMGM0XHUwMGQ2XHUwMGRjXHUwMGU0XHUwMGY2XHUwMGZjMTIzPSIsImJpcnRoZGF0ZSI6IjE5NzkvMDUvMDciLCJzY29yZSI6IjEwMDEiLCJuYW1lIjoiSm9obiBEb2UiLCJkZXBvc2l0IjoiOTguNzYifQ,,6db974f86d9ea3a23477514dd44af57700f0556f";
    }
    
    
    // Means: "it generates predictable decoded output"
    public function testPredictableDecoding()
    {
        $decoded = UriGeller::decode($this->encoded, $this->secret);
        $this->assertEquals($decoded, $this->decoded);
    }
    
    // Means: "it generates same output for same input"
    public function testSameOutputForSameInput()
    {
        $firstTry  = UriGeller::encode($this->decoded, $this->secret);
        $secondTry = UriGeller::encode($this->decoded, $this->secret);
        $this->assertEquals($firstTry, $secondTry);
    }
    
    // Means: "it spits out what came in"
    public function testInputEqualsOutputLoop()
    {
        $encodedThenDecoded = UriGeller::decode(UriGeller::encode($this->decoded, $this->secret), $this->secret);
        $this->assertEquals($this->decoded, $encodedThenDecoded);
    }
    
    // Means: "it can not decode when data was changed"
    public function testDataIntegrity()
    {
        $encoded = UriGeller::encode($this->decoded, $this->secret);
        $decoded = UriGeller::decode("changed " . $encoded, $this->secret);
        $this->assertNull($decoded);
    }
    
    // Means: "it can not decode with a wrong secret"
    public function testDataSecurity()
    {
        $encoded = UriGeller::encode($this->decoded, $this->secret);
        $decoded = UriGeller::decode($encoded, 'try-a-random-key');
        $this->assertNull($decoded);
    }
    
    // @todo
    // Means "it produces strings that are url-conform"
    public function testUrlConformity()
    {
        $encoded = UriGeller::encode($this->decoded, $this->secret);
        $this->assertEquals($encoded, $encoded);
    }
    
    //Means "it prints out its version if you ask for"
    public function testVersion()
    {
        $this->assertNotNull(UriGeller::version());
    }
    
}