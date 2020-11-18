<?php

namespace SilverStripe\Lessons;

use MaterialCategory;
use SilverStripe\Assets\Image;
use Page;
use SebastianBergmann\CodeCoverage\Report\Text;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextField;

class MaterialPage extends Page{

    private static $db = [
        'Title' => 'Varchar',
        'Date' => 'Date',
        'Code' => 'Int'
    ];

    private static $has_one = [
        'Image' => Image::class,
    ];

    private static $many_many = [
        'MaterialCategory' => MaterialCategory::class
    ];

    private static $owns = [
        'Image'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Content', TextField::create('Code', 'Input Code Here'));
        $fields->addFieldToTab('Root.Content', TextField::create('Title','Input Title here'));
        $fields->addFieldToTab('Root.Content', DateField::create('Date', 'Input Date'));
        $fields->addFieldToTab('Root.Image', $uploaded = UploadField::create('Image', 'Upload image'));
        $fields->addFieldToTab('Root.Categories', CheckboxSetField::create(
            'MaterialCategory',
            'Check Category',
            $this->Parent()->MaterialCategory()->map('ID','Title')
        ));

        $uploaded->setFolderName('Image-Material');
        $uploaded->setAllowedExtensions('png','jpg','jpeg', 'gif');

        return $fields;
    }

    public function CategoriesList(){
        if($this->MaterialCategory()->exists()){
            return implode(', ', $this->MaterialCategory()->column('Title'));
        }

        return null;
    }
}