<?php

namespace App\Http\Controllers;

use App\Models\Mod_Company;
use App\Models\Mod_PaymentPostpaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;

class PaymentPostpaid extends Controller
{
    public function index(Request $request)
    {
		if(Session::get('userid'))
		{
			//jika memang session sudah terdaftar
			//$paymentmethod  = DB::select('SELECT PAYMENTCODE, PAYMENTMETHOD FROM paymentmethod ORDER BY PAYMENTCODE;');

			return view('home.paymentpostpaid.index');
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
			DB::disconnect('mysql_4');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}

    public function datatables(Request $request)
    {
		if(Session::get('userid'))
		{
			if ($request->ajax()) 
			{
				$data = QueryBuilder::for(Mod_Company::class)
						->where('fapi', 1)
						->where('billingtypes', 2)
						->whereNotIn('master_company.customerno', ["DWH00000020C","DWH00000056C","DWH00000058C","DWH00000071C","DWH00000072C","DWH00000077R","DWH00000078R","DWH00000079R"])
						->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company.SALESAGENTCODE')
						->join('master_product_api_customer', 'master_product_api_customer.customerno', '=', 'master_company.customerno')
						->select('master_company.customerno', 'master_company.company_name', DB::raw('UPPER(SALESAGENTNAME) AS SALESAGENTNAME'), DB::raw('DATE_FORMAT(activation_date,"%d-%m-%Y") AS activate_date'), DB::raw('(active) as factive'), DB::raw('(CASE WHEN active = 1 THEN "Active" WHEN active = 2 THEN "Trial" WHEN active = 0 THEN "Terminated" ELSE "Blocked" END) as active'), DB::raw('billingtypes AS billingtype'),DB::raw('(CASE WHEN billingtypes = 1 THEN "PREPAID" WHEN billingtypes = 2 THEN "POSTPAID" END) as tipebilling'))
						->groupBy('master_company.customerno','master_company.company_name','SALESAGENTNAME','activate_date','factive','active','billingtypes','tipebilling')
						->orderBy('master_company.customerno','DESC')
						->paginate($request->query('perpage', 10))
						->appends(request()->query());
						//dd($data);

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
			DB::disconnect('mysql_2');
			DB::disconnect('mysql_3');
			DB::disconnect('mysql_4');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}

	public function view_detail(Request $request, $id)
	{
		if(Session::get('userid'))
        {
			$customerno 	= $id;

			if ($request->ajax()) 
			{
				//$data = DB::table('trans_postpaid')
				$data = QueryBuilder::for(Mod_PaymentPostpaid::class)
						->where('fapi', 1)
						->where('billingtypes', 2)
						->where('TOTALAMOUNT', '>', 0)
						->where('master_company.customerno', $customerno)
						->join('master_company', 'master_company.CUSTOMERNO', '=', 'trans_postpaid.CUSTOMERNO')
						->join('master_product_api_customer', 'master_product_api_customer.customerno', '=', 'master_company.customerno')
						->join('bs_postpaid', function ($join) {
							$join->on('trans_postpaid.customerno', '=', 'bs_postpaid.customerno')
								 ->on('trans_postpaid.PERIOD', '=', 'bs_postpaid.PERIOD');
							})
						->select('TR_ID', DB::raw('trans_postpaid.CUSTOMERNO AS CustomerId'), DB::raw('master_company.company_name AS CustomerName'), DB::raw('DATE_FORMAT(trans_postpaid.DUEDATE,"%Y-%m-%d") AS DueDate'), DB::raw('DATE_FORMAT(ENTRYDATE,"%Y-%m-%d") AS EntryDate'), DB::raw('CONCAT("Rp. ",FORMAT((bs_postpaid.TOTALAMOUNT + bs_postpaid.TOTALVAT),0)) AS NOMINAL_TAGIHAN'), 'trans_postpaid.PERIOD', DB::raw('CONCAT("Rp. ",FORMAT(AMOUNT,0)) AS Payment'), DB::raw('bs_postpaid.BSNO AS InvoiceNo'), DB::raw('CASE WHEN AMOUNT > 0 THEN "PAID" ELSE "UNPAID" END AS statuspayment'), DB::raw('(CASE WHEN master_company.active = 1 THEN "Active" WHEN master_company.active = 2 THEN "Trial" WHEN master_company.active = 0 THEN "Terminated" ELSE "Blocked" END) as active'))
						->groupBy('trans_postpaid.TR_ID','trans_postpaid.CUSTOMERNO','master_company.company_name','trans_postpaid.DUEDATE','ENTRYDATE','TOTALAMOUNT','TOTALVAT','trans_postpaid.PERIOD','Payment','bs_postpaid.BSNO','statuspayment','active')
						->orderBy('trans_postpaid.PERIOD','DESC')
						->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 10))
						->appends(request()->query());
						
				return response()->paginator($data);
			}

			$paymentmethod  = DB::select('SELECT PAYMENTCODE, PAYMENTMETHOD FROM paymentmethod ORDER BY PAYMENTCODE;');

			$cname 			= DB::table('master_company')->select('company_name')->where('customerno', $customerno)->where('fapi', 1)->first();
			$company_name	= $cname->company_name;						

            return view('home.paymentpostpaid.detail', compact('paymentmethod','customerno','company_name'));

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
			DB::disconnect('mysql_4');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
    }

    public function view(Request $request, $id)
    {
        if(Session::get('userid'))
        {
            $data = DB::table('trans_postpaid')
					->where('billingtypes', 2)
					->where('fapi', 1)
                    ->where('trans_postpaid.TR_ID', $id)
                    ->join('master_company', 'master_company.CUSTOMERNO', '=', 'trans_postpaid.CUSTOMERNO')
					->join('master_product_api_customer', 'master_product_api_customer.customerno', '=', 'master_company.customerno')
                    ->leftJoin('paymentmethod', 'paymentmethod.PAYMENTCODE', '=', 'trans_postpaid.PAYMENTCODE')
                    ->select('TR_ID', DB::raw('trans_postpaid.CUSTOMERNO AS CustomerId'), DB::raw('master_company.company_name AS CustomerName'), DB::raw('DATE_FORMAT(TRANSACTIONDATE,"%Y-%m-%d") AS PaymentDate'), DB::raw('DATE_FORMAT(ENTRYDATE,"%Y-%m-%d") AS EntryDate'), 'trans_postpaid.PAYMENTCODE', DB::raw('paymentmethod.PAYMENTMETHOD AS PaymentMethod'), DB::raw('CASE WHEN TRANSACTIONCODE = "P" THEN "PAYMENT" WHEN TRANSACTIONCODE = "B" THEN "BALANCED ADJUSTMENT" WHEN TRANSACTIONCODE = "D" THEN "DISCOUNT" WHEN TRANSACTIONCODE = "U" THEN "USAGE ADJUSTMENT" WHEN TRANSACTIONCODE = "R" THEN "REFUND" END AS TransactionType'), DB::raw('TRANSACTIONCODE AS TransactionTypes'), 'trans_postpaid.AMOUNT', DB::raw('FORMAT(AMOUNT,0) AS Payment'), DB::raw('INFO AS AdditionalInfo'),'trans_postpaid.RECEIPTNO','trans_postpaid.NOMINAL_TAGIHAN','trans_postpaid.PERIOD')
					->distinct()
                    ->first();

            return response()->json($data);
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
			DB::disconnect('mysql_4');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
        }
    }

    public function insert(Request $request)
    {
        if(Session::get('userid'))
        {
            //TR_ID,TRANSACTIONDATE,TRANSACTIONCODE,CUSTOMERNO,AMOUNT,PAYMENTCODE,INFO,RECEIPTNO,UPD_USER,UPD_DATE,SETTLEMENT_STATUS
			//dd($request);
            $editid             = $request->id1;
            $ENTRYDATE		    = date('Y-m-d H:i:s');
            $TRANSACTIONCODE    = $request->transtype1;
	        $CUSTOMERNO         = $request->cno1;
	        $AMOUNT             = floatval(str_replace('.', ',', str_replace(',', '', $request->payment1))); //$request->payment2;
	        $PAYMENTCODE        = $request->paymentcode1;
	        $INFO               = $request->keterangan1;
	        $RECEIPTNO          = $request->receipt1;
			$SETTLEMENT_STATUS	= 1;
	        $NOMINAL_TAGIHAN    = $request->nominal1;
	        $PERIOD		        = $request->period1;
	        $PERIOD_PAY	        = $request->period1 + 1;
            $UPD_USER           = $request->userid1;
	        $UPD_DATE           = date('Y-m-d H:i:s');
			
			//echo "TAGIHAN : ".$AMOUNT."<br />";
			//echo "INPUT PAYMENT : ".$NOMINAL_TAGIHAN."<br />";
			//dd("------");
			//if ($AMOUNT !== $NOMINAL_TAGIHAN)
			//{
				//return response()->json(['error' => 'The Payment Amount must be the same as the Billing Amount !']);
			//};

            $data = array('ENTRYDATE' => $ENTRYDATE, 'TRANSACTIONCODE' => $TRANSACTIONCODE, 'AMOUNT' => $AMOUNT, 'PAYMENTCODE' => $PAYMENTCODE, 'INFO' => $INFO, 'RECEIPTNO' => $RECEIPTNO, 'SETTLEMENT_STATUS' => $SETTLEMENT_STATUS, 'UPD_USER' => $UPD_USER, 'UPD_DATE' => $UPD_DATE);

		    Mod_PaymentPostpaid::updateData($editid, $data);
			
			//Update previouspayment periode +1 di table bs_postpaid
            $query1 = DB::table('bs_postpaid')->where('CUSTOMERNO', $CUSTOMERNO)->where('PERIOD', $PERIOD_PAY)->update(['PREVIOUSPAYMENT' => $AMOUNT]);


			//Update field "active" di table master_company_api dan di table master_user server dasboard (app global)
            $query1 = DB::connection('mysql_4')->table('master_company')->where('fapi', 1)->where('customerno', $CUSTOMERNO)->update(['active' => 1]);

			$parent = DB::connection('mysql_4')->table('master_company')->where('fapi', 1)->where('customerno', $CUSTOMERNO)->select('parentid')->first();
			$parentid = $parent->parentid;

            $query2 = DB::connection('mysql_4')->table('master_user')->where('parentid', $parentid)->update(['active' => 1]);

            $query3 = DB::table('master_company')->where('customerno', $CUSTOMERNO)->update(['active' => 1]);

            $query4 = DB::connection('mysql_3')->table('master_company')->where('fapi', 1)->where('customerno', $CUSTOMERNO)->update(['active' => 1]);

	        //return back()->with('success','Payment Saved Successfully.');
			return response()->json(['success' => 'Payment Saved Successfully.']);
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
			DB::disconnect('mysql_4');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
        }
    }

    public function update(Request $request)
    {
        if(Session::get('userid'))
        {
            //TR_ID,TRANSACTIONDATE,TRANSACTIONCODE,CUSTOMERNO,AMOUNT,PAYMENTCODE,INFO,RECEIPTNO,UPD_USER,UPD_DATE,SETTLEMENT_STATUS

            $editid             = $request->id2;
            $ENTRYDATE		    = date('Y-m-d H:i:s');
            $TRANSACTIONCODE    = $request->transtype2;
	        $CUSTOMERNO         = $request->cno2;
	        $AMOUNT             = floatval(str_replace('.', ',', str_replace(',', '', $request->payment2))); //$request->payment2;
	        $PAYMENTCODE        = $request->paymentcode2;
	        $INFO               = $request->keterangan2;
	        $RECEIPTNO          = $request->receipt2;
			$SETTLEMENT_STATUS	= 1;
	        $NOMINAL_TAGIHAN    = $request->nominal2;
	        $PERIOD		        = $request->period2;
            $UPD_USER           = $request->userid2;
	        $UPD_DATE           = date('Y-m-d H:i:s');

            $data = array('ENTRYDATE' => $ENTRYDATE, 'TRANSACTIONCODE' => $TRANSACTIONCODE, 'AMOUNT' => $AMOUNT, 'PAYMENTCODE' => $PAYMENTCODE, 'INFO' => $INFO, 'RECEIPTNO' => $RECEIPTNO, 'SETTLEMENT_STATUS' => $SETTLEMENT_STATUS, 'UPD_USER' => $UPD_USER, 'UPD_DATE' => $UPD_DATE);

		    Mod_PaymentPostpaid::updateData($editid, $data);
			
			//Update field "active" di table master_company_api dan di table master_user server dasboard (app global)
            $query1 = DB::connection('mysql_4')->table('master_company')
					->where('fapi', 1)
                    ->where('customerno', $CUSTOMERNO)
                    ->update(['active' => 1]);

			$parent = DB::connection('mysql_4')->table('master_company')->where('fapi', 1)->where('customerno', $CUSTOMERNO)->where('active', 1)->select('parentid')->first();
			$parentid = $parent->parentid;

            $query2 = DB::connection('mysql_4')->table('master_user')
                    ->where('parentid', $parentid)
                    ->update(['active' => 1]);

	        return back()
	            ->with('success','Payment Updated Successfully.');
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
			DB::disconnect('mysql_4');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
        }
    }
	
	/*
    public function delete(Request $request,  $id)
    {
        if(Session::get('userid'))
        {
            DB::table('trans_postpaid')->where('trans_postpaid.TR_ID',$id)->delete();    
            
            return back()
                    ->with('success','A Payment was deleted successfully.');
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
			DB::disconnect('mysql_4');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
        }
    }
	*/
	
}
