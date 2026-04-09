<?php

namespace App\Http\Controllers;

use App\Exports\RptDiscNonNPWP;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class DiscNonNPWP extends Controller
{
    public function index(Request $request)
    {
		if(Session::get('userid'))
		{
			//jika memang session sudah terdaftar
            $data['thn']	= DB::select('SELECT DATE_FORMAT(CURDATE(), "%Y") AS TAHUN;');
			return view('home.reports.DiscNonNPWP.index')->with($data);
		}
		else
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
	
    public function datatable(Request $request, $params)
	{
        if(Session::get('userid'))
		{
			$periode	= $params;
			//dd($periode);
			if ($request->ajax()) 
			{
                $data = DB::table('bs_postpaid')
                        ->where('bs_postpaid.PERIOD', $periode)
                        ->where('bs_postpaid.TOTALAMOUNT', '!=', 0)
                        ->where('master_company.npwpno', '=', '00.000.000.0-000.000')
                        ->join('master_company', 'master_company.customerno', '=', 'bs_postpaid.CUSTOMERNO')
                        ->select('bs_postpaid.PERIOD', 'master_company.customerno', 'bs_postpaid.bsno', 'master_company.company_name', 'master_company.address_npwp', 'master_company.npwpno', DB::raw('FORMAT(bs_postpaid.TOTALAMOUNT,0) AS TOTALAMOUNT'), DB::raw('FORMAT(bs_postpaid.TOTALDISCOUNT,0) TOTALDISCOUNT'),DB::raw('FORMAT(bs_postpaid.TOTALAMOUNT - bs_postpaid.TOTALDISCOUNT,0) as charge'),DB::raw('FORMAT(bs_postpaid.TOTALVAT,0) AS TOTALVAT'))
                        ->orderBy('bs_postpaid.TOTALAMOUNT','DESC')
						->paginate($request->query('perpage', 1000000))
						->appends(request()->query());

				return response()->paginator($data);
			}

			//return view('home.reports.DiscNonNPWP.index');
		}
        else
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

	public function download(Request $request, $params)
    {
        if(Session::get('userid'))
		{
			//dd($params);
			$periode	= $params;
		
			$data = DB::table('bs_postpaid')
					->where('bs_postpaid.PERIOD', $periode)
					->where('bs_postpaid.TOTALAMOUNT', '!=', 0)
					->where('master_company.npwpno', '=', '00.000.000.0-000.000')
					->join('master_company', 'master_company.customerno', '=', 'bs_postpaid.CUSTOMERNO')
					->select('bs_postpaid.PERIOD', 'master_company.customerno', 'bs_postpaid.bsno', 'master_company.company_name', 'master_company.address_npwp', 'master_company.npwpno', DB::raw('FORMAT(bs_postpaid.TOTALAMOUNT,0) AS TOTALAMOUNT'), DB::raw('FORMAT(bs_postpaid.TOTALDISCOUNT,0) TOTALDISCOUNT'),DB::raw('FORMAT(bs_postpaid.TOTALAMOUNT - bs_postpaid.TOTALDISCOUNT,0) as charge'),DB::raw('FORMAT(bs_postpaid.TOTALVAT,0) AS TOTALVAT'))
					->orderBy('bs_postpaid.TOTALAMOUNT','DESC')
					->get();	

			ob_end_clean();

			return Excel::download(new RptDiscNonNPWP($periode, $data), 'Rpt Discount Non NPWP DataWiz API '.$periode.'.xlsx');
		}
        else
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

}
