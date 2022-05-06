<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\VariantResource;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Variant;
use App\Repositories\FileRepository;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    protected $file;
    public function __construct(FileRepository $file)
    {
        $this->file = $file;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (isset($_GET['sortCol'])) {
            $variants = Variant::orderBy($_GET['sortCol'], ($_GET['sortByDesc'] == 1 ? 'desc' : 'asc'));
        } else {
            $variants = Variant::orderBy('variants.id', 'desc');
        }
        if (isset($_GET['perpage']) && intval($_GET['perpage']) > 0) {
            $variants = $variants->paginate($_GET['perpage']);
        } else {
            $variants = $variants->get();
        }
        return VariantResource::collection($variants);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $files = $request->file('image');
        $req_data  = (object)json_decode($request->data);
        $product =  Product::findOrfail($req_data->product_id);
        foreach ($req_data->variants as $vari) {
            $variant = new Variant();
            $variant->product_id = $product->id;
            $variant->attribute_1 = $vari->attribute_1;
            $variant->attribute_2 = $vari->attribute_2;
            $variant->attribute_3 = $vari->attribute_3;
            $variant->attribute_1_value = $vari->attribute_1_value;
            $variant->attribute_2_value = $vari->attribute_2_value;
            $variant->attribute_3_value = $vari->attribute_3_value;
            $variant->sku = $vari->sku;
            $variant->stock = $vari->stock;
            $variant->is_active = ($vari->is_active == true) ? 1 : 0;
            $variant->save();
        }
        foreach ($req_data->attributes as $attribute) {
            $pro_attribute = new ProductAttribute();
            $pro_attribute->product_id = $product->id;
            $pro_attribute->attribute = $attribute->attribute;
            $pro_attribute->save();
            foreach ($attribute->values as $value) {
                $attribute_val = new AttributeValue();
                $attribute_val->product_attribute_id = $pro_attribute->id;
                $attribute_val->value = $value;
                $attribute_val->save();
            }
        }
        if ($files) {
            foreach ($files as $file) {
                $variant_id = getVarientID($file->getClientOriginalName());
                $this->file->create([$file], 'variants', $variant_id);
            }
        }

        return new VariantResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        if($product->has_variant == 1){
        $variants = $product->variant()->get();
        $attributes = $product->attribute()->get();
        $attr1_array = [];
        $attr2_array = [];
        $attr3_array = [];

        $attributes_array = [];
        foreach ($attributes as $key => $attribute) {
            $values_array = [];
            foreach ($attribute->attribute_values()->get()  as $attribute_value) {
                array_push($values_array, $attribute_value->value);
            }
            array_push($attributes_array, [
                'attribute' => $attribute->attribute,
                'values' =>  $values_array,
            ]);
            if ($key == 0) {
                array_push($attr1_array, [
                    'status' => true,
                    'key' => $attribute->attribute,
                    'values' =>  $values_array,
                ]);
            } else if ($key == 1) {
                array_push($attr2_array, [
                    'status' => true,
                    'key' => $attribute->attribute,
                    'values' =>  $values_array,
                ]);
            } else if ($key == 2) {
                array_push($attr3_array, [
                    'status' => true,
                    'key' => $attribute->attribute,
                    'values' =>  $values_array,
                ]);
            }
        }
        $attrb = [
            'attr1_array' => $attr1_array,
            'attr2_array' => $attr2_array,
            'attr3_array' => $attr3_array,
        ];
        return response()->json(['has_variant' => true,'variants' => $variants, 'attributes' => $attributes_array, 'attrb' => $attrb]);
    }
    return response()->json(['has_variant' => false]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $files = $request->file('image');
        $request  = (object)json_decode($request->data);
        $product =  Product::find($request->product_id);

        $this->delete_variants_and_data($product);

        foreach ($request->variants as $vari) {
            $variant = new Variant();
            $variant->id = $vari->id;
            $variant->product_id = $product->id;
            $variant->attribute_1 = $vari->attribute_1;
            $variant->attribute_2 = $vari->attribute_2;
            $variant->attribute_3 = $vari->attribute_3;
            $variant->attribute_1_value = $vari->attribute_1_value;
            $variant->attribute_2_value = $vari->attribute_2_value;
            $variant->attribute_3_value = $vari->attribute_3_value;
            $variant->sku = $vari->sku;
            $variant->stock = $vari->stock;
            $variant->is_active = ($vari->is_active == true) ? 1 : 0;
            $variant->save();
        }
        foreach ($request->attributes as $attribute) {
            $pro_attribute = new ProductAttribute();
            $pro_attribute->product_id = $product->id;
            $pro_attribute->attribute = $attribute->attribute;
            $pro_attribute->save();
            foreach ($attribute->values as $value) {
                $attribute_val = new AttributeValue();
                $attribute_val->product_attribute_id = $pro_attribute->id;
                $attribute_val->value = $value;
                $attribute_val->save();
            }
        }
        if ($files) {
            foreach ($files as $file) {
                $variant_id = getVarientID($file->getClientOriginalName());
                $this->file->create([$file], 'variants', $variant_id);
            }
        }

        return new VariantResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    static function delete_variants_and_data($product)
    {
        $product->variant()->delete();
        $product->attribute()->delete();
    }
}
