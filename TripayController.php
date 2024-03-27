<?php

namespace Andreracodex\Tripay;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\Setting;
use App\Models\ShortURL;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Number;

class TripayController extends Controller
{
    public function instruction($tripay)
    {
        $profile = Setting::all();
        $tripays = strtoupper($tripay);
        if ($tripays != 'MANDIRIVA' && $tripays != 'BCAVA' && $tripays != 'BRIVA' && $tripays != 'BNIVA' && $tripays != 'ALFAMART' && $tripays != 'ALFAMIDI' && $tripays != 'INDOMARET') {
            return view('tripay::failed', compact('profile'));
        }
        $apiKey = env('TRIPAY_API_KEY');
        $baseURL = env('TRIPAY_API_DEBUG') ? 'https://tripay.co.id/api-sandbox/' : 'https://tripay.co.id/api/';
        $payload = ['code' => $tripays];


        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => $baseURL . 'payment/instruction?' . http_build_query($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);
        if ($response) {
            $data = json_decode($response, true)['data'];
            return view('tripay::instruction', compact('data', 'profile'));
        }
    }

    public function merchant()
    {
        $profile = Setting::all();
        $apiKey = env('TRIPAY_API_KEY');
        $baseURL = env('TRIPAY_API_DEBUG') ? 'https://tripay.co.id/api-sandbox/' : 'https://tripay.co.id/api/';

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            => $baseURL . 'merchant/payment-channel',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($response) {
            $data = json_decode($response, true)['data'];

            return view('tripay::merchant', compact('data', 'profile'));
        }
    }

