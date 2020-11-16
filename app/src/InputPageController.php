<?php

namespace SilverStripe\Lessons;

use SilverStripe\Control\Director;
use PageController;
use Product;

class InputPageController extends PageController{

    protected $product;

    private static $allowed_actions = ['store','delete', 'update', 'show'];

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

    }

    public function show(){

       $product = Product::get();

        if(isset($_GET['price']) && $_GET['price'] != ''){
            $product = $product->where('Price = '.$_GET['price']);
        }

        if(isset($_GET['title']) && $_GET['title'] != ''){
            $product = $product->where('Title = '.$_GET['title']);
        }

        return $product->sort('price','asc');
    }

    public function delete(){

        $product = Product::get()->byID($_GET['ID']);

        $product->delete();

        return $this->redirectBack();
    }

    public function update(){

        $product = Product::get_by_id($_GET['ID']);
        $product->Title = $_POST['title'];
        $product->Price = $_POST['price'];
        $product->write();

        return $this->redirectBack();
    }

}
