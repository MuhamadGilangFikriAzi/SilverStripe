<?php

namespace SilverStripe\Lessons;

use PageController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\PaginatedList;

class ArticleHolderController extends PageController{
    private static $allowed_actions = [
        'category',
        'region',
        'date'
    ];

    protected $artilceList;

    protected function init(){
        parent::init();

        $this->artilceList = ArticlePage::get()->filter([
            'ParentID' => $this->ID
        ])->sort('Date DESC');
    }

    public function PaginatedArticles ($num = 10){
        return PaginatedList::create(
            $this->artilceList,
            $this->getRequest()
        )->setPageLength($num);
    }

    public function category(HTTPRequest $r){
        $category = ArticleCategory::get()->byID($r->param('ID'));

        if(!$category){

           return $this->httpError(404, 'That category  was not found');
        }

        $this->artilceList = $this->artilceList->filter([
            'Categories.ID' => $category->ID
        ]);

        return [
            'SelectedCategory' => $category
        ];
    }

    public function region(HTTPRequest $r){

        $region = Region::get()->byID($r->param('ID'));

        if (!$region) {
            return $this->httpError(404, 'That region was not found');
        }

        $this->artilceList = $this->artilceList->filter([
            'RegionID' => $region->ID
        ]);

        return [
            'SelectedRegion' => $region
        ];

    }
}
