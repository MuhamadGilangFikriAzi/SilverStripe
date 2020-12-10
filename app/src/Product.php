<?php

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\CurrencyField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\ValidationException;

class Product extends DataObject {

    private static $db = [
        'Name' => 'Varchar',
        'Date' => 'Date',
        'Qty' => 'Int',
        'Price' => 'Int',
        'Description' => 'Text',
        'Status' => 'Int'
    ];

    private static $defaults = [
        'Status' => 1
    ];

    private static $has_one = [
        'Image' => Image::class
    ];

    private static $owns = [
        'Image'
    ];

    private static $summary_fields = [
        'Name' => 'Nama',
        'DateDisplay' => 'Tanggal',
        'Qty' => 'Kuantitas',
        'PriceDisplay' => 'Harga',
        'Description' => 'Deskripsi',
        'StatusDisplay' => 'Status'
    ];

    private static $searchable_fields = [
        'Name',
        'Date',
        'Qty',
        'Price',
        'Description',
        'Status'
    ];

    public function getDateDisplay(){
        return date('d/m/yy', strtotime($this->Date));
    }

    public function getPriceDisplay(){
        return number_format($this->Price, 0, ",", ".");
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create('Root'));
        $fields->addFieldToTab('Root.Main', TextField::create('Name','Name'));
        $fields->addFieldToTab('Root.Main', DateField::create('Date','Date'));
        $fields->addFieldToTab('Root.Main', NumericField::create('Qty','Qty'));
        $fields->addFieldToTab('Root.Main', CurrencyField::create('Price','Price'));
        $fields->addFieldToTab('Root.Main', TextareaField::create('Description'));
        $fields->addFieldToTab('Root.Main', $upload = UploadField::create('Image','Image'));
        $fields->addFieldToTab('Root.Main', OptionsetField::create('Status', 'status', array("1" => "Aktif", "2" => "Non Aktif"), 1));

        $upload->setAllowedExtensions('jpg','png','jpeg','img');

        return $fields;
    }

    static $statusLabel = [
        2 => 'Tidak Aktif',
        1 => 'Aktif',
    ];

    public function getStatusDisplay(){
        if(empty($this->Status))
            return self::$statusLabel[1];
        return self::$statusLabel[$this->Status];
    }

    public function onBeforeWrite()
    {
        $id =  $this->record['ID'];
        $name = $this->record['Name'];
        $data = Product::get()->where("Name = '{$name}'")->toNestedArray();
        if(!empty($data) && $id == 0){
            throw new ValidationException('Nama telah digunakan');
        }
        parent::onBeforeWrite();
    }

    // public function onBeforeDelete()
    // {
    //     $id = $this->record['ID'];
    //     $data = TransactionDetail::get()->where("ProductID = '{$id}'");

    //     if(!empty($data)){
    //         throw new ValidationException('Data masih digunakan di transaksi lain');
    //     }

    //     parent::onBeforeDelete();
    // }
}