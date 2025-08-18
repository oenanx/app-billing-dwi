<?php
namespace App\Http\Controllers;

use App\Models\Mod_login;
use App\Mail\SentMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class Home extends Controller
{
    public function index(Request $request)
    {
		if(Session::get('userid'))
		{
			$username = Session::get('username');
			//dd($username);

			$bulan = DB::select("CALL sp_bulan()");

			return view('home.dashboard.home_user', compact('bulan'));
		}
		else
		{
			//jika session belum terdaftar, maka redirect ke halaman login
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

			Auth::logoutOtherDevices(Session::get('userid'));
			Auth::logoutOtherDevices(Session::get('realname'));
			Auth::logoutOtherDevices(Session::get('email'));
			Auth::logoutOtherDevices(Session::get('username'));
			Auth::logoutOtherDevices(Session::get('company_id'));
			Auth::logoutOtherDevices(Session::get('departemen_id'));
			Auth::logoutOtherDevices(Session::get('departemen'));
			Auth::logoutOtherDevices(Session::get('sex'));
			Auth::logoutOtherDevices(Session::get('login'));
			
			session()->forget('userid');
			session()->forget('realname');
			session()->forget('email');
			session()->forget('username');
			session()->forget('company_id');
			session()->forget('departemen_id');
			session()->forget('departemen');
			session()->forget('sex');
			session()->forget('login');
		
			session()->flush();
			Auth::logout();
			DB::disconnect('mysql');
			DB::disconnect('mysql_2');
			DB::disconnect('mysql_3');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
    }

    public function dashboard(Request $request)
    {
		if(Session::get('userid'))
		{
			return view('home.dashboard.home_user');
		}
		else
		{
			//jika session belum terdaftar, maka redirect ke halaman login
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

			Auth::logoutOtherDevices(Session::get('userid'));
			Auth::logoutOtherDevices(Session::get('realname'));
			Auth::logoutOtherDevices(Session::get('email'));
			Auth::logoutOtherDevices(Session::get('username'));
			Auth::logoutOtherDevices(Session::get('company_id'));
			Auth::logoutOtherDevices(Session::get('departemen_id'));
			Auth::logoutOtherDevices(Session::get('departemen'));
			Auth::logoutOtherDevices(Session::get('sex'));
			Auth::logoutOtherDevices(Session::get('login'));
			
			session()->forget('userid');
			session()->forget('realname');
			session()->forget('email');
			session()->forget('username');
			session()->forget('company_id');
			session()->forget('departemen_id');
			session()->forget('departemen');
			session()->forget('sex');
			session()->forget('login');
		
			session()->flush();
			Auth::logout();
			DB::disconnect('mysql');
			DB::disconnect('mysql_2');
			DB::disconnect('mysql_3');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
    }

    public function home(Request $request)
    {
		if($request->userid)
		{
            $userid = $request->userid;
            //dd($userid);
            $data = DB::table('db_user.master_user')
                    ->select('id','userid','realname','email','company_id','departemen_id','departemen','sex')
                    ->where('userid', '=', $userid)
                    ->where('IsActive', '=', 1)
                    ->first();

            Session::put('id',$data->id);
            Session::put('userid',$data->userid);
            Session::put('realname',$data->realname);
            Session::put('email',$data->email);
            Session::put('username',$data->email);
            Session::put('company_id',$data->company_id);
            Session::put('departemen_id',$data->departemen_id);
            Session::put('departemen',$data->departemen);
            Session::put('sex',$data->sex);
            Session::put('login',TRUE);

			$username = Session::get('username');
			//dd($username);

			$bulan = DB::select("CALL sp_bulan()");

			return view('home.dashboard.home_user', compact('bulan'));
		}
		else
		{
			//jika session belum terdaftar, maka redirect ke halaman login
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

			Auth::logoutOtherDevices(Session::get('userid'));
			Auth::logoutOtherDevices(Session::get('realname'));
			Auth::logoutOtherDevices(Session::get('email'));
			Auth::logoutOtherDevices(Session::get('username'));
			Auth::logoutOtherDevices(Session::get('company_id'));
			Auth::logoutOtherDevices(Session::get('departemen_id'));
			Auth::logoutOtherDevices(Session::get('departemen'));
			Auth::logoutOtherDevices(Session::get('sex'));
			Auth::logoutOtherDevices(Session::get('login'));
			
			session()->forget('userid');
			session()->forget('realname');
			session()->forget('email');
			session()->forget('username');
			session()->forget('company_id');
			session()->forget('departemen_id');
			session()->forget('departemen');
			session()->forget('sex');
			session()->forget('login');
		
			session()->flush();
			Auth::logout();
			DB::disconnect('mysql');
			DB::disconnect('mysql_2');
			DB::disconnect('mysql_3');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
    }
	
    public function logout()
    {
		header("cache-Control: no-store, no-cache, must-revalidate");
		header("cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

		Auth::logoutOtherDevices(Session::get('userid'));
		Auth::logoutOtherDevices(Session::get('realname'));
		Auth::logoutOtherDevices(Session::get('email'));
		Auth::logoutOtherDevices(Session::get('username'));
		Auth::logoutOtherDevices(Session::get('company_id'));
		Auth::logoutOtherDevices(Session::get('departemen_id'));
		Auth::logoutOtherDevices(Session::get('departemen'));
		Auth::logoutOtherDevices(Session::get('sex'));
		Auth::logoutOtherDevices(Session::get('login'));
		
		session()->forget('userid');
		session()->forget('realname');
		session()->forget('email');
		session()->forget('username');
		session()->forget('company_id');
		session()->forget('departemen_id');
		session()->forget('departemen');
		session()->forget('sex');
		session()->forget('login');
	
		session()->flush();
		Auth::logout();
		DB::disconnect('mysql');
		DB::disconnect('mysql_2');
		DB::disconnect('mysql_3');

		return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
		echo "<script>window.close();</script>";
    }

}
?>