<?php

use SilverStripe\Admin\ModelAdmin;

class ProductAdmin extends ModelAdmin{

    private static $menu_title = 'Product';

    private static $url_segment = 'product';


    private static $managed_models = [
        Product::class
    ];

    private static $menu_icon = 'icons/property.png';

}
