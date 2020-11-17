<?php

namespace SilverStripe\Lessons;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Upload;
use SilverStripe\Forms\CurrencyField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class Hotel extends DataObject{

    private static $db = [
        'Title' => 'Varchar',
        'Bedroom' => 'Int',
        'Bathroom' => 'Int',
        'Price' => 'Double'
    ];

    private static $has_one = [
        'HotelPage' => HotelPage::class,
        'Picture' => Image::class
    ];

    private static $summary_allowed = [
        'Title' => 'Title',
        'Bedroom' => 'Bedroom',
        'Bathroom' => 'Bathroom',
        'Price' => 'Price'
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create('Root'));
        $fields->addFieldsToTab([
            TextField::create('Title'),
            NumericField::create('Bedroom'),
            NumericField::create('Bathroom'),
            CurrencyField::create('Price')
        ]);

        $fields->addFieldToTab('Root.Picture', UploadField::create('Picture'));

        return $fields;
    }
}