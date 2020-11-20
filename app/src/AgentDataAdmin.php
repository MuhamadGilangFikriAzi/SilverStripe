<?php

use SilverStripe\Admin\ModelAdmin;

class AgentDataAdmin extends ModelAdmin{

    private static $menu_title = "Agent";

    private static $url_segment = 'agent';

    private static $managed_models = [
        AgentData::class
    ];

    private static $menu_icon = 'icons/property.png';
}
