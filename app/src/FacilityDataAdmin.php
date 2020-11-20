<?php

use SilverStripe\Admin\ModelAdmin;

class FacilityDataAdmin extends ModelAdmin{

    private static $menu_title = "Facility";

    private static $url_segment = 'facility';

    private static $managed_models = [
        FacilityData::class
    ];

    private static $menu_icon = 'icons/property.png';
}
