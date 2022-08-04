<?php

namespace App\Imports;

use App\wholesale;
use App\FrontUser;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class WholesellerImport implements ToCollection
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
                    $wholesale = WholeSale::where(['mobile'=>$user->mobile])->count();
                    if($wholesale==0)
                    {
                        WholeSale::create([
                            'wholeseller_name' =>$vals[0],
                            'mobile' => $user->mobile,
                            'email'=>(isset($vals[2]))?$vals[2]:'',
                            'address' => (isset($vals[3]))?$vals[3]:'',
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
