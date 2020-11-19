<?php

namespace SilverStripe\Lessons;

use SilverStripe\Control\Director;
use PageController;
use Product;
use Symfony\Component\Translation\Interval;

class InputPageController extends PageController{

    protected $product;

    private static $allowed_actions = ['store','delete', 'update', 'show','getData'];

    public static $tableData = [];

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

    public function getData(){
        $arr = array();
        $count = 0;
        $data = Product::get();


        $draw = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : 10;

        //Filter
        $filter_record = (isset($_REQUEST['filter_record'])) ? $_REQUEST['filter_record'] : '';
        $param_array = [];
        parse_str($filter_record, $param_array);

        if(!empty($param_array)){
            if($param_array['title']){
                $data = $data->where("Title LIKE '%".$param_array['title']."%'");
            }

            if($param_array['price']){
                $data = $data->where("Price LIKE '%".$param_array['price']."%'");
            }
        }
        //End Filter

        //Sorting
        $colomn = ['Title','Price'];
        $sorting_colomn = (isset($_REQUEST['order'][0]['column'])) ? $_REQUEST['order'][0]['column'] : 0;
        $sorting_type = (isset($_REQUEST['order'][0]['dir'])) ? $_REQUEST['order'][0]['dir'] : 'desc';
        $data = $data->sort($colomn[$sorting_colomn], $sorting_type);
        //End Sorting

        //Set Data for return ajax
        $dataCont = $data->count();
        $data = $data->limit($length, $start);

        foreach ($data as $value) {
            $count += 1;
            $tempArray = array();
            $tempArray[] = $value->Title;
            $tempArray[] = $value->Price;

            $arr[] = $tempArray;
        }

        $result = array(
            'data' => $arr,
            'colomn_sort' => "",
            'params_arr' => $filter_record,
            'recordsTotal' => $dataCont,
            'recordsFiltered' => $dataCont,
            'sql' => '',
            'draw' => $draw
        );
        //End of set data

        return json_encode($result);
    }

    public function getList($param){

    }

    public function filterList($param, $list){

        foreach ($param as $key => $value) {

            if($value != ""){
                if(strpos($key, '_start') > 0){
                    $arr = explode("/", $value);
                    $value2 = $arr[2].'-'.$arr[1].'_'.$arr[0].' 00:00:00';
                    $list = $list->where(str_replace('_start','', $key).' >= \''.$value2.'\'');
                }elseif(strpos($key, '_end') > 0){
                    $arr = explode("/", $value);
                    $value2 = $arr[2].'-'.$arr[1].'_'.$arr[0].' 23:59:59';
                    $list = $list->where(str_replace('_end','', $key).' <= \''.$value2.'\'');
                }else{
                    if(isset(static::$filterAction[$key])){
                        $valueFilter = addslashes($value);

                        if(static::$filterAction[$key] == "LIKE"){
                            $list = $list->where($key. ' LIKE \'%'.$valueFilter.'%\'');
                        }else{
                            $list = $list->where($key.' = \''.$valueFilter.'\'');
                        }
                    }else{
                        $list = $list->where($key.' = \''.$valueFilter.'\'');
                    }
                }

            }
        }

        return $list;
    }

    function getCusmtomColomns(){
        $colomn = array();

        // switch($config){
        //     case ''
        // }
    }
}