<?php

namespace App\Http\Controllers\Backend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\FrontUser;
use DB;
use Hash;
use DataTables;
use Validator;
use App\Doctor;
use App\DoctorCategory;
use App\DoctorBooking;
use Input;
use App\Imports\DoctorsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\States;
use Session;
class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $doctor=array();
        $doctor = Doctor::get();
        $states = States::get();
        return view('admin.doctor.doctor')->with(['doctor'=>$doctor,'states'=>$states]);
    }
    
    public function AppointmentList(Request $request)
    {
        $booking = DoctorBooking::with('user','doctors')->get();
        // echo "<pre>";print_r($booking);
        // exit;
        return view('admin.doctor.booking-list')->with(['booking'=>$booking]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $doctor = Doctor::get();
        $states = DB::table('states')->get();
        $user = FrontUser::get();
        $category = DoctorCategory::get();
        return view('admin.doctor.doctor-create',compact('doctor','states','user','category'));
    }

    public function GetCities(Request $request){
       $stateid =  $request->state_id;
       $states = DB::table('cities')->where(['state_id'=>$stateid])->get();
       return response()->json($states);
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
            'doctor_name' => 'required|regex:/^[a-z A-Z]+$/u',
            'category_id'=>'required',
            'category_name'=>'required',
            'education'=>'required',
            'state'=>'required',
            'city'=>'required',
            'contact_no'=>'required|min:10|max:10|',
            'email'=>'required',
            'type.*'=>'required',
            'hospital_name.*'=>'required',
            'address.*'=>'required',
            'fees.*'=>'required|numeric',
            'timing.*'=>'required',
            'experience'=>'required',
            'registration_number'=>'required',
            'system_medicine'=>'required',
            'place'=>'required',
            'alternative_mobile_no'=>'max:10',
            // 'specialization'=>'requried'
            ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }

        $doctor = new Doctor();
        $doctor->user_id = $request->user_id;
        $doctor->category_id = $request->category_id;
        $doctor->category_name = $request->category_name;
        $doctor->doctor_name = $request->doctor_name;
        // $doctor->specialist_name = $request->specialist_name;
        $doctor->system_medicine = $request->system_medicine;
        $doctor->experience = $request->experience;
       
        $doctor->education = implode(', ',$request->education);
        
        // $doctor->hospital_name = $request->hospital_name;
        // $doctor->clinic_address = $request->clinic_address;

        // $doctor->latitude = $request->latitude;
        // $doctor->longitute = $request->longitute;

        $doctor->contact_no = $request->contact_no;

        $doctor->state_id =    $request->state_id;
        $doctor->state    =    $request->state;

        $doctor->city_id =     $this->Cities($request->city);
        $doctor->city    =     $request->city;
        
        $doctor->email = $request->email;
        $doctor->our_expert    =     $request->our_expert;
        // $doctor->fees = $request->fees;       
        $doctor->status = $request->status;
        $doctor->registration_number=$request->registration_number;
        $doctor->place=$request->place;
        $doctor->alternative_mobile_no=$request->alternative_mobile_no;
        // $doctor->system_name=$request->system_medicine;
        
        if($request->hasFile('registration_certificate'))
        {
            $image = 'category_'.time().'.'.$request->registration_certificate->extension();
            $request->registration_certificate->move(public_path('/uploads/category'), $image);
            $image = "/uploads/category/".$image;
            $doctor->registration_certificate = $image ;
        }

        if($request->hasFile('file'))
        {
            $image1 = 'category2_'.time().'.'.$request->file->extension();
            $request->file->move(public_path('/uploads/category'), $image1);
            $image1 = "/uploads/category/".$image;
            $doctor->images = $image1 ;
        }
       
        

        $doctor->save();

        foreach($request->post('type') as $key=>$val)
        {
            DB::table('doctors_timings')->insertGetId([
                'doctor_id'=>$doctor->id,
                'type'=>$val,
                'hospital_name'=>$request->post('hospital_name')[$key],
                'address'=>$request->post('address')[$key],
                'timing'=>$request->post('timing')[$key],
                'fees'=>$request->post('fees')[$key],
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')
            ]);
        }

        return response()->json(['status' => true,'msg' => 'Doctor created successfully']);

    }
    
     public function Cities($name)
     {
          $cities = DB::table('cities')->select('id','city')->where(['city'=>$name])->first();
          return $cities->id;
     }    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $doctor = Doctor::with('parent_detail')->find($id);
        return view('admin.doctor.doctor-show',compact('drug'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Doctor::find($id);
        $states = DB::table('states')->get();
        $cities = DB::table('cities')->select('id','city','state_id')->where(['state_id'=>$post->state_id])->get();
        $post->doctortimings = DB::table('doctors_timings')->select('id','type','hospital_name','address','timing','fees')->where(['doctor_id'=>$post->id])->get();
        $user = FrontUser::get();
        $category = DoctorCategory::get();
        // echo "<pre>";print_r($category);
        // exit;
        return view('admin.doctor.doctor-edit')->with(['post'=>$post,'cities'=>$cities,'states'=>$states,'user'=>$user,'category'=>$category]);
    }

    public function DeleteTimings(Request $request){
        $id =  $request->id;
        DB::delete("delete from doctors_timings where id ='$id'");
        return response()->json(['status' => true,'msg' => 'Timing  Removed successfully']);
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
            'doctor_name' => 'required|string',
            'category_id'=>'required',
            'category_name'=>'required',
            'education'=>'required',
           
            'state_id'=>'nullable',
            'city'=>'nullable',
            'contact_no'=>'nullable|min:10|max:10|',
            'email'=>'nullable',
            'type.*'=>'nullable',
            'hospital_name.*'=>'nullable',
            'address.*'=>'nullable',
            'fees.*'=>'nullable|numeric',
            'timing.*'=>'nullable',
            'experience'=>'nullable',
            'registration_number'=>'nullable',
            'system_medicine'=>'nullable',
            'place'=>'nullable',
            'alternative_mobile_no'=>'nullable|max:10',
            // 'specialization'=>'requried'
            ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }

        $doctor = Doctor::find($id);
        $doctor->user_id = $request->user_id;
        $doctor->category_id = $request->category_id;
        $doctor->category_name = $request->category_name;
        $doctor->doctor_name = $request->doctor_name;
        // $doctor->specialist_name = $request->specialization;
        $doctor->system_medicine = $request->system_medicine;
        $doctor->experience = $request->experience;
  $doctor->our_expert    =     $request->our_expert;
        // $doctor->latitude = $request->latitude;
        // $doctor->longitute = $request->longitute;

        $doctor->education = implode(', ',$request->education);
        // $doctor->hospital_name = $request->hospital_name;
        // $doctor->clinic_address = $request->clinic_address;
        
        $doctor->contact_no = $request->contact_no;
        $doctor->state_id   =    $request->state_id;
        $doctor->state      =    $request->state;
        $doctor->city_id    =     $this->Cities($request->city);
        $doctor->city       =     $request->city;
        $doctor->email      = $request->email;
        //$doctor->system_name=$request->system_medicine;
        //$doctor->fees = $request->fees;       
        $doctor->status = $request->status;
        $doctor->alternative_mobile_no=$request->alternative_mobile_no;
       
        if($request->hasFile('file'))
        {
        $image = 'category_'.time().'.'.$request->file->extension();
        $request->file->move(public_path('/uploads/category'), $image);
          $image = "/uploads/category/".$image;
         $doctor->images = $image ;
        }
       
    
        if($request->hasFile('registration_certificate'))
        {
         $image1 = 'category2_'.time().'.'.$request->registration_certificate->extension();
         $request->registration_certificate->move(public_path('/uploads/category'), $image1);
          $image1 = "/uploads/category/".$image1;
         $doctor->registration_certificate = $image1 ;
        }
    
      
        $doctor->save();

        DB::delete("delete from doctors_timings where doctor_id ='$id'");

        foreach($request->post('type') as $key=>$val)
        {
            DB::table('doctors_timings')->insertGetId([
                'doctor_id'=>$doctor->id,
                'type'=>$val,
                'hospital_name'=>$request->post('hospital_name')[$key],
                'address'=>$request->post('address')[$key],
                'timing'=>$request->post('timing')[$key],
                'fees'=>$request->post('fees')[$key],
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')
            ]);
        }

        return response()->json(['status' => true,'msg' => 'Drug updated successfully']);

    }
    
    public function OurExpert(Request $request)
    {
        $doctor=array();
        $doctor = Doctor::where('our_expert','Yes')->get();
        $states = States::get();
        return view('admin.doctor.our-expert')->with(['doctor'=>$doctor,'states'=>$states]);
    }
    
    public function Doctorimport(Request $request)
    {
        
       $file = request()->file('import_file');
       $handle = fopen($file, "r");
       $c = 0;
       $errors=[];       
       $err='';
       $succ='';
      
           while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
            {
                                
                // $user = FrontUser::where(['mobile'=>$filesop[2]])->first();
                
                if($c>0)
                {
                    $data= [];
                    $data['mobile'] =  $filesop[2];

                    $validator = Validator::make($data, [
                        'mobile' => 'required|min:10',
                    ]);
                    
                    $user = FrontUser::where(['mobile'=>$filesop[2]])->first();

                    if ($validator->fails() || !$user) 
                    {
                         $errors[]=$filesop[2];
                        
                        $err =  Session::flash('errors',implode(',',$errors));
                    }
                    else
                    {
                     
                        
                        if(isset($filesop[1]))
                        {
                            $user = FrontUser::where(['mobile'=>$filesop[1]])->first();
                            $userCnt = FrontUser::where(['mobile'=>$filesop[1]])->count();
                            // echo $user->mobile;
                            if($userCnt==1)
                            {
                                $category = DoctorCategory::where(['id'=>$filesop[0]])->first();
                                $doctor = Doctor::where(['contact_no'=>$user->mobile])->count();
                                if($doctor==0)
                                {
                                    Doctor::create([
                                        'category_id' =>$filesop[0],
                                        'contact_no' => $user->mobile,
                                        
                                        'doctor_name'=>(isset($filesop[2]))?$filesop[2]:'',
                                        'user_id' => $user->id,
                                        
                                        'category_name' =>(isset($category->title))?$category->title:'',
                                        'education' =>(isset($filesop[3]))?$filesop[3]:'',

                                        'state_id' =>$request->state_id,
                                        'state' =>$request->state,
                                        
                                        'city_id' =>$request->city_id,
                                        'city' =>$request->city,                                        
                                        
                                        'created_by'=>auth()->user()->name,
                                        'status'=>'active'
                                        ]);
                                 $succ =  Session::flash('success','Excel Rows  Import Successfully');
                                }
                            }
                        }
            
                    }
                }
                $c = $c + 1;
            }


            // echo "<pre>";print_r($errors);
            // exit;
        return redirect()->back();		
		
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Doctor::find($id)->delete();
    }



}
