<?php

namespace SilverStripe\Lessons;

use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Page;
use phpDocumentor\Reflection\PseudoTypes\True_;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\Queries\SQLSelect;
use SilverStripe\Versioned\Versioned;

class ArticleHolder extends Page{

    private static $has_many = [
        'Categories' => ArticleCategory::class
    ];


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab('Root.Categories', GridField::create(
            'Categories',
            'Article categories',
            $this->Categories(),
            GridFieldConfig_RecordEditor::create()
        ));

        return $fields;
    }

    public function Regions(){
        $page = RegionsPage::get()->first();


        if($page){
            return $page->Regions();
        }
    }

    public function ArciveDates(){
        $list = ArrayList::create();
        $stage = Versioned::get_stage();
        $baseTable = ArticlePage::getSchema()->tableName(ArticlePage::class);
        $tableName = $stage === Versioned::LIVE ? "{$baseTable}_Live" : $baseTable;

        $query = SQLSelect::create()
            ->setSelect([])
            ->selectField()
            ->setFrom($tableName)
            ->setOrderBy("DateString", "ASC")
            ->setDistinct(true);

        $result = $query->execute();

        return $list;
    }
}