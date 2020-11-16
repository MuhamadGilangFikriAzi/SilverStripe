<?php

namespace SilverStripe\Lessons;

use City;
use Page;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\CheckboxSetField;

class ClientPage extends Page
{

    private static $many_many = [
        'City' => City::class,
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab('Root.City', CheckboxSetField::create(
            'City',
            'Select City',
            City::get()->map('ID','Name')
        ));

        return $fields;
    }

}
