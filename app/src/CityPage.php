<?php

namespace SilverStripe\Lessons;

use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use City;
use Page;
use SilverStripe\Forms\GridField\GridField;

class CityPage extends Page{

    private static $has_many = [
        'City' => City::class
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.City', GridField::create(
            'City',
            'City',
            $this->City(),
            GridFieldConfig_RecordEditor::create()
        ));

        return $fields;
    }
}
