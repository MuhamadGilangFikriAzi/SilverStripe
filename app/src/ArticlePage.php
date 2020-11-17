<?php

namespace SilverStripe\Lessons;

use City;
use Page;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\DropdownField;

class ArticlePage extends Page{
    private static $can_be_root = false;

    private static $db = [
        'Date' => 'Date',
        'Teaser' => 'Text',
        'Author' => 'Varchar'
    ];

    private static $has_one = [
        'Photo' => Image::class,
        'Brochure' => File::class,
        'Region' => Region::class
    ];

    private static $many_many = [
        'Categories' => ArticleCategory::class
    ];

    private static $owns = [
        'Photo',
        'Brochure'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab('Root.main', DateField::create('Date', 'Date of Article'), 'Content');
        $fields->addFieldsToTab('Root.main', TextareaField::create('Teaser')
            ->setDescription('Teaser for Article'), 'Content'
        );
        $fields->addFieldsToTab('Root.main', TextField::create('Author', 'Author of article'), 'Content');

        $fields->addFieldsToTab('Root.Attachments', $photo = UploadField::create('Photo'));
        $fields->addFieldsToTab('Root.Attachments', $brochure =  UploadField::create('Brochure', 'Travel brochure, optional (PDF ONLY)'));

        $photo->setFolderName('travel-photos');

        $brochure->setFolderName('travel-brochures')->getValidator()->setAllowedExtensions(['pdf']);

        $fields->addFieldsToTab('Root.Categories', CheckboxSetField::create(
            'Categories',
            'selected Categories',
            $this->Parent()->Categories()->map('ID','Title')
        ));

        $fields->addFieldsToTab('Root.Main', DropdownField::create(
            'RegionID',
            'Region',
            Region::get()->map('ID', 'Title')
        )->setEmptyString('-- None --'), 'Content');

        return $fields;
    }

    public function CategoriesList(){
        if($this->Categories()->exists()){
            return implode(', ', $this->Categories()->column('Title'));
        }

        return null;
    }
}