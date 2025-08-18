<?php
namespace App\Http\Controllers;

use App\Models\Mod_Company;
use App\Models\Mod_Senderno;
use App\Models\MasterAccount;
use App\Models\Mod_User;
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

class M_Company extends Controller
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
						//->where('active', 1)
						->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company.SALESAGENTCODE')	
						->join('master_paket_customer', 'master_paket_customer.customerno', '=', 'master_company.customerno')
						//->join('master_product_paket', 'master_product_paket.id', '=', 'master_paket_customer.product_paket_id') 
						->select('master_company.id','master_company.customerno','company_name','SALESAGENTNAME', DB::raw('(active) as factive'), DB::raw('(CASE WHEN product_paket_id < 5 THEN (SELECT product FROM master_product_paket WHERE master_product_paket.id = product_paket_id) ELSE (SELECT nama_paket FROM master_paket WHERE master_paket.id = product_paket_id) END) as paket'), DB::raw('(CASE WHEN active = 1 THEN "Live" WHEN active = 2 THEN "Trial" ELSE "Not Actived" END) as active'), 'fcompleted', DB::raw('(CASE WHEN fcompleted = 1 THEN "Completed" ELSE "Not Completed" END) as fcomplete'), 'fftp', DB::raw('(CASE WHEN fftp = 0 THEN "Dashboard" WHEN fftp = 1 THEN "SFTP / FTP" WHEN fftp = 2 THEN "Email" WHEN fftp = 3 THEN "Google Drive" END) as fftpdesc'))
						->orderBy('master_company.id','DESC')
						->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 10))
						->appends(request()->query());

                return response()->paginator($data);
			}
			
			return view('home.master_company.company', compact('sales','customer'));
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
 
    public function autocompleteSearch(Request $request)
    {
        $query = $request->get('query');
		  
        $filterResult = DB::table('billing_ats.customer')->where('STATUSCODE', 'A')->whereIn('PRODUCTID', [17])->where('CUSTOMERNAME', 'LIKE', '%'.$query.'%')->select('CUSTOMERNAME')->get();
		//dd($data);

        $data = array();

        foreach ($filterResult as $hsl)
        {
            $data[] = $hsl->CUSTOMERNAME;
        }

        return response()->json($data);
    } 
	
	public function autocompleteLokalAllSearch(Request $request)
	{
        $query = $request->get('query');
		
		$data = DB::table('master_company_api')->where('apptypeid', '=', 1)->where('company_name', 'LIKE', '%'.$query.'%')->orWhere('customerno', 'LIKE', '%'.$query.'%')->select('customerno', 'company_name')
		->distinct();
		
        $filterResult = DB::table('master_company')->where('invtypeid', '=', 2)->where('company_name', 'LIKE', '%'.$query.'%')->orWhere('customerno', 'LIKE', '%'.$query.'%')->select('customerno', 'company_name')
		->distinct()
		->union($data)
		->get();
		//dd($data);

        $data = array();

        foreach ($filterResult as $hsl)
        {
			$data[] = $hsl->customerno;
            $data[] = $hsl->company_name;
        }

        return response()->json($data);
	}
	
    public function autocompleteLokalSearch(Request $request)
    {
        $query = $request->get('query');
		  
        $filterResult = DB::table('master_company')->where('invtypeid', '=', 2)->where('company_name', 'LIKE', '%'.$query.'%')->orWhere('customerno', 'LIKE', '%'.$query.'%')->select('customerno', 'company_name')->get();
		//dd($data);

        $data = array();

        foreach ($filterResult as $hsl)
        {
			$data[] = $hsl->customerno;
            $data[] = $hsl->company_name;
        }

        return response()->json($data);
    } 
	
    public function autocompletePeriodSearch(Request $request)
    {
        $query = $request->get('query');
		  
        $filterResult = DB::table('master_company')->where('invtypeid', '=', 1)->where('company_name', 'LIKE', '%'.$query.'%')->orWhere('customerno', 'LIKE', '%'.$query.'%')->select('customerno', 'company_name')->get();
		//dd($data);

        $data = array();

        foreach ($filterResult as $hsl)
        {
			$data[] = $hsl->customerno;
            $data[] = $hsl->company_name;
        }

        return response()->json($data);
    } 
	
	public function cariCustomer(Request $request, $id)
	{
		$data = DB::table('billing_ats.customer')
				->where('STATUSCODE', 'A')
				->whereIn('PRODUCTID', [17])
				->where('CUSTOMERNAME', 'LIKE', '%'.$id.'%')
				->select('CUSTOMERNO','CUSTOMERNAME','ACTIVATIONDATE','EMAIL','SALESAGENTCODE','DISCOUNT','NPWP','COMPANYNAME','NPWPADDRESS', 'BILLINGADDRESS1','BILLINGADDRESS2','BILLINGADDRESS3','BILLINGADDRESS4','BILLINGADDRESS5','ZIPCODE','ATTENTION',DB::raw('CASE WHEN PHONE1 IS NULL OR PHONE1 = "" THEN "-" ELSE CASE WHEN PHONE2 IS NULL OR PHONE2 = "" THEN PHONE1 ELSE CONCAT(PHONE1,"/",PHONE2) END END as PHONE'))
				->first();
		//dd($data);
		
		return response()->json($data);
	}
	
	public function cariLokalAllCustomer(Request $request, $id)
	{
		$data2 = DB::table('master_company_api')
                ->where('customerno', $id)
				->orWhere('company_name', $id)
				->select('parentid','master_company_api.id AS companyid','customerno','company_name','fftp','apptypeid','billingtype')
				->distinct();
				
		$data1 = DB::table('master_company')
                ->where('customerno', $id)
				->orWhere('company_name', $id)
				->select('parentid','master_company.id AS companyid','customerno','company_name','fftp','apptypeid',DB::raw('"0" as billingtype'))
				->distinct()
				->union($data2)
				->first();
		//dd($data);
		
		return response()->json($data1);
	}
	
	public function cariLokalCustomer(Request $request, $id)
	{
		$data = DB::table('master_company')
                ->where('customerno', $id)
				->orWhere('company_name', $id)
				->select('master_company.id AS companyid','customerno','company_name','fftp','apptypeid')
				->first();
		//dd($data);
		
		return response()->json($data);
	}
	
	public function getcompany(Request $request)
	{
        $companyid = $request->cpy_name;

        $data = DB::table('billing_ats.customer')
					->where('STATUSCODE', 'A')
					->whereIn('PRODUCTID', [17])
					->select('CUSTOMERNO', 'CUSTOMERNAME', 'SALESAGENTCODE', 'BILLINGADDRESS1', 'BILLINGADDRESS2', 'BILLINGADDRESS3', 'BILLINGADDRESS4', 'BILLINGADDRESS5', 'ZIPCODE', 'PHONE1', 'COMPANYNAME', 'NPWP', 'NPWPADDRESS', 'EMAIL')
					->orderBy('CUSTOMERNO','DESC')
					->get();

		return response()->json($data);
        //echo json_encode($data);
    }
	
	public function view_cust($id)
    {
        if(Session::get('userid'))
        {
			$datas	= DB::table('master_company')->where('id', $id)->where('fftp', 1)->first();
			
			if(!empty($datas) || $datas != null)
			{
				$data = DB::table('master_company')
						->where('master_company.id', $id)
						->where('master_company.active', 1)
						->where('fftp', 1)
						->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company.SALESAGENTCODE')	
						->join('master_paket_customer', 'master_paket_customer.customerno', '=', 'master_company.customerno')
						//->join('master_product_paket', 'master_product_paket.id', '=', 'master_paket_customer.product_paket_id') 
						->leftJoin('master_ftp', 'master_ftp.companyid', '=', 'master_company.id')	
						->select('master_company.id','master_company.customerno','company_name','address','address2','address3','address4','address5','zipcode','address_npwp','phone_fax','email_pic','email_billing','npwpno','npwpname','master_company.SALESAGENTCODE','SALESAGENTNAME','activation_date','notes',DB::raw('(master_company.active) as factive'), DB::raw('(CASE WHEN master_company.active = 1 THEN "Active" ELSE "Inactive" END) as active'), 'master_paket_customer.product_paket_id', DB::raw('(CASE WHEN product_paket_id < 5 THEN (SELECT product FROM master_product_paket WHERE master_product_paket.id = product_paket_id) ELSE (SELECT nama_paket FROM master_paket WHERE master_paket.id = product_paket_id) END) as paket'), 'master_company.invtypeid', DB::raw('(CASE WHEN master_company.invtypeid = 1 THEN "Invoice Periodic" WHEN master_company.invtypeid = 2 THEN "Invoice Monthly" END) as invtype'), 'master_company.fcompleted', DB::raw('(CASE WHEN master_company.fcompleted = 1 THEN "Completed" ELSE "Not Completed" END) as fcomplete'), 'fftp', DB::raw('(CASE WHEN fftp = 0 THEN "Dashboard" WHEN fftp = 1 THEN "SFTP / FTP" WHEN fftp = 2 THEN "Email" WHEN fftp = 3 THEN "Google Drive" END) as fftpdesc'), 'ip_ftp', 'username', 'passwd', 'jam_awal_download', 'jam_akhir_download', 'folder_download', 'jam_awal_upload', 'jam_akhir_upload', 'folder_upload' , 'pic_email', 'protocol', 'port', 'folderlokal')
						->first();

				return response()->json($data);
			}
			else
			{
				$data = DB::table('master_company')
						->where('master_company.id', $id)
						->where('master_company.active', 1)
						->where('fftp', '!=', 1)
						->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company.SALESAGENTCODE')	
						->join('master_paket_customer', 'master_paket_customer.customerno', '=', 'master_company.customerno')
						->leftJoin('master_user_appglobal', 'master_user_appglobal.parentid', '=', 'master_company.parentid')	
						->leftJoin('master_ftp', 'master_ftp.companyid', '=', 'master_company.id')	
						->select('master_company.id','master_company.customerno','company_name','address','address2','address3','address4','address5','zipcode','address_npwp','phone_fax','email_pic','email_billing','npwpno','npwpname','master_company.SALESAGENTCODE','SALESAGENTNAME','activation_date','notes',DB::raw('(master_company.active) as factive'), DB::raw('(CASE WHEN master_company.active = 1 THEN "Active" ELSE "Inactive" END) as active'), 'master_paket_customer.product_paket_id', DB::raw('(CASE WHEN product_paket_id < 5 THEN (SELECT product FROM master_product_paket WHERE master_product_paket.id = product_paket_id) ELSE (SELECT nama_paket FROM master_paket WHERE master_paket.id = product_paket_id) END) as paket'), 'master_company.invtypeid', DB::raw('(CASE WHEN master_company.invtypeid = 1 THEN "Invoice Periodic" WHEN master_company.invtypeid = 2 THEN "Invoice Monthly" END) as invtype'), 'master_company.fcompleted', DB::raw('(CASE WHEN master_company.fcompleted = 1 THEN "Completed" ELSE "Not Completed" END) as fcomplete'), 'fftp', DB::raw('(CASE WHEN fftp = 0 THEN "Dashboard" WHEN fftp = 1 THEN "SFTP / FTP" WHEN fftp = 2 THEN "Email" WHEN fftp = 3 THEN "Google Drive" END) as fftpdesc'), 'master_user_appglobal.username', 'master_user_appglobal.password', 'master_user_appglobal.passwd', 'master_user_appglobal.full_name', 'master_user_appglobal.divisi_name', DB::raw('(CASE WHEN master_user_appglobal.active = 1 THEN "Active" ELSE "Inactive" END) as factivenonftp'), 'master_user_appglobal.folder')
						->first();

				return response()->json($data);
			}
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

	public function view_ftp($id)
    {
        if(Session::get('userid'))
        {
			//id,company_id,username,password,passwd,full_name,divisi_name,group_id,active,createdby,createddate,updby,upddate,folder
			
			$data = DB::table('master_company')
					->where('master_company.id', $id)
					->where('master_company.active', 1)
					->leftJoin('master_user_appglobal', 'master_user_appglobal.company_id', '=', 'master_company.id')	
					->select('master_company.id','master_company.customerno','company_name', DB::raw('(CASE WHEN fftp = 0 THEN "Dashboard" WHEN fftp = 1 THEN "SFTP / FTP" WHEN fftp = 2 THEN "Email" WHEN fftp = 3 THEN "Google Drive" END) as fftpdesc'), 'username', 'password', 'passwd', 'full_name', 'divisi_name', DB::raw('(master_user_appglobal.active) as factive'), 'folder')
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
