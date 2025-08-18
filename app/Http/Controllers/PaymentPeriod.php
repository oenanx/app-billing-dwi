<?php

namespace App\Http\Controllers;

use App\Models\Mod_PaymentPeriod;
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

class PaymentPeriod extends Controller
{
    public function index(Request $request)
    {
		if(Session::get('userid'))
		{
			//jika memang session sudah terdaftar
			$username = Session::get('username');

			$paymentmethod  = DB::select('SELECT PAYMENTCODE,PAYMENTMETHOD FROM paymentmethod ORDER BY PAYMENTCODE;');

			return view('home.paymentperiod.index', compact('paymentmethod'));
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

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}
	
    public function searching(Request $request, $period)
    {
        //dd($period);
        $pieces = explode(";", $period);
        $start = $pieces[0];
        $end = $pieces[1];
        //dd($end);

        if ($request->ajax()) 
        {
            $data = DB::table('trans')
                    ->whereBetween(DB::raw('DATE_FORMAT(ENTRYDATE,"%Y-%m-%d")'), [$start, $end])
					->where('invtypeid', 1)
                    ->join('master_company', 'master_company.CUSTOMERNO', '=', 'trans.CUSTOMERNO')
                    ->join('paymentmethod', 'paymentmethod.PAYMENTCODE', '=', 'trans.PAYMENTCODE')
                    ->select('TR_ID', DB::raw('trans.CUSTOMERNO AS CustomerId'), DB::raw('master_company.company_name AS CustomerName'), DB::raw('DATE_FORMAT(TRANSACTIONDATE,"%Y-%m-%d") AS PaymentDate'), DB::raw('DATE_FORMAT(ENTRYDATE,"%Y-%m-%d") AS EntryDate'), DB::raw('paymentmethod.PAYMENTMETHOD AS PaymentMethod'), DB::raw('CASE WHEN TRANSACTIONCODE = "P" THEN "PAYMENT" WHEN TRANSACTIONCODE = "B" THEN "BALANCED ADJUSTMENT" WHEN TRANSACTIONCODE = "D" THEN "DISCOUNT" WHEN TRANSACTIONCODE = "U" THEN "USAGE ADJUSTMENT" WHEN TRANSACTIONCODE = "R" THEN "REFUND" END AS TransactionType'), DB::raw('CONCAT("Rp. ",FORMAT(AMOUNT,0)) AS Payment'), DB::raw('INFO AS AdditionalInfo'))
                    ->orderBy('trans.ENTRYDATE','DESC')
                    ->paginate($request->query('perpage', 10))
					->appends(request()->query());
					
			return response()->paginator($data);
        }
    }
    
    public function insert(Request $request)
    {
        if(Session::get('userid'))
        {
            //TR_ID,ENTRYDATE,TRANSACTIONDATE,TRANSACTIONCODE,CUSTOMERNO,AMOUNT,PAYMENTCODE,INFO,RECEIPTNO,CRT_USER,CRT_DATE,UPD_USER,UPD_DATE,SETTLEMENT_STATUS

            $ENTRYDATE          = date('Y-m-d');
            $TRANSACTIONDATE    = $request->paydate;
	        $TRANSACTIONCODE    = $request->transtype;
            $CUSTOMERNO         = $request->custno;
            $AMOUNT             = floatval(str_replace('.', ',', str_replace(',', '', $request->payment))); //$request->payment;

            $PAYMENTCODE        = $request->paymentcode;
	        $INFO               = $request->keterangan;
	        $RECEIPTNO          = $request->receipt;

            $CRT_USER           = $request->userid;
	        $CRT_DATE           = date('Y-m-d H:i:s');
            
            DB::table('trans')->insert(
                [
                    'ENTRYDATE'         => $ENTRYDATE,
                    'TRANSACTIONDATE'   => $TRANSACTIONDATE,
                    'TRANSACTIONCODE'   => $TRANSACTIONCODE,
                    'CUSTOMERNO'        => $CUSTOMERNO,
                    'AMOUNT'            => $AMOUNT,
                    'PAYMENTCODE'       => $PAYMENTCODE,
                    'INFO'              => $INFO,
                    'RECEIPTNO'         => $RECEIPTNO,
                    'CRT_USER'          => $CRT_USER,
                    'CRT_DATE'          => $CRT_DATE
                ]
            );

	        return back()
	            ->with('success','You have successfully Inserted a new Payment.');
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

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
    }

    public function view(Request $request, $id)
    {
        if(Session::get('userid'))
        {
            $data = DB::table('trans')
                    ->where('trans.TR_ID', $id)
                    ->join('master_company', 'master_company.CUSTOMERNO', '=', 'trans.CUSTOMERNO')
                    ->join('paymentmethod', 'paymentmethod.PAYMENTCODE', '=', 'trans.PAYMENTCODE')
                    ->select('TR_ID', DB::raw('trans.CUSTOMERNO AS CustomerId'), DB::raw('master_company.company_name AS CustomerName'), DB::raw('DATE_FORMAT(TRANSACTIONDATE,"%Y-%m-%d") AS PaymentDate'), DB::raw('DATE_FORMAT(ENTRYDATE,"%Y-%m-%d") AS EntryDate'), 'trans.PAYMENTCODE', DB::raw('paymentmethod.PAYMENTMETHOD AS PaymentMethod'), DB::raw('CASE WHEN TRANSACTIONCODE = "P" THEN "PAYMENT" WHEN TRANSACTIONCODE = "B" THEN "BALANCED ADJUSTMENT" WHEN TRANSACTIONCODE = "D" THEN "DISCOUNT" WHEN TRANSACTIONCODE = "U" THEN "USAGE ADJUSTMENT" WHEN TRANSACTIONCODE = "R" THEN "REFUND" END AS TransactionType'), DB::raw('TRANSACTIONCODE AS TransactionTypes'), 'trans.AMOUNT', DB::raw('FORMAT(AMOUNT,0) AS Payment'), DB::raw('INFO AS AdditionalInfo'),'trans.RECEIPTNO')
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
            $TRANSACTIONDATE    = $request->paydate2;
            $TRANSACTIONCODE    = $request->transtype2;
	        $CUSTOMERNO         = $request->cno2;
	        $AMOUNT             = floatval(str_replace('.', ',', str_replace(',', '', $request->payment2))); //$request->payment2;
	        $PAYMENTCODE        = $request->paymentcode2;
	        $INFO               = $request->keterangan2;
	        $RECEIPTNO          = $request->receipt2;

            $UPD_USER           = $request->userid2;
	        $UPD_DATE           = date('Y-m-d H:i:s');

            $data = array('TRANSACTIONDATE' => $TRANSACTIONDATE, 'TRANSACTIONCODE' => $TRANSACTIONCODE, 'CUSTOMERNO' => $CUSTOMERNO, 'AMOUNT' => $AMOUNT, 'PAYMENTCODE' => $PAYMENTCODE, 'INFO' => $INFO, 'RECEIPTNO' => $RECEIPTNO,  'UPD_USER' => $UPD_USER, 'UPD_DATE' => $UPD_DATE);

		    Mod_PaymentPeriod::updateData($editid, $data);

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

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
        }
    }

    public function delete(Request $request,  $id)
    {
        if(Session::get('userid'))
        {
            DB::table('trans')->where('trans.TR_ID',$id)->delete();    
            
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

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
        }
    }
}
