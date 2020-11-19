<?php

use SilverStripe\Admin\ModelAdmin;

class PropertyDataAdmin extends ModelAdmin{

    private static $menu_title = 'PropertyData';

    private static $url_segment = 'propertyData';


    private static $managed_models = [
        PropertyData::class
    ];

    private static $menu_icon = 'icons/property.png';

}
