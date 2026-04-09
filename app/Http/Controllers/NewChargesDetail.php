<?php

namespace App\Http\Controllers;

use App\Exports\RptNewChargesDetail;
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

class NewChargesDetail extends Controller
{
    public function index(Request $request)
    {
		if(Session::get('userid'))
		{
			//jika memang session sudah terdaftar
            $data['thn']	= DB::select('SELECT DATE_FORMAT(CURDATE(), "%Y") AS TAHUN;');
			return view('home.reports.NewChargesDetail.index')->with($data);
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
						->where('fapi', 1)
                        ->where('bs_postpaid.PERIOD', $periode)
                        ->join('master_company', 'master_company.CUSTOMERNO', '=', 'bs_postpaid.CUSTOMERNO')
                        ->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company.SALESAGENTCODE')
                        ->select('bs_postpaid.PERIOD',
                        'bs_postpaid.CUSTOMERNO',
                        'master_company.company_name',
                        'master_company.activation_date',
                        DB::raw('CASE WHEN master_company.active = 1 THEN "ACTIVED" WHEN master_company.active = 0 THEN "INACTIVED" END AS active'),
                        DB::raw('FORMAT(bs_postpaid.USAGEADJUSTMENT,0) AS USAGEADJUSTMENT'),
                        DB::raw('FORMAT(bs_postpaid.TOTALDISCOUNT,0) AS TOTALDISCOUNT'),
                        DB::raw('FORMAT(bs_postpaid.PREVIOUSBALANCE,0) AS PREVIOUSBALANCE'),
                        DB::raw('FORMAT(bs_postpaid.BALANCEADJUSTMENT,0) AS BALANCEADJUSTMENT'),
                        DB::raw('FORMAT(bs_postpaid.PREVIOUSPAYMENT,0) AS PREVIOUSPAYMENT'),
                        DB::raw('FORMAT(bs_postpaid.TOTALAMOUNT,0) AS TOTALAMOUNT'),
                        DB::raw('FORMAT((bs_postpaid.TOTALAMOUNT-bs_postpaid.TOTALDISCOUNT-bs_postpaid.USAGEADJUSTMENT-bs_postpaid.PENALTY),0) AS REVENUE'),
                        DB::raw('FORMAT(bs_postpaid.TOTALVAT,0) AS TOTALVAT'),
                        DB::raw('FORMAT((bs_postpaid.TOTALAMOUNT-bs_postpaid.TOTALDISCOUNT+bs_postpaid.TOTALVAT-bs_postpaid.USAGEADJUSTMENT-bs_postpaid.PENALTY),0) AS NEWCHARGE'),
                        DB::raw('FORMAT(bs_postpaid.TOTALUSAGE,0) AS TOTALUSAGE'),
                        DB::raw('FORMAT((bs_postpaid.PREVIOUSBALANCE-bs_postpaid.BALANCEADJUSTMENT-bs_postpaid.PREVIOUSPAYMENT),0) as NEWBALANCE'),
                        'salesagent.SALESAGENTNAME')
						->orderBy('bs_postpaid.CUSTOMERNO','ASC')
						->paginate($request->query('perpage', 1000000))
						->appends(request()->query());
				//dd($data);
				return response()->paginator($data);
			}

			//return view('home.reports.NewChargesDetail.index');
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
					->where('fapi', 1)
					->where('bs_postpaid.PERIOD', $periode)
					->join('master_company', 'master_company.CUSTOMERNO', '=', 'bs_postpaid.CUSTOMERNO')
					->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company.SALESAGENTCODE')
					->select('bs_postpaid.PERIOD',
					'bs_postpaid.CUSTOMERNO',
					'master_company.company_name',
					'master_company.activation_date',
					DB::raw('CASE WHEN master_company.active = 1 THEN "ACTIVED" WHEN master_company.active = 0 THEN "INACTIVED" END AS active'),
					DB::raw('FORMAT(bs_postpaid.USAGEADJUSTMENT,0) AS USAGEADJUSTMENT'),
					DB::raw('FORMAT(bs_postpaid.TOTALDISCOUNT,0) AS TOTALDISCOUNT'),
					DB::raw('FORMAT(bs_postpaid.PREVIOUSBALANCE,0) AS PREVIOUSBALANCE'),
					DB::raw('FORMAT(bs_postpaid.BALANCEADJUSTMENT,0) AS BALANCEADJUSTMENT'),
					DB::raw('FORMAT(bs_postpaid.PREVIOUSPAYMENT,0) AS PREVIOUSPAYMENT'),
					DB::raw('FORMAT(bs_postpaid.TOTALAMOUNT,0) AS TOTALAMOUNT'),
					DB::raw('FORMAT((bs_postpaid.TOTALAMOUNT-bs_postpaid.TOTALDISCOUNT-bs_postpaid.USAGEADJUSTMENT-bs_postpaid.PENALTY),0) AS REVENUE'),
					DB::raw('FORMAT(bs_postpaid.TOTALVAT,0) AS TOTALVAT'),
					DB::raw('FORMAT((bs_postpaid.TOTALAMOUNT-bs_postpaid.TOTALDISCOUNT+bs_postpaid.TOTALVAT-bs_postpaid.USAGEADJUSTMENT-bs_postpaid.PENALTY),0) AS NEWCHARGE'),
					DB::raw('FORMAT(bs_postpaid.TOTALUSAGE,0) AS TOTALUSAGE'),
					DB::raw('FORMAT((bs_postpaid.PREVIOUSBALANCE-bs_postpaid.BALANCEADJUSTMENT-bs_postpaid.PREVIOUSPAYMENT),0) as NEWBALANCE'),
					'salesagent.SALESAGENTNAME')
					->orderBy('bs_postpaid.CUSTOMERNO','ASC')
					->get();	

			ob_end_clean();

			return Excel::download(new RptNewChargesDetail($periode, $data), 'Rpt New Charges Detail DataWiz API '.$periode.'.xlsx');
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
