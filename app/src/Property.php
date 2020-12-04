<?php

namespace SilverStripe\Lessons;

use GuzzleHttp\Psr7\DroppingStream;
use SebastianBergmann\CodeCoverage\Report\Text;
use SebastianBergmann\Version;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\CurrencyField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DateField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ArrayLib;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

class Property extends DataObject{

    private static $db = [
        'Title' => 'Varchar',
        'PricePerNight' => 'Currency',
        'Bedrooms' => 'Int',
        'Bathrooms' => 'Int',
        'FeaturedOnHomepage' => 'Boolean',
        'Description' => 'Text',
        'AvailableStart' => 'Date',
        'AvailableEnd' => 'Date'
    ];

    private static $has_one = [
        'Region' => Region::class,
        'PrimaryPhoto' => Image::class
    ];

    private static $summary_fields = [
      'Title' => 'Title',
      'Region.Title' => 'Region',
      'PricePerNight.Nice' => 'Price',
      'FeaturedOnHomepage.Nice' => 'Featured?'
    ];

    private static $searchable_fields = [
        'Title',
        'Region.Title',
        'FeaturedOnHomepage'
    ];


    private static $owns = [
        'PrimaryPhoto'
    ];

    private static $extensions = [
        Versioned::class
    ];

    private static $versioned_gridfield_extensions = true;

    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create('Root'));

        $fields->addFieldsToTab('Root.Main', TextField::create('Title'));
        $fields->addFieldsToTab('Root.Main', TextareaField::create('Description'));
        $fields->addFieldsToTab('Root.Main', CurrencyField::create('PricePerNight','Price (Per Night)'));
        $fields->addFieldsToTab('Root.Main', DropdownField::create('Bedrooms')
            ->setSource(ArrayLib::valuekey(range(1,10)))
        );
        $fields->addFieldsToTab('Root.Main', DropdownField::create('Bathrooms')->setSource(ArrayLib::valuekey(range(1,10))));
        $fields->addFieldsToTab('Root.Main', DropdownField::create('RegionID','Region')->setSource(ArrayLib::valuekey(range(1,10))));
        $fields->addFieldsToTab('Root.Main', CheckboxField::create('FeaturedOnHomepage', 'Featured on Homepage'));
        // $fields->addFieldToTab('Root.Main', [
        //     TextField::create('Title'),
        //     CurrencyField::create('PricePerNight','Price (Per night)'),
        //     DropdownField::create('Bedrooms')
        //         ->setSource(ArrayLib::valuekey(range(1,10))),
        //     DropdownField::create('Bathrooms')
        //         ->setSource(ArrayLib::valuekey(range(1,10))),
        //     DropdownField::create('RegionID', 'Region')
        //         ->setSource(Region::get()->map('ID', 'Title')),
        //     CheckboxField::create('FeaturedonHomepage','Featured on Homepage')
        // ]);

        $fields->addFieldToTab('Root.Photos', $upload = UploadField::create(
            'PrimaryPhoto',
            'Primary photo'
        ));

        $fields->addFieldsToTab('Root.Main', DateField::create('AvailableStart', 'Date available (start)'));
        $fields->addFieldsToTab('Root.Main', DateField::create('AvailableEnd', 'Date available (end)'));

        $upload->getValidator()->getAllowedExtensions(array(
            'png','jpeg','jpg','gif'
        ));

        $upload->setFolderName('property-photos');

        return $fields;
    }

    public function searchableFields()
    {
        return [
            'Title' => [
                'filter' => 'PartialMatchFilter',
                'title' => 'Title',
                'field' => TextField::class,
            ],
            'RegionID' => [
                'filter' => 'ExactMatchFilter',
                'title' => 'Region',
                'field' => DropdownField::create('RegoinID')
                    ->setSource(
                        Region::get()->map('ID','Title')
                    )
                    ->setEmptyString('-- Any Region ---')
            ],
            'FeaturedOnHomepage' => [
                'filter' => 'ExactMatchFilter',
                'title' => 'Only Featured'
            ]
            ];
    }
}
