<?php

use SilverStripe\ORM\DataObject;

class Product extends DataObject{
    private static $db = [
        'Title' => 'Varchar(100)',
        'Price' => 'Currency'
    ];
}