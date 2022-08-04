<?php
namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\FrontUser;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use DataTables;
use Validator;
use Auth;
use App\States;
use App\City;
use Session;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = User::latest()
			->where(function($query){
				if(!Auth()->user()->hasRole('Super Admin')){
				   $quefry->where('created_by', Auth()->user()->id);
				}
			})
			->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn =' ';
                        if(Auth()->user()->can('User Edit')){
                            $btn .= '<a href="'.route("user-edit", $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>';
                        }

                        if(Auth()->user()->can('User View')){
                        $btn .= ' <button type="button" data-url="'.route('user-view', $row->id).'" class="edit btn btn-primary btn-sm viewDetail">View</a>';
                        }
                        return $btn;
                    })
                     ->addColumn('role',  function ($user) {return $user->getRoleNames();})
                     ->addColumn('status',  function ($user) {return ($user->status)?'Active':'InActive';})
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.users.users');
    }
    
    public function PasswordUpdate(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'change_password' => 'required',
        ]);

        if ($validator->fails()) 
        {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        
        
        $fronuser = FrontUser::find($request->user_id);
        $fronuser->password_visiable = $request->change_password;
        $fronuser->password = bcrypt($request->change_password);
        $fronuser->save();

        return response()->json(['status' => true,'msg' => 'Front User Update successfully']);
    }
    
    public function Getreporterdata(Request $request){
        
         
         $fronuser = FrontUser::find($request->user_id);
       
       if($request->btn_id == 1){
           
       
         $fronuser->reporter = "YES";
       }else{
            $fronuser->reporter = "NO";
       }
           $fronuser->save();
           
         return response()->json(['status' => true,'msg' => $fronuser->name.' Reporter successfully']);
         
         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::select('id','name')->get();
        return view('admin.users.users-create',compact('roles'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    //    $data=DB::select('SELECT * FROM roles WHERE `name`="Sales"');
    //    $roleId='';
    //    if(is_array($data) && count($data)>0) $roleId=$data[0]->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|unique:users,email',
            'mobile_no' => 'required|min:10|unique:users,mobile_no',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required',
            'roles' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }
        $imageName = "";
        if($request->hasFile('profile_image')){
        $imageName = time().'.'.$request->profile_image->extension();
        $request->profile_image->move(public_path('uploads/profile'), $imageName);
        $imageName = "uploads/profile/".$imageName;
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = implode(',',$request->roles);
        $user->mobile_no = $request->mobile_no;
        if($imageName != "")     $user->profile_image = $imageName;
        $user->status = $request->status;
        $user->password = Hash::make($request->password);
		$user->created_by = Auth()->user()->id;
        $user->save();
        $user->assignRole($request->roles);
        return response()->json(['status' => true,'msg' => 'User created successfully']);

    }


//  public function import(Request $request) 
//     {


//       $file = request()->file('file');
//       $handle = fopen($file, "r");
//       $c = 0;
//       $errors=[];       
//       $err='';
//       $succ='';
      
//           while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
//             {
//                 if($c>0)
//                 {
//                     $data= [];
//                     $data['mobile'] =  $filesop[2];

//                     $validator = Validator::make($data, [
//                         'mobile' => 'required|min:10|unique:front_users,mobile',
//                     ]);
            
//                     if ($validator->fails()) 
//                     {
//                         $errors[]=$c;
//                         //  echo "<pre>";print_r($errors);
//                         //  exit;
//                         $err =  Session::flash('errors',implode(',',$errors));
//                     }
//                     else
//                     {
//                       $fronuser = New FrontUser();
//                       $fronuser->name =  (!empty($filesop[0]))?$filesop[0]:'';
//                       $fronuser->email = (!empty($filesop[1]))?$filesop[1]:'';
//                       $fronuser->mobile = (!empty($filesop[2]))?$filesop[2]:'';
//                       $fronuser->password = Hash::make('12345678');
//                       $fronuser->membership_date = (!empty($filesop[3]))?$filesop[3]:'';
//                       $fronuser->redemption_value = (!empty($filesop[4]))?$filesop[4]:'0.00';
//                       $fronuser->state = $request->state;
//                       $fronuser->city = $request->city;
//                       $fronuser->save();
//                       $succ =  Session::flash('success','Excel Rows  Import Successfully');
//                     }
//                 }
//                 $c = $c + 1;
//             }


//             // echo "<pre>";print_r($errors);
//             // exit;
       
      
//         return redirect()->back();
//     }
    
     public function import(Request $request) 
    {
        date_default_timezone_set('Asia/Kolkata');

       $file = request()->file('file');
       $handle = fopen($file, "r");
       $c = 0;
       $errors=[];       
       $err='';
       $succ='';
      
           while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
            {
               
                if($c>0)
                {
                    $data= [];
                    $data['mobile'] =  $filesop[2];

                    $validator = Validator::make($data, [
                        'mobile' => 'required|min:10|unique:front_users,mobile',
                    ]);
            
                    if ($validator->fails()) 
                    {
                        $errors[]=$c;
                        //  echo "<pre>";print_r($validator->errors());
                        //  exit;
                        $err =  Session::flash('errors',implode(',',$errors));
                    }
                    else
                    {
                       $fronuser = New FrontUser();
                       $fronuser->name =  (!empty($filesop[0]))?$filesop[0]:'';
                       $fronuser->email = (!empty($filesop[1]))?$filesop[1]:'';
                       $fronuser->mobile = (!empty($filesop[2]))?$filesop[2]:'';
               
                       $fronuser->password = Hash::make('12345678');
                       $date = explode('-',$filesop[3]);
                       if(is_array($date) && !empty($date[0]) &&  !empty($date[1]) && !empty($date[2]))
                        {
                            $day = $date[0];
                            $month = $date[1];
                            $year = $date[2];
                            echo $fronuser->membership_date = $year.'-'.$month.'-'.$day;
                            
                        }
                        else
                        {
                            // echo $c."error by date format";
                            // echo "<br />";
                        }
                      
                       $fronuser->redemption_value = (!empty($filesop[4]))?$filesop[4]:'0.00';
                       
                       $fronuser->business_name = (!empty($filesop[5]))?$filesop[5]:'';
                       $fronuser->receipt_no = (!empty($filesop[6]))?$filesop[6]:'';
                       $fronuser->date = (!empty($filesop[7]))?$filesop[7]:'';
                       $fronuser->pincode = (!empty($filesop[8]))?$filesop[8]:'';
                       $fronuser->post = (!empty($filesop[9]))?$filesop[9]:'';
                       $fronuser->cities = (!empty($filesop[10]))?$filesop[10]:'';
                       $fronuser->alternate_mobile = (!empty($filesop[11]))?$filesop[11]:'';

                       $fronuser->state = $request->state;
                       $fronuser->city = $request->city;
                       
                       $fronuser->save();
                       $succ =  Session::flash('success','Excel Rows  Import Successfully');
                    }
                }
                $c = $c + 1;
            }

         return back();
            // echo "<pre>";print_r($errors);
            // exit;
       
      
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.users.users-show',compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::select('id','name')->get();
        $userRole = $user->roles->pluck('id','name')->all();

        return view('admin.users.users-edit',compact('user','roles', 'userRole'));
    }
    
    public function FrontUserupdate(Request $request ,$id)
    {
        
       $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|exists:front_users,email',
            'mobile' => 'required|min:10|exists:front_users,mobile',
            //'password'=>'required',
            'alternate_mobile' => 'nullable|min:10',
            'date'=>'nullable|date',
            'pincode'=>'digits:6',
        ]);
        if($validator->fails())  return response()->json(['status' => false,'errors' => $validator->errors()]);
        $fronuser = FrontUser::find($id);
        $fronuser->name = $request->name;
        
        $fronuser->business_name = $request->business_name;
        $fronuser->receipt_no = $request->receipt_no;
        $fronuser->date = $request->date;
        $fronuser->pincode = $request->pincode;
        $fronuser->post = $request->post;
        $fronuser->citiess = $request->citiess;
        $fronuser->alternate_mobile = $request->alternate_mobile;

        $fronuser->redemption_value = $request->redemption_value;


        $fronuser->state = $request->state_id;
        $fronuser->city = $request->city_id;

        
        
        $fronuser->email = $request->email;
        $fronuser->mobile = $request->mobile;
        
        $fronuser->membership_date = $request->membership_date;

        $fronuser->save();
        return response()->json(['status' => true,'msg' => 'Front User Update successfully']);
        
    }
    
    public function GetCitiesdfdssf(Request $request)
    {
        // echo "<pre>";print_r($request->post());
        // exit;
        $cities = City::where(['state_id'=>$request->state])->get();
        return response()->json($cities);
    }
    
    public function FrontUseredit($id)
    {
        $front_users = FrontUser::find($id);
        $states = States::get();
        $cities = City::get();
        return view('admin.users.front-users-edit',compact('front_users','states','cities'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function FrontUser()
     {
        $front_users = FrontUser::with('states','cities','referalby')->orderBy('id','DESC')->get();
        $states = States::get();
        $cities = City::get();
        // echo "<pre>";print_r($front_users);
        // exit;
        return view('admin.users.front-users',compact('front_users','states','cities'));
     }

     public function CreateFrontUser()
     {
          $states = States::get();
          $cities = City::get();
        return view('admin.users.front-users-create',compact('states','cities'));
     }

     public function SaveFrontUsers(Request $request)
     {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:front_users,email',
            'mobile' => 'required|min:10|unique:front_users,mobile',
            'password'=>'required',
            'date'=>'nullable|date',
            'alternate_mobile' => 'nullable|min:10',
            'pincode'=>'digits:6',
        ]);
        if($validator->fails())  return response()->json(['status' => false,'errors' => $validator->errors()]);
        $fronuser = New FrontUser();
               $fronuser->name = $request->name;
        $fronuser->business_name = $request->business_name;
        $fronuser->receipt_no = $request->receipt_no;
        $fronuser->date = $request->date;
        $fronuser->pincode = $request->pincode;

        $fronuser->state = $request->state_id;
        $fronuser->city = $request->city_id;
        $fronuser->post = $request->post;

        $fronuser->cities = $request->cities;
        $fronuser->alternate_mobile = $request->alternate_mobile;
    
      $fronuser->redemption_value = $request->redemption_value;
    
        $fronuser->email = $request->email;
        $fronuser->mobile = $request->mobile;
        $fronuser->membership_date = $request->membership_date;
        $fronuser->password = Hash::make($request->password);

        $fronuser->save();
        return response()->json(['status' => true,'msg' => 'Front User Create successfully']);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|unique:users,email,'.$id,
            'mobile_no' => 'required|min:10|unique:users,mobile_no,'.$id,
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'roles' => 'required',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
		   return response()->json([
			'status' => false,
			'errors' => $validator->errors()
			]);
        }

        $imageName = "";
        if($request->hasFile('profile_image')){
        $imageName = time().'.'.$request->profile_image->extension();
        $request->profile_image->move(public_path('uploads/profile'), $imageName);
        $imageName = "uploads/profile/".$imageName;
        }
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile_no = $request->mobile_no;
        if($imageName != ""){
        $user->profile_image = $imageName;
        }
        $user->status = $request->status;
        $user->save();

        if($user->id != 1){
            DB::table('model_has_roles')->where('model_id',$id)->delete();
            $user->assignRole($request->roles);
        }

        return response()->json([
            'status' => true,
            'msg' => 'User updated successfully'
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
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','User deleted successfully');
    }

    public function enquirylist(){
       $contact_us=DB::table('contact_us')->get();
        return view('admin.users.enquiry')->with(['contact_us'=>$contact_us]);
    }
     
    public function getStyle($subject,$description)
    {
         return  $style =  '<html lang="en">
            <head>
              <title></title>
              <meta charset="utf-8">
              <meta name="viewport" content="width=device-width, initial-scale=1">
              <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
              <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
              <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            </head>
            <body>
            
            <div class="jumbotron text-center">
              <h1>'.$subject.'</h1>
              <h4>'.$description.'</h4>
            </div>
        </body>
    </html>';
            
       
    }
    
    public function sendmail(Request $request)
    {
        if(count(explode(',',$request->tags))>0)
        {
            foreach(explode(',',$request->tags) as $key=>$vals)
            {
                ini_set("SMTP", "smtp.gmail.com");

                ini_set("sendmail_from", "kashifhussain146@gmail.com");
                
                
                $subject = $request->subject;
               
                $description=$request->description;
                
                $headers  = 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: 	chikitsasansar@chikitsasansar.co.in'."\r\n".'Reply-To: 	chikitsasansar@chikitsasansar.co.in'."\r\n" .'X-Mailer: PHP/' . phpversion();
            
                $message = $this->getStyle($subject,$description);
             
                 $mail = $vals;
                // echo "$mail";
                // exit;
                mail($mail,$subject,$message, $headers);                
            }
            
           Session::flash('message','Mail Send Successfully');
           return redirect()->route('admin.dashboard');
        }
        
        
    }
    
}
