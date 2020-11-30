<?php

use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class AgentDataGallery extends DataObject{

    private static $db = [
        'Name' => 'Varchar'
    ];

    private static $has_one = [
        'AgentData' => AgentData::class,
        'File' => File::class
    ];

    private static $owns = [
        'File'
    ];

}