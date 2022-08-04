<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Product;
use App\ProductsVariations;
use App\Category;
use App\Orders;
use App\FrontUser;
use App\Wallet;
use App\Transactions;
use App\ProductImages;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
            $product = Product::get();
            return view('admin.product.product')->with(['product'=>$product]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $product = Product::get();
        $category= Category::where(['parent_id'=>0])->get();
        // dd($category);
        return view('admin.product.product-create')->with(['product'=>$product,'category'=>$category]);
    }

    public function getSubcategory(Request $request){
        // echo $request->id;
        // exit;
        $category= Category::select('id','title')->where(['parent_id'=>$request->id])->get();
        return response()->json($category);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $postData=$request->post();
        $filedata=$request->file();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'category_id' => 'required',
            'category_name'=>'required',
            'short_desc'=>'required',
            'image'=>'required||mimes:jpg,png,jpeg'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        $image = "";

        $latest=1;
        $is_variations=1;
        if(!isset($request->latest))        $latest=0;
        if(!isset($request->is_variations)) $is_variations=0;
            $product = New Product();
            $product->product_name = $request->name;
            $product->slug = $request->slug;
            $product->category_id = $request->category_id;
            $product->category_name = $request->category_name;
            $product->sub_category_id =  $request->sub_category_id;
            $product->sub_category_name= $request->sub_category_name;
            $product->latest  = $latest;
            $product->short_desc= $request->short_desc;
            $product->is_variations = $is_variations;
            $product->location = 'jaipur';
            $product->image= $image;
            $product->status= $request->status;
            $product->created_at =date('Y-m-d h:i:s');
            $product->updated_at =date('Y-m-d h:i:s');
            $product->created_by =Auth::user()->name;
            $product->save();


            foreach($postData['product_weight'] as $key=>$val){
                DB::table('product_variation')->insertGetId([
                    'product_id'=>$product->id,
                    'product_weight'=>$val,
                    'product_mrp_price'=>$postData['product_mrp_price'][$key],
                    'product_sell_price'=>$postData['product_sell_price'][$key],
                ]);
            }

        if($request->is_variations==1){
            foreach($postData['size'] as $key=>$val){
                DB::table('product_size')->insertGetId([
                    'product_id'=>$product->id,
                    'size'=>$val,
                    'price'=>$postData['size_price'][$key],
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    ]);
            }

            foreach($postData['crust'] as $key=>$val){
                DB::table('product_crust')->insertGetId([
                    'product_id'=>$product->id,
                    'crust'=>$val,
                    'price'=>$postData['crust_price'][$key],
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    ]);
            }

            foreach($filedata['toppings_image'] as $key=>$val){
                $image = 'singleproduct_'.time().'.'.$val->extension();
                $val->move(public_path('/uploads/singleproduct'), $image);
                $image = "/uploads/singleproduct/".$image;
                DB::table('product_toppings')->insertGetId([
                    'product_id'=>$product->id,
                    'image'=>$image,
                    'title'=>$postData['toppings_title'][$key],
                    'price'=>$postData['toppings_price'][$key],
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    ]);
            }
        }

        if($request->hasfile('products_images'))
        {
           foreach($request->file('products_images') as $file)
           {
               $name = 'productsimages_'.time().'.'.$file->extension();
               $file->move(public_path('/uploads/productsimages'),$name);
               $name = "/uploads/productsimages/".$name;
               DB::table('product_images')->insertGetId([
                   'product_id'=>$product->id,
                   'category_id'=>request('category_id'),
                   'subcategory_id'=>request('sub_category_id'),
                   'images'=>$name,
                   'created_at'=>date('Y-m-d h:s:i')
               ]);
           }
       }

       if($request->hasFile('image'))
       {
           $image = 'singleproduct_'.time().'.'.$request->image->extension();
           $request->image->move(public_path('/uploads/singleproduct'), $image);
           $image = "/uploads/singleproduct/".$image;
       }

        return response()->json([
            'status' => true,
            'msg' => 'Category created successfully'
			]);

    }

    public function OrdersListing()
    {
        $order=Orders::with('userdetails')->get();
        return view('admin.product.my-orders')->with(['order'=>$order]);
    }

    public function OrdersDetailListing($id){

        $orders=Orders::where(['order_id'=>$id])->with('orderproducts','userdetails')->get();
        // echo "<pre>";print_r($orders);
        // exit;
        return view('admin.product.orders-detail')->with(['orders'=>$orders]);
    }

    public function UpdateOrderStatus(Request $request,$id){
        date_default_timezone_set('Asia/Kolkata');
        $timestamp = date("Y-m-d h:i:s");
        Orders::where(['id'=>$id])->update(['status'=>$request->status,'updated_at'=>$timestamp]);
        if($request->status=='delivered'){
             $wallet = New  Wallet();

            //  $wallet->user_id=$request->user_id;
            //  $wallet->order_id=$request->order_id;
            //  $points  =  ($request->total_price*5)/100;
            //  $wallet->redemption_points=$points;
            //  $wallet->redemption_value=$points*0.50;
            //  $wallet->save();

            $front =FrontUser::where(['id'=>$request->user_id])->get();

            $user= FrontUser::find($request->user_id);
            $points = ($request->total_price*5)/100;
            $user->redemption_points = $points;
            $user->redemption_value = $points*0.50;

            $user->save();

            $transction = New Transactions();
            $transction->user_id = $request->user_id;
            $transction->order_id = $request->order_id;
            $transction->trans_type  = 'CR';
            $transction->amount = $points*0.50;
            $transction->save();
        }
        return response()->json(['status' => true,'msg' => 'Order updated successfully']);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::with('products_images','products_variations')->find($id);
        if(is_object($product)  && $product->is_variations==1){
            $product->size =  DB::table('product_size')->select('id','size','price')->where(['product_id'=>$product->id])->get();
            $product->crust =  DB::table('product_crust')->select('id','crust','price')->where(['product_id'=>$product->id])->get();
            $product->toppings =  DB::table('product_toppings')->select('id','image','title','price')->where(['product_id'=>$product->id])->get();
        }
        // echo "<pre>";print_r($product);
        // exit;
        return view('admin.product.product-edit')->with(['product'=>$product]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $postData=$request->post();
        $filedata=$request->file();
        // echo "<pre>";print_r($postData);
        // echo "<pre>";print_r($filedata);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'slug' => 'required',
            'category_id' => 'required',
            'category_name'=>'required',
            'short_desc'=>'required',
            // 'location'=>'required',
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        $image = "";
        if($request->hasFile('image'))
        {
        $image = 'category_'.time().'.'.$request->image->extension();
        $request->image->move(public_path('/uploads/category'), $image);
        $image = "/uploads/category/".$image;
        }
        else{
            $image=$request->old_image;
        }
        $latest=1;
        if(!isset($request->latest)) $latest=0;
        DB::table('products')->where(['id'=>$id])->update([
            'product_name' => $request->name,
            'slug' => $request->slug,
            'category_id' => $request->category_id,
            'category_name'=>$request->category_name,
            'sub_category_id' => $request->sub_category_id,
            'sub_category_name'=>$request->sub_category_name,
            'latest' =>$latest,
            'short_desc'=>$request->short_desc,
            // 'location'=>implode(',',$request->location),
            'image'=>$image,
            'status'=>$request->status,
            'updated_at'=>date('Y-m-d h:s:i'),
            'created_at'=>date('Y-m-d h:s:i'),
            'created_by'=>Auth::user()->name
        ]);

        DB::delete('DELETE FROM `product_variation` WHERE product_id='.$id);

        foreach($postData['product_weight'] as $key=>$val){
            DB::table('product_variation')->insertGetId([
                'product_id'=>$id,
                'product_weight'=>$val,
                'product_mrp_price'=>$postData['product_mrp_price'][$key],
                'product_sell_price'=>$postData['product_sell_price'][$key],
            ]);
        }

    if($request->is_variations==1){

        DB::delete('Delete from product_size where product_id='.$id);

        foreach($postData['size'] as $key=>$val){
            DB::table('product_size')->insertGetId([
                'product_id'=>$id,
                'size'=>$val,
                'price'=>$postData['size_price'][$key],
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                ]);
        }

        DB::delete('Delete from product_crust where product_id='.$id);

        foreach($postData['crust'] as $key=>$val){
            DB::table('product_crust')->insertGetId([
                'product_id'=>$id,
                'crust'=>$val,
                'price'=>$postData['crust_price'][$key],
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s'),
                ]);
        }

     DB::delete('Delete from product_toppings where product_id='.$id);        

        if($request->hasFile('toppings_image'))
        {
            
            foreach($postData['valtoppings_old'] as $oldkey=>$oldval){
                $toppings_image[]=$oldval;
            }

            foreach($filedata['toppings_image'] as $key=>$val){
                $toppings = 'product-toppings-'.time().'.'.$val->extension();
                $val->move(public_path('uploads/product-toppings'), $toppings);
                $toppings =  asset("/public/uploads/product-toppings/".$toppings);
                $toppings_image[]=$toppings;
            }
            // echo "<pre>";print_r($toppings_image);
            // exit;
            foreach($postData['toppings_title'] as $titlekey=>$titleval){
                if(empty($toppings_image[$titlekey])) $toppings_image[$titlekey]=''; 
                DB::table('product_toppings')->insertGetId([
                    'product_id'=>$id,
                    'title'=>$titleval,
                    'image'=>$toppings_image[$titlekey],
                    'price'=>$postData['toppings_price'][$key],
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    ]);

            }  
        }
        else
        {
            //http://localhost/area41/public/uploads/product-toppings/product-toppings-1590407567.jpeg
            foreach($postData['toppings_title'] as $key=>$val)
            {
                if(!isset($filedata['toppings_image'][$key])){
                    $old = $postData['valtoppings_old'][$key];
                }else{
                    $old = $filedata['toppings_image'][$key];
                }
                DB::table('product_toppings')->insertGetId([
                    'product_id'=>$id,
                    'image'=>$old,
                    'title'=>$val,
                    'price'=>$postData['toppings_price'][$key],
                    'created_at'=>date('Y-m-d H:i:s'),
                    'updated_at'=>date('Y-m-d H:i:s'),
                    ]);
            }


        }    
    }

        if($request->hasfile('products_images'))
        {
            DB::delete('Delete from product_images where product_id='.$id);
           foreach($request->file('products_images') as $file)
           {
               $name = 'productsimages_'.time().'.'.$file->extension();
               $file->move(public_path('/uploads/productsimages'),$name);
               $name = "/uploads/productsimages/".$name;
               DB::table('product_images')->insertGetId([
                   'product_id'=>$id,
                   'category_id'=>request('category_id'),
                   'subcategory_id'=>request('sub_category_id'),
                   'images'=>$name,
                   'created_at'=>date('Y-m-d h:s:i')
               ]);
           }
       }

        return response()->json([
            'status' => true,
            'msg' => 'Product updated successfully'
			]);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::find($id)->delete();
    }



}
