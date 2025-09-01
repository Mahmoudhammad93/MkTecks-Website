<?php

use App\Models\AdminLog;
use App\Models\Banner;
use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Notification;
use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\RoleUser;
use App\Models\Setting;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

function responseSuccess($message, $data)
{
    return response([
        "success" => true,
        "message" => $message,
        "data"    => $data,
    ], 200);
}

function responseSuccessWithPaginate($message, $data)
{
    return response([
        "success" => true,
        "message" => $message,
        "data"    => $data,
        "paginate" => [
            'current_page' => $data->currentPage(),
            'has_pages' => $data->hasPages(),
            'next_page_url' => (string)$data->nextPageUrl(),
            'per_page' => $data->perPage(),
        ]
    ], 200);
}

function responseSuccessMessage($message)
{
    return response([
        "success" => true,
        "message" => $message,
    ], 200);
}

function responseError($exception)
{
    return response([
        "success" => false,
        "message" => trans('app.sorry_somthing_wrong'),
        "file" => $exception->getFile(),
        "line" => $exception->getLine(),
        "exception" => $exception->getMessage(),
    ], 200);
}

function responseValid($message)
{
    return response([
        "success" => false,
        "message" => $message
    ], 200);
}

if (!function_exists('userLogin')) {
    function userLogin()
    {
        if (Auth::check()) {
            if(Auth::user()->user_type == "user"){
                return Auth::user()->id;
            }
        }
        $user_id = 0;
        if (Session::get('user_id')) {
            $user_id = Session::get('user_id');
        } else {
            $user_id = uniqid();
            Session::put('user_id', $user_id);
        }
        return $user_id;
    }
}

if (!function_exists('apiUserLogin')) {
    function apiUserLogin()
    {
        return Auth::user()->id;
    }
}

if (!function_exists('cartsCount')) {
    function cartsCount()
    {
        $cartsProduct = CartProduct::wherehas('cart', function ($query) {
            $query->where('user_id', userLogin());
        })->get();
        return $cartsProduct;
    }
}

if (!function_exists('userLogs')) {
    function userLogs($data)
    {
        $log = new AdminLog();
        $log->user_id = Auth::user()->id;
        $log->model = $data["model"];
        $log->model_id = $data['model_id'];
        $log->description_ar = $data['description_ar'];
        $log->description_en = $data['description_en'];
        $log->status = $data['status'];
        $log->save();

        Notification::create([
            'user_id' => Auth::user()->id,
            'model' => $data["model"],
            'model_id' => $data['model_id'],
            'title_ar' => Auth::user()->name,
            'title_en' => Auth::user()->name,
            'content_ar' => $data['description_ar'],
            'content_en' => $data['description_en'],
        ]);
    }
}

if (!function_exists('categories')) {
    function categories()
    {
        return Category::orderBy('name_' . lang(), 'asc')->withCount('products')->with('image')->take(6)->get();
    }
}

if (!function_exists('aurl')) {
    function aurl($url)
    {
        return url('/admin/' . $url);
    }
}

if (!function_exists('purl')) {
    function purl($url)
    {
        return url('/pos/' . $url);
    }
}

if (!function_exists('lang')) {
    function lang()
    {
        if (Request::is('api/*')) {
            return request()->header('Accept-Language');
        } else {
            if (session()->has('lang')) {
                return session()->get('lang');
            } else {
                if (Auth::check()) {
                    if (adminLogin()->details()->exists()) {
                        session()->put('lang', adminLogin()->details->language);
                        return adminLogin()->details->language;
                    }
                }
                session()->put('lang', 'en');
                return 'en';
            }
        }
    }
}

if (!function_exists('theme')) {
    function theme()
    {
        if (session()->has('theme')) {
            return session()->get('theme');
        } else {
            if (Auth::check()) {
                if (adminLogin()->details()->exists()) {
                    session()->put('theme', adminLogin()->details->theme);
                    return adminLogin()->details->theme;
                }
            }
            session()->put('theme', 'dark');
            return 'dark';
        }
    }
}

if (!function_exists('notifications')) {
    function notifications()
    {
        return Notification::with('user')->whereHas('user')->where('model', '!=', '\App\Models\Order')->take(20)->latest()->get();
    }
}

if (!function_exists('notificationsCount')) {
    function notificationsCount()
    {
        return Notification::with('user')->whereHas('user')->where('model', '!=', '\App\Models\Order')->where('admin_read_at', null)->take(21)->latest()->get();
    }
}

if (!function_exists('newOrders')) {
    function newOrders()
    {
        return Notification::where('model', '\App\Models\Order')->orderBy('created_at', 'desc')->limit(20)->get();
    }
}

if (!function_exists('newOrdersCount')) {
    function newOrdersCount()
    {
        return Notification::where('model', '\App\Models\Order')->where('admin_read_at', null)->orderBy('created_at', 'desc')->limit(21)->get();
    }
}

if (!function_exists('newBoardOrders')) {
    function newBoardOrders()
    {
        return Notification::where('model', '\App\Models\BoardOrder')->orderBy('created_at', 'desc')->limit(20)->get();
    }
}

