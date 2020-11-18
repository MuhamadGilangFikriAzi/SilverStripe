<?php

namespace SilverStripe\Lessons;

use MaterialCategory;
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

    public function category(HTTPRequest $r){
        $category = MaterialCategory::get()->byID($r->param('ID'));

        if(!$category){

           return $this->httpError(404, 'That category  was not found');
        }

        $this->materialList = $this->materialList->filter([
            'Categories.ID' => $category->ID
        ]);

        return [
            'SelectedCategory' => $category
        ];
    }

}