<?php

namespace App\Controllers;

use App\Models\ApplicationModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['url', 'text', 'wallet_helper', 'inflector'];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        session();
    }

    protected function sendSms($mobile, $message)
    {
        return true;
    }

    protected function generateReferalCode(): string
    {
        $model = new ApplicationModel('users', 'uid');
        $referalCode = random_string('alnum', 6);
        while (true) {
            $check = $model->select('uid')->where('referal_code', $referalCode)->first();
            if (!$check)
                break;
        }
        return $referalCode;
    }

    protected function curlRequestCashFree($path = '', $formData = [])
    {
        // $formData = [
        //     'customer_details' => [
        //         'customer_id' => 'user_1',
        //         'customer_email' => 'test@gmail.com',
        //         'customer_phone' => '9999999999'
        //     ],
        //     'order_meta' => [
        //         'return_url' => 'http://localhost/payment/response/{order_id}',
        //         'payment_methods' => 'cc,nb,upi,app,dc,banktransfer'
        //     ],
        //     'order_id' => 'order_1001' . uniqid(),
        //     'order_amount' => 1,
        //     'order_currency' => 'INR'
        // ];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://sandbox.cashfree.com/pg/' . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($formData),
            CURLOPT_HTTPHEADER => [
                'accept: application/json',
                'content-type: application/json',
                'x-api-version: 2022-09-01',
                'x-client-id: ' . CASHFREE_KEY,
                'x-client-secret: ' . CASHFREE_SECRET_KEY
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            //echo 'cURL Error #:' . $err;
            return ['status' => false, 'data' => $err];
        } else {
            return ['status' => true, 'data' => json_decode($response, true)];
        }
    }

    protected function checkStatusCashFree($orderId = "")
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sandbox.cashfree.com/pg/orders/' . $orderId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'x-client-id: ' . CASHFREE_KEY,
                'x-client-secret: ' . CASHFREE_SECRET_KEY,
                'x-api-version: 2021-05-21'
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            //echo 'cURL Error #:' . $err;
            return ['status' => false, 'data' => $err];
        } else {
            return ['status' => true, 'data' => json_decode($response, true)];
        }
    }

    protected function crTransaction($userId, $amount, $type)
    {
        $balance = availableBalanceByUserId($userId);
        $wtrandData = [
            'user_id' => $userId,
            'amount' => $amount,
            'amount_type' => 'cr',
            'transaction_type' => $type,
            'before_balance' => $balance,
            'after_balance' => $balance + $amount,
            'is_withdrawable' => 1
        ];
        $transactionModel = new ApplicationModel('wallet_transactions', 'wid');
        $y = $transactionModel->insert($wtrandData);
        if ($y) {
            $model = new ApplicationModel('users', 'uid');
            $x = $model->set('balance', '`balance` + ' . $amount, false)->where('uid', $userId)->update();
            if ($x) {
                return ['status' => true, 'message' => "success"];
            } else {
                $transactionModel->delete($y);
            }
        }
        return ['status' => false, 'message' => "Something went wrong."];
    }
}
