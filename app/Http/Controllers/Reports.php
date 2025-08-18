<?php

namespace App\Http\Controllers;

use App\Models\Mod_Trx_h;
use App\Exports\ReportSummaryMonthly;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;
use Carbon\Carbon;

class Reports extends Controller
{
    public function summarymonth(Request $request)
    {
		if(Session::get('userid'))
		{
            $data['tgl'] = DB::select('SELECT BL_CODE,BL_DESC FROM sys_month WHERE BL_CODE = (SELECT DATE_FORMAT(CURDATE(),"%m"));');
            $data['thnx'] = DB::select('SELECT DATE_FORMAT(CURDATE(), "%Y") AS TAHUN;');
			$data['thn'] = DB::select('SELECT DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL -1 YEAR), "%Y") AS TAHUN;');

			return view('home.reports.summarymonth')->with($data);
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
		//dd($params);
        if(Session::get('userid'))
        {	
			if ($request->ajax()) 
			{
				$data = QueryBuilder::for(Mod_Trx_h::class) 
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $params)
						->where('trx_screen_no_h.customerno', '!=', 'DWH00000001C')
						->join('master_company', 'master_company.customerno', '=', 'trx_screen_no_h.customerno')
						->select('trx_screen_no_h.customerno','master_company.company_name',DB::raw('CASE WHEN nama_file IS NULL AND nama_file_wa IS NULL THEN nama_file_hp WHEN nama_file IS NULL AND nama_file_hp IS NULL THEN nama_file_wa WHEN nama_file_wa IS NULL AND nama_file_hp IS NULL THEN nama_file WHEN nama_file IS NOT NULL AND nama_file_hp IS NOT NULL AND nama_file_wa IS NOT NULL THEN nama_file END AS nama_file_result'),DB::raw('CASE WHEN nama_file IS NULL AND nama_file_wa IS NULL THEN jml_all_no_hp WHEN nama_file IS NULL AND nama_file_hp IS NULL THEN jml_all_no_wa WHEN nama_file_wa IS NULL AND nama_file_hp IS NULL THEN CASE WHEN trx_screen_no_h.customerno = "DWH00000024C" THEN jml_ktp_with_hp ELSE CASE WHEN jml_ktp_invalid = 0 THEN jml_ktp ELSE jml_ktp_valid END END WHEN nama_file IS NOT NULL AND nama_file_hp IS NOT NULL AND nama_file_wa IS NOT NULL THEN CASE WHEN trx_screen_no_h.customerno = "DWH00000024C" THEN jml_ktp_with_hp ELSE CASE WHEN jml_ktp_invalid = 0 THEN jml_ktp ELSE jml_ktp_valid END END END AS jml_result'),DB::raw('DATE_FORMAT(created_at,"%Y-%m-%d %H:%i:%s") AS created_at'))
						->orderBy('created_at', 'DESC')
						->get();

				return response($data);
			}

			return view('home.reports.summarymonth');
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

	public function searching(Request $request, $params)
    {
        if(Session::get('userid'))
        {
            //dd($params);
			$data = QueryBuilder::for(Mod_Trx_h::class) 
					->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $params)
					->where('trx_screen_no_h.customerno', '!=', 'DWH00000001C')
					->join('master_company', 'master_company.customerno', '=', 'trx_screen_no_h.customerno')
					->select('trx_screen_no_h.customerno','master_company.company_name',DB::raw('CASE WHEN nama_file IS NULL AND nama_file_wa IS NULL THEN nama_file_hp WHEN nama_file IS NULL AND nama_file_hp IS NULL THEN nama_file_wa WHEN nama_file_wa IS NULL AND nama_file_hp IS NULL THEN nama_file WHEN nama_file IS NOT NULL AND nama_file_hp IS NOT NULL AND nama_file_wa IS NOT NULL THEN nama_file END AS nama_file_result'),DB::raw('CASE WHEN nama_file IS NULL AND nama_file_wa IS NULL THEN jml_all_no_hp WHEN nama_file IS NULL AND nama_file_hp IS NULL THEN jml_all_no_wa WHEN nama_file_wa IS NULL AND nama_file_hp IS NULL THEN CASE WHEN jml_ktp_invalid = 0 THEN jml_ktp ELSE ((jml_ktp-jml_ktp_null_hp)+jml_ktp_na) END WHEN nama_file IS NOT NULL AND nama_file_hp IS NOT NULL AND nama_file_wa IS NOT NULL THEN CASE WHEN jml_ktp_invalid = 0 THEN jml_ktp ELSE ((jml_ktp-jml_ktp_null_hp)+jml_ktp_na) END END AS jml_result'),DB::raw('DATE_FORMAT(created_at,"%Y-%m-%d %H:%i:%s") AS created_at'))
					->orderBy('created_at', 'DESC')
					->get();
								
			ob_end_clean();
		
			return Excel::download(new ReportSummaryMonthly(
						$params,
						$data
					), 'summary usage monthly datawiz_'.$params.'.xlsx');
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
