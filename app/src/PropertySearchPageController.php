<?php

namespace SilverStripe\Lessons;

use PageController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\ArrayLib;
use SilverStripe\Forms\Form;
use SilverStripe\ORM\PaginatedList;

class PropertySearchPageController extends PageController{

    private static $allowed_actions = [
        'PropertySearchForm','test'
    ];

    public function index(HTTPRequest $request){

        $properties = Property::get();

        if($search = $request->getVar('Keywords')){
            $properties = $properties->filter(array(
                'Title:PartialMatch' => $search
            ));
        }

        if($arrival = $request->getVar('ArrivalDate')){
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
            ['Bedrooms', 'Bedrooms', 'GreaterThanOrEqual'],
            ['Bathrooms', 'Bathrooms', 'GreateThanOrEqual'],
            ['MinPrice', 'PricePerNight', 'GreaterThanOrEqual'],
            ['MaxPrice', 'PricePerNight', 'LessThanOrEqual']
        ];

        foreach ($filters as $filterkeys) {
            list($getVar, $field, $filter) = $filterkeys;

            if($value = $request->getVar($getVar)){
                $properties = $properties->filter([
                    "{$field}:{$filter}" => $value
                ]);
            }
        }

        if($bedrooms = $request->getVar('Bedrooms')){
            $properties = $properties->filter([
                'Bedrooms:GreaterThanOrEqual' => $bedrooms
            ]);
        }

        if($bathrooms = $request->getVar('Bathrooms')){
            $properties = $properties->filter([
                'Bathrooms:GreaterThanOrEqual' => $bathrooms
            ]);
        }

        if($minPrice = $request->getVar('MinPrice')){
            $properties = $properties->filter([
                'MinPrice:GreaterThanOrEqual' => $minPrice
            ]);
        }

        if($maxPrice = $request->getVar('MaxPrice')){
            $properties = $properties->filter([
                'MaxPrice:GreaterThanOrEqual' => $maxPrice
            ]);
        }

        $paginatedProperties = PaginatedList::create(
            $properties,
            $request
        )
        ->setPageLength(5)
        ->setPaginationGetVar('s');

        if($request->isAjax()){
            return "Ajax response!";
        }

        return [
            'Results' => $paginatedProperties
        ];
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