<?php
namespace App\Http\Controllers;

use App\Models\Mod_Company;
use App\Models\M_MGCustomer;
use App\Models\Mod_ProductsApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;

class M_Trial extends Controller
{
    public function index(Request $request)
    {
		if(Session::get('userid'))
		{
			//jika memang session sudah terdaftar
			$username = Session::get('username');

			$sales  = DB::table('salesagent')
						->where('STATUS', 1)
						->select('SALESAGENTCODE','SALESAGENTNAME')
						->orderBy('SALESAGENTCODE','ASC')
						->get();

			$customer = DB::table('billing_ats.customer')
						->where('STATUSCODE', 'A')
						->where('PRODUCTID', 17)
						->select('CUSTOMERNO', 'CUSTOMERNAME')
						->orderBy('CUSTOMERNO','DESC')
						->get();

			if ($request->ajax()) 
			{
                dataTableGeneralSearch($request, function($search) {
                    return [
                        'filter' => [
                            'general_search' => $search
                        ]
                    ];
                });

				$data = QueryBuilder::for(Mod_Company::class)
						->where('master_company.fapi', 1)
						->whereIn('master_company.active', [0, 2])
						->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company.SALESAGENTCODE')	
						//->join('master_product_api_customer', 'master_product_api_customer.customerno', '=', 'master_company.customerno')
						->select('master_company.id','master_company.customerno','company_name','SALESAGENTNAME','activation_date','notes',DB::raw('(master_company.active) as factive'),DB::raw('(CASE WHEN master_company.active = 1 THEN "Active" WHEN master_company.active = 2 THEN "Trial" ELSE "Terminated" END) as active'))
						->distinct()
						->orderBy('master_company.id','DESC')
						->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 10))
						->appends(request()->query());

                return response()->paginator($data);
			}
			
			return view('home.master_trial.index', compact('sales','customer'));
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

	public function view_data($id)
	{
		if(Session::get('userid'))
		{
			$pieces = explode(";", $id);
			$pid = $pieces[0];
			$fid = $pieces[1];
		
			//dd("Dashboard");
			$data = QueryBuilder::for(Mod_Company::class)
					->where('master_company.parentid', $pid)
					->where('master_company.fapi', 1)
					->where('master_company.active', 2)
					->join('billing_ats.customer_parent', 'billing_ats.customer_parent.ID', '=', 'master_company.parentid')
					->join('master_paket_non_paket_customer', 'master_paket_non_paket_customer.customerno', '=', 'master_company.customerno')	
					->leftJoin('master_user_appglobal', 'master_user_appglobal.parentid', '=', 'master_company.parentid')
					//->leftJoin('master_ftp', 'master_ftp.companyid', '=', 'master_company.id')
					->select(DB::raw('billing_ats.customer_parent.ID as id'),'billing_ats.customer_parent.PARENT_CUSTOMER','fftp',DB::raw('CONCAT(billing_ats.customer_parent.ID,";",master_company.fftp) as idx'),DB::raw('(CASE WHEN fftp = 0 THEN "Dashboard" WHEN fftp = 1 THEN "SFTP / FTP" WHEN fftp = 2 THEN "Email" ELSE "Google Drive" END) as fftpdesc'),'master_company.apptypeid',DB::raw('(CASE WHEN master_company.apptypeid = 1 AND fftp = 0 THEN "Dashboard - Datawhiz Lite" WHEN master_company.apptypeid = 2 AND fftp = 0 THEN "Dashboard - Datawhiz Pro" WHEN master_company.apptypeid = 2 AND fftp = 1 THEN "SFTP / FTP - Datawhiz Pro" WHEN master_company.apptypeid = 3 AND fftp = 0 THEN "Dashboard - Combined" END) as apptype'), 'fcompleted', DB::raw('(CASE WHEN fcompleted = 1 THEN "Completed" WHEN fcompleted = 0 THEN "Not Completed" END) as fcomplete'), 'master_user_appglobal.fsync', DB::raw('(CASE WHEN fsync = 0 THEN "No need for synchronization" WHEN fsync = 1 THEN "Synchronized" WHEN fsync = 2 THEN "Not yet Synchronized" ELSE "No need for synchronization" END) as fsyncdesc'),'username','full_name','divisi_name','folder')
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

	public function view_cust($id)
    {
        if(Session::get('userid'))
        {
			$data = DB::table('master_company')
					->where('master_company.id', $id)
					->where('master_company.fapi', 1)
					->where('master_company.active', 2)
					->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company.SALESAGENTCODE')	
					->select('master_company.id','master_company.customerno','company_name','address','address2','address3','address4','address5','zipcode','address_npwp','phone_fax','email_pic','email_billing','npwpno','npwpname','master_company.SALESAGENTCODE','SALESAGENTNAME','activation_date','notes',DB::raw('(master_company.active) as factive'), DB::raw('(CASE WHEN master_company.active = 1 THEN "Active" WHEN master_company.active = 2 THEN "Trial" ELSE "Inactive" END) as active'))
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

			return redirect('http://192.168.100.115/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
    }

	public function view_services($id)
    {
        if(Session::get('userid'))
        {
			$data = DB::table('master_product_api_customer')
					->where('master_product_api_customer.customerno', $id)
					->where('master_company.fapi', 1)
					->where('master_company.active', 2)
					->join('master_product_api', 'master_product_api.id', '=', 'master_product_api_customer.product_api_id')	
					->join('master_company', 'master_company.customerno', '=', 'master_product_api_customer.customerno')	
					->select('master_product_api_customer.customerno','master_company.company_name','master_product_api_customer.product_api_id','master_product_api.product',DB::raw('(master_company.active) as factive'),DB::raw('(CASE WHEN master_company.active = 1 THEN "Active" WHEN master_company.active = 2 THEN "Trial" ELSE "Inactive" END) as active'),'master_product_api_customer.rates','master_product_api_customer.quota','master_product_api_customer.start_trial','master_product_api_customer.end_trial')
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

			return redirect('http://192.168.100.115/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
    }


}