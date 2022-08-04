<?php
namespace App\Http\Controllers\Api\Mobile\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\FrontUser;
use App\User;
use App\States;
use App\City;
use App\Pincode;
use App\Offer;
use App\Category;
use App\Transactions;
use App\Banner;
use App\LabData;
use App\ForgotOtp;
use Illuminate\Support\Str;
use Validator;
use Mail;
use DB;
use App\Epaper;
use PDF;
use App\Doctor;
use App\News;
use App\DoctorCategory;
use App\DoctorBooking;
use App\Patient;
use App\Team;
use App\Advertisement;
use App\Hospitals;

class ApiAuthController extends Controller
{

    public function BaseUrl(){return response()->json(['base_url'=>url('/public/')]);}

    public function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'message' => $message,
            'data'    => $result,
        ];
        return response()->json($response, 200);
    }
    
    public function OurExperts(Request $request)
    {
         $doctor  = Doctor::where(['our_expert'=>'Yes'])->get();        
         
        if(is_object($doctor) && count($doctor)>0)
        {
            return response()->json(['success' => true,'data'=>$doctor]);
        }
        else
        {
            return response()->json(['success' => false,'message'=>'No Records Found']);
        }
        
    }

    public function HospitalsList(Request $request)
    {
        $hospitals  = Hospitals::select('id','user_id','hospital_name','sector','image','state','city','address','contact_person','alternate_mobno','area','mobile','email','latitude','longitute')->where(['status'=>'active'])->get();        
        if(is_object($hospitals) && count($hospitals)>0)
        {
            return response()->json(['success' => true,'data'=>$hospitals]);
        }
        else
        {
            return response()->json(['success' => false,'message'=>'No Records Found']);
        }
          
    }
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    public function register(Request $request)
    {
        $existmobile = DB::table('front_users')->where('mobile',$request->mobile)->exists();
        if($existmobile==1)
        {
             return response()->json(['success'=>false,'message'=>'Mobile No Already Exists']);            
        }
        else
        {
             $exist = DB::table('front_users')->where('email',$request->email)->exists();
            if($exist==1)
            {
                 return response()->json(['success'=>false,'message'=>'E-mail Id Already Exists']);
            }
            else
            {
                $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'email' => 'required|email',
                    'password' => 'required',
                    'mobile' => 'required|numeric|digits:10|unique:front_users,mobile',
                   
                    
                ]);
                if($validator->fails())         return response()->json(['success'=>false,'message'=>$validator->errors()]);
                $input = $request->all();
                if($request->has('referal_by') && !empty($request->referal_by))
                {
                    $frontusers = FrontUser::where(['mobile'=>$request->referal_by])->count();
                    if($frontusers==0)
                    {
                        return response()->json(['success'=>false,'message'=>'Invalid Referal Code']);  
                    }
                }
                
                
                $input['password'] = bcrypt($input['password']);
                $input['state'] = $request->state_id;
                $input['city'] = $request->city_id;
                $input['reporter'] = "NO";
                $user = FrontUser::create($input);
                $success['id'] =    $user->id;
                $success['name'] =  $user->name;
                $success['state'] = $input['state'];
                $success['city'] =  $input['city'];
                $success['reporter'] = $user->reporter;
                $success['token'] = $user->createToken('MyApp')->accessToken;
                return $this->sendResponse($success, 'Your account successfully created');
            }
        }
    }
    
    public function login(Request $request)
    {

        if(preg_match('/^[0-9]{10}+$/', $request->post('input')))
        {
            $cred['mobile']=$request->input;
            $validation['input']='required|numeric|digits:10';
            $validation['password']='required';
            $error="Mobile No. Not Exist";
        }
        else
        {
            $cred['email']=$request->input;
            $validation['input']='required|email';
            $validation['password']='required';
            $error="E-mail ID Not Exist";
        }

        // echo "<pre>";print_r($cred);
        // exit;
        	$validator = Validator::make($request->all(), $validation);
        if ($validator->fails()) 
        {
		   return response()->json([
			'success' => false,
			'message' => $validator->errors()
			]);
        }

        $user = FrontUser::where($cred)->select('email','password')->first();
                    //   echo "<pre>";print_r($user);
                    //   exit;
       if($user)
       {
           if (Hash::check($request->password,$user->password))
           {
               $user = FrontUser::where($cred)->select('id','name','email','mobile','membership_date','state','city','reporter')->first();

               $user->membership_date = $user->membership_date.' '.date('H:i:s');

               if(!empty($user->state))  $user->state_name = $this->StatesNames($user->state);
               if(!empty($user->city))   $user->city_name = $this->CitiesName($user->city);
               
               

               $doctor  = Doctor::where(['user_id'=>$user->id])->count();
               
                if(empty($user->membership_date))  $user->membership_date='';
                
                $tokenResult =$user->createToken('MyApp');
				$token = $tokenResult->token;
				$token->expires_at = Carbon::now()->addYear(1);
				$token->save();
				return response()->json([
					'success' => true,
					'data' => $user,
					'doctors'=>$doctor,
					'access_token' => $tokenResult->accessToken,
					'token_type' => 'Bearer',
					'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                    'message'=>'Successfully Connected',
				]);
		   }
		   else            return response()->json(['success' => false,'message' => 'Authentication Invalid']);
	   }
	   else
	   {
		   return response()->json(['success' => false,'message' => $error]);
       }
    }

    public function CategoryData(Request $request){
       $data=Category::where(['parent_id'=>0])->get();
       $data=$this->removeEmptyValues($data);
        if(is_object($data) && count($data)>0)
        {
            return $this->sendResponse($data, 'No of Records '.count($data));
        }
        else
        {
            return $this->sendError('No Records Found', '');
        }
    }
     
    public function random_strings($length_of_string){
        $str_result = '0123456789';
        return substr(str_shuffle($str_result),  0, $length_of_string);
    }

    public function generateNumericOTP($n) {
        $generator = "1357902468";
        $result = "";
        for ($i = 1; $i <= $n; $i++)
        { 
            $result .= substr($generator, (rand()%(strlen($generator))), 1); 
        } 
          return $result; 
    }

    public function ForgotPassword(Request $request ){
        
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
        ]);

        if($validator->fails()) return $this->sendError('Validation Error', $validator->errors());
    
        $postData=$request->post();
        $frontUser=FrontUser::where(['mobile'=>$request->mobile])->count();
        if($frontUser>0)
        {
            $user=FrontUser::where(['mobile'=>$request->mobile])->first();
            if($user)
            {
                $otp = $this->generateNumericOTP(8);
                
                ini_set("SMTP", "smtp.gmail.com");
        
                ini_set("sendmail_from", "kashifhussain146@gmail.com");
                
                $message='Reset Password :'.$otp;
                
                $headers = "From: chikitsasansar@chikitsasansar.co.in";
                
                 $mail = $user->email;
              
                mail($mail, "Your New Password", $message, $headers);
        
                $forgot = New ForgotOtp();
                $forgot->email = $user->email;
                $forgot->otp = $otp;
                $forgot->save();
                
                $userupdate=FrontUser::find($user->id);
                $userupdate->password = bcrypt($otp);
                $userupdate->save();
                
                
                return response()->json(['success'=>true,'message'=>'Password Sent on '.$mail], 200);
            }
            else
            {
                return response()->json(['success'=>true,'message'=>'E-mail ID Not Exists'], 200);
            }
        }
        else          return response()->json(['success'=>'false','message'=>'Mobile No Not Exists'], 200);
    }

    public function verifyOtp(Request $request){
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
        ]);
        if($validator->fails()) return $this->sendError('Validation Error', $validator->errors());
         $otp=ForgotOtp::where(['otp'=>$request->otp])->count();
         if($otp>0)
         {
         $otpdata=ForgotOtp::where(['otp'=>$request->otp])->get();
         return response()->json(['success'=>true,'message'=>'OTP Matched','data'=>$otpdata[0]->email], 200);
         }
         else        return response()->json(['success'=>'false','message'=>'Invalid OTP'], 200);
    }

    public function SaveBooking(Request $request){

          $validator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required',
            'mobile_no'=>'required',
            'date'=>'required',
            'time'=>'required',
            'no_of_people'=>'required',
            'code_human'=>'required',
        ]);
        
         if ($validator->fails())
         {
            return response()->json([
             'success' => false,
             'message' => $validator->errors()
             ]);
         }
        $booking = New Booking();
        $booking->name = $request->name;
        $booking->company = $request->company;
        $booking->email = $request->email;
        $booking->mobile_no = $request->mobile_no;
        $booking->date = $request->date;
        $booking->time = $request->time;
        $booking->no_of_people = $request->no_of_people;
        $booking->message = $request->message;
        $booking->heardabout = $request->heardabout;
        $booking->code_human = $request->code_human;
        $booking->created_at = date('Y-m-d h:i:s');
        $booking->updated_at = date('Y-m-d h:i:s');
        $booking->save();
        
        return response()->json(['success'=>true,'message'=>'Booking Save Successfully'], 200);
    }
    
    public function UpdateForgotPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password'=>'required'
        ]);

        if($validator->fails()) return $this->sendError('Validation Error', $validator->errors());
        $updatepass = FrontUser::where(['email'=>$request->email])->update(['password'=> bcrypt($request->password)]);
         return response()->json(['success'=>true,'message'=>'Password Changed Successfully'], 200);
    }
    
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'password'=>'required'
        ]);

        if($validator->fails()) return reponse()->json(['success'=>false,'errors'=>$validator->errors()]);
        
        $updatepass = FrontUser::where(['id'=>$request->user_id])->update(['password'=> bcrypt($request->password)]);
        
        return response()->json(['success'=>true,'message'=>'Password Changed Successfully'], 200);
    }



    public function MinimumCart(Request $request){
        $data = DB::table('minimum_cart')->select('cart_value')->get();
        return $this->sendResponse($data, 'Minimum Cart Value');
    }

    public function TimeSlots(Request $request){
        $data = DB::table('time_slot')->select('id','time_slot','date')->get();
        $pincode=Pincode::get();
        return response()->json(['success'=>true,'data'=>$data,'pincode'=>$pincode]);
    }

    public function Pincode(Request $request){

       $pincode = Pincode::where(['pincode'=>$request->pincode])->count();
       if($pincode==0) return response()->json(['success'=>'false','message'=>'Product Not Available in This Area']);
       else            return response()->json(['success'=>true,'message'=>'Product Available in This Area']);

    }

    public function MyProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if($validator->fails())  return $this->sendError('Validation Error', $validator->errors());
        $data=FrontUser::select('name','email','mobile','profile_pic','pincode','state','city')->find(request('user_id'));

        if(empty($data->profile_pic)) $data->profile_pic='';
        if(empty($data->pincode)) $data->pincode='';
        if(empty($data->state)) $data->state='';
        if(empty($data->city)) $data->city='';

        if(is_object($data))    return $this->sendResponse($data, 'Data Found Successfully');
        else                    return $this->sendError('No Records Found', '');
     }

     public function StateList(Request $request)
     {
         $states =  DB::table("states")->select('id','name')->get();
         return response()->json(['success'=>true,'data'=>$states]);  
     }

     public function CityList(Request $request)
     {
          $validator = Validator::make($request->all(), [
            'state_id' => 'required',
        ]);

        if($validator->fails())  return $this->sendError('Validation Error', $validator->errors());
        
         $cities =  DB::table("cities")->select('id','city')->where(['state_id'=>$request->state_id])->get();
         return response()->json(['success'=>true,'data'=>$cities]);  
     }

     

    public function UpdatedMyProfile(Request $request){
        
        $validator = Validator::make($request->all(), [
            'user_id'=>'required|exists:front_users,id',
            'name'=>'required',
            'email'=>'required',
            'state_name'=>'required',
            'city_name'=>'required',
            'pincode'=>'nullable|regex:/\b\d{6}\b/'
        ]);

        if($validator->fails()){            return $this->sendError('Validation Error', $validator->errors()); }

        $profile='';
        if($request->hasFile('profile'))
        {
            $profile = 'profile_'.time().'.'.$request->profile->extension();
            $request->profile->move(public_path('uploads/profile'), $profile);
            $profile = "/public/uploads/profile/".$profile;
        }

        $post = FrontUser::find($request->user_id);
        $post->name          =  $request->name;
        $post->email         =  $request->email;
        $post->address       =  $request->address;
        $post->profile_pic   =  $profile;
        $post->address       =  $request->address;
        $post->state         =  $request->state_name;
        $post->city          =  $request->city_name;
        $post->pincode       =  $request->pincode;
        $post->updated_at   =  date('Y-m-d h:i:s') ;
        $post->save();
        return response()->json(['success'=>true,'message'=>'Profile Update Successfully']);
     }

   
	public function verifyLoginOtp(Request $request){  }

	public function logout(Request $request)
	{
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

	public function sendOtp(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|digits:10',
        ]);
		if ($validator->fails()) {
		   return response()->json([
			'success' => false,
			'message' => $validator->errors()
			]);
        }

		$otp = rand(1000,9999);
        $this->sendSMS("Your OTP ".$otp." Please use for change password", $request->mobile);
		$saveotp = new ForgotOtp;
		$saveotp->mobile = $request->mobile;
		$saveotp->otp = $otp;
		$saveotp->save();




		return response()->json([
			'success' => true,
			'msg' => 'Otp Send success'
			]);

    }

    public function passwordSet(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'mobile' => 'required|numeric|digits:10|exists:api_users',
            'otp' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);
		if ($validator->fails()) {
		   return response()->json([
			'success' => false,
			'message' => $validator->errors()
			]);
        }

		$matchOtp = ForgotOtp::where('mobile', $request->mobile)->whereDate('created_at', Carbon::today())->where('otp', $request->otp)->first();
		if(!$matchOtp){

			return response()->json([
			'success' => false,
			'message' => ['otp'=> ['Wrong Otp.']]
			]);

		}else{
			ForgotOtp::where('mobile', $request->mobile)->delete();
		}

		$user = ApiUser::where('mobile', $request->mobile)->update(['password' => Hash::make($request->password)]);

		return response()->json([
			'success' => true,
			'message' => 'Password Updated.'
			]);

    }

   
    
    public function removeEmptyValues($array)
    {
    foreach ($array as $key => $value) {
        foreach($value as $k=>$val){
            if(empty($val)){
                $val='';
            }
        }
    }
    return $array;
  }
  
    public function StatesNames($state_id)
    {
          $states = DB::table('states')->select('name')->where(['id'=>$state_id])->first();
          return $states->name;
    }

    public function CitiesName($city_id)
    {
          $cities = DB::table('cities')->select('city')->where(['id'=>$city_id])->first();
          return $cities->city;
     
      }
      
    public function States($state)
    {
          $states = DB::table('states')->select('id','name')->where(['id'=>$state])->first();
          return $states->id;
    }

    public function Cities($city)
    {
          $cities = DB::table('cities')->select('id','city')->where(['id'=>$city])->first();
          return $cities->id;
      }
      
    public function DataList(Request $request){
        $data=array();
        $experience=array();
        $data['baseurl']=url('/');
        $data['specialization']=DoctorCategory::get();
        $data['education']=['MBBS','BDS','MDS','BAMS','BUMS','DNYS','BNYS','MS','MD','DNB','DLO','DM','MCH','DGO','DVD','DOMS','BPT','MPT','DPM','DMRD','BSC','MSC','DO','DHD','UMD','PHD','D orth','DCH','DCP','OTHER'];
                        
        for($i=1;$i<=30;$i++)
        {
            $experience[]=$i;
        }
        
        $data['experience']=$experience;
        $data['system_medicine']=['Allopathy','Homeopathic','Aayurvedic','Unanai','Yog and Naturopathy','Dietician','Physiotherapy','Other'];
        return response()->json(['status' => true,'datalist' =>$data ]);
    }  
      

    public function DoctorCategoryName($title)
    {
        
     $category =   DoctorCategory::select('title')->where(['id'=>$title])->first();
     return $category->title;
    }

    public function DoctorList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id'=>'required',
            ]);

        if($validator->fails()) 
        {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        $data = Doctor::select('id','user_id','category_id','category_name','doctor_name','alternative_mobile_no','experience','system_medicine','state_id','state','area','city_id','city','contact_no','email','education','status','created_at','updated_at','registration_certificate','images','place','registration_number')->where(['category_id'=>$request->category_id,'status'=>'active'])->orderBy('category_name','DESC')->get();
        if(isset($request->search))
        {
            $search = $request->search;
            $data = Doctor::select('id','user_id','category_id','category_name','doctor_name','specialist_name','alternative_mobile_no','experience','system_medicine','state_id','state','area','city_id','city','contact_no','email','education','status','created_at','updated_at','registration_certificate','images','place','registration_number')
                            ->orWhere('city', '=',$search)
                            ->orWhere('doctor_name', 'like', '%'.$search)
                            ->where(['status'=>'active','category_id'=>$request->category_id])
                            ->orderBy('category_name','ASC')
                            ->get();
        }
        
        foreach($data as $key=>$val)
        {
           if(empty($val->latitude)) $val->latitude='';
           if(empty($val->longitude)) $val->longitude='';
           $data[$key]->doctortype = DB::table('doctors_timings')->where(['doctor_id'=>$val->id])->get();
           $state =   States::find($val->state_id);
           $city =    City::find($val->city_id);
           $val->state = (!empty($state->name))?$state->name:'';
           $val->city  = (!empty($city->city))?$city->city:'';
        }
       
        if(is_object($data) && count($data)>0)
        {
            return response()->json(['success' => true,'data'=>$data]);
        }
        else
        {
            return response()->json(['success' => false,'message'=>'No Records Found']);
        }
    }
    
    
    public function UserDoctorList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'=>'required',
        ]);

        if($validator->fails()) 
        {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
         $data = Doctor::select('id','category_name','doctor_name','images')->where(['user_id'=>$request->user_id])->orderBy('category_name','DESC')->get();
        

        if(is_object($data) && count($data)>0)
        {
            return response()->json(['success' => true,'data'=>$data]);
        }
        else
        {
            return response()->json(['success' => false,'message'=>'No Records Found']);
        }
        
    }
    
    public function DoctorDetails(Request $request)
    {
        $validator = Validator::make($request->all(), ['doctor_id'=>'required']);

        if($validator->fails()) 
        {
		   return response()->json(['status' => false,'errors' => $validator->errors()]);
        }
        
        $data = Doctor::select('id','user_id','category_id','category_name','doctor_name','alternative_mobile_no','experience','system_medicine','state_id','state','area','city_id','city','contact_no','email','education','status','created_at','updated_at','registration_certificate','images','place','registration_number')->find($request->doctor_id);
        
        $doctor = DB::table('doctors_timings')->where(['doctor_id'=>$request->doctor_id])->get();
        $data->timings = $doctor;
        if(empty($data->latitude)) $data->latitude='';
        if(empty($data->longitute)) $data->longitute='';
        
        return response()->json(['success' => true,'data'=>$data]);
    }
    
    public function DoctorBooking(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'user_id'=>'required|numeric',
            'doctor_id' => 'required|numeric',
            'date' => 'required',
            'location_id' => 'required',
            'name' => 'required',
            'mobile'=>'required|digits:10',
            'gender'=>'required',
           
        ]);

        if ($validator->fails()) 
        {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        $booking = New DoctorBooking();
        $booking->user_id = $request->user_id;
        $booking->doctor_id = $request->doctor_id;
        $booking->date = $request->date;
        $booking->location_id = $request->location_id;
        $booking->name = $request->name;
        $booking->age = $request->age;
        $booking->mobile = $request->mobile;
        $booking->email = $request->email;
        $booking->gender=$request->gender;

        $booking->chief_complaint=$request->chief_complaint;
        $booking->significant_medical=$request->significant_medical;

        $booking->status='booked';
        if(isset($request->payment_id) && !empty($request->payment_id))
        {
            $booking->payment_id=$request->payment_id;
            $booking->payment_status='paid';
            $booking->amount=$request->amount;
        }
        else
        {
            $booking->payment_status='unpaid';            
        }

        $booking->created_at = date('Y-m-d H:i:s');
        $booking->updated_at = date('Y-m-d H:i:s');
        $booking->save();
        
        $bookid = DoctorBooking::find($booking->id);
        $bookid->booking_id = 'BOOK'.$booking->id;
        $bookid->save();
        
        return response()->json(['success' => true,'message'=>'Appointment Book Sucessfully']);
    }
    
    public function DoctorBookingList(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'user_id'=>'required|numeric',
        ]);

        if ($validator->fails()) 
        {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        $book = DoctorBooking::select('id','booking_id','date','name','gender','age','mobile','payment_id','chief_complaint','significant_medical','amount','payment_status','timing','status')->where(['user_id'=>$request->user_id])->first();
        return response()->json(['success' =>($book)?true:false,'data'=>$book]);
    }
    
    public function DoctorCategoryList(Request $request)
    {
        $category = DoctorCategory::select('id','title','image')->where('status','=','active')->get();
        return response()->json(['success' => true,'data'=>$category]);
    }
    
}
