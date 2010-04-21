<?php
    require_once('lib/UriGeller.php');
    $value =  UriGeller::assertion();
    $compressed =  UriGeller::encode($value, "test-123");
    echo $compressed;
    // echo "\n";
    //     echo "\n";
    //     echo strlen($compressed);
    //     echo "\n";
    //     echo "\n";
    //     $decoded = UriGeller::decode($compressed, "test-123");
    //     var_dump($decoded);
    //     echo "\n";