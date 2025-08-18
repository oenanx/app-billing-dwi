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

class M_Postpaid extends Controller
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
						->where('master_company.billingtype', 2)
						->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company.SALESAGENTCODE')	
						->select('master_company.id','master_company.customerno','company_name','address','address2','address3','address4','address5','zipcode','address_npwp','phone_fax','email_pic','email_billing','npwpno','npwpname','master_company.SALESAGENTCODE','SALESAGENTNAME','activation_date','notes',DB::raw('(master_company.active) as factive'), DB::raw('(CASE WHEN master_company.active = 1 THEN "Active" ELSE "Inactive" END) as active'),DB::raw('(CASE WHEN master_company.billingtype = 2 THEN "Postpaid" END) as billingtype'))
						->orderBy('master_company.id','DESC')
						->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 10))
						->appends(request()->query());

                return response()->paginator($data);
			}
			
			return view('home.master_postpaid.index', compact('sales','customer'));
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

	public function datatable_rates(Request $request, $id)
	{
		//$customer = Mod_Company::query()->where('master_company.fapi', 1)->where('fftp', 0)->where('id', $id)->first();
		//$customerno = $customer->customerno;
		//dd($customerno);

		if ($request->ajax()) 
		{
			$data = QueryBuilder::for(Mod_ProductsApi::class)
					->where('master_product_api_customer.customerno', $id)
					->where('master_company.billingtype', 2)
					->where('master_company.fapi', 1)
					->join('master_product_api', 'master_product_api.id', '=', 'master_product_api_customer.product_api_id')
					->join('master_company', 'master_company.customerno', '=', 'master_product_api_customer.customerno')
					->select('master_product_api_customer.id','company_name','master_product_api_customer.customerno','master_product_api_customer.product_api_id','master_product_api.product','rates')
					->orderBy('master_product_api_customer.id','ASC')
					->allowedFilters(
						AllowedFilter::scope('general_search')
					)
					->paginate($request->query('perpage', 10))
					->appends(request()->query());

			return response()->paginator($data);
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
					->whereIn('master_company.active', [1, 2])
					->where('master_company.fapi', 1)
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
					->where('master_company.customerno', $id)
					->where('master_company.billingtype', 2)
					->where('master_company.fapi', 1)
					->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company.SALESAGENTCODE')	
					->join('master_product_api_customer', 'master_product_api_customer.customerno', '=', 'master_company.customerno')
					->join('master_product_api', 'master_product_api.id', '=', 'master_product_api_customer.product_api_id') 
					->select('master_company.id','master_company.customerno','company_name','address','address2','address3','address4','address5','zipcode','address_npwp','phone_fax','email_pic','email_billing','npwpno','npwpname','master_company.SALESAGENTCODE','SALESAGENTNAME','activation_date','notes',DB::raw('(master_company.active) as factive'),DB::raw('(CASE WHEN master_company.active = 1 THEN "Active" ELSE "Inactive" END) as active'),'master_product_api_customer.product_api_id','master_product_api.product','invtypeid',DB::raw('CASE WHEN invtypeid = 2 THEN "Invoice Monthly" ELSE "Invoice Periodic" END AS invtype'))
					->first();
			dd($data);
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
	
	public function view_rates($id)
    {
        if(Session::get('userid'))
		{
			$data = DB::table('master_product_api_customer')
					->where('master_company.customerno', $id)
					->where('master_company.billingtype', 2)
					->where('master_company.fapi', 1)
					->join('master_product_api', 'master_product_api.id', '=', 'master_product_api_customer.product_api_id')
					->join('master_company', 'master_company.customerno', '=', 'master_product_api_customer.customerno')
					->select('master_company.id','master_product_api_customer.customerno','company_name',DB::raw('CASE WHEN billingtype = 1 THEN "Prepaid" ELSE "PostPaid" END AS billingtype'),DB::raw('MAX( case when product_api_id = "1" THEN 1 END) AS pid1'),DB::raw('MAX( case when product_api_id = "2" THEN 2 END) AS pid2'),DB::raw('MAX( case when product_api_id = "3" THEN 3 END) AS pid3'),DB::raw('MAX( case when product_api_id = "1" THEN "Validation API" END) AS product1'),DB::raw('MAX( case when product_api_id = "2" THEN "Skiptrace API" END) AS product2'),DB::raw('MAX( case when product_api_id = "3" THEN "Id. Match API" END) AS product3'),DB::raw('MAX( case when product_api_id = "1" THEN rates ELSE 0 END) AS rates1'),DB::raw('MAX( case when product_api_id = "2" THEN rates ELSE 0 END) AS rates2'),DB::raw('MAX( case when product_api_id = "3" THEN rates ELSE 0 END) AS rates3'),'master_company.active')
					->groupBy('master_company.id','master_product_api_customer.customerno','company_name','billingtype','active')
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