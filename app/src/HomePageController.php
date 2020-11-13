<?php

namespace SilverStripe\Lessons;

use PageController;
use Product;

class HomePageController extends PageController{

    public function FeaturedProperties(){
        return Property::get()
            ->filter(array(
                'FeaturedonHomepage' => true
            ))
            ->limit(6);
    }
}