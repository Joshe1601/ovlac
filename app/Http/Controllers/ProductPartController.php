<?php

namespace App\Http\Controllers;

use App\Helpers\AuthenticationHelper;
use App\Models\Product;
use App\Models\ProductPart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

use Illuminate\Support\Facades\File;


class ProductPartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        dd('store de las partes del producto');
        $productPart = new ProductPart();
        return $this->update($request, $productPart);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductPart  $productPart
     * @return \Illuminate\Http\Response
     */
    public function show(ProductPart $productPart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductPart  $productPart
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductPart $productPart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductPart  $productPart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductPart $productPart = null)
    {
        //dd('UPDATE product part', $request->query('api_token'));
        // Auth block
        $api_token = $request->query('api_token');
        $is_logged = AuthenticationHelper::isLogged($api_token);
        $is_admin = AuthenticationHelper::isAdmin($api_token);
        if ($is_logged == null || $is_admin == null) {
            $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=login').replace('md=product_part', 'md=auth').concat('&error=You need admin permission.');</script>";
            return $redirect;
        }

        $submit = $request->get('submit');
        if ($submit && strpos($submit, 'remove_') !== false) {
            $part_id = intval(str_replace('remove_', '', $submit));
            $part = ProductPart::find($part_id);
            return $this->destroy($request, $part);

        } else if ($submit && strpos($submit, 'delete_model_') !== false) {
            $part_id = intval(str_replace('delete_model_', '', $submit));
            $part = ProductPart::find($part_id);
            if(!$part) {
                $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=edit').replace('md=product_part', 'md=product').replace('id=".$request->get('id')."', 'id=".$request->get('product_id')."');</script>";
                return $redirect;
            }
            return $this->remove_model($request, $part);

        } else if ($submit && strpos($submit, 'delete_image_') !== false) {
            $part_id = intval(str_replace('delete_image_', '', $submit));
            $part = ProductPart::find($part_id);
            if(!$part) {
                $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=edit').replace('md=product_part', 'md=product').replace('id=".$request->get('id')."', 'id=".$request->get('product_id')."');</script>";
                return $redirect;
            }
            return $this->remove_image($request, $part);

        } else {
            if (is_null($productPart)) {
                $productPart = new ProductPart();
            }

            $this->part_update($request, $productPart);

            $subparts = $request->get('subparts');
            if (is_array($subparts)) {
                foreach ($subparts as $part_id => $part_data) {
                    $update = true;
                    if (strpos($part_id, 'new') !== false) {
                        $update = false;
                    }
                    if (!$update) {
                        $part = new ProductPart(['product_id' => $request->get('product_id')]);
                    } else {
                        $part = ProductPart::find($part_id);
                    }
                    $this->part_update($request, $part, $part_id);
                    //$part->fill($part_data);
                }
            }




        }
        $this->updateIsLastNode($subparts);
        //$redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=edit').replace('md=product_part', 'md=product').replace('product_id=".$request->get('product_id')."', 'id=".$request->get('product_id')."');</script>"; //.replace('id=".$request->get('id')."', 'id=".$request->get('product_id')."')
        $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=edit').replace('md=product_part', 'md=product').replace('&id=".$request->get('id')."', '').replace('product_id=".$request->get('product_id')."', 'id=".$request->get('product_id')."');</script>"; //
        echo $redirect;
    }

    private function part_update(Request $request, ProductPart $productPart, $index_subpart = -1) {
        $model_key = 'model';
        $image_key = 'image';
        if ($index_subpart != -1) {
            if (empty($request->get('subparts')[$index_subpart]['title'])) {
                return;
            }

            $productPart->fill($request->get('subparts')[$index_subpart]);
            if (!isset($request->get('subparts')[$index_subpart]['colorize'])) {
                $productPart->color = '';
            }
            $model_key = 'subparts.' . $index_subpart . '.' . $model_key;
            $image_key = 'subparts.' . $index_subpart . '.' . $image_key;
        } else {
            $productPart->fill($request->all());
            if (!$request->get('colorize')) {
                $productPart->color = '';
            }
        }

        if ($request->hasFile($model_key)) {
            $file = $request->file($model_key);
            $extension = $file->extension();
            $name = basename($file->path());
            $dest = base_path() . "/storage/app/models/".$name.'.'.$extension;
            move_uploaded_file($file->path(), $dest);

            $dest_folder = base_path() .  "/storage/app/models/".$name.'/';

            $zip = new ZipArchive;
            $res = $zip->open($dest);
            $zip->extractTo($dest_folder);
            $zip->close();

            unlink($dest);

            $models = glob($dest_folder . "*.gltf");
            if (!isset($models[0])) {
                $models = glob($dest_folder . "*.glb");
                if (!isset($models[0])) {
                    $models = glob($dest_folder . "*.hdr");
                    if (!isset($models[0])) {
                        $models = glob($dest_folder . "*.obj");
                        if (!isset($models[0])) {
                            $models = glob($dest_folder . "*.fbx");
                        }
                    }
                }
            }
            if (!isset($models[0])) {
                die("File not suported");
            }

            $gltf = basename($models[0]);

            //dd("/storage/app/models/".$name.'/'.$gltf);

            $productPart->model = "/storage/app/models/".$name.'/'.$gltf;
        }

        if ($request->hasFile($image_key)) {
            $file = $request->file($image_key);
            $extension = $file->extension();
            $name = basename($file->path());
            $dest = base_path() . "/storage/app/images/".$name.'.'.$extension;
            move_uploaded_file($file->path(), $dest);
            $productPart->image = "/storage/app/images/".$name.'.'.$extension;
        }


        $productPart->save();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductPart  $productPart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ProductPart $productPart)
    {
        //dd("destroy " . $productPart->id . "   " . dirname(relative_path() . $productPart->model));
        $productPart->delete();
        $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=edit').replace('md=product_part', 'md=product').replace('id=".$request->get('id')."', 'id=".$request->get('product_id')."');</script>";
        return $redirect;
    }

    public function remove_model(Request $request, ProductPart $productPart)
    {
        $productPart->model = '';
        $productPart->save();
        $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=edit').replace('md=product_part', 'md=product').replace('id=".$request->get('id')."', 'id=".$request->get('product_id')."');</script>";
        return $redirect;
    }

    public function remove_image(Request $request, ProductPart $productPart)
    {
        $productPart->image = '';
        $productPart->save();
        $redirect = "<script>window.location.href = window.location.href.replace('action=update', 'action=edit').replace('md=product_part', 'md=product').replace('id=".$request->get('id')."', 'id=".$request->get('product_id')."');</script>";
        return $redirect;
    }

    public function updateIsLastNode($subparts)
    {
        try {

            if (is_array($subparts)) {
                foreach ($subparts as $part_id => $part_data) {
                    if (strpos($part_id, 'new') !== false) {
                        if($part_data['product_part_id'])
                        {

                            $product_part_parent = ProductPart::findOrFail($part_data['product_part_id']);
                            //dd($product_part_parent);
                            $product_part_parent->is_last_node = 0;
                            $product_part_parent->save();
                        }
                    }
                }
            }
        } catch (\Exception $e)
        {
            dd('falla el update isLastNode', $e);
        }
    }
}
