<?php

use SilverStripe\Forms\CheckboxSetField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\Queries\SQLDelete;
use SilverStripe\ORM\Queries\SQLSelect;

class PropertyData extends DataObject{

    private static $db = [
        'Address' => 'Text',
        'AddressFull' => 'Text',
        'Phone' => 'Varchar(20)',
        'VendorName' => 'Varchar(100)',
        'VendorPhone' => 'Varchar(20)'
    ];

    private static $has_one = [
        'Category' => CategoryData::class
    ];

    private static $has_many = [
        'Agent' => AgentData::class
    ];

    private static $belongs_many_many = [
        'Facility' => FacilityData::class
    ];

    private static $summary_fields = [
        'Address' => "Address",
        'Phone' => "Phone number",
        'VendorName' => "Vendor Name"
    ];

    private static $searchable_fields = [
        'Address',
        'Phone',
        'VendorName'
    ];

    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create('Root'));

        $fields->addFieldToTab('Root.Main', TextField::create('Address', 'Address'));
        $fields->addFieldToTab('Root.Main', TextareaField::create('AddressFull', 'Address Full'));
        $fields->addFieldToTab('Root.Main', TextField::create('Phone', 'Input Phone number'));
        $fields->addFieldToTab('Root.Main', TextField::create('VendorName', 'Input Vendor Name'));
        $fields->addFieldToTab('Root.Main', TextField::create('VendorPhone', 'Input Vendor phone'));
        $fields->addFieldToTab('Root.Category', DropdownField::create(
            'CategoryID',
            'Select Category',
            CategoryData::get()->map('ID', 'Name')
        )->setEmptyString('-- select category --'));
        $fields->addFieldToTab('Root.Facility', CheckboxSetField::create(
            'Facility',
            'Select Facility',
            FacilityData::get()->map('ID', 'Name')
        ));
        return $fields;
    }

    function deleteFacility($id){
        $query = DB::query("DELETE from FacilityData_PropertyData where PropertyDataID = ".$id." ");

        return $query;
    }

}
