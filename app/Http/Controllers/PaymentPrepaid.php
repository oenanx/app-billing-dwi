<?php

namespace App\Http\Controllers;

use App\Models\Mod_PaymentPrepaid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;

class PaymentPrepaid extends Controller
{
    public function index(Request $request)
    {
		if(Session::get('userid'))
		{
			//jika memang session sudah terdaftar
			/*
			if ($request->ajax()) 
			{
				//$data = DB::table('trans_prepaid')
				$data = QueryBuilder::for(Mod_PaymentPrepaid::class)
						->where('fapi', 1)
						->where('master_company.billingtype', 2)
						->join('master_company', 'master_company.CUSTOMERNO', '=', 'trans_prepaid.CUSTOMERNO')
						->select('TR_ID', DB::raw('trans_prepaid.CUSTOMERNO AS CustomerId'), DB::raw('master_company.company_name AS CustomerName'), DB::raw('DATE_FORMAT(DUEDATE,"%Y-%m-%d") AS DueDate'), DB::raw('DATE_FORMAT(ENTRYDATE,"%Y-%m-%d") AS EntryDate'), DB::raw('CONCAT("Rp. ",FORMAT(NOMINAL_TAGIHAN,0)) AS NOMINAL_TAGIHAN'), 'PERIOD', DB::raw('CONCAT("Rp. ",FORMAT(AMOUNT,0)) AS Payment'), DB::raw('BSNO AS InvoiceNo'), DB::raw('CASE WHEN (NOMINAL_TAGIHAN - AMOUNT) = 0 THEN "PAID" ELSE "UNPAID" END AS statuspayment'))
						->orderBy('trans_prepaid.TR_ID','DESC')
						->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 10))
						->appends(request()->query());
						
				return response()->paginator($data);
			}

			$paymentmethod  = DB::select('SELECT PAYMENTCODE, PAYMENTMETHOD FROM paymentmethod ORDER BY PAYMENTCODE;');
			*/
			$data['paymentmethod'] = DB::select('SELECT PAYMENTCODE,PAYMENTMETHOD FROM paymentmethod ORDER BY PAYMENTCODE;');

			return view('home.paymentprepaid.index')->with($data);
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
				//$data = DB::table('trans_prepaid')
				$data = QueryBuilder::for(Mod_PaymentPrepaid::class)
						->where('fapi', 1)
						->where('master_company.billingtype', 1)
						->where('master_company.customerno', $customerno)
						->join('master_company', 'master_company.CUSTOMERNO', '=', 'trans_prepaid.CUSTOMERNO')
						->select('TR_ID', DB::raw('trans_prepaid.CUSTOMERNO AS CustomerId'), DB::raw('master_company.company_name AS CustomerName'), DB::raw('DATE_FORMAT(DUEDATE,"%Y-%m-%d") AS DueDate'), DB::raw('DATE_FORMAT(ENTRYDATE,"%Y-%m-%d") AS EntryDate'), DB::raw('CONCAT("Rp. ",FORMAT(NOMINAL_TAGIHAN,0)) AS NOMINAL_TAGIHAN'), 'PERIOD', DB::raw('CONCAT("Rp. ",FORMAT(AMOUNT,0)) AS Payment'), DB::raw('BSNO AS InvoiceNo'), DB::raw('CASE WHEN (NOMINAL_TAGIHAN - AMOUNT) = 0 THEN "PAID" ELSE "UNPAID" END AS statuspayment'), DB::raw('(CASE WHEN master_company.active = 1 THEN "Active" WHEN master_company.active = 2 THEN "Trial" WHEN master_company.active = 0 THEN "Terminated" ELSE "Blocked" END) as active'))
						->orderBy('trans_prepaid.TR_ID','DESC')
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

            return view('home.paymentprepaid.detail', compact('paymentmethod','customerno','company_name'));

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
            $data = DB::table('trans_prepaid')
					->where('master_company.billingtype', 1)
					->where('fapi', 1)
                    ->where('trans_prepaid.TR_ID', $id)
                    ->join('master_company', 'master_company.CUSTOMERNO', '=', 'trans_prepaid.CUSTOMERNO')
                    ->leftJoin('paymentmethod', 'paymentmethod.PAYMENTCODE', '=', 'trans_prepaid.PAYMENTCODE')
                    ->select('TR_ID', DB::raw('trans_prepaid.CUSTOMERNO AS CustomerId'), DB::raw('master_company.company_name AS CustomerName'), DB::raw('DATE_FORMAT(TRANSACTIONDATE,"%Y-%m-%d") AS PaymentDate'), DB::raw('DATE_FORMAT(ENTRYDATE,"%Y-%m-%d") AS EntryDate'), 'trans_prepaid.PAYMENTCODE', DB::raw('paymentmethod.PAYMENTMETHOD AS PaymentMethod'), DB::raw('CASE WHEN TRANSACTIONCODE = "P" THEN "PAYMENT" WHEN TRANSACTIONCODE = "B" THEN "BALANCED ADJUSTMENT" WHEN TRANSACTIONCODE = "D" THEN "DISCOUNT" WHEN TRANSACTIONCODE = "U" THEN "USAGE ADJUSTMENT" WHEN TRANSACTIONCODE = "R" THEN "REFUND" END AS TransactionType'), DB::raw('TRANSACTIONCODE AS TransactionTypes'), 'trans_prepaid.AMOUNT', DB::raw('FORMAT(AMOUNT,0) AS Payment'), DB::raw('INFO AS AdditionalInfo'),'trans_prepaid.RECEIPTNO','trans_prepaid.NOMINAL_TAGIHAN','trans_prepaid.PERIOD')
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
            $UPD_USER           = $request->userid1;
	        $UPD_DATE           = date('Y-m-d H:i:s');
			
			if ($AMOUNT !== $NOMINAL_TAGIHAN)
			{
				//return back()->with('error','Payment can not less than Billing Amount !');
				return response()->json(['error' => 'The Payment Amount must be the same as the Billing Amount !']);
			};

            $data = array('ENTRYDATE' => $ENTRYDATE, 'TRANSACTIONCODE' => $TRANSACTIONCODE, 'AMOUNT' => $AMOUNT, 'PAYMENTCODE' => $PAYMENTCODE, 'INFO' => $INFO, 'RECEIPTNO' => $RECEIPTNO, 'SETTLEMENT_STATUS' => $SETTLEMENT_STATUS, 'UPD_USER' => $UPD_USER, 'UPD_DATE' => $UPD_DATE);

		    Mod_PaymentPrepaid::updateData($editid, $data);
			
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

		    Mod_PaymentPrepaid::updateData($editid, $data);
			
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
            DB::table('trans_prepaid')->where('trans_prepaid.TR_ID',$id)->delete();    
            
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
