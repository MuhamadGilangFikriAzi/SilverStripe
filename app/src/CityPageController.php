<?php

namespace SilverStripe\Lessons;

use City;
use PageController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\PaginatedList;

class CityPageController extends PageController{

    public function index(HTTPRequest $request){
        $city = City::get();

        // var_dump($data->first());die();

        $paginatedList = PaginatedList::create(
            $city,
            $request
        )->setPageLength(2)->setPaginationGetVar('s');

        $data = array(
            'Results' => $paginatedList,
        );

        if($request->isAjax()) {
            return $this->customise($data)
                         ->renderWith('SilverStripe/Lessons/Includes/CitySearchResult');
        }

        return $data;
    }

}
