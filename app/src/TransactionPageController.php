<?php

namespace SilverStripe\Lessons;

use MGNotif;
use PageController;
use Product;
use SilverStripe\Control\Director;
use Transaction;
use TransactionDetail;

class TransactionPageController extends PageController
{

    private static $allowed_actions = [
        'getProduct',
        'getPrice',
        'store',
        'getData',
        'delete',
        'getDate',
        'editPage',
        'update',
        'renderProduct',
        'sendNotif',
    ];

    private static $casting = [
        'renderProduct' => 'HTMLText',
    ];

    private function formatNumber($number)
    {
        return number_format($number, 0, ",", ".");
    }

    private function reverseFormat($number)
    {
        return str_replace('.', '', $number);
    }

    private function reverseDate($param)
    {
        return date('Y-m-d', strtotime(str_replace('/', '-', $param)));
    }

    private function getUrl()
    {
        return Director::absoluteBaseURL() . 'transaction/';
    }

    public function getProduct()
    {
        return Product::get()->where('"Status" = 1');
    }

    public function getDate()
    {
        return date('d/m/Y');
    }

    public function getPrice()
    {
        $product = Product::get_by_id($_REQUEST['id']);
        $price = ($product) ? $this->formatNumber($product->Price) : 0;

        $data = [
            'message' => '',
            'status' => 200,
            'data' => [
                'Price' => $price,
                'Qty' => $product->Qty
            ],
        ];

        return json_encode($data);
    }

    public function store()
    {
        $request = $_REQUEST;

        // set date
        $date = date('Y-m-d', strtotime(str_replace('/', '-', $request['Date'])));
        $detail = $request['detail'];
        unset($request['detail']);

        //set code
        $lastCode = Transaction::get()->last();
        $number = ($lastCode->Kode != null) ? str_replace('T-', '', $lastCode->Kode) + 1 : 1;
        $code = 'T-' . $number;

        $request['Kode'] = $code;
        $request['Date'] = $date;
        $request['Total'] = $this->reverseFormat($request['Total']);

        $idTransaction = Transaction::create($request)->write();
        $transaction = Transaction::get_by_id($idTransaction);

        foreach ($detail as $value) {
            $value['Price'] = $this->reverseFormat($value['Price']);
            $value['Subtotal'] = $this->reverseFormat($value['Subtotal']);
            $value['Qty'] = $this->reverseFormat($value['Qty']);

            $transactionDetail = TransactionDetail::create($value);
            $transaction->TransactionDetail()->add($transactionDetail);

            $product = Product::get_by_id($value['ProductID']);
            $product->Qty = $product->Qty - $this->reverseFormat($value['Qty']);
            $product->write();
        }

        $data = [
            'status' => 200,
            'message' => 'Data Transaction ' . $transaction->Name . ' has been added',
            'data' => [],
        ];

        return json_encode($data);
    }

    public function getData()
    {
        //set Data
        $arr = array();
        $count = 0;
        $data = Transaction::get()->where('"Delete" = 0');
        $draw = isset($_REQUEST['draw']) ? $_REQUEST['draw'] : '';
        $start = isset($_REQUEST['start']) ? $_REQUEST['start'] : 0;
        $length = isset($_REQUEST['length']) ? $_REQUEST['length'] : 10;

        //Filter
        $filter_record = (isset($_REQUEST['filter_record'])) ? $_REQUEST['filter_record'] : '';
        $param_array = [];
        parse_str($filter_record, $param_array);

        if (!empty($param_array)) {
            foreach ($param_array as $key => $value) {
                if ($value != null && $key == 'Date') {
                    $date = $this->reverseDate($value);
                    $data = $data->where("" . $key . " LIKE '%" . $date . "%'");
                } elseif ($value != null && $key == 'Total') {
                    $total = $this->reverseFormat($value);
                    $data = $data->where("" . $key . " LIKE '%" . $total . "%'");
                } else {
                    $data = $data->where("" . $key . " LIKE '%" . $value . "%'");
                }
            }
        }
        //End Filter

        //Sorting
        $colomn = ['Kode', 'Name', 'Date'];
        $sorting_colomn = (isset($_REQUEST['order'][0]['column'])) ? $_REQUEST['order'][0]['column'] : 0;
        $sorting_type = (isset($_REQUEST['order'][0]['dir'])) ? $_REQUEST['order'][0]['dir'] : 'desc';
        $data = $data->sort($colomn[$sorting_colomn], $sorting_type);
        //End Sorting

        //Set Data for return ajax
        $dataCont = $data->count();
        $data = $data->limit($length, $start);

        foreach ($data as $value) {
            $url = $this->getUrl() . 'editPage?ID=' . $value->ID;

            $btn = "
            <div class='btn-group dropleft'>
                <button type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    Action
                </button>
                <div class='dropdown-menu dropdown-menu-left'>
                    <a href='" . $url . "' class='btn col-sm-12 btn-white edit' data-ID='" . $value->ID . "'>Edit</a>
                    <a class='dropdown-item col-sm-12 btn btn-white delete' data-ID='" . $value->ID . "'>Delete</a>
                </div>
            </div>";

            $count += 1;
            $tempArray = array();
            $tempArray[] = $value->Kode;
            $tempArray[] = $value->Name;
            $tempArray[] = date('d/m/yy', strtotime($value->Date));
            $tempArray[] = $this->formatNumber($value->Total);
            $tempArray[] = $btn;
            $arr[] = $tempArray;
        }

        $result = array(
            'data' => $arr,
            'colomn_sort' => "",
            'params_arr' => $filter_record,
            'recordsTotal' => $dataCont,
            'recordsFiltered' => $dataCont,
            'sql' => '',
            'draw' => $draw,
        );
        //End of set data

        return json_encode($result);
    }

