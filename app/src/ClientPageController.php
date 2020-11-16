<?php

namespace SilverStripe\Lessons;

use City;
use Client;
use PageController;

class ClientPageController extends PageController{

    private static $allowed_actions = ['store','delete'];

    // public function init(){
    //     parent::init();

    //     return [
    //         'test' => 'test',
    //         'coba' => 'coba'
    //     ];
    // }

    public function index(){
        $data = Client::get();
        // print_r($data->first());die();

        // print_r(City::get()->map('ID','Name'));die();
        return ['data' => $data];
    }

    public function store(){

        $data = [
            'Name' => $_POST['name'],
            'Address' => $_POST['address']
        ];

        Client::create($data)->write();

        return $this->redirectBack();
    }

    public function delete(){
        $id = $_GET['id'];

        Client::get()->byID($id)->delete();

        return $this->redirectBack();
    }
}