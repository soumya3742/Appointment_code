<?php
namespace App\Helper;
use DB;
use App\Offer;
use App\FrontUser;


class Helper
{

    public function send_notification($title,$content,$image,$tokenarray = array(),$sendto='all',$id=0,$type='offer'){
        
        // if($sendto=='all'){
        //     $userdata = FrontUser::where('fcm_token','!=','')->select(['id','fcm_token	'])->get();
        //     if($userdata->count()>0){
        //         foreach($userdata as $singleddd){
        //             $tokenarray[] = $singleddd->fcm_token;
        //         }
        //     }
        // }
        
        $message=   array(
				'title' => ucfirst($title), 
				'body' =>  $content ,
				'sound'=>'Default',
				'image'=> $image
			);
        //$extraNotificationData = ["message" => $message,"type" =>$type,'dataid'=>$id];
        
         $message=   array(
				'title' => 'New '.ucfirst($title), 
				'body' =>  ucfirst($title),//mb_substr($content, 0, 500),
				'sound'=>'Default',
				'image'=> $image,
				"type"=> $type,
                "dataid"=> $id
			);
        
        $topic = 'ChikitsaSansar';
		$response = $this->sendpushtopicnot($topic, $message);
		$responsearr = json_decode($response,true);
        //echo "<pre>"; print_r($responsearr);die;
        return $responsearr;
        
        
// 		$response = sendPushNotificationToFCMSever($tokenarray, $message,$extraNotificationData);
// 		$responsearr = json_decode($response,true);
//         return $responsearr;
        
    }
    public function sendpushtopicnot($topic, $message=array()) {
		
         $notificationkey = '';
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
 
        $fields = array(
            "to" => '/topics/'.$topic,
            'priority' => 10,
            'data' =>$message,
        );
        $headers = array(
            'Authorization:key=AAAAGUjc_Lw:APA91bFhYcCJ7X5fiVH75enD3zByM_PaMPXDgJkF4kIoTOtks0fpdWiJpzt-24RBerW6vImfS6q1qU3dcuxS08QJH_bh_9J4ZNPSW35DBJPJ8EqllVcmGWxFTQW_f8Q3bAfucIkNZMnl',
            'Content-Type:application/json'
        );  
        //print_r(json_encode($fields));die;
        // Open connection  
        $ch = curl_init(); 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post   
        $result = curl_exec($ch); 
        // Close connection      
        curl_close($ch);
        return $result;
    }
    public function sendPushNotificationToFCMSever($tokenarr=array(), $message=array(),$extraNotificationData=array()) {
		
        $notificationkey = 'AAAAGUjc_Lw:APA91bFhYcCJ7X5fiVH75enD3zByM_PaMPXDgJkF4kIoTOtks0fpdWiJpzt-24RBerW6vImfS6q1qU3dcuxS08QJH_bh_9J4ZNPSW35DBJPJ8EqllVcmGWxFTQW_f8Q3bAfucIkNZMnl';
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
 
        $fields = array(
            'registration_ids' => $tokenarr,
            'priority' => 10,
            'notification' =>$message,
            'data'=>$extraNotificationData
        );
        $headers = array(
            'Authorization:key='.$notificationkey,
            'Content-Type:application/json'
        );  
        // print_r($fields);die;
        // Open connection  
        $ch = curl_init(); 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm); 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post   
        $result = curl_exec($ch); 
        // Close connection      
        curl_close($ch);
        return $result;
    }
    
}