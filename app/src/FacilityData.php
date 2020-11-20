<?php

use Bramus\Ansi\ControlFunctions\Tab;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class FacilityData extends DataObject{

    private static $db = [
        'Name' => 'Varchar(100)'
    ];

    private static $many_many = [
        'PropertyData' => PropertyData::class
    ];

    private static $summary_fields = [
        'Name'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create('Root'));
        $fields->addFieldToTab('Root.Main', TextField::create('Name', 'Input Name'));

        return $fields;
    }
}