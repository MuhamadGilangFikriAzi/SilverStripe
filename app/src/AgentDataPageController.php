<?php

namespace SilverStripe\Lessons;

use AgentData;
use PageController;
use PropertyData;

class AgentDataPageController extends PageController{

    private static $allowed_actions = [
        'getData','edit','delete'
    ];

    function getPropertyData(){
        return PropertyData::get();
    }

    public function getData(){
        $arr = array();
        $count = 0;
        $data = AgentData::get();
        // print_r($data);die();
        $draw = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : 10;

        //Add
        $create = (isset($_REQUEST['add'])) ? $_REQUEST['add'] : '';
        $create_array = [];

        parse_str($create, $create_array);
        if(!empty($create_array)){
            $this->store($create_array);
        }


         //Edit
         $edit = (isset($_REQUEST['edit'])) ? $_REQUEST['edit'] : '';
         $edit_array = [];
         parse_str($edit, $edit_array);

         if(!empty($edit_array)){
            $this->update($edit_array);
         }
         //End Filter

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
        $colomn = ['Name','Address', 'Phone'];
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
            $tempArray[] = $value->Name;
            $tempArray[] = $value->Address;
            $tempArray[] = $value->Phone;
            $tempArray[] = $value->PropertyData()->Address;
            $tempArray[] = "<button class='btn btn-info edit' data-ID='".$value->ID."' data-toggle='modal' data-target='#editModal'>edit</button> <button class='btn btn-danger delete' data-ID='".$value->ID."' >delete</button> ";

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

    function store($data){
        //craete property
        AgentData::create($data)->write();

        return 'succes';
    }


    public function delete(){
        $data = AgentData::get()->byID($_POST['id']);

        $data->delete();

        return $this->getData();
    }

    public function edit(){
        $agent = AgentData::get()->byID($_POST['id']);
        $result = [
            'message' => '',
            'status' => 200,
            'data' => [
                'ID' => $agent->ID,
                'Name' => $agent->Address,
                'Address' => $agent->Address,
                'Phone' => $agent->Phone,
                'PropertyDataID' => $agent->PropertyDataID
            ]
        ];

        return json_encode($result);
    }

    public function update($data){

        $update = AgentData::get()->byID($data['ID']);

        foreach ($data as $key => $value) {

            $update->$key = $value;
        }

        $update->write();

        return 'succes';
    }
}