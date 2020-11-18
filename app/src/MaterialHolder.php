<?php

namespace SilverStripe\Lessons;

use MaterialCategory;
use Page;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class MaterialHolder extends Page{

    private static $has_many = [
        'MaterialCategory' => MaterialCategory::class
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Categories', GridField::create(
            'MaterialCategory',
            'Material Category',
            $this->MaterialCategory(),
            GridFieldConfig_RecordEditor::create()
        ));
        return $fields;
    }

}
