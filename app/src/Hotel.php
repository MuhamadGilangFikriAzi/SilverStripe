<?php

namespace SilverStripe\Lessons;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

class Hotel extends DataObject{

    private static $db = [
        'Title' => 'Varchar',
        'Bedroom' => 'Int',
        'Bathroom' => 'Int',
        'Price' => 'Double'
    ];

    private static $has_one = [
        'HotelPage' => HotelPage::class,
        'Picture' => Image::class
    ];

    private static $summary_allowed = [
        'Title' => 'Title',
        'Bedroom' => 'Bedroom',
        'Bathroom' => 'Bathroom',
        'Price' => 'Price'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        return $fields;
    }
}
