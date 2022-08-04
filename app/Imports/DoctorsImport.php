<?php

namespace App\Imports;

use App\Doctor;
use App\FrontUser;
use App\DoctorCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class DoctorsImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        foreach($rows as $key=>$vals)
        {
            if(isset($vals[1]))
            {
                $user = FrontUser::where(['mobile'=>$vals[1]])->first();
                $userCnt = FrontUser::where(['mobile'=>$vals[1]])->count();
                // echo $user->mobile;
                if($userCnt==1)
                {
                    $category = DoctorCategory::where(['id'=>$vals[0]])->first();
                    $doctor = Doctor::where(['contact_no'=>$user->mobile])->count();
                    if($doctor==0)
                    {
                        Doctor::create([
                            'category_id' =>$vals[0],
                            'contact_no' => $user->mobile,
                            'doctor_name'=>(isset($vals[2]))?$vals[2]:'',
                            'user_id' => $user->id,
                            'category_name' =>(isset($category->title))?$category->title:'',
                            'education' =>(isset($vals[3]))?$vals[3]:'',
                            'created_by'=>auth()->user()->name,
                            'status'=>'active'
                            ]);
    
                    }
                }
            }
        }
       return true;
    }
}
