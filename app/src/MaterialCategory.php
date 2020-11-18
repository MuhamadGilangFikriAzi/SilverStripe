<?php

use SilverStripe\Forms\TextField;
use SilverStripe\Lessons\MaterialHolder;
use SilverStripe\Lessons\MaterialPage;
use SilverStripe\ORM\DataObject;

class MaterialCategory extends DataObject{

    private static $db = [
        'Title' => 'Varchar'
    ];

    private static $has_one = [
        'MaterialHolder' => MaterialHolder::class
    ];

    private static $belongs_many_many = [
        'MaterialPage' => MaterialPage::class
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', TextField::create('Title', 'Input for title'));
        return $fields;
    }
}