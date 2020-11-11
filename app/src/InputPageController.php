<?php

namespace SilverStripe\Lessons;

use SilverStripe\Control\Director;
use PageController;
use Product;

class InputPageController extends PageController{

    protected $product;

    private static $allowed_actions = ['store'];

    public function init(){
        parent::init();

        $test = 'test';
        // return [
        //     'test' => $test,
        //     'product' => Product::get(),
        // ];

        $this->product = Product::get();
    }

    public function store(){
        $data = [
            'Title' => $_POST['Title'],
            'Price' => $_POST['Price']
        ];

        Product::create($data)->write();

        return $this->redirectBack();

        // echo 'masuk';
    }

    public function show(){
        return Product::get()->sort('price','desc');
    }

}