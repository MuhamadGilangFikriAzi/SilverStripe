<?php

namespace SilverStripe\Lessons;

use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Page;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\TextField;

class HotelPage extends Page{
    private static $has_many = [
        'Hotel' => Hotel::class
    ];

    private static $owns = [
        'Hotel'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Main', GridField::create(
            'Title',
            'Title Text',
            $this->Hotel(),
            GridFieldConfig_RecordEditor::create()
        ));
        return $fields;
    }
}
