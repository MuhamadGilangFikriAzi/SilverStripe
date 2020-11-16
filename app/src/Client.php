<?php

use SilverStripe\ORM\DataObject;

class Client extends DataObject{

    private static $db = [
        'Name' => 'Varchar(50)',
        'Address' => 'Text'
    ];
}
