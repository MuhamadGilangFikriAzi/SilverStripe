<?php

namespace SilverStripe\Lessons;

use SilverStripe\Assets\Image;
use AgentData;
use AgentDataGallery;
use PageController;
use PropertyData;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Upload;

class AgentDataPageController extends PageController{

    private static $allowed_actions = [
        'getData','edit','delete','store','update','dropZone','getDropZone','getProperty'
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

    public function getProperty(){
        return json_encode(PropertyData::get()->map('ID','Name'));
    }

    public function getData(){
        $arr = array();
        $count = 0;
        $data = AgentData::get()->where('"Delete" = 0');
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
        $colomn = ['Name','Address', 'Phone'];
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
            $tempArray[] = $value->Name;
            $tempArray[] = $value->Address;
            $tempArray[] = $value->Phone;
            $tempArray[] = $value->PropertyData()->Address;
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

    public function store(){

        $create = $_REQUEST;
        $salary = str_replace('Rp.', '', $create['Salary']);
        $salary = str_replace('.','', $salary);
        $create['Salary'] = (int)$salary;
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

    public function getDropZone(){
        $agentData = AgentData::get_by_id($_REQUEST['id'])->AgentDataGallery();
        $getFile = [];

        foreach ($agentData as $key => $value) {

            $getFile[] = [
                'Name' => $value->Name,
                'URL' => $value->File()->getAbsoluteUrl(),
                'Size' => $value->File()->getSize()
            ];

        }

        $data = [
            'status' => 200,
            'message' => 'data has ben succusfuly geter',
            'data' => $getFile
        ];

        return json_encode($data);
    }

    public function dropZone(){

        $id = $_REQUEST['ID'];

        $this->uploadDropzone($id);

        $data = [
            'status' => 200,
            'message' => 'Image has been uploaded',
            'data' => []
        ];

        return json_encode($data);
    }

    private function uploadDropzone($id){

        $fileName = $_FILES['file']['name'];
        $fileID = $this->uploadFile();

        $data = [
            'Name' => $fileName,
            'FileID' => $fileID,
            'AgentDataID' => $id
        ];

        $create = AgentDataGallery::create($data)->write();

        return $create;
    }

    private function uploadFile(){
        $upload = new Upload();
        $file = new File();
        $tanggal = date('d-m-Y');
        $upload->loadIntoFile($_FILES['file'], $file, 'File/'.$tanggal);
        $file->write();

        return $file->ID;
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
                'PropertyDataID' => $agent->PropertyDataID,
                'File' => [
                    'URL' => $agent->File->URL,
                    'Name' => $agent->File->Name
                    ]
            ]
        ];

        return json_encode($result);
    }

    public function update(){

        $edit = $_REQUEST;
        $update = AgentData::get()->byID($edit['ID']);

        foreach ($edit as $key => $value) {
            $update->$key = $value;
        }

        if(isset($_FILES['file']['name'])){
            $update->FileID = $this->uploadFile();
        }

        $update->write();

        $data = [
            'status' => 200,
            'message' => 'Data Has been updated',
            'data' => []
        ];
        return json_encode($data);
    }

}