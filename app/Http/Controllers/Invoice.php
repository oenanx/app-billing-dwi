<?php

namespace App\Http\Controllers;

use App\Models\Mod_Invoice;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class Invoice extends Controller
{
    public function index(Request $request)
    {
        if(Session::get('userid'))
        {
            $data1['tgl'] = DB::select('SELECT BL_CODE,BL_DESC FROM sys_month WHERE BL_CODE = (SELECT DATE_FORMAT(CURDATE(),"%m"));');
            $data1['thn'] = DB::select('SELECT DATE_FORMAT(CURDATE(), "%Y") AS TAHUN;');
			$data1['period'] = DB::select('SELECT DISTINCT PERIOD FROM bs ORDER BY PERIOD DESC;');

            return view('home.invoice.index')->with($data1);
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
	
    public function datatable(Request $request)
    {
        if(Session::get('userid'))
        {
			if ($request->ajax()) 
			{
                dataTableGeneralSearch($request, function($search) {
                    return [
                        'filter' => [
                            'general_search' => $search
                        ]
                    ];
                });

				$data = QueryBuilder::for(Mod_Invoice::class)
						->where('master_company.active',1)
						->where('master_company.invtypeid', 2)
						->join('master_company', 'master_company.customerno', '=', 'invoice_file.customerno')
						->select('invoice_file.id','master_company.customerno', 'master_company.company_name', 'bsno', 'period', DB::raw('file_name as filename'), 'path')
						->orderBy('invoice_file.period','DESC')
						->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 10))
						->appends(request()->query());

                return response()->paginator($data);
			}

			return view('home.invoice.index');
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

	public function download($id)
	{
		//dd($id);
		$datas = DB::table('invoice_file')
				->where('id', $id)
				->select('path','file_name')
				->get();

		foreach ($datas as $user)
		{
			$url_media 		= $user->path;
			$file_names		= $user->file_name;
			
			$paths = 'public/invoice/';
			if(Storage::exists($paths.$file_names))
			{
				return Storage::download($paths.$file_names);
			}
			else
			{
				echo "<script>window.close();</script>";
			}
		}
	}

    public function delete(Request $request, $id)
    {
        if(Session::get('userid'))
        {
			$datas = DB::table('invoice_file')
					->where('id', $id)
					->select('path','file_name')
					->get();

			foreach ($datas as $user)
			{
				//$url_media 		= $user->path;
				$file_names		= $user->file_name;
			}
			
			$paths = 'public/invoice/';
			
			Storage::delete($paths.$file_names);
			
            DB::table('invoice_file')->where('invoice_file.id',$id)->delete();    
            
            return back()
                    ->with('success','This Invoice have been deleted successfully.');
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

	/*
	public function addInv(Request $request, $id)
	{	
		$response = Http::delete('http://192.168.100.114/api-robo/public/index.php/delbs/'.$id);
						
		$response = Http::delete('http://192.168.100.114/api-robo/public/index.php/delbsd/'.$id);
		
		$bsno	= DB::table('bs')
				  ->where('PERIOD', $id)
				  ->select('ID','BSNO','PERIOD','CUSTOMERNO','STATUS','MANAGE_SERVICE_PRICE','NUMBER_PRICE','CONCURRENT_PRICE','STORAGE_PRICE','USAGEADJUSTMENT','DISCOUNTTYPE','TOTALDISCOUNT','TOTALVAT','PREVIOUSBALANCE','BALANCEADJUSTMENT','PREVIOUSPAYMENT','DUEDATE','NEWSTATEMENTDATE','LASTSTATEMENTDATE','PAYMENTDATEVAT','TOTALAMOUNT','PENALTY','TOTALUSAGE','TOTALMATERAI')
				  ->get();
		
		foreach ($bsno as $bs)
		{
			$ID 					= $bs->ID;
			$BSNO					= $bs->BSNO;
			$PERIOD					= $bs->PERIOD;
			$CUSTOMERNO				= $bs->CUSTOMERNO;
			$MANAGE_SERVICE_PRICE	= $bs->MANAGE_SERVICE_PRICE;
			$NUMBER_PRICE	 		= $bs->NUMBER_PRICE;
			$CONCURRENT_PRICE		= $bs->CONCURRENT_PRICE;
			$STORAGE_PRICE	 		= $bs->STORAGE_PRICE;
			$USAGEADJUSTMENT		= $bs->USAGEADJUSTMENT;
			$DISCOUNTTYPE			= $bs->DISCOUNTTYPE;
			$TOTALDISCOUNT	 		= $bs->TOTALDISCOUNT;
			$TOTALVAT				= $bs->TOTALVAT;
			$PREVIOUSBALANCE		= $bs->PREVIOUSBALANCE;
			$BALANCEADJUSTMENT 		= $bs->BALANCEADJUSTMENT;
			$PREVIOUSPAYMENT		= $bs->PREVIOUSPAYMENT;
			$DUEDATE		 		= $bs->DUEDATE;
			$NEWSTATEMENTDATE		= $bs->NEWSTATEMENTDATE;
			$LASTSTATEMENTDATE		= $bs->LASTSTATEMENTDATE;
			$PAYMENTDATEVAT	 		= $bs->PAYMENTDATEVAT;
			$TOTALAMOUNT	 		= $bs->TOTALAMOUNT;
			$PENALTY				= $bs->PENALTY;
			$TOTALUSAGE				= $bs->TOTALUSAGE;
			$TOTALMATERAI	 		= $bs->TOTALMATERAI;
			
			$databs = [
					'ID'					=> $ID,
					'BSNO'					=> $BSNO,
					'PERIOD'				=> $PERIOD,
					'CUSTOMERNO'			=> $CUSTOMERNO,
					'MANAGE_SERVICE_PRICE'	=> $MANAGE_SERVICE_PRICE,
					'NUMBER_PRICE'			=> $NUMBER_PRICE,
					'CONCURRENT_PRICE'		=> $CONCURRENT_PRICE,
					'STORAGE_PRICE'			=> $STORAGE_PRICE,
					'USAGEADJUSTMENT'		=> $USAGEADJUSTMENT,
					'DISCOUNTTYPE'			=> $DISCOUNTTYPE,
					'TOTALDISCOUNT'			=> $TOTALDISCOUNT,
					'TOTALVAT'				=> $TOTALVAT,
					'PREVIOUSBALANCE'		=> $PREVIOUSBALANCE,
					'BALANCEADJUSTMENT'		=> $BALANCEADJUSTMENT,
					'PREVIOUSPAYMENT'		=> $PREVIOUSPAYMENT,
					'DUEDATE'				=> $DUEDATE,
					'NEWSTATEMENTDATE'		=> $NEWSTATEMENTDATE,
					'LASTSTATEMENTDATE'		=> $LASTSTATEMENTDATE,
					'PAYMENTDATEVAT'		=> $PAYMENTDATEVAT,
					'TOTALAMOUNT'			=> $TOTALAMOUNT,
					'PENALTY'				=> $PENALTY,
					'TOTALUSAGE'			=> $TOTALUSAGE,
					'TOTALMATERAI'			=> $TOTALMATERAI,
			];

			$data['bs'] = $databs;
			
			$response = Http::post('http://192.168.100.114/api-robo/public/index.php/addbs',$data);
		}
		

		$bsdet	= DB::table('bs_detail')
				  ->where('PERIOD', $id)
				  ->select('BD_ID','PERIOD','CUSTOMERNO','DESCRIPTION','PERIOD_SERVICE','AMOUNT','PRSS_ID')
				  ->get();
		
		foreach ($bsdet as $bsd)
		{
			$BD_ID			= $bsd->BD_ID;
			$PERIOD			= $bsd->PERIOD;
			$CUSTOMERNO		= $bsd->CUSTOMERNO;
			$DESCRIPTION	= $bsd->DESCRIPTION;
			$PERIOD_SERVICE	= $bsd->PERIOD_SERVICE;
			$AMOUNT			= $bsd->AMOUNT;
			$PRSS_ID		= $bsd->PRSS_ID;
			
			$databsd = [
					'BD_ID'				=> $BD_ID,
					'PERIOD'			=> $PERIOD,
					'CUSTOMERNO'		=> $CUSTOMERNO,
					'DESCRIPTION'		=> $DESCRIPTION,
					'PERIOD_SERVICE'	=> $PERIOD_SERVICE,
					'AMOUNT'			=> $AMOUNT,
					'PRSS_ID'			=> $PRSS_ID,
			];

			$data['bsd'] = $databsd;
			
			$response = Http::post('http://192.168.100.114/api-robo/public/index.php/addbsdetail',$data);
		}
		
		return response()->json(['success'=>'Upload data to Apps successfully.']);
	}
	*/
}
