<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Models\Product;
use App\Models\ProductPart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Helpers\AuthenticationHelper;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;

class ProductController extends Controller
{

    static $model_tag = 'product';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Auth block
        $api_token = $request->api_token;
        $is_logged = AuthenticationHelper::isLogged($api_token);
        $is_admin = AuthenticationHelper::isAdmin($api_token);
        if ($is_logged == null) {
            $redirect = "<script>window.location.href = window.location.href.replace('action=index', 'action=login').replace('md=product', 'md=auth').concat('&error=You need admin permission.');</script>";
            return $redirect;
        }

        $products = Product::all();
        $html = View::make(self::$model_tag . '.model_list', [
            'products' => $products,
            'api_token' => $api_token,
            'is_admin' => $is_admin,
            'is_logged' => $is_logged
//            'user' => $user
        ])->render();
        return $html;
    }


    /**
     * Display a listing of the resource just for the user
     *
     * @return \Illuminate\Http\Response
     */
    public function public_list(Request $request)
    {
        // Auth block
//        $api_token = $request->api_token;
//        $is_logged = AuthenticationHelper::isLogged($api_token);
//        $is_admin = AuthenticationHelper::isAdmin($api_token);
//         if ($is_logged == null) {
//            $redirect = "<script>window.location.href = window.location.href.replace('action=public_list', 'action=login').replace('md=product', 'md=auth').concat('&error=You need admin permission.');</script>";
//            return $redirect;
//        }

        $products = Product::all();
        $html = View::make(self::$model_tag . '.public_list', [
            'products' => $products,
//            'api_token' => $api_token,
//            'is_admin' => $is_admin,
//            'is_logged' => $is_logged
//            'user' => $user
        ])->render();
        return $html;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //dd($request->api_token);
        $empty_part = new ProductPart();
        $empty_part->id = 0;

        // Auth block
        $api_token = $request->api_token;
        $is_logged = AuthenticationHelper::isLogged($api_token);
        $is_admin = AuthenticationHelper::isAdmin($api_token);
        if ($is_logged == null || $is_admin == null) {
            $redirect = "<script>window.location.href = window.location.href.replace('action=create', 'action=login').replace('md=product', 'md=auth').concat('&error=You need admin permission.');</script>";
            return $redirect;
        }

        $product = new Product();
        $html = View::make(self::$model_tag . '.model_edit', [
            'form_action' => 'store',
            'product' => $product,
            'empty_part' => $empty_part,
            'api_token' => $request->api_token,
            'is_admin' => $is_admin,
        ])->render();
        return $html;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Auth block
        $api_token = $request->api_token;
        $is_logged = AuthenticationHelper::isLogged($api_token);
        $is_admin = AuthenticationHelper::isAdmin($api_token);
        if ($is_admin == null) {
            $redirect = "<script>window.location.href = window.location.href.replace('action=store', 'action=login').replace('md=product', 'md=auth').concat('&error=You need admin permission.');</script>";
            return $redirect;
        }

        $submit = $request->get('submit');
        if ($submit && strpos($submit, 'delete_image_') !== false) {
            $part_id = intval(str_replace('delete_image_', '', $submit));
            $part = Product::find($part_id);
            if(!$part) {
                $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=index').replace('action=store', 'action=index');</script>";
                return $redirect;
            }
            return $this->remove_image($request, $part);
        }

        $product = new Product($request->all());
        $product->fill($request->all());

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->extension();
            $name = basename($file->path());
            $dest = base_path() . "/storage/app/images/".$name.'.'.$extension;
            move_uploaded_file($file->path(), $dest);
            $product->image = "/storage/app/images/".$name.'.'.$extension;
        }
        $product->save();

        $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=index').replace('action=store', 'action=index');</script>";
        return $redirect;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request , ?Product $product)
    {

        $data = [];
        $data['parts'] = [];

        $data['magnify'] = 1;


        $data['empty_part'] = new ProductPart();
        $data['product'] = $product;
        $data['cam_debug'] = false;
        $data['variable_parts'] = ProductPart::tree()
            ->where('product_id', $product->id)
            ->where('fixed', 0);

        if ($request->get('cam_debug') == 1) $data['cam_debug'] = true;
        $html = View::make('front', $data)->render();
        return $html;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Product $product)
    {
        // Auth block
        $api_token = $request->api_token;
        $is_logged = AuthenticationHelper::isLogged($api_token);
        $is_admin = AuthenticationHelper::isAdmin($api_token);
        if ($is_logged == null || $is_admin == null) {
            $redirect = "<script>window.location.href = window.location.href.replace('action=edit', 'action=login').replace('md=product', 'md=auth').concat('&error=You need admin permission.');</script>";
            return $redirect;
        }

        $empty_part = new ProductPart();
        $empty_part->id = 0;
        $html = View::make(self::$model_tag . '.model_edit', [
            'form_action' => 'update',
            'product' => $product,
            'empty_part' => $empty_part,
            'api_token' => $request->api_token,
            'is_admin' => $is_admin,
        ])->render();
        return $html;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
       // dd($request);
        // Auth block
        $api_token = $request->api_token;
        $is_logged = AuthenticationHelper::isLogged($api_token);
        $is_admin = AuthenticationHelper::isAdmin($api_token);
        if ($is_logged == null || $is_admin == null) {
            $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=login').replace('md=product', 'md=auth').concat('&error=You need admin permission.');</script>";
            return $redirect;
        }

        $submit = $request->get('submit');
        if ($submit && strpos($submit, 'delete_image_') !== false) {
            $part_id = intval(str_replace('delete_image_', '', $submit));
            $part = Product::find($part_id);
            return $this->remove_image($request, $part);
        }

        $product->fill($request->all());
        if(!$request->has_light) {
            $product->has_light = 0;
        }
        if(!$request->has_shadow) {
            $product->has_shadow = 0;
        }
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->extension();
            $name = basename($file->path());
            $dest = base_path() . "/storage/app/images/".$name.'.'.$extension;
            move_uploaded_file($file->path(), $dest);
            $product->image = "/storage/app/images/".$name.'.'.$extension;
        }
        $product->save();

        $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=edit').concat('&api_token=$api_token');</script>";
        return $redirect;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        // Auth block
        $api_token = $request->api_token;
        $is_admin = AuthenticationHelper::isAdmin($api_token);
        if ($is_admin == null) {
            $redirect = "<script>window.location.href = window.location.href.replace('action=destroy', 'action=login').replace('md=product', 'md=auth').concat('&error=You need admin permission.');</script>";
            return $redirect;
        }

        $id = $product->id;
        //dd('Aqui llegamos', $id, $product);
        $product->delete();

        $redirect = "<script>window.location.href = window.location.href.replace('action=destroy', 'action=index').replace('&id=".$id."', '').concat('&api_token=$api_token');</script>";
        return $redirect;
    }


    public function remove_image(Request $request, Product $product)
    {
        $product->image = '';
        $product->save();
        $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=edit');</script>";
        return $redirect;
    }

    public function install_db(Request $request)
    {
        if (!Schema::hasTable('fpc_migrations')) {
            Artisan::call('migrate:install');
        }
        if ($request->get('force') == 'force') {
            Artisan::call('migrate', ['--force' => '1']);
        } else {
            Artisan::call('migrate');
        }
        return "DB tables created successfully. You can close this window now.";
    }

    public function submit_form(Request $request)
    {
        $prod_data = $request->get('prod_data');
        $prod_data = base64_decode($prod_data);
        $prod_data = json_decode($prod_data, true);

        // put the selected models on product_parts array
        $selected_models_ids = [];
        foreach($prod_data['selected_models'] as $selected) {
            $selected_models_ids[] = $selected['model_id'];
        }
        $product_parts_selected = ProductPart::whereIn('id', $selected_models_ids)->get();
        $prod_data["product_parts"] = $product_parts_selected;

        $product = Product::find($prod_data['product_id']);
        $prod_data["product"] = $product;

        // Get the screenshot filename
        $screenshot = $prod_data['screenshot'];

        $currentDir = __DIR__;
        $fixedDir = dirname(dirname(dirname($currentDir)));
        $screenshotPath = $fixedDir . '/storage/app/captures/' . $screenshot;
        $screenshotPath = str_replace('\\', '/', $screenshotPath);

        $prod_data["relative_path"] = $fixedDir;
        $prod_data["screenshot_path"] = $screenshotPath;


        $pdf = Pdf::loadView('pdf', $prod_data);
        $pdf_data = $pdf->output();

        $view_data['pdf_data'] = $pdf_data;

        $html = View::make('file_download', $view_data)->render();
        return $html;
    }

    public function send_email(Request $request)
    {
        $this->validate(
            $request, [
                'inputFullname' => 'required|string',
                'inputProvince' => 'required|string',
                'inputEmail' => 'required|email'
            ]
        );

        // put the selected models id on an array for get their data later
        $selected_models_ids = $request->input('input_selected_models_id');
        $models_array = explode(',', $selected_models_ids);
        $models_array = array_filter($models_array, function($value){
            return $value !== '';
        });
        $models_array = array_map('intval', $models_array); // models selected ids [title, price]
        // get the product id
        $hidden_product_id = $request->input('input_product_id'); // product [title, price]
        $product_id = intval($hidden_product_id);
        // get the total price amount
        $total_price = $request->input('input_total_price');


        $fullName = $request->input('inputFullname');
        $province = $request->input('inputProvince');
        $email = $request->input('inputEmail');


        // Data for sending on the email
        $product = Product::findOrFail($product_id);

        // Body - Presupuesto
        $mail_body = view('emails.product', compact('product', 'models_array', 'total_price'))->render();

        // Titulo email
        $mail_subject = "Presupuesto: " . $product->title;
        try {
            MailHelper::sendTextMail($email, $fullName,
                $mail_subject, $mail_body);
        } catch (\Exception $e) {
            dd('Mail Error', $e);
            echo 'Excepción capturada: ', $e->getMessage(), "\n";
        }


        // REDIRECCION TO SHOW PRODUCT - is loading again the product-show -> front.blade.php
        $data = [];
        $data['magnify'] = 1;
        $data['empty_part'] = new ProductPart();
        $product = Product::findOrFail($product_id);
        $data['product'] = $product;
        $data['cam_debug'] = false;
        $data['variable_parts'] = ProductPart::tree()
            ->where('product_id', $product_id)
            ->where('fixed', 0);

        $html = View::make('front', $data)->render();
        return $html;
    }





//    public function save_image(Request $request) {
//
//        $imageData = $request->input('imageData');
//        $saveDirectory = $request->input('saveDirectory');
//
//        // Convert data url to image file
//        $image = str_replace('data:image/png;base64,', '', $imageData);
//        $image = str_replace(' ', '+', $image);
//        $imageData = base64_decode($image);
//
//        // Save image file to specified directory
//        $imageName = 'screenshot.png';
//        $path = storage_path('app/' . $saveDirectory . '/') . $imageName;
//        file_put_contents($path, $imageData);
//
//        return response()->json(['success' => true, 'imagePath' => $path]);
//    }
}
