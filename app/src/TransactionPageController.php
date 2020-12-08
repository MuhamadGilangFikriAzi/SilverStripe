<?php

namespace SilverStripe\Lessons;

use PageController;
use Product;
use SilverStripe\Control\Director;
use Transaction;
use TransactionDetail;

class TransactionPageController extends PageController
{

    private static $allowed_actions = [
        'getProduct',
        'getPrice',
        'store',
        'getData',
        'delete',
        'getDate',
        'editPage',
        'update',
        'renderProduct'
    ];

    private static $casting = [
        'renderProduct' => 'HTMLText'
    ];

    private function formatNumber($number){
        return number_format($number,0,",",".");
    }

    private function reverseFormat($number){
        return str_replace('.','',$number);
    }

    private function getUrl(){
        return Director::absoluteBaseURL().'transaction/';
    }

    public function getProduct()
    {
        return Product::get();
    }

    public function getDate(){
        return date('d/m/Y');
    }

    public function getPrice(){
        $product = Product::get_by_id($_REQUEST['id']);
        $price = ($product) ? $this->formatNumber($product->Price) : 0;

        $data = [
            'message' => '',
            'status' => 200,
            'data' => [
                'Price' => $price,
            ]
        ];

        return json_encode($data);
    }

    public function store(){

        $request = $_REQUEST;

        // set date
        $date = date('Y-m-d', strtotime(str_replace('/','-',$request['Date'])));
        $detail = $request['detail'];
        unset($request['detail']);

        //set code
        $lastCode = Transaction::get()->last();
        $number = ($lastCode->Kode != null) ? str_replace('T-','', $lastCode->Kode) + 1 : 1 ;
        $code = 'T-'.$number;

        $request['Kode'] = $code;
        $request['Date'] = $date;
        $request['Total'] = $this->reverseFormat($request['Total']);

        $idTransaction = Transaction::create($request)->write();
        $transaction = Transaction::get_by_id($idTransaction);

        foreach ($detail as $value) {
            $value['Price'] = $this->reverseFormat($value['Price']);
            $value['Subtotal'] = $this->reverseFormat($value['Subtotal']);
            $value['Qty'] = $this->reverseFormat($value['Qty']);

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
            $url = $this->getUrl().'editPage?ID='.$value->ID;

            $btn = "
            <div class='btn-group dropleft'>
                <button type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    Action
                </button>
                <div class='dropdown-menu dropdown-menu-left'>
                    <a href='".$url."' class='btn btn-white edit' data-ID='".$value->ID."'>Edit</a>
                    <a class='dropdown-item col-sm-12 btn btn-white delete' data-ID='".$value->ID."'>Delete</a>
                </div>
            </div>";

                    // <button class='dropdown-item col-sm-12 btn btn-white edit' data-ID='".$value->ID."'>Edit</button>
            $count += 1;
            $tempArray = array();
            $tempArray[] = $value->Kode;
            $tempArray[] = $value->Name;
            $tempArray[] = date('d/m/yy', strtotime($value->Date));
            $tempArray[] = $this->formatNumber($value->Total);
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

    public function delete(){

        $delete = Transaction::get_by_id($_REQUEST['id']);

        $detail = $delete->TransactionDetail();

        foreach ($detail as $key => $value) {
            $value->delete = 1;
            $value->write();
        }

        $delete->Delete = 1;
        $delete->write();



        $data = [
            'message' => 'Data '.$delete->Kode.' has been deleted',
            'status' => 200,
            'data' => []
        ];

        return json_encode($data);
    }

    public function editPage(){
        $id = $_REQUEST['ID'];
        $transaction = Transaction::get_by_id($id);
        $transactionDetail = $transaction->TransactionDetail()->where("TransactionDetail.Delete = 0");

        $data = [
            'transaction' => $transaction,
            'detail' => $transactionDetail,
            'date' => date('d/m/Y', strtotime($transaction->Date))

        ];

        return $data;
    }

    public function update(){


        $id = $_REQUEST['id'];

        $date = date('Y-m-d', strtotime(str_replace('/','-',$_REQUEST['Date'])));

        $transaction = Transaction::get_by_id($id);
        $detail = $transaction->TransactionDetail();

        foreach ($detail as $key => $value) {
            $value->Delete = 1;
            $value->write();
        }

        foreach ($_REQUEST['detail'] as $value) {
            $value['Price'] = $this->reverseFormat($value['Price']);
            $value['Subtotal'] = $this->reverseFormat($value['Subtotal']);
            $value['Qty'] = $this->reverseFormat($value['Qty']);
            $idDetail = TransactionDetail::create($value)->write();
            $transactionDetail = TransactionDetail::get_by_id($idDetail);
            $transaction->TransactionDetail()->add($transactionDetail);

        }
        $transaction->Name = $_REQUEST['Name'];
        $transaction->Date = $date;
        $transaction->Description = $_REQUEST['Description'];
        $transaction->Total = $this->reverseFormat($_REQUEST['Total']);
        $transaction->write();

        $data = [
            'status' => 200,
            'message' => 'success',
            'data' => []
        ];

        return json_encode($data);
    }

    public function renderProduct($id){
        $detail = TransactionDetail::get_by_id($id)->ProductID;
        $product = Product::get();
        $option = "<option value=''>-- Pilih Product --</option>";
        foreach ($product as $value) {
            if($value->ID == $detail){
                $option .= "<option value='{$value->ID}' selected>{$value->Name}</option>";
            }else{
                $option .= "<option value='{$value->ID}'>{$value->Name}</option>";
            }
        }

        return $option;
    }

}
