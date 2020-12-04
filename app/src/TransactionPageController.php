<?php

namespace SilverStripe\Lessons;

use PageController;
use Product;
use Transaction;
use TransactionDetail;

class TransactionPageController extends PageController
{
    private static $allowed_actions = [
        'getProduct','getPrice','store','getData'
    ];

    public function getProduct()
    {
        return Product::get();
    }

    public function getPrice(){
        $product = Product::get_by_id($_REQUEST['id']);

        $data = [
            'message' => '',
            'status' => 200,
            'data' => [
                'Price' => $product->Price,
            ]
        ];

        return json_encode($data);
    }

    public function store(){
        $request = $_REQUEST;
        $detail = $request['detail'];
        unset($request['detail']);

        $lastCode = Transaction::get()->last();

        $number = ($lastCode->Kode != null) ? str_replace('T-','', $lastCode->Kode) : 1 ;
        $code = 'T-'.$number;
        $request['Kode'] = $code;

        $idTransaction = Transaction::create($request)->write();
        $transaction = Transaction::get_by_id($idTransaction);

        foreach ($detail as $value) {
            $transactionDetail = TransactionDetail::create($value);
            $transaction->TransactionDetail()->add($transactionDetail);
        }

        $data = [
            'status' => 200,
            'message' => 'Data Transaction '.$transaction->Name.' has been added',
            'data' =>[]
        ];

        return json_encode($data);
    }

    public function getData(){
        $arr = array();
        $count = 0;
        $data = Transaction::get()->where('"Delete" = 0');
        // print_r($data->first()->AgentDataGallery()->first()->File()->getAbsoluteUrl());die();
        $draw = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : 10;

        //Filter
        $filter_record = (isset($_REQUEST['filter_record'])) ? $_REQUEST['filter_record'] : '';
        $param_array = [];
        parse_str($filter_record, $param_array);

        if(!empty($param_array)){
            foreach ($param_array as $key => $value) {
                if($key){
                    $data = $data->where("".$key." LIKE '%".$value."%'");
                }
            }
        }
        //End Filter

        //Sorting
        $colomn = ['Kode','Name', 'Date'];
        $sorting_colomn = (isset($_REQUEST['order'][0]['column'])) ? $_REQUEST['order'][0]['column'] : 0;
        $sorting_type = (isset($_REQUEST['order'][0]['dir'])) ? $_REQUEST['order'][0]['dir'] : 'desc';
        $data = $data->sort($colomn[$sorting_colomn], $sorting_type);
        //End Sorting

        //Set Data for return ajax
        $dataCont = $data->count();
        $data = $data->limit($length, $start);


        foreach ($data as $value) {
            $btn = "
            <div class='btn-group dropleft'>
                <button type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    Action
                </button>
                <div class='dropdown-menu dropdown-menu-left'>
                    <button class='dropdown-item col-sm-12 btn btn-white edit' data-ID='".$value->ID."' data-toggle='modal' data-target='#editModal'>Edit</button>
                    <button class='dropdown-item col-sm-12 btn btn-white image' data-ID='".$value->ID."' data-toggle='modal' data-target='#uploadModal' title='upload Images'>Upload</button>
                    <button class='dropdown-item col-sm-12 btn btn-white delete' data-ID='".$value->ID."'>Delete</button>
                </div>
            </div>";

            $count += 1;
            $tempArray = array();
            $tempArray[] = $value->Kode;
            $tempArray[] = $value->Name;
            $tempArray[] = $value->Date;
            $tempArray[] = $value->Total;
            $tempArray[] = $btn;

            // "<button class='btn btn-sm btn-gray edit' data-ID='".$value->ID."' data-toggle='modal' data-target='#editModal'>edit</button>
            // <button class='btn btn-sm btn-gray delete' data-ID='".$value->ID."' >delete</button> <button class='btn btn-sm btn-gray image' type='button' data-ID='".$value->ID."' data-toggle='modal' data-target='#uploadModal' title='upload Images' >upload</button> ";

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

}