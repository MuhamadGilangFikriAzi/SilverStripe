<?php

namespace SilverStripe\Lessons;

use AgentData;
use CategoryData;
use FacilityData;
use PageController;
use phpDocumentor\Reflection\Types\Parent_;
use PropertyData;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Upload;
use SilverStripe\ORM\ArrayList;

class PropertyDataPageController extends PageController{

    private static $allowed_actions = [
        'getData','delete','getEdit','store','update'
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
            $fileURL = '0';
            if($value->ImageID != 0){
                $image = File::get_by_id($value->ImageID);
                $fileURL = $image->getAbsoluteURL();
            }

            $count += 1;
            $tempArray = array();
            $tempArray[] = "<img src='".$fileURL."' alt='...' class='img-thumbnail'  data-toggle='modal' data-target='#image".$value->ID."' style='width: 150px; height: 150px;'>
            <div class='modal fade' id='image".$value->ID."' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                            </div>
                            <div class='modal-body'>
                                <img src='".$fileURL."' alt='...' class='img-thumbnail' style='width: 600px; height: 600px;'>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
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

         $create = $_REQUEST;
         $create['ImageID'] = $this->uploadFile();

         //set data for facility and agent
         $facility = $create['FacilityDataID'];
         unset($create['FacilityDataID']);

         if(!empty($create)){
            $createID = PropertyData::create($create)->write();
            $proprty = PropertyData::get()->byID($createID);

            //craete many many realation facility
            foreach ($facility as $value) {
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

    public function getEdit(){
        $proprty = PropertyData::get()->byID($_POST['id']);
        $facility = $proprty->Facility();

        $facilityData = array();
        foreach ($facility as $key => $value) {
            array_push($facilityData, $value->ID);
        }

        $img_id = !empty($proprty->ImageID) ? (int) $proprty->ImageID : 0;

        if(!empty($img_id)){
            $fileData = File::get()->byID($img_id);
            $file = $fileData->getAbsoluteURL();
        }else{
            $file = '#';
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
                'FacilityData' => $facilityData,
                'FileURL' => $file
            ]
        ];

        return json_encode($result);
    }

    public function update($data){

        //Edit
        $edit = $_REQUEST;
        $fileURL = '';
        if(!empty($edit)){
            $update = PropertyData::get()->byID($edit['id']);
            // print_r($_FILES);die();
            if(!empty($_FILES)){
                // $file = File::get()->byID($update->ImageID);
                // $file->delete();

                $update->ImageID = $this->uploadFile();
                $image = File::get_by_id($update->ImageID);
                $fileURL = $image->getAbsoluteURL();
            }

            $update->deleteFacility($update->ID);

            //Insert facility
            foreach ($edit['editFacilityDataID'] as $value) {
                $facility = FacilityData::get()->byID($value);

                $update->Facility()->add($facility);
            }

            $update->Address = $edit['Address'];
            $update->AddressFull = $edit['AddressFull'];
            $update->Phone = $edit['Phone'];
            $update->VendorName = $edit['VendorName'];
            $update->VendorPhone = $edit['VendorPhone'];
            $update->CategoryID = $edit['CategoryID'];
            $update->write();

            $message = 'Data has been updated';
            $status = 200;
        }else{
            $message = 'Data failed to edit';
            $status = 404;
        }

        $data = [
            'message' => $message,
            'status' => $status,
            'data' => [
                'FileURL' => $fileURL
            ]
        ];

        return json_encode($data);

    }

    private function uploadFile(){
        $upload = new Upload();
        $file = new File();
        $tanggal = date('d-m-Y');
        $upload->loadIntoFile($_FILES['Photo'], $file, 'File/'.$tanggal);
        $file->write();

        return $file->ID;
    }

}