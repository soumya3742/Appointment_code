<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Category::with('parent_detail')->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('Category Edit')){
                            $btn .= '<a href="'.route("category-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        if(Auth()->user()->can('Category View'))
                        {
                            $btn .= ' <button type="button" data-url="'.route('category-view', $row->id).'" class="edit btn btn-primary btn-sm viewDetail">View</a>';
                        }
                        
                        if(Auth()->user()->can('Category View'))
                        {
                            $btn .= '<button type="button" id="deleteButton" data-url="'.route('category-delete', $row->id).'" class="edit btn btn-primary btn-sm deleteButton ml-2" data-loading-text="Deleted...." data-rest-text="Delete">Delete</button>';
                        }
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('admin.category.category');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$category = Category::where(['parent_id'=>0])->get();
        return view('admin.category.category-create',compact('category'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:category,title',
            'parent_id' => '',
            'sort_order' => ''
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }



        $category = new Category();
        $category->title = $request->title;
        $category->parent_id = $request->parent_id;
        $category->description = $request->description;
        $category->short_desc = $request->short_desc;

        $image = "";
        if($request->hasFile('image'))
        {
        $image = 'category_'.time().'.'.$request->image->extension();
        $request->image->move(public_path('/uploads/category'), $image);
        $image = "/uploads/category/".$image;
        }
        $category->image = $image ;
        $category->sort_order = $request->sort_order;
        $category->save();


        return response()->json([
            'status' => true,
            'msg' => 'Category created successfully'
			]);

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $loan = Category::with('parent_detail')->find($id);
        return view('admin.category.category-show',compact('loan'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $loan = Category::find($id);

        $category = Category::get();
        return view('admin.category.category-edit',compact('loan', 'category'));
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


        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:category,title,'.$id,
            'parent_id' => '',
            'sort_order' => ''
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }


        $category = Category::find($id);
        $category->title = $request->title;
        $category->parent_id = $request->parent_id;
        $category->description = $request->description;
        $category->short_desc = $request->short_desc;

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
        $category->image = $image ;
        $category->sort_order = $request->sort_order;
        $category->save();



        return response()->json([
            'status' => true,
            'msg' => 'Category updated successfully'
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
        Category::find($id)->delete();
    }



}
