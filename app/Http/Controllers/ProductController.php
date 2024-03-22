<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductPart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
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
        //dd($request->all());
        $prod_data = $request->get('prod_data');
        $prod_data = base64_decode($prod_data);
        $prod_data = json_decode($prod_data, true);
        //dd($prod_data);

        $product = Product::find($prod_data['product_id']);
        $prod_data["product"] = $product;

        $parts_data = $prod_data["product_selected_ids"];
        $items = ProductPart::whereIn('id', $parts_data)->get();
        $prod_data["product_parts"] = $items;
        //dd($items);

        /* $html = View::make('pdf', $prod_data)->render();
        return $html; */

        $pdf = Pdf::loadView('pdf', $prod_data);
        $pdf_data = $pdf->output();


        $view_data['pdf_data'] = $pdf_data;
        $html = View::make('file_download', $view_data)->render();
        return $html;
    }
}
