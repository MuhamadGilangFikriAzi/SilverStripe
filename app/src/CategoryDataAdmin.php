<?php

namespace SilverStripe\Lessons;

use CategoryData;
use SilverStripe\Admin\ModelAdmin;

class CategoryDataAdmin extends ModelAdmin{

    private static $menu_title = 'Category';

    private static $url_segment = 'category';


   private static $managed_models = [
        CategoryData::class
    ];

    private static $menu_icon = 'icons/property.png';
}
