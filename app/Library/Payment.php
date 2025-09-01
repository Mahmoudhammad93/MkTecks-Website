<?php

namespace App\Library;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Loyality;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Payment extends Controller
{
    //// Test /////
    private static $apiURL = "https://apitest.myfatoorah.com/";
    private static $apiToken = "rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL";

    public static function proceed($orderId, $total, $data)
    {
        $data = [
            'PaymentMethodId' => 1,
            'CustomerName' => $data["name"],
            'DisplayCurrencyIso' => "KWD",
            'CurrencyIso' => "KWD",
            'MobileCountryCode' => '+965',
            'CustomerMobile' => $data["phone"],
            'CustomerEmail' => $data["email"],
            'InvoiceValue' => number_format($total, 3),
            'InvoiceAmount' => number_format($total, 3),
            'CallBackUrl' => url('api/checkout/payment/callback/success'),
            'ErrorUrl' => url('api/checkout/payment/callback/faild'),
            'Language' => lang(),
            'CustomerReference' => $orderId,
            'CustomerCivilId' => 12345678,
            'UserDefinedField' => userLogin(),
            'ExpireDate' => '',
        ];

        $response = Http::withToken(self::$apiToken)->post(self::$apiURL . "/v2/ExecutePayment", $data);
        $paymentURL = $response->json('Data')["PaymentURL"];
        if ($response->successful() && $response->json('IsSuccess')) {
            return redirect()->away($paymentURL);
        } else {
            return back()->with('faild', 'Please Try Again');
        }
    }

    public function callback_success(Request $request)
    {
        $response = Http::withToken(self::$apiToken)->post(self::$apiURL . "/v2/getPaymentStatus", [
            'Key' => $request->paymentId,
            'KeyType' => 'paymentId',
        ]);
        $orderId = $response->json('Data')["CustomerReference"];
        OrderTransaction::create([
            'order_id' => $orderId,
            'transaction' => json_encode($request->all())
        ]);

        if ($response['IsSuccess'] && $response->json('Data')["InvoiceStatus"] == "Paid") {
            $checkOrder = Order::where('id', $orderId)->first();
            if ($checkOrder->status != "pending") {
                return redirect(url(''));
            }
            Order::where('id', $orderId)->update([
                'status' => 'paid'
            ]);

            Cart::where('user_id', userLogin())->delete();
            $order = Order::where('id', $orderId)->with('products.product.image', 'user', 'address')->first();
            Notification::create([
                'model' => "\App\Models\Order",
                'model_id' => $orderId,
                'title_ar' => "طلب جديد",
                'title_en' => "New Order",
                'content_ar' => "لديك طلب جديد من العضو " . $order->address->name,
                'content_en' => "Have New Order From "  . $order->address->name,
            ]);

            if (Auth::check()) {
                $user = User::where('id', userLogin())->first();
                $loyality = Loyality::where('user_id', userLogin())->orderBy('id', 'desc')->first();
                if ($loyality) {
                    Loyality::create([
                        'user_id' => userLogin(),
                        'bonus' => $order->total,
                        'total' => $order->total + $loyality->total,
                        'description_ar' => "لقد اكتسبت عدد النقاط من خلال اتمامك للطلب # " . $order->id,
                        'description_en' => "You have earned the bonus by completing the order " . $order->id,
                    ]);
                } else {
                    Loyality::create([
                        'user_id' => userLogin(),
                        'bonus' => $order->total,
                        'total' => $order->total,
                        'description_ar' => "لقد اكتسبت عدد النقاط من خلال اتمامك للطلب # " . $order->id,
                        'description_en' => "You have earned the bonus by completing the order #" . $order->id,
                    ]);
                }
            }

            return view('web.carts.success', [
                'title' => trans('admin.Payment Method'),
                'address' => Address::where('user_id', userLogin())->where('is_default', 1)->with('area')->first(),
                'order' => $order,
            ]);
        }
    }

    public function callback_faild(Request $request)
    {
        $response = Http::withToken(self::$apiToken)->post(self::$apiURL . "/v2/getPaymentStatus", [
            'Key' => $request->paymentId,
            'KeyType' => 'paymentId',
        ]);
        $orderId = $response->json('Data')["CustomerReference"];
        OrderTransaction::create([
            'order_id' => $orderId,
            'transaction' => json_encode($request->all())
        ]);

        return view('web.carts.faild', [
            'title' => trans('admin.Payment Faild')
        ]);
    }
}
