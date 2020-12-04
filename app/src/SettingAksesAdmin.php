<?php

use SilverStripe\Admin\LeftAndMain;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Security\Group;
use SilverStripe\View\ViewableData;

class SettingAksesAdmin extends LeftAndMain{

    private static $url_segment = 'setting';

    private static $menu_title = 'Setting akses';

    private static $allowed_actions = [
        'getEditForm', 'setPermission'
    ];
    /**
     * @param Int $id
     * @param FieldList $fields
     * @return Form
     */
    public function getEditForm($id = null, $fields = null)
    {
        $arrAkses = new ArrayList();

        foreach (AccessCode::$akses as $key => $value) {
            $tempArr = new ArrayList();

            foreach ($value['akses'] as $item) {
                $tempArr->push([
                    'Label' => $item.' '.$value['label'],
                    'Kode' => $value['label'].'_'.$item
                ]);
            }
            $arrAkses->push([
                'Label' => $value['label'],
                'KodeParent' => $key,
                'Data' => $tempArr
            ]);
        }

        $data = [
            'mgeJS' => 'hakakses',
            'KodeAkses' => $arrAkses,
            'Group' => Group::get()
        ];

        $v = new ViewableData();
        $content = $v->renderWith(["SettingAkses"], $data);
        $tes = new LiteralField("tes", $content);

        $dropdown = new DropdownField('GroupID', 'Group', Group::get()->map('ID','Title'));
        $dropdown->setEmptyString("Group");

        $form = Form::create(
            $this,
            'EditForm',
            new FieldList(
                [$tes]
            ),
            new FieldList()
        );
        // print_r($form);die();

        return $form;
    }

    public function setPermission(){
        print_r('masuk');die();
    }
}
