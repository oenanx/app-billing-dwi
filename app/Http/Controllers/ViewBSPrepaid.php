<?php

namespace App\Http\Controllers;

use App\Models\M_BSPrepaid;
use App\Models\Mod_PaymentPrepaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\Datatables\Datatables;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;

class ViewBSPrepaid extends Controller
{
    public function bs(Request $request, $id)
    {
		if(Session::get('userid'))
		{
			if ($request->ajax()) 
			{
                //$data = QueryBuilder::for(M_BSPrepaid::class)  //DB::table('bs')
				$data = DB::table('bs_prepaid')
						->where('fapi', 1)
                        ->where('master_company.id', $id)
						->join('master_company', 'master_company.customerno', '=', 'bs_prepaid.CUSTOMERNO')
                        ->select('BSNO', 'PERIOD', DB::raw('FORMAT(PREVIOUSBALANCE,0) AS PREVIOUSBALANCE'), DB::raw('FORMAT(PREVIOUSPAYMENT,0) AS PREVIOUSPAYMENT'), DB::raw('FORMAT(BALANCEADJUSTMENT,0) AS BALANCEADJUSTMENT'), DB::raw('FORMAT(TOTALUSAGE,0) AS TOTALUSAGE'), DB::raw('FORMAT((TOTALVAT-USAGEADJUSTMENT-TOTALDISCOUNT+TOTALUSAGE),0) as NEWCHARGE'), DB::raw('FORMAT((PREVIOUSBALANCE-PREVIOUSPAYMENT-BALANCEADJUSTMENT+TOTALVAT-USAGEADJUSTMENT-TOTALDISCOUNT+TOTALAMOUNT),0) as AMOUNTDUE'))
                        ->orderBy('PERIOD','ASC')
						//->allowedFilters(
						//	AllowedFilter::scope('general_search')
						//)
						//->paginate($request->query('perpage', 0))
						//->appends(request()->query());

				//return response()->paginator($data);
                        ->get();

                return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
			}

			//return view('home.inquiryapi.inquiryapi');
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

            return redirect('http://192.168.100.115/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}
	
    public function pay(Request $request, $id)
    {
		if(Session::get('userid'))
		{
			if ($request->ajax()) 
			{
                $data = QueryBuilder::for(Mod_PaymentPrepaid::class)  //DB::table('trans_prepaid')
						->where('fapi', 1)
                        ->where('master_company.id', $id)
						->join('master_company', 'master_company.customerno', '=', 'trans_prepaid.CUSTOMERNO')
						->join('paymentmethod', 'paymentmethod.PAYMENTCODE', '=', 'trans_prepaid.PAYMENTCODE')
                        ->select('trans_prepaid.CUSTOMERNO', DB::raw('DATE_FORMAT(entrydate,"%Y-%m-%d") AS ENTRYDATE'), DB::raw('DATE_FORMAT(transactiondate,"%Y-%m-%d") AS TRANSDATE'), DB::raw('CASE WHEN TRANSACTIONCODE = "P" THEN "PAYMENT" WHEN TRANSACTIONCODE = "B" THEN "BALANCED ADJUSTMENT" WHEN TRANSACTIONCODE = "D" THEN "DISCOUNT" WHEN TRANSACTIONCODE = "U" THEN "USAGE ADJUSTMENT" WHEN TRANSACTIONCODE = "R" THEN "REFUND" END AS TRANSCODE'), DB::raw('CONCAT("Rp. ", FORMAT(amount,0)) AS AMOUNT'), 'trans_prepaid.paymentcode', DB::raw('paymentmethod.PAYMENTMETHOD AS PAYMETHOD'), 'info',DB::raw('CASE WHEN receiptno IS NULL THEN "-" ELSE receiptno END AS RECEIPTNO'),'settlement_status')
                        ->orderBy('ENTRYDATE','DESC')
						->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 0))
						->appends(request()->query());

				return response()->paginator($data);
			}

			return view('home.inquiryapi.inquiryapi');
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

            return redirect('http://192.168.100.115/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}
	
}
