<?php

namespace SilverStripe\Lessons;

use PageController;
use PropertyData;

class PropertyDataPageController extends PageController{

    private static $allowed_actions = [
        'getData','delete','edit'
    ];

    public function getData(){
        $arr = array();
        $count = 0;
        $data = PropertyData::get();


        $draw = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : 10;

        //Add
        $create = (isset($_REQUEST['add'])) ? $_REQUEST['add'] : '';
        $create_array = [];

        parse_str($create, $create_array);
        if(!empty($create_array)){
            PropertyData::create($create_array)->write();
        }

        //Filter
        $filter_record = (isset($_REQUEST['filter_record'])) ? $_REQUEST['filter_record'] : '';
        $param_array = [];
        parse_str($filter_record, $param_array);

        if(!empty($param_array)){
            if($param_array['Address']){
                $data = $data->where("Address LIKE '%".$param_array['Address']."%'");
            }

            if($param_array['Phone']){
                $data = $data->where("Phone LIKE '%".$param_array['Phone']."%'");
            }
        }
        //End Filter

        //Sorting
        $colomn = ['Address','Phone', 'VendorName', 'VendorPhone'];
        $sorting_colomn = (isset($_REQUEST['order'][0]['column'])) ? $_REQUEST['order'][0]['column'] : 0;
        $sorting_type = (isset($_REQUEST['order'][0]['dir'])) ? $_REQUEST['order'][0]['dir'] : 'desc';
        $data = $data->sort($colomn[$sorting_colomn], $sorting_type);
        //End Sorting

        //Set Data for return ajax
        $dataCont = $data->count();
        $data = $data->limit($length, $start);

        foreach ($data as $value) {
            // print_r($value);die();
            $count += 1;
            $tempArray = array();
            $tempArray[] = $value->Address;
            $tempArray[] = $value->Phone;
            $tempArray[] = $value->VendorName;
            $tempArray[] = $value->VendorPhone;
            $tempArray[] = "<button class='btn btn-info edit' data-ID='".$value->ID."' data-toggle='modal' data-target='#addModal'>edit</button> <button class='btn btn-danger delete' data-ID='".$value->ID."' >delete</button> ";

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
        $data = PropertyData::get()->byID($_POST['id']);
        $data->delete();

        return $this->getData();
    }

    public function edit(){
        $proprty = PropertyData::get()->byID($_POST['id']);

        $data = [
            'message' => '',
            'status' => 200,
            'data' => $proprty
        ];

        print_r($proprty);die();
        return $data;
    }

}
