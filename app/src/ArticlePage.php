<?php

namespace SilverStripe\Lessons;

use Page;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;

class ArticlePage extends Page{
    private static $can_be_root = false;

    private static $db = [
        'Date' => 'Date',
        'Teaser' => 'Text',
        'Author' => 'Varchar'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab('Root.main', DateField::create('Date', 'Date of Article'), 'Content');
        $fields->addFieldsToTab('Root.main', TextareaField::create('Teaser')
            ->setDescription('Teaser for Article'), 'Content'
        );
        $fields->addFieldsToTab('Root.main', TextField::create('Author', 'Author of article'), 'Content');

        return $fields;
    }
}