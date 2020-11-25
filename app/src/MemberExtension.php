<?php

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataExtension;

class MemberExtension extends DataExtension{

    private static $searchable_fields = [
        'FirstName',
        'Email'
    ];

    private static $summary_fields = [
        'FirstName',
        'Email'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName("Surname");
        $fields->removeByName("Locale");
        $fields->removeByName('FailedLoginCount');
        $fields->removeByName("Permissions");
        $fields->push(LiteralField::create('tes'.'Password Minimal 8 Karakter'));
    }



}