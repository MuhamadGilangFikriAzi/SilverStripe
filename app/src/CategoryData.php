<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class CategoryData extends DataObject{

    private static $db = [
        'Name' => 'Varchar(100)'
    ];

    private static $has_many = [
        'PropertyData' => PropertyData::class
    ];


    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create('Root'));
        $fields->addFieldToTab('Root.Main', TextField::create('Name', 'Input Name'));

        return $fields;
    }
}
