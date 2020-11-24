<?php

namespace SilverStripe\Lessons;

use AgentData;
use CategoryData;
use FacilityData;
use PageController;
use phpDocumentor\Reflection\Types\Parent_;
use PropertyData;
use SilverStripe\ORM\ArrayList;

class PropertyDataPageController extends PageController{

    private static $allowed_actions = [
        'getData','delete','edit','store'
    ];

    function getCategory(){
        return  CategoryData::get();
    }

    function getAgentData(){
        return AgentData::get();
    }

    function getFacilityData(){
        return FacilityData::get();

    }

    public function getData(){
        $arr = array();
        $count = 0;
        $data = PropertyData::get();


        $draw = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : 10;

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
        $colomn = ['Address','Phone', 'VendorName', 'VendorPhone'];
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
            $tempArray[] = $value->Address;
            $tempArray[] = $value->Phone;
            $tempArray[] = $value->VendorName;
            $tempArray[] = $value->VendorPhone;
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

    function store(){
        //craete property
         //Add
         $create = (isset($_REQUEST['data'])) ? $_REQUEST['data'] : '';
         $data = [];

         parse_str($create, $data);
         if(!empty($data)){
            $create = PropertyData::create($data)->write();
            $proprty = PropertyData::get()->byID($create);

            //set data for facility and agent
            $facility = $data['FacilityDataID'];

            //craete many many realation facility
            foreach ($facility as $key => $value) {
                $facilityData = FacilityData::get()->byID($value);

                $proprty->Facility()->add($facilityData);
            }

            $message = 'Data has been added';
            $status = 200;
         }else {
            $message = 'data failed to add';
            $status = 404;
         }

         $data = [
            'message' => $message,
            'status' => $status,
            'data' => []
         ];

        return json_encode($data);
    }


    public function delete(){
        $data = PropertyData::get()->byID($_POST['id']);
        $data->deleteFacility($data->ID);
        $data->delete();

        return $this->getData();
    }

    public function edit(){
        $proprty = PropertyData::get()->byID($_POST['id']);
        $facility = $proprty->Facility();

        $facilityData = array();
        foreach ($facility as $key => $value) {
            array_push($facilityData, $value->ID);
        }

        $result = [
            'message' => '',
            'status' => 200,
            'data' => [
                'ID' => $proprty->ID,
                'Address' => $proprty->Address,
                'AddressFull' => $proprty->AddressFull,
                'Phone' => $proprty->Phone,
                'VendorName' => $proprty->VendorName,
                'VendorPhone' => $proprty->VendorPhone,
                'CategoryID' => $proprty->CategoryID,
                'FacilityData' => $facilityData
            ]
        ];

        return json_encode($result);
    }

    public function update($data){
        $update = PropertyData::get()->byID($data['id']);
        $update->deleteFacility($update->ID);

        //Insert facility
        foreach ($data['editFacilityDataID'] as $value) {
            $facility = FacilityData::get()->byID($value);

            $update->Facility()->add($facility);
        }

        $update->Address = $data['Address'];
        $update->AddressFull = $data['AddressFull'];
        $update->Phone = $data['Phone'];
        $update->VendorName = $data['VendorName'];
        $update->VendorPhone = $data['VendorPhone'];
        $update->CategoryID = $data['CategoryID'];
        $update->write();

        return 'succes';
    }

}