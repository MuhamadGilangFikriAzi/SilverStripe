<?php

namespace SilverStripe\Lessons;

use GraphQL\Examples\Blog\Type\Field\HtmlField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataObject;
use SilverStripe\Versioned\Versioned;

class Region extends DataObject{

    private static $versioned_gridfield_extensions = true;


    private static $db = [
        'Title' => 'Varchar',
        'Description' => 'HTMLText'
    ];

    private static $has_one = [
        'Photo' => Image::class,
        'RegionsPage' => RegionsPage::class
    ];

    private static $owns = [
        'Photo'
    ];

    private static  $extensions = [
        Versioned::class
    ];

    private static $summary_fields = [
        'Photo.Filename' => 'Photo File name',
        'Title' => 'Title of region',
        'Description' => 'Short description'
    ];

    public function getGridThumbnail(){
        if($this->Photo()->exists()){
            return $this->Photo()->ScaleWidth(100);
        }

        return "(no image)";
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create('Title'),
            HTMLEditorField::create('Description'),
            $uploader = UploadField::create('Photo')
        );

        $uploader->setFolderName('regions-photos');
        $uploader->getValidator()->setAllowedExtensions(['png','gif','jpeg','jpg']);

        return $fields;
    }

    public function link(){
        return $this->RegionsPage()->Link('show/'.$this->ID);
    }

    public function LinkMode(){
        return Controller::curr()->getRequest()->param('ID') == $this->ID ? 'current' : 'link';
    }
}