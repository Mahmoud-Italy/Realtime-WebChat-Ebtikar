<?php

namespace App\Http\Controllers;

use DB;
use App;
use Auth;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\User_logs;
use App\User_agent;

class AppCtrl extends Controller
{
    public function login()
    {
    	#If Auth exists return 404 page
    	if(Auth::check()) {
    		return redirect()->to('chat-window');
    	}
    	return view('layouts.app');
    }

    public function doLogin(Request $request)
    {
    	#Validation 
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        $email = $request->input('email');
        $password = $request->input('password');
        
        #Check User Access Denied 
        if(self::AccessDenied()) {
        	Session::flash('warning','Your Account have been Suspend for 5min');
        	return redirect()->back();
        }

        #Get Ready for Authentication
        $data = ["email"=>$email,"password" =>$password];
        if(Auth::attempt($data, true)) {
        	$userId = Auth::user()->id;

        	// Check User IP ADDRESS IF FALSE SEND Activation Key
        	if(self::checkUserIP($userId)) {
        		User_agent::where('user_id',$userId)->update(['user_agent'=>$_SERVER['HTTP_USER_AGENT']]);
        		return redirect()->to('chat-window');
        	} else {
        		#Generate Activation key
                $row = User::find($userId);
                $row->activation_key = time().''.uniqid(md5($email));
                $row->save();
                Auth::logout();

                //Send Mail for Verifiy Account
                Mail::send('emails.verify', ['user' => $row], function($message) use($row) {
                    $message->to($row->email, $row->name)->subject('Verifiy Your Account');
                 });
                Session::flash('user_verify','');
                return redirect()->back();
        	}
        } else {
           self::userLogs();
           Session::flash('error','Email \ Password Incorrect');
           return redirect()->back();
        }
    }

    public function doSignup(Request $request)
    {
    	#Validation 
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        try {
        	#Transaction between 2 tables
        	DB::beginTransaction();
        	$usr = new User;
        	$usr->name = $request->input('name');
        	$usr->email = $request->input('email');
        	$usr->password = bcrypt($request->input('password'));
            $usr->activation_key = time().''.uniqid(md5($usr->name));
        	$usr->save();

        	$agent = new User_agent;
        	$agent->user_id = $usr->id;
        	$agent->user_agent = $_SERVER['HTTP_USER_AGENT'];
        	$agent->ip_address = $_SERVER['REMOTE_ADDR'];
        	$agent->save();

        	#Commit the roles & Save into DB
            DB::commit();
            
            #Send Mail for Verifiy Account
            Mail::send('emails.verify', ['user' => $usr], function($message) use($usr) {
                $message->to($usr->email, $usr->name)->subject('Verify Your Account');
             });
            Session::flash('verification_key','');

        } catch (\Exception $e) {
        	#Rollback incase exception at one of them
        	DB::rollback();
        	Session::flash('error','Something went wrong');
        }
        return redirect()->back();
    }

    public function checkUserIP($userId)
    {
    	try {
    		#Compare Current IP Address with who's stored into DB
    		$current_ip = $_SERVER['REMOTE_ADDR'];
    		$agent = User_agent::where('user_id',$userId)->first();
    		if($current_ip == $agent->ip_address) { return true; } 
    		else { return false; }
    	} catch (\Exception $e) { return false; }
    }

    public function userVerify(Request $request)
    {
    	try {
    		#Verifiy Activation key
    		$activation_key = $request->input('activation_key');
    		if(User::where('activation_key',$activation_key)->count() == 0) {
    			Session::flash('error','Invalid Activation key');
                Session::flash('user_verify','');
    			return redirect()->back();
    		} else {
              
              #Update tables with new recoards
    		  DB::beginTransaction();
              $usr = User::where('activation_key',$activation_key)->first();
              $usr->activation_key = NULL;
              $usr->save();

              $agent = User_agent::where('user_id',$usr->id)->first();
              $agent->user_agent = $_SERVER['HTTP_USER_AGENT'];
              $agent->ip_address = $_SERVER['REMOTE_ADDR'];
              $agent->save();
              DB::commit();

              #Auto Login after Activated
              Auth::login($usr);
              return redirect()->to('chat-window');
    		}
    	} catch (\Exception $e) {
    		DB::rollback();
    		Session::flash('error','Something went wrong');
            Session::flash('user_verify','');
    		return redirect()->back();
    	}
    }




    public function doVerify(Request $request)
    {
        try {
            #Verifiy Activation key
            $activation_key = $request->input('activation_key');
            if(User::where('activation_key',$activation_key)->count() == 0) {
                Session::flash('error','Invalid Activation key');
                Session::flash('verification_key','');
                return redirect()->to('/');
            } else {
              
              #Update tables with new recoards
              DB::beginTransaction();
              $usr = User::where('activation_key',$activation_key)->first();
              $usr->email_verified_at = date('Y-m-d H:i:s');
              $usr->activation_key = NULL;
              $usr->save();

              $agent = User_agent::where('user_id',$usr->id)->first();
              $agent->user_agent = $_SERVER['HTTP_USER_AGENT'];
              $agent->ip_address = $_SERVER['REMOTE_ADDR'];
              $agent->save();
              DB::commit();

              #Auto Login after Activated
              Auth::login($usr);
              return redirect()->to('chat-window');
            }
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error','Something went wrong');
            Session::flash('verification_key','');
            return redirect()->to('/');
        }
    }

    public function userLogs()
    {
    	try {
    		#Save Logs each time trying Access
	    	$row = new User_logs;
	    	$row->ip_address = $_SERVER['REMOTE_ADDR'];
	    	$row->save();
    	} catch (\Exception $e) {}
    }

    public function AccessDenied()
    {
    	try {
    		#Return false if overload 5 times
    		$current_ip = $_SERVER['REMOTE_ADDR'];
	    	if(User_logs::where('ip_address',$current_ip)->whereRaw('last_activity >= now() - interval 5 minute')->count() >= 5) { return true; } 
	    	else return false;
    	} catch (\Exception $e) { return false; }
    }

    public function logout()
    {
    	Auth::logout();
    	return redirect()->to('/');
    }

}
