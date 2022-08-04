<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use App\Offer;
use App\Helper\Helper;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offer=array();
        $offer = Offer::orderBy('id','DESC')->where(function($query){
                            if(!Auth()->user()->hasRole('Super Admin'))
                            {
                                 $query->where('user_id', Auth()->user()->id); 
                            }
                         })->get();
        return view('admin.offer.offer')->with(['offer'=>$offer]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$offer = Offer::get();
        return view('admin.offer.offer-create',compact('offer'));
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
            'offer_title' => 'required',
            'offer_desc' => 'required',
            'no_of_referal'=>'required',
            'offer_image' => 'nullable|mimes:jpg,png,jpeg',
            'offer_start_date'=>'required|date|date_format:d-m-Y',
            'offer_end_date'=>'required|date|date_format:d-m-Y',
            'offer_redemption'=>'required',
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }

        $offer = new Offer();
        $offer->user_id = auth()->user()->id;
        $offer->offer_title = $request->offer_title;
        $offer->offer_desc = strip_tags($request->offer_desc);
        $offer->no_of_referal = $request->no_of_referal;
        $offer->offer_start_date = $request->offer_start_date;
        $offer->offer_end_date = $request->offer_end_date;
        if($request->hasFile('offer_image'))
        {
            $image = 'offer_'.time().'.'.$request->offer_image->extension();
            $request->offer_image->move(public_path('/uploads/offer'), $image);
            $image = "/uploads/offer/".$image;
            $offer->offer_image = $image ;
        }
        $offer->offer_redemption = $request->offer_redemption;
        $offer->status = $request->status;
        $offer->save();
        if($offer->status=='active'){
            $title = "New offer ".$request->offer_title;
            $content = ucfirst("New Offer ".$request->offer_desc);
            $image = "";
             $helper = new Helper();
            $information = $helper->send_notification($title,$content,$image,$tokenarray = array(),
            $sendto='all',$id=$offer->id,$type="offer");
        }

        return response()->json([
            'status' => true,
            'msg' => 'offer created successfully'
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
        $offer = Offer::with('parent_detail')->find($id);
        return view('admin.offer.offer-show',compact('offer'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $offer = Offer::find($id);
        return view('admin.offer.offer-edit')->with(['offer'=>$offer]);
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
            'offer_title' => 'required',
            'offer_desc' => 'required',
            'no_of_referal'=>'required',
            'offer_image' => 'nullable|mimes:jpg,png,jpeg',
            'offer_start_date'=>'required|date|date_format:d-m-Y',
            'offer_end_date'=>'required|date|date_format:d-m-Y',
            'offer_redemption'=>'required',
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        $offer = Offer::find($id);
        $oldoffer = $offer;
        $offer->user_id = auth()->user()->id;
        $offer->offer_title = $request->offer_title;
        $offer->offer_desc = strip_tags($request->offer_desc);
        $offer->no_of_referal = $request->no_of_referal;
        $offer->offer_start_date = $request->offer_start_date;
        $offer->offer_end_date = $request->offer_end_date;
        if($request->hasFile('offer_image'))
        {
            $image = 'offer_'.time().'.'.$request->offer_image->extension();
            $request->offer_image->move(public_path('/uploads/offer'), $image);
            $image = "/uploads/offer/".$image;
            $offer->offer_image = $image ;
        }
        $offer->offer_redemption = $request->offer_redemption;
        $offer->status = $request->status;
        $offer->save();
        //&& ($oldoffer->status!=$request->status)
        if($request->status=='active'){
           //echo 'neeeeeee';die;
            $title = "New offer ".$request->offer_title;
            $content = ucfirst("New Offer ".$request->offer_desc);
            $image = "";
            $helper = new Helper();
            $information = $helper->send_notification($title,$content,$image,$tokenarray = array(),
            $sendto='all',$id=$offer->id,$type="offer");
            
        }
        return response()->json(['status' => true,'msg' => 'Offer updated successfully']);

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Offer::find($id)->delete();
    }



}