    public function transaction($tripay, $invoices, $amount)
    {
        $profile = Setting::all();
        $apiKey = env('TRIPAY_API_KEY');
        $privateKey   = env('TRIPAY_API_SECRET');
        $merchantCode = env('TRIPAY_MERCHANT_CODE');
        $base = env('APP_URL');
        $baseURL = env('TRIPAY_API_DEBUG') ? 'https://tripay.co.id/api-sandbox/' : 'https://tripay.co.id/api/';
        $merchantRef  = $invoices;
        $amount       = $amount;

        $inv = OrderDetail::leftJoin('orders', 'order_details.order_id', 'orders.id')
            ->leftJoin('customers', 'orders.customer_id', 'customers.id')
            ->leftJoin('users', 'customers.user_id', 'users.id')
            ->leftJoin('pakets', 'orders.paket_id', 'pakets.id')
            ->where('order_details.invoice_number', $invoices)->first();

        $data = [
            'method'         => $tripay,
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => $inv->nama_customer,
            'customer_email' => $inv->email,
            'customer_phone' => $inv->nomor_telephone,
            'order_items'    => [
                [
                    'sku'         => $inv->nama_paket,
                    'name'        => $inv->jenis_paket,
                    'price'       => $amount,
                    'quantity'    => 1,
                ],
            ],
            'return_url'   => $baseURL . '/tripay/redirect',
            'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
            'signature'    => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            =>  $baseURL . 'transaction/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);
        $data = json_decode($response, true)['data'];

        return view('tripay::result', compact('data', 'profile'));
    }

    public function callback()
    {
        return view('tripay::callback', compact('callback'));
    }

    public function short(Request $request)
    {
        // $request->validate([
        //     'url' => 'required|url',
        // ]);

        // $shortURL = ShortURL::create([
        //     'original_url' => $request->url,
        //     'short_code' => Str::random(6), // Generate a random short code
        // ]);

        // return response()->json([
        //     'short_url' => route('short-url.redirect', $shortURL->short_code),
        // ]);
    }

    public function merchantstore(Request $request){
        $invoices = $request->input('invoice_number');
        $tripay = $request->input('code');

        $detail = OrderDetail::leftJoin('orders', 'order_details.order_id', 'orders.id')
            ->leftJoin('pakets', 'orders.paket_id', 'pakets.id')
            ->where('order_details.invoice_number', $invoices)->first();

        $amount = intval($detail->harga_paket);

        $profile = Setting::all();
        $apiKey = env('TRIPAY_API_KEY');
        $privateKey   = env('TRIPAY_API_SECRET');
        $merchantCode = env('TRIPAY_MERCHANT_CODE');
        $base = env('APP_URL');
        $baseURL = env('TRIPAY_API_DEBUG') ? 'https://tripay.co.id/api-sandbox/' : 'https://tripay.co.id/api/';
        $merchantRef  = $invoices;

        $inv = OrderDetail::leftJoin('orders', 'order_details.order_id', 'orders.id')
            ->leftJoin('customers', 'orders.customer_id', 'customers.id')
            ->leftJoin('users', 'customers.user_id', 'users.id')
            ->leftJoin('pakets', 'orders.paket_id', 'pakets.id')
            ->where('order_details.invoice_number', $invoices)->first();

        $data = [
            'method'         => $tripay,
            'merchant_ref'   => $merchantRef,
            'amount'         => $amount,
            'customer_name'  => $inv->nama_customer,
            'customer_email' => $inv->email,
            'customer_phone' => $inv->nomor_telephone,
            'order_items'    => [
                [
                    'sku'         => $inv->nama_paket,
                    'name'        => $inv->jenis_paket,
                    'price'       => $amount,
                    'quantity'    => 1,
                ],
            ],
            'return_url'   => $baseURL . '/tripay/redirect',
            'expired_time' => (time() + (24 * 60 * 60)), // 24 jam
            'signature'    => hash_hmac('sha256', $merchantCode . $merchantRef . $amount, $privateKey)
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_URL            =>  $baseURL . 'transaction/create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_HTTPHEADER     => ['Authorization: Bearer ' . $apiKey],
            CURLOPT_FAILONERROR    => false,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);
        $data = json_decode($response, true)['data'];

        // Kirim WA
        $message = "*Yth Pelanggan GNET*\n\n";
        $message .= "Hallo Bapak/Ibu,\n";
        $message .= "Customer Name :\n*".$data['customer_name']."*\n\n";
        $message .= "Berikut detail, pembayaran melalui virtual account :\n\n";
        $message .= "Merchant Ref : _*".$data['reference']."*_\n";
        $message .= "Payment Name : *".$data['payment_name']."*\n";
        $message .= "Pay Code (Virtual Number) : *".$data['pay_code']."*\n\n";
        $message .= "Harga Paket : _*".'Rp ' . number_format($data['amount_received'], 0, ',', '.')."*_\n";
        $message .= "Customer Fee : _*".'Rp ' . number_format($data['fee_merchant'], 0, ',', '.')."*_\n";
        $message .= "Jumlah yang Harus Dibayar : _*".'Rp ' . number_format($data['amount'], 0, ',', '.')."*_\n";
        $message .= "Status : *".$data['status']."*\n";
        $message .= "Bayar Sebelum : *".date('d F Y H:i', $data['expired_time'])."*\n\n";
        $message .= "Segera lakukan pembayaran sebelum tanggal jatuh tempo, untuk mencegah isolir\n";
        $message .= "Terima Kasih, Untuk perhatiannya \n\n";
        $message .= "Hormat kami\n*PT. Global Data Network*\nJl. Dinoyo Tenun No 109, RT.006/RW.003, Kel, Keputran, Kec, Tegalsari, Kota Surabaya, Jawa Timur 60265.\nPhone : 085731770730 / 085648747901\n\n";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => convert_phone($inv->nomor_telephone),
                'message' => $message,
                'countryCode' => '62', //optional
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: F#3Ny@o4WUtC7SYuiEUx' //change TOKEN to your actual token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return view('tripay::result', compact('data', 'profile'));
    }

    public function redirect($code)
    {
        $shortURL = ShortURL::where('short_code', $code)->firstOrFail();

        return redirect($shortURL->original_url);
    }
}
