<?php

use SilverStripe\Forms\HiddenField;
use SilverStripe\ORM\DataExtension;

class MyMemberExtension extends DataExtension
{
    protected function apiCall(){
        $myAPIClient->getUser($this->owner->getName());
    }

    public function getMemberFormFields(){
        $someData = $this->apiCall();

        $this->extends('updateMemberFormFields', $fields);
    }

    public function updateMemberFormFields($fields){
        $someData = $this->apiCall();
        $fields->push(HiddenField::create('someData',null, $someData));
    }
}