    public function delete()
    {

        $delete = Transaction::get_by_id($_REQUEST['id']);

        $detail = $delete->TransactionDetail();

        foreach ($detail as $key => $value) {
            $value->delete = 1;
            $value->write();
        }

        $delete->Delete = 1;
        $delete->write();

        $data = [
            'message' => 'Data ' . $delete->Kode . ' has been deleted',
            'status' => 200,
            'data' => [],
        ];

        return json_encode($data);
    }

    public function editPage()
    {
        $id = $_REQUEST['ID'];
        $transaction = Transaction::get_by_id($id);
        $transactionDetail = $transaction->TransactionDetail()->where("TransactionDetail.Delete = 0");

        $data = [
            'transaction' => $transaction,
            'detail' => $transactionDetail,
            'date' => date('d/m/Y', strtotime($transaction->Date)),
        ];
        return $data;
    }

    public function update()
    {
        $id = $_REQUEST['id'];
        $date = $this->reverseDate($_REQUEST['Date']);
        $transaction = Transaction::get_by_id($id);
        $detail = $transaction->TransactionDetail();

        foreach ($detail as $value) {
            $value->Delete = 1;
            $value->write();
        }

        foreach ($_REQUEST['detail'] as $value) {
            $value['Price'] = $this->reverseFormat($value['Price']);
            $value['Subtotal'] = $this->reverseFormat($value['Subtotal']);
            $value['Qty'] = $this->reverseFormat($value['Qty']);
            $idDetail = TransactionDetail::create($value)->write();
            $transactionDetail = TransactionDetail::get_by_id($idDetail);
            $transaction->TransactionDetail()->add($transactionDetail);

            $product = Product::get_by_id($value['ProductID']);
            $product->Qty = $product->Qty - $this->reverseFormat($value['Qty']);
            $product->write();
        }
        $transaction->Name = $_REQUEST['Name'];
        $transaction->Date = $date;
        $transaction->Description = $_REQUEST['Description'];
        $transaction->Total = $this->reverseFormat($_REQUEST['Total']);
        $transaction->write();

        $data = [
            'status' => 200,
            'message' => 'success',
            'data' => [],
        ];

        return json_encode($data);
    }

    public function renderProduct($id)
    {
        $detail = TransactionDetail::get_by_id($id)->ProductID;
        $product = Product::get();
        $option = "<option value=''>-- Pilih Product --</option>";
        foreach ($product as $value) {
            if ($value->ID == $detail) {
                $option .= "<option value='{$value->ID}' selected>{$value->Name}</option>";
            } else {
                $option .= "<option value='{$value->ID}'>{$value->Name}</option>";
            }
        }

        return $option;
    }

    public function sendNotif()
    {
        $content = $_REQUEST['Message'];
        $recipient = $_REQUEST['recipient'];
        $subject = $_REQUEST['subject'];

        if ($_REQUEST['type'] == 'Email') {
            MGNotif::sendEmail($content, $recipient, $subject);

            $message = "sending Email to {$subject} was successful";
        } elseif ($_REQUEST['type'] == 'WA') {
            MGNotif::sendWA($content, $recipient, $subject);

            $message = "sending WA to {$subject} was successful";
        }

        $data = [
            'status' => 200,
            'message' => $message,
            'data' => [],
        ];

        return json_encode($data);
    }

}
