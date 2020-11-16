<?php

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Lessons\CityPage;
use SilverStripe\Lessons\ClientPage;
use SilverStripe\ORM\DataObject;

class City extends DataObject{

    private static $db = [
        'Name' => 'Varchar(100)'
    ];

    private static $has_one = [
        'Image' => Image::class,
        'CityPage' => CityPage::class,
    ];

    private static $belongs_many_many = [
        'ClientPage' => ClientPage::class
    ];

    private static $owns = [
        'Image'
    ];


    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create('Name', 'Input city name'),
            $uploader = UploadField::create('Image'),
        );

        $uploader->setFolderName('city-Images');
        $uploader->getValidator()->setAllowedExtensions('png','jpeg','jpg');

        return $fields;
    }

}

