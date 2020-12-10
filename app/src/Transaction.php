<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\DB;

class Transaction extends DataObject {

    private static $db = [
        'Kode' => 'Varchar',
        'Name' => 'Varchar',
        'Date' => 'Date',
        'Description' => 'Text',
        'Total' => 'Double',
        'Delete' => 'Int'
    ];

    private static $has_many = [
        'TransactionDetail' => TransactionDetail::class
    ];

}
