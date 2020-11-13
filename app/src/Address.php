<?php

use SilverStripe\View\ViewableData;

class Adress extends ViewableData{

    public $Static = '123 Main street';

    public $City = 'Compton';

    public $Zip = '90210';

    public $Country = 'us';

    public function Country(){
        return MyGeoLibrary::get_country_name($this->Country);
    }

    public function getFullAddress(){
        return sprintf(
            '%s<br>%s %s<br>%s',
            $this->Street,
            $this->City,
            $this->Zip,
            $this->Country()
        );
    }

    public function forTempalte(){
        return $this->getFullAddress();
    }

}
