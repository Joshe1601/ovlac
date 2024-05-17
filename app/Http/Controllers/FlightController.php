<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\Product;
use App\Models\ProductPart;
use App\Models\ProductPartVariation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use App\Helpers\AuthenticationHelper;

class FlightController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $module = $request->get('md') ?: $request->get('module');
        $action = $request->get('action');
        $id = $request->get('id');

        if (!$action) $action = 'login';
        if (!$module) $module = 'auth'; // default module product as index


        // add actions: login, register
        $actions = [
            'index', 'create', 'store', 'edit', 'update', 'destroy', 'show',
            'install_db', 'submit_form', 'activate',
            'login', 'verify_user', 'logout',
            'public_list',
            'send_email'
//            'save_image'
        ];
        if (!in_array($action, $actions)) dd("INVALID ACTION", $action);

        $controller = null;
        $object = null;

        switch ($module) {
            case 'product':
                $controller = new ProductController();
                if ($id) $object = Product::find($id);
                break;

            case 'product_part':
                $controller = new ProductPartController();
                if ($id) $object = ProductPart::findOrFail($id);
                break;

            case 'product_part_variation':
                $controller = new ProductPartVariationController();
                if ($id) $object = ProductPartVariation::findOrFail($id);
                break;

            case 'user':
                $controller = new UserController();
                if ($id) $object = User::findOrFail($id);
                break;

            case 'auth':
                $controller = new AuthController();
                if ($id) $object = User::findOrFail($id);
                break;

            default:
                dd($request->all());
                break;
        }


        switch ($action) {

            case 'install_db':
            case 'submit_form':
                return $controller->$action($request);
                break;

            case 'create':
                return $controller->$action($request);
                break;

            case 'store':
                return $controller->$action($request);
                break;

            case 'show':
                return $controller->$action($request, $object);
                break;

            case 'edit':
                return $controller->$action($request, $object);
                break;

            case 'update':
                return $controller->$action($request, $object);
                break;

            case 'destroy':
                return $controller->$action($request, $object);
                break;

            default:
            case 'index':
                return $controller->$action($request);
                break;
        }
        //$controller->$action($request);
        return;


        //(new FlightController)->index($request);

        $html = View::make('model_list')->render();
        echo $html;

        $posts = DB::table('posts')->get();
        //dd($posts);
        //dd(config('database'));
        //dd($request->all());


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Flight  $flight
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
