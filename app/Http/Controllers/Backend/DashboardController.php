<?php
namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Orders;
use App\Doctor;
use App\MedicalStore;
use App\WholeSale;
use App\FrontUser;
use DB;
use Carbon\Carbon;
use App\Gharelu;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         $nousers = FrontUser::count();
         $getsers = FrontUser::get();
         $todayusers = FrontUser::whereDate('created_at','=', Carbon::today())->count();
         $yesterdayusers = FrontUser::whereDate('created_at','=', Carbon::now()->subDays(1))->count();



         $totaldoctors   = Doctor::count();
         $approvedoctors = Doctor::where(['status'=>'active'])->count();
         $pendingdoctors  = Doctor::where(['status'=>'inactive'])->count();






         return view('admin.dashboard.dashboard',compact('getsers','nousers','todayusers','yesterdayusers','totaldoctors','approvedoctors','pendingdoctors'));
    }
    public function getAllNotification(){
       $data=Fundraise::select('*')->get()->toArray();
       return response()->json($data);
    }

    public function getusers(Request $request)
    {
        $frontuser = FrontUser::select('id','email')->where('name', 'like', '%'.$request->data.'%')->get()->take(5)->pluck('email');
        return response()->json($frontuser);
    }
}
