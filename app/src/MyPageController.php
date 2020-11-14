<?php

namespace My\App;

use PageController;
use Psr\Log\LoggerInterface;

class MyPageController extends PageController{
    private static $dependencies = [
        'logger' => '%$'.LoggerInterface::class
    ];

    protected $shouldFail = true;

    public $logger;

    public function doSomething(){
        if ($this->shouldFail){
            $this->logger->log('It failed');
        }
    }
}
