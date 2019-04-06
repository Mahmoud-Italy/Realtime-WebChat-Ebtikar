<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Redirect;
use Response;
use Illuminate\Http\Request;
use App\User;
use App\Chat;

class ChatCtrl extends Controller
{
    public function index()
    {
        $user_id = Auth::user()->id;
        #Get Recent
    	$recent = self::loadRecent();
        
        #Prepare for belongs chat's
        $belongs = DB::table('users')->where('id','!=',$user_id)->get();
    	return view('chats.list')->withrecent($recent)->withbelongs($belongs);
    }

    public function loadRecent()
    {
    	$user_id = User::MyID();
    	$msgs = [];
    	$rows = User::where('id','!=',$user_id)->get();

        foreach($rows as $row) {
        	$unread_msg = 0;
        	$last_message = '';
        	$created_at = '';
            $seen = 0;
        	if(Chat::where([['user_from',$row->id],['user_to',$user_id]])->orwhere([['user_to',$row->id],['user_from',$user_id]])->count()) {
            
            #Get Last Recoard with last message between user's
            $last_row = DB::table("chats")->where([['user_from',$row->id],['user_to',$user_id]])->orwhere([['user_to',$row->id],['user_from',$user_id]])->orderBy('created_at','DESC')->limit(1)->first();

            $current_date = date('Y-m-d');
            $yesterday = date('Y-m-d', strtotime( '-1 days' ));
            $onlyDate = explode(' ',$last_row->created_at)[0];
            $onlyTime = explode(' ',$last_row->created_at)[1];
            $last_message = str_limit($last_row->message,50,'...');
            $seen = $last_row->seen;

            if ($onlyDate == $current_date) $created_at = date('h:i A',strtotime($onlyTime));
            else if ($onlyDate == $yesterday) $created_at = 'Yesterday';
            else $created_at = $onlyDate;
        	}
            $msgs[] = ["id"=>$row->id,"name"=>$row->name,"online"=>$row->online, 
                            "count_unread_msg"=>$unread_msg,"last_message"=>$last_message,'seen'=>$seen,
                            "created_at"=>$created_at]; 
        } 
              
            // Reverse data and get latest friends
            $reverse = collect($msgs)->sortBy('id')->reverse()->toArray();
              
            // Convert array to Collection
            $collection = collect($reverse)->map(function ($item) {
                return (object) $item;
            });
            return $collection;
    }





    public function loadChat(Request $request)
    {
        #Prepare Variables
        $user_id = Auth::user()->id;
          $friend_id = $request->userId;
        $conversion = array();
        $row = array();
        $page = 1;
        $const = 10;
        $total_data = 0;
        $page = $request->input('page');

        if(is_null($page)) {$page = 1;} 
        else {$page = $request->input('page');}

         try {
          #Admit Seen Old Message
          $submit_seens = DB::table('chats')->where('user_from','=',$friend_id)->where('user_to','=',$user_id)->update(['seen'=>1]);
          
          #Get Some Information About User
          $row = User::where('id',$friend_id)->first();
         
         #Get Holy Conversion
          $conversion = DB::table('chats as ch')
                   ->select('ch.id as chat_id','s.id','s.name','ch.message','ch.seen','ch.hidden','ch.created_at')
                   ->leftjoin('users as s', 'ch.user_from','=','s.id')->where('ch.hidden',0)
                   ->where(function ($query) use ($user_id,$friend_id) {
                  $query->where('ch.user_from', '=', $user_id)
                      ->where('ch.user_to', '=', $friend_id);
                  })->orWhere(function ($query) use ($user_id,$friend_id) {
                    $query->where('ch.user_from', '=', $friend_id)
                      ->where('ch.user_to', '=', $user_id);
                  })->orderBy('ch.created_at','DESC')->paginate(10)->getCollection();

            $total_data = DB::table('chats')->where('hidden',0)->where(function ($query) use ($user_id,$friend_id) {
                            $query->where('user_from', '=', $user_id)
                            ->where('user_to', '=', $friend_id);
                      })->orWhere(function ($query) use ($user_id,$friend_id) {
                            $query->where('user_from', '=', $friend_id)
                            ->where('user_to', '=', $user_id);
                     })->count();

        $status = true; 
     } catch (\Exception $e) {
        $status = false; 
    }
         
        #Get Ready For Next page [ pagination ]
        $nextPg = $page+1;
        $reload = $const*$page;
        if($reload < $total_data) $hasMore = true;
        else $hasMore = false;
       
      $returnView = view('chats.conversion')->withconversion($conversion)->withrow($row)->render();
      $json = ["status"=>$status,"total_data"=>$total_data,"html"=>$returnView,"hasMore"=>$hasMore,"nextPg"=>$nextPg,"reload"=>$reload];
      return Response::json($json);
    }


}
