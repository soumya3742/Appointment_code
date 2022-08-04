<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Blog;
use DB;
use Hash;
use DataTables;
use Validator;
use App\Notification;
use App\Category;
use App\Helper\Helper;
class NotificationController extends Controller
{
    
    public function index(Request $request)
    {
        $news=array();
        $news = Notification::orderBy('id','DESC')->get();
        return view('admin.notification.index')->with(['news'=>$news]);
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
   
        return view('admin.notification.create');
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
            // 'user_id'=>'required|numeric',
            'title' => 'required',
            'type' => 'required',
            'description' => 'required',
            
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }

        $news = new Notification();
        $news->title = $request->title;
        $news->type = $request->type;
        $news->description = $request->description;
        if($news->save()){
            $title = ucfirst($request->title);
            $content = ucfirst($request->description);
            $imageb = '';
             $helper = new Helper();
            $information = $helper->send_notification($title,$content,$imageb,$tokenarray = array(),
            $sendto=$request->type,$id=$news->id,$type="notification");
        }
        return response()->json([
            'status' => true,
            'msg' => 'Notification created successfully'
			]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Notification::find($id);
        return view('admin.notification.edit')->with(['post'=>$post]);
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
            // 'user_id'=>'required|numeric',
            'title' => 'required',
            'type' => 'required',
            'description' => 'required',
            
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }

        $news = Notification::find($id);
        $news->title = $request->title;
        $news->type = $request->type;
        $news->description = $request->description;
        if($news->save()){
            $title = ucfirst($request->title);
            $content = ucfirst($request->description);
            $imageb = "";
            $helper = new Helper();
            $information = $helper->send_notification($title,$content,$imageb,$tokenarray = array(),
            $sendto='all',$id=$news->id,$type="notification");
        }
        return response()->json(['status' => true,'msg' => 'Notification updated successfully']);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Notification::find($id)->delete();
    }



}
