<?php

namespace SilverStripe\Lessons;

use City;
use Page;
use SilverStripe\Forms\CheckboxField;

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
        $fields->addFieldsToTab('Root.City', CheckboxField::create(
            'City',
            'Select City',
            $this->City()->map('ID', 'Name')
        ));

        return $fields;
    }

}