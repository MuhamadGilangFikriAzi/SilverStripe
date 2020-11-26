<?php

namespace SilverStripe\Lessons;

use AgentData;
use PageController;
use PropertyData;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Upload;

class AgentDataPageController extends PageController{

    private static $allowed_actions = [
        'getData','edit','delete','store','update','uploadFile'
    ];

    private function getUploadImagesFieldGroup() {
		$imageUploadField = new UploadField('UploadedImages', 'Upload Images');
		$imageUploadField->setCanAttachExisting(false);
		$imageUploadField->setCanPreviewFolder(false);
		$imageUploadField->relationAutoSetting = false;
		$imageUploadField->setAllowedExtensions(array('jpg', 'jpeg', 'png', 'gif','tiff'));
		$imageUploadField->setFolderName('images/tmp-upload-images');
		$imageUploadField->setTemplateFileButtons('UploadField_FileButtons_ORS');

		$fg = new FieldGroup(
			$imageUploadField
		);
		$fg->addExtraClass('upload ss-upload ss-uploadfield');	  // had to add these classes because UploadField is added to FieldGroup
		$fg->setName('UploadImagesFieldGroup');

		return $fg;
	}

    function getPropertyData(){
        return PropertyData::get();
    }

    public function getData(){
        $arr = array();
        $count = 0;
        $data = AgentData::get()->where('"Delete" = 0');
        // print_r($data);die();
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

    public function store(){
        $create = $_REQUEST;
        $fileID['FileID'] = $this->uploadFile();
        $dataCreate = array_merge($create, $fileID);
        AgentData::create($dataCreate)->write();

        $data = [
            'status' => 200,
            'message' => 'Data has been added',
            'data' => []
        ];

        return json_encode($data);
    }


    public function delete(){
        $data = AgentData::get()->byID($_POST['id']);
        $data->Delete = 1;
        $data->write();

        return $this->getData();
    }

    public function edit(){
        $agent = AgentData::get()->byID($_POST['id']);
        $result = [
            'message' => '',
            'status' => 200,
            'data' => [
                'ID' => $agent->ID,
                'Name' => $agent->Name,
                'Address' => $agent->Address,
                'Phone' => $agent->Phone,
                'PropertyDataID' => $agent->PropertyDataID
            ]
        ];

        return json_encode($result);
    }

    public function update($data){

        //Edit
        $edit = (isset($_REQUEST['edit'])) ? $_REQUEST['edit'] : '';
        $edit_array = [];
        parse_str($edit, $edit_array);

        $update = AgentData::get()->byID($edit_array['ID']);

        foreach ($edit_array as $key => $value) {
            $update->$key = $value;
        }
        $update->write();

        $data = [
            'status' => 200,
            'message' => 'Data Has been updated',
            'data' => []
        ];
        return json_encode($data);
    }

    public function uploadFile(){
        $upload = new Upload();
        $file = new File();
        $tanggal = date('d-m-Y');
        $upload->loadIntoFile($_FILES['file'], $file, 'File/'.$tanggal);
        $file->write();

        return $file->ID;
    }
}