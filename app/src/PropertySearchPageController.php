<?php

namespace SilverStripe\Lessons;

use PageController;
use SilverStripe\Control\HTTP;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ArrayLib;
use SilverStripe\Forms\Form;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\View\ArrayData;

class PropertySearchPageController extends PageController{

    private static $allowed_actions = [
        'PropertySearchForm','test'
    ];

    public function index(HTTPRequest $request){
        // print_r($request);die();

        $properties = Property::get();
        // print_r($properties);die();
        $activeFilters = ArrayList::create();

        if($search = $request->getVar('keywords')){
            $activeFilters->push(ArrayData::create([
                'Label' => "Keyword : '$search'",
                'RemoveLink' => HTTP::setGetVar('Keywords', null, null, '&'),
            ]));

            $properties = $properties->filter(array(
                'Title:PartialMatch' => $search
            ));
        }

        if($arrival = $request->getVar('search_nights')){
            $arrivalStamp = strtotime($arrival);
            $nightAdder = '+'.$request->getVar('Nights'). ' days';
            $startDate = date('Y-m-d', $arrivalStamp);
            $endDate = date('Y-m-d', strtotime($nightAdder, $arrivalStamp));

            $properties = $properties->filter([
                'AvailableStart:GreaterThanOrEqual' => $startDate,
                'AvailableEnd:LessThanOrEqual' => $endDate
            ]);
        }

        $filters = [
            ['Bedrooms', 'Bedrooms', 'GreaterThanOrEqual', '%s bedrooms'],
            ['Bathrooms', 'Bathrooms', 'GreateThanOrEqual', '%s bathrooms'],
            ['MinPrice', 'PricePerNight', 'GreaterThanOrEqual', 'Min. $%s'],
            ['MaxPrice', 'PricePerNight', 'LessThanOrEqual', 'Max. $%s'],
        ];

        foreach ($filters as $filterKeys) {
            list($getVar, $field, $filter, $labelTemplate) = $filterKeys;

            if($value = $request->getVar($getVar)){
                $activeFilters->push(ArrayData::create([
                    'Label' => sprintf($labelTemplate, $value),
                    'RemoveLink' => HTTP::setGetVar($getVar, null, null, '&'),
                ]));

                $properties = $properties->filter([
                    "{$field}:{$filter}" => $value
                ]);
            }
        }

        if($bedrooms = $request->getVar('search_bedrooms')){

            $properties = $properties->filter([
                'Bedrooms:GreaterThanOrEqual' => $bedrooms
            ]);

            // var_dump($properties);die();
        }

        if($bathrooms = $request->getVar('search_bathrooms')){
            $properties = $properties->filter([
                'Bathrooms:GreaterThanOrEqual' => $bathrooms
            ]);
        }

        if($minPrice = $request->getVar('search_minprice')){

            $properties = $properties->filter([
                'PricePerNight:GreaterThanOrEqual' => $minPrice
            ]);
        }

        if($maxPrice = $request->getVar('search_maxprice')){
            $properties = $properties->filter([
                'PricePerNight:GreaterThanOrEqual' => $maxPrice
            ]);
        }

        $paginatedProperties = PaginatedList::create(
            $properties,
            $request
        )
        ->setPageLength(15)
        ->setPaginationGetVar('s');

        $data = array (
            'Results' => $paginatedProperties,
            'ActtiveFilters' => $activeFilters
        );

        if($request->isAjax()) {
            return $this->customise($data)
                         ->renderWith('SilverStripe/Lessons/Includes/PropertySearchResults');
        }

        return $data;
    }

    public function PropertySearchForm(){
        $night = [];
        foreach (range(1, 14) as $i) {
            $night[$i] = "$i night".(($i > 1) ? 's' : '');
        }

        $prices = [];
        foreach (range(100, 1000, 50) as $i) {
            $prices[$i] = '$'.$i;
        }

        $form = Form::create(
            $this,
            'PropertySearchForm',
            FieldList::create(
                TextField::create('Keywords')
                    ->setAttribute('pleaceholder','City, State, Country, et....')
                    ->addExtraClass('form-control'),
                TextField::create('ArrivalDate', 'Arrive on...')
                    ->setAttribute('data-datapicker', true)
                    ->setAttribute('data-date-format', 'DD-MM-YYYY')
                    ->addExtraClass('form-control'),
                DropdownField::create('Night','Stay for...')
                    ->setSource($night)
                    ->addExtraClass('form-control'),
                DropdownField::create('Bedrooms')
                    ->setSource(ArrayLib::valuekey(range(1,5)))
                    ->addExtraClass('form-control'),
                DropdownField::create('Bathrooms')
                    ->setSource(ArrayLib::valuekey(range(1,5)))
                    ->addExtraClass('form-control'),
                DropdownField::create('MinPrice', 'Min. Price')
                    ->setEmptyString('-- any --')
                    ->setSource($prices)
                    ->addExtraClass('form-control'),
                DropdownField::create('MaxPrice', 'Max. Price')
                    ->setEmptyString('-- any --')
                    ->setSource($price)
                    ->addExtraClass('form-control')
            ),

            FieldList::create(
                FormAction::create('doPropertySearch', 'search')
                    ->addExtraClass('btn-lg btn-fullcolor')
            )
        );

        $form->setFormMethod('GET')
            ->setFormAction($this->Link())
            ->disableSecurityToken()
            ->loadDataFrom($this->request->getVar());

        return $form;
    }
}
