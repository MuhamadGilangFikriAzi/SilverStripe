<?php

use SilverStripe\Assets\Image;
use Embed\Adapters\File;
use SilverStripe\Assets\File as AssetsFile;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class AgentData extends DataObject{

    private static $db = [
        'Name' => 'Varchar(100)',
        'Address' => 'Text',
        'Phone' => 'Varchar(20)',
        'Delete' => 'Int',
        'Salary' => 'Double'
    ];

    private static $has_one = [
        'PropertyData' => PropertyData::class,
        'File' => AssetsFile::class
    ];

    private static $has_many = [
        'Images' => Image::class
    ];

    private static $summary_fields = [
        'Name',
        'Address',
        'Phone'
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create('Root'));
        $fields->addFieldToTab('Root.Main', TextField::create('Name', 'Input Name'));
        $fields->addFieldToTab('Root.Main', TextareaField::create('Address', 'Input Address'));
        $fields->addFieldToTab('Root.Main', TextField::create('Phone', 'Input Phone'));

        return $fields;
    }
}