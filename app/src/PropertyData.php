<?php

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class PropertyData extends DataObject{

    private static $db = [
        'Title' => 'Varchar',
        'Address' => 'Varchar',
        'Phone' => 'Varchar'
    ];

    private static $has_one = [
        'Image' => Image::class

   ];

    private static $owns = [
        'Image'
    ];

    private static $summary_fields = [
        'Title' => 'Name',
        'Address' => 'Address',
        'Phone' => 'Phone'
    ];

    private static $searchable_fields = [
        'Title',
        'Address',
        'Phone'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->addFieldToTab('Root.Main', $phone = TextField::create('Phone', 'Phone'));

        $fields->addFieldToTab('Root.Image', $uploaded = UploadField::create('Image', 'Input image here'));
        $uploaded->setFolderName('propertyData-images');
        $uploaded->setAllowedExtensions(array('png', 'jpg', 'jpeg', 'gif'));

        return $fields;
    }
}