<?php

namespace SilverStripe\Lessons;

use PageController;
use SilverStripe\ORM\PaginatedList;

class MaterialHolderController extends PageController{

    protected $materialList;

    protected function init(){
        parent::init();

        $this->materialList = MaterialPage::get()->filter([
            'ParentID' => $this->ID
        ])->sort('Date DESC');
    }

    public function PaginatedMaterial($num = 10){
        return PaginatedList::create(
            $this->materialList,
            $this->getRequest()
        )->setPageLength($num);
    }

}