<?php

namespace SilverStripe\Lessons;

use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Page;
use SilverStripe\Forms\GridField\GridField;

class RegionsPage extends Page{

    private static $has_many = [
        'Regions' => Region::class
    ];

    private static $owns = [
        'Regions'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab('Root.Regions', GridField::create(
            'Region',
            'Region on this page',
            $this->Regions(),
            GridFieldConfig_RecordEditor::create()
        ));

        return $fields;
    }
}