if (!function_exists('newBoardOrdersCount')) {
    function newBoardOrdersCount()
    {
        return Notification::where('model', '\App\Models\BoardOrder')->where('admin_read_at', null)->orderBy('created_at', 'desc')->limit(21)->get();
    }
}


if (!function_exists('settings')) {
    function settings()
    {
        return Setting::latest()->first();
    }
}

if (!function_exists('adminLogin')) {
    function adminLogin()
    {
        return User::where('id', Auth::user()->id)->first();
    }
}


function headers(){
    return [
        header('Referrer-Policy: strict-origin-when-cross-origin'),
        header('Access-Control-Allow-Origin: *'), // Replace * with the appropriate origin(s) if needed
        header('Access-Control-Allow-Headers: Content-Type, X-Requested-With')
    ];
}

function getAuth(){
    $response = Http::post('https://delivery.mk-techs.com/api/vendor/auth/token', [
        "email" => "m@mktech.com",
        "password" => "12345"
    ]);

    $authData = json_decode($response);
    if($authData->success){
        $authToken = $authData->data->token;
    }

    return $authToken;
}

function is_permited($option){
    $user = Auth::user();
    $permission = Permission::where('name', $option)->first();
    $user_role = RoleUser::where('user_id', $user->id)->first();

    if($user_role && $permission){
        $role_permission = PermissionRole::where('permission_id', $permission->id)
        ->where('role_id', $user_role->role_id)
        // ->orWhere('role_id', $user->additional_role_id)
        ->first();
    }
    return (isset($role_permission))? 1 : 0;
}

function createDeliveryOrder($order, $user, $address, $branch){
    $apiKey = 'AIzaSyACaD1BYeXiO63exUnx0DzRid5uSZnUohM';
    $token = getAuth();
    $obj = ['order' => $order, 'user' => $user, 'address' => $address, 'branch' => $branch];
    $branch_address = getAddressText($branch->latitude, $branch->longitude);


    $address_text = $address->area->name;

    // return $address;

    $coordinates = getCoordinates($address_text);
    if ($coordinates) {
        $user_latitude = $coordinates['latitude'];
        $user_longitude = $coordinates['longitude'];
        // Use the retrieved latitude and longitude as needed
    } else {
        echo "Failed to retrieve coordinates.";
    }

    $companyOrigins = "$branch->latitude,$branch->longitude";
    $userDistinations = "$user_latitude,$user_longitude";
    $url = "https://maps.googleapis.com/maps/api/directions/json?origin=$companyOrigins&destination=$userDistinations&key=$apiKey";
    $response = Http::get($url);
    if (isset($response["routes"][0]["legs"][0]["distance"]["value"])) {
        $value = $response["routes"][0]["legs"][0]["distance"]["value"];
        // return round($value / 1000, 2);
    }


    // return $obj;
    $response = Http::withToken($token)->post('https://delivery.mk-techs.com/api/vendor/orders/create',[
        "customer_name" => $user->name,
        "payment_type" => "COD",
        "mobile_number" => $user->mobile,
        "amount_to_collect" => $order->total,
        "vendor_order_id" => $order->id,
        "pick_up" => [
            "vendor_name" => $branch->name_en,
            "mobile_number" => "84651548",
            "latitude" => $branch->latitude,
            "longitude" => $branch->longitude,
            "area" => (isset($branch_address[1]))?$branch_address[1]['long_name']:'',
            "block" => $branch_address[0]['long_name'],
            "street" => "Fahd Elsalem",
            "building" => "10",
            "landmark" => ""
        ],
        "drop_off" => [
            "latitude" => $user_latitude,
            "longitude" => $user_longitude,
            "landmark" => "",
            "area" => $address->area->name,
            "block" => $address->block,
            "street" => $address->street,
            "building" => $address->building,
            "room_number" => ""
        ]
    ]);
    return json_decode($response->body());
}

function getDeliveryOrders(){
    $token = getAuth();
    $response = Http::withToken($token)->get("https://delivery.mk-techs.com/api/vendor/orders");
    return json_decode($response);
}

function getApiUrl(){
    return 'https://delivery.mk-techs.com/api/vendor';
}

function getAddressText($latitude, $longitude){
    $apiKey = 'AIzaSyACaD1BYeXiO63exUnx0DzRid5uSZnUohM';
    $url = "https://maps.googleapis.com/maps/api/geocode/json?latlng={$latitude},{$longitude}&key={$apiKey}";

    try{
        $response = Http::get($url);
        $data = $response->json();
        if(count($data['results']) > 1){
            $address = $data['results'][3]['address_components'];
        }else{
            $address = $data['results'][0]['address_components'];
        }
        return $address;
    }catch(Exception $e){
        return $e;
    }
}

function getCoordinates($address){
    $apiKey = 'AIzaSyACaD1BYeXiO63exUnx0DzRid5uSZnUohM';
    $formattedAddress = urlencode($address);
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address={$formattedAddress}&key={$apiKey}";

    $response = Http::get($url);
    $data = $response->json();
    $latitude = $data['results'][0]['geometry']['location']['lat'];
    $longitude = $data['results'][0]['geometry']['location']['lng'];
    return ['latitude' => $latitude, 'longitude' => $longitude];
}
