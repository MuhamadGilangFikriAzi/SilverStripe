<?php

use SilverStripe\ORM\DataObject;

class FacilityData extends DataObject{

    private static $db = [
        'Name' => 'Varchar(100)'
    ];
}