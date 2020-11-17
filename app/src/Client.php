<?php

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class Client extends DataObject{

    private static $db = [
        'Name' => 'Varchar(50)',
        'Address' => 'Text'
    ];

    private static $has_one = [
        'Picture' => Image::class
    ];
}
