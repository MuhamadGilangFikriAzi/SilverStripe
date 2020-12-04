<?php

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\CurrencyField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;

class Product extends DataObject {

    private static $db = [
        'Name' => 'Varchar',
        'Date' => 'Date',
        'Qty' => 'Int',
        'Price' => 'Int',
        'Description' => 'Text'
    ];

    private static $has_one = [
        'Image' => Image::class
    ];

    private static $owns = [
        'Image'
    ];

    private static $summary_fields = [
        'Name' => 'Nama',
        'Date' => 'Tanggal',
        'Qty' => 'Kuantitas',
        'Price' => 'Harga',
        'Description' => 'Deskripsi'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create('Root'));
        $fields->addFieldToTab('Root.Main', TextField::create('Name','Name'));
        $fields->addFieldToTab('Root.Main', DateField::create('Date','Date'));
        $fields->addFieldToTab('Root.Main', NumericField::create('Qty','Qty'));
        $fields->addFieldToTab('Root.Main', CurrencyField::create('Price','Price'));
        $fields->addFieldToTab('Root.Main', TextareaField::create('Description'));
        $fields->addFieldToTab('Root.Main', $upload = UploadField::create('Image','Image'));

        $upload->setAllowedExtensions('jpg','png','jpeg','img');

        return $fields;
    }
}