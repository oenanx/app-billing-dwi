<?php

namespace App\Http\Controllers;

use App\Models\Mod_Company;
use App\Models\Mod_ProductsApi;
use App\Models\Valid_No_Api_Trial;
use App\Models\Skiptrace_Api_Trial;
use App\Models\IdMatch_Api_Trial;
use App\Models\Demography_Api_Trial;
use App\Models\Income_Api_Trial;
use App\Models\PhoneHistory_Api_Trial;
use App\Models\Slik_Summary_Api_Trial;
use App\Models\Demography_Verification_Api_Trial;
use App\Models\Address_Verification_Api_Trial;
use App\Models\Negative_Record_Api_Trial;
use App\Models\Home_Address_Api_Trial;
use App\Models\Office_Address_Api_Trial;
use App\Models\Slik_Api_Trial;
use App\Models\Valid_No_Api_Postpaid;
use App\Models\Skiptrace_Api_Postpaid;
use App\Models\IdMatch_Api_Postpaid;
use App\Models\Demography_Api_Postpaid;
use App\Models\Income_Api_Postpaid;
use App\Models\PhoneHistory_Api_Postpaid;
use App\Models\Slik_Summary_Api_Postpaid;
use App\Models\Demography_Verification_Api_Postpaid;
use App\Models\Address_Verification_Api_Postpaid;
use App\Models\Negative_Record_Api_Postpaid;
use App\Models\Home_Address_Api_Postpaid;
use App\Models\Office_Address_Api_Postpaid;
use App\Models\Slik_Api_Postpaid;
use App\Exports\RptLogAll;
use App\Exports\RptLogTrial1;
use App\Exports\RptLogTrial2;
use App\Exports\RptLogTrial3;
use App\Exports\RptLogTrial4;
use App\Exports\RptLogTrial5;
use App\Exports\RptLogTrial6;
use App\Exports\RptLogTrial7;
use App\Exports\RptLogTrial8;
use App\Exports\RptLogTrial9;
use App\Exports\RptLogTrial10;
use App\Exports\RptLogTrial11;
use App\Exports\RptLogTrial12;
use App\Exports\RptLogTrial13;
use App\Exports\RptLogTrial14;
use App\Exports\RptLogTrial17;
use App\Exports\RptLogTrial18;
use App\Exports\RptLogTrial20;
use App\Exports\RptLogPostpaid1;
use App\Exports\RptLogPostpaid2;
use App\Exports\RptLogPostpaid3;
use App\Exports\RptLogPostpaid4;
use App\Exports\RptLogPostpaid5;
use App\Exports\RptLogPostpaid6;
use App\Exports\RptLogPostpaid7;
use App\Exports\RptLogPostpaid8;
use App\Exports\RptLogPostpaid9;
use App\Exports\RptLogPostpaid10;
use App\Exports\RptLogPostpaid11;
use App\Exports\RptLogPostpaid12;
use App\Exports\RptLogPostpaid13;
use App\Exports\RptLogPostpaid14;
use App\Exports\RptLogPostpaid17;
use App\Exports\RptLogPostpaid18;
use App\Exports\RptLogPostpaid20;
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
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;

class ViewUsageAPI extends Controller
{
    public function index(Request $request)
    {
		if(Session::get('userid'))
		{
			//jika memang session sudah terdaftar
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
						->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company.SALESAGENTCODE')	
						->join('master_product_api_customer', 'master_product_api_customer.customerno', '=', 'master_company.customerno')
						->select('master_company.id','master_company.customerno','company_name','SALESAGENTNAME',DB::raw('(CASE WHEN master_company.active = 0 THEN "Not Active" WHEN master_company.active = 1 THEN "Active" WHEN master_company.active = 2 THEN "Trial" ELSE "Terminated" END) as actives'))
						->groupBy('master_company.id', 'master_company.customerno', 'company_name', 'SALESAGENTNAME', 'master_company.active')
						->orderBy('master_company.id','DESC')
						->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 10))
						->appends(request()->query());

                return response()->paginator($data);
			}

			return view('home.reports.ViewUsageAPI.index');
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
		
	public function view_usage(Request $request, $id)
	{
        if(Session::get('userid'))
		{
			$custno 		= $id;
            $data['thn']	= DB::select('SELECT DATE_FORMAT(CURDATE(), "%Y") AS TAHUN;');
			
			$produk 		= DB::connection('mysql_4')->table('datawhiz_app.master_product_api')
								->where('fActive', 1)
								->where('master_product_api_customer.customerno', $custno)
								->join('datawhiz_app.master_product_api_customer', 'master_product_api_customer.product_api_id', '=', 'master_product_api.id')
								->select('master_product_api.id', 'product')
								->orderBy('master_product_api.id','ASC')
								->get();
			
			//return response()->json($data);
			return view('home.reports.ViewUsageAPI.viewusage', compact('custno','produk'))->with($data);
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

    public function datatableusage(Request $request, $params)
	{
        if(Session::get('userid'))
		{
			$pieces		= explode(";", $params);
			$periode	= $pieces[0];
			$product	= $pieces[1];
			$customerno	= $pieces[2];

			if ($product == 1) //Validation API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_valid_no_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('(CASE WHEN success = 1 THEN "SUCCESS" ELSE "FAILED" END) AS status_hit'),DB::raw('MAX(phone_number) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id','status_hit')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Valid_No_Api_Postpaid::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('(CASE WHEN success = 1 THEN "SUCCESS" ELSE "FAILED" END) AS status_hit'),DB::raw('MAX(phone_number) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id','status_hit')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Valid_No_Api_Trial::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('(CASE WHEN success = 1 THEN "SUCCESS" ELSE "FAILED" END) AS status_hit'),DB::raw('MAX(phone_number) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id','status_hit')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 2) //Skiptrace API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_skiptrace_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Skiptrace_Api_Postpaid::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Skiptrace_Api_Trial::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 3) //Id. Match API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_idmatch_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(IdMatch_Api_Postpaid::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(IdMatch_Api_Trial::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 4) //Reverse Skiptrace API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_reverse_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phoneno) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_reverse_postpaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phoneno) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_reverse_trial')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phoneno) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 5) //Demography API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_demography_prepaid')
								->where('ftype', 2)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Demography_Api_Postpaid::class)
								->where('ftype', 2)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Demography_Api_Trial::class)
								->where('ftype', 2)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 6) //Income Verification API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_income_prepaid')
								->where('customerno', $customerno)
								->where('price', 'PAY')
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Income_Api_Postpaid::class)
								->where('customerno', $customerno)
								->where('price', 'PAY')
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Income_Api_Trial::class)
								->where('customerno', $customerno)
								->where('price', 'PAY')
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 7) //Phone History API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$first = DB::connection('mysql_4')->table('api_phonehistory_08_prepaid')
								->where('customerno', $customerno)
								->where('product_api_id', 7)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id');
						 
						$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_prepaid')
								->where('customerno', $customerno)
								->where('product_api_id', 7)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($first);
						 
						$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_prepaid')
								->where('customerno', $customerno)
								->where('product_api_id', 7)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($secnd);
						 
						$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_prepaid')
								->where('customerno', $customerno)
								->where('product_api_id', 7)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($third)
								->orderBy('tgl_hit','DESC')
								->paginate($request->query('perpage', 100000000))
								->appends(request()->query());
						
						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$first = DB::connection('mysql_4')->table('api_phonehistory_08_postpaid')
								->where('customerno', $customerno)
								->where('product_api_id', 7)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id');
						 
						$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_postpaid')
								->where('customerno', $customerno)
								->where('product_api_id', 7)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($first);
						 
						$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_postpaid')
								->where('customerno', $customerno)
								->where('product_api_id', 7)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($secnd);
						 
						$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_postpaid')
								->where('customerno', $customerno)
								->where('product_api_id', 7)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($third)
								->orderBy('tgl_hit','DESC')
								->paginate($request->query('perpage', 100000000))
								->appends(request()->query());
						
						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$first = DB::connection('mysql_4')->table('api_phonehistory_08_trial')
								->where('customerno', $customerno)
								->where('product_api_id', 7)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id');
						 
						$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_trial')
								->where('customerno', $customerno)
								->where('product_api_id', 7)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($first);
						 
						$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_trial')
								->where('customerno', $customerno)
								->where('product_api_id', 7)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($secnd);
						 
						$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_trial')
								->where('customerno', $customerno)
								->where('product_api_id', 7)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($third)
								->orderBy('tgl_hit','DESC')
								->paginate($request->query('perpage', 100000000))
								->appends(request()->query());
						
						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 8) //SLIK Summary API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_slik_summary_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Slik_Summary_Api_Postpaid::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Slik_Summary_Api_Trial::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 9) //Id. Verification API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_demography_verification_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Demography_Verification_Api_Postpaid::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Demography_Verification_Api_Trial::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 10) //Demography Foto API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_demography_prepaid')
								->where('ftype', 1)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Demography_Api_Postpaid::class)
								->where('ftype', 1)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Demography_Api_Trial::class)
								->where('ftype', 1)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 11) //Address Verification Api
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_address_verification_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Address_Verification_Api_Postpaid::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Address_Verification_Api_Trial::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 12) //Negative Record Api
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_negative_record_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nama) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Negative_Record_Api_Postpaid::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nama) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Negative_Record_Api_Trial::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nama) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 13) //Home Address Api
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_home_address_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Home_Address_Api_Postpaid::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Home_Address_Api_Trial::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 14) //Office Address Api
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_work_address_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Office_Address_Api_Postpaid::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Office_Address_Api_Trial::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 15) //Phone History 365 API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$first = DB::connection('mysql_4')->table('api_phonehistory_08_prepaid')
								->where('customerno', $customerno)
								->where('product_api_id', 15)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id');
						 
						$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_prepaid')
								->where('customerno', $customerno)
								->where('product_api_id', 15)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($first);
						 
						$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_prepaid')
								->where('customerno', $customerno)
								->where('product_api_id', 15)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($secnd);
						 
						$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_prepaid')
								->where('customerno', $customerno)
								->where('product_api_id', 15)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($third)
								->orderBy('tgl_hit','DESC')
								->paginate($request->query('perpage', 100000000))
								->appends(request()->query());
						
						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$first = DB::connection('mysql_4')->table('api_phonehistory_08_postpaid')
								->where('customerno', $customerno)
								->where('product_api_id', 15)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id');
						 
						$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_postpaid')
								->where('customerno', $customerno)
								->where('product_api_id', 15)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($first);
						 
						$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_postpaid')
								->where('customerno', $customerno)
								->where('product_api_id', 15)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($secnd);
						 
						$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_postpaid')
								->where('customerno', $customerno)
								->where('product_api_id', 15)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($third)
								->orderBy('tgl_hit','DESC')
								->paginate($request->query('perpage', 100000000))
								->appends(request()->query());
						
						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$first = DB::connection('mysql_4')->table('api_phonehistory_08_trial')
								->where('customerno', $customerno)
								->where('product_api_id', 15)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id');
						 
						$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_trial')
								->where('customerno', $customerno)
								->where('product_api_id', 15)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($first);
						 
						$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_trial')
								->where('customerno', $customerno)
								->where('product_api_id', 15)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($secnd);
						 
						$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_trial')
								->where('customerno', $customerno)
								->where('product_api_id', 15)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($third)
								->orderBy('tgl_hit','DESC')
								->paginate($request->query('perpage', 100000000))
								->appends(request()->query());
						
						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 16) //SLIK Detail API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_slik_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Slik_Api_Postpaid::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = QueryBuilder::for(Slik_Api_Trial::class)
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 17) //Phone Age API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_phone_age_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_phone_age_postpaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_phone_age_trial')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 18) //Phone Id Match API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_phone_id_match_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_phone_id_match_postpaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_phone_id_match_trial')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 19) //Phone History 365 Date API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$first = DB::connection('mysql_4')->table('api_phonehistory_08_prepaid')
								->where('customerno', $customerno)
								->where('product_api_id', 19)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id');
						 
						$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_prepaid')
								->where('customerno', $customerno)
								->where('product_api_id', 19)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($first);
						 
						$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_prepaid')
								->where('customerno', $customerno)
								->where('product_api_id', 19)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($secnd);
						 
						$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_prepaid')
								->where('customerno', $customerno)
								->where('product_api_id', 19)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($third)
								->orderBy('tgl_hit','DESC')
								->paginate($request->query('perpage', 100000000))
								->appends(request()->query());
						
						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$first = DB::connection('mysql_4')->table('api_phonehistory_08_postpaid')
								->where('customerno', $customerno)
								->where('product_api_id', 19)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id');
						 
						$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_postpaid')
								->where('customerno', $customerno)
								->where('product_api_id', 19)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($first);
						 
						$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_postpaid')
								->where('customerno', $customerno)
								->where('product_api_id', 19)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($secnd);
						 
						$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_postpaid')
								->where('customerno', $customerno)
								->where('product_api_id', 19)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($third)
								->orderBy('tgl_hit','DESC')
								->paginate($request->query('perpage', 100000000))
								->appends(request()->query());
						
						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$first = DB::connection('mysql_4')->table('api_phonehistory_08_trial')
								->where('customerno', $customerno)
								->where('product_api_id', 19)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id');
						 
						$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_trial')
								->where('customerno', $customerno)
								->where('product_api_id', 19)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($first);
						 
						$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_trial')
								->where('customerno', $customerno)
								->where('product_api_id', 19)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($secnd);
						 
						$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_trial')
								->where('customerno', $customerno)
								->where('product_api_id', 19)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->unionAll($third)
								->orderBy('tgl_hit','DESC')
								->paginate($request->query('perpage', 100000000))
								->appends(request()->query());
						
						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 20) //Double Skiptrace API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_double_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phone_input) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_double_postpaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phone_input) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_double_trial')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phone_input) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 22) //WA Validation API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_whatsapp_validation_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phone_number) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_whatsapp_validation_postpaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phone_number) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_whatsapp_validation_trial')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phone_number) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
			}
			
			if ($product == 23) //Cellular Validation Pro API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_cellular_no_validation_pro_prepaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phone_number) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_cellular_no_validation_pro_postpaid')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phone_number) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
				
				if ($billingtype === 3) //TRIAL
				{
					if ($request->ajax()) 
					{
						$data = DB::connection('mysql_4')->table('api_cellular_no_validation_pro_trial')
								->where('customerno', $customerno)
								->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
								->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phone_number) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
								->groupBy('noapi_id')
								->orderBy('id','DESC')
								->paginate($request->query('perpage', 1000000))
								->appends(request()->query());

						return response()->paginator($data);
					}
				}
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
			DB::disconnect('mysql_2');
			DB::disconnect('mysql_3');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
        }		
	}

    public function datatableAll(Request $request, $params)
	{
        if(Session::get('userid'))
		{
			$pieces		= explode(";", $params);
			$periode	= $pieces[0];
			$product	= $pieces[1];
			$customerno	= $pieces[2];
			
			if ($request->ajax()) 
			{
				$data = DB::connection('mysql_4')->select("CALL View_Usage_Customer_All_Monthly('".$customerno."', '".$periode."');");
				ob_end_clean();

				return response($data);
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
			DB::disconnect('mysql_2');
			DB::disconnect('mysql_3');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
        }		
	}		

	public function downloadlog(Request $request, $params)
    {
        if(Session::get('userid'))
		{
			//dd($params);
			$pieces		= explode(";", $params);
			$periode	= $pieces[0];
			$product	= $pieces[1];
			$customerno	= $pieces[2];
			
			if ($product == 0) //ALL Product
			{
				$data = DB::connection('mysql_4')->select("CALL View_Usage_Customer_All_Monthly('".$customerno."', '".$periode."');");

				ob_end_clean();

				return Excel::download(new RptLogAll($data), 'Log_DataWiz_API_ALL_'.$customerno.'_'.$periode.'.xlsx');
			}

			if ($product == 1) //Validation API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_valid_no_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('(CASE WHEN success = 1 THEN "SUCCESS" ELSE "FAILED" END) AS status_hit'),DB::raw('MAX(phone_number) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id','status_hit')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial1($data), 'Log_DataWiz_API_Prepaid_Validation_No_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = QueryBuilder::for(Valid_No_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('(CASE WHEN success = 1 THEN "SUCCESS" ELSE "FAILED" END) AS status_hit'),DB::raw('MAX(phone_number) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id','status_hit')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid1($data), 'Log_DataWiz_API_Postpaid_Validation_No_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = QueryBuilder::for(Valid_No_Api_Trial::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('(CASE WHEN success = 1 THEN "SUCCESS" ELSE "FAILED" END) AS status_hit'),DB::raw('MAX(phone_number) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id','status_hit')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial1($data), 'Log_DataWiz_API_Trial_Validation_No_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 2) //Skiptrace API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_skiptrace_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial2($data), 'Log_DataWiz_API_Prepaid_Skiptrace_No_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = QueryBuilder::for(Skiptrace_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid2($data), 'Log_DataWiz_API_Postpaid_Skiptrace_No_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = QueryBuilder::for(Skiptrace_Api_Trial::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial2($data), 'Log_DataWiz_API_Trial_Skiptrace_No_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 3) //Id. Match API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_idmatch_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial3($data), 'Log_DataWiz_API_Prepaid_Id._Match_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = QueryBuilder::for(IdMatch_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid3($data), 'Log_DataWiz_API_Postpaid_Id._Match_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = QueryBuilder::for(IdMatch_Api_Trial::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial3($data), 'Log_DataWiz_API_Trial_Id._Match_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 4) //Reverse Skiptrace API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_reverse_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('phoneno AS data_input'),DB::raw('created_at AS tgl_hit'),DB::raw('nik AS nik'),DB::raw('tanggal AS reg_date'))
							->orderBy('tgl_hit','DESC')
							->orderBy('reg_date','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial4($data), 'Log_DataWiz_API_Reverse_Skiptrace_Prepaid_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = DB::connection('mysql_4')->table('api_reverse_postpaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('phoneno AS data_input'),DB::raw('created_at AS tgl_hit'),DB::raw('nik AS nik'),DB::raw('tanggal AS reg_date'))
							->orderBy('tgl_hit','DESC')
							->orderBy('reg_date','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid4($data), 'Log_DataWiz_API_Reverse_Skiptrace_Postpaid_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = DB::connection('mysql_4')->table('api_reverse_trial')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('phoneno AS data_input'),DB::raw('created_at AS tgl_hit'),DB::raw('nik AS nik'),DB::raw('tanggal AS reg_date'))
							->orderBy('tgl_hit','DESC')
							->orderBy('reg_date','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial4($data), 'Log_DataWiz_API_Reverse_Skiptrace_Trial_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 5) //Demography API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_demography_prepaid')
							->where('ftype', 2)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial5($data), 'Log_DataWiz_API_Prepaid_Demography_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = QueryBuilder::for(Demography_Api_Postpaid::class)
							->where('ftype', 2)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid5($data), 'Log_DataWiz_API_Postpaid_Demography_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = QueryBuilder::for(Demography_Api_Trial::class)
							->where('ftype', 2)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial5($data), 'Log_DataWiz_API_Trial_Demography_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 6) //Income Verification API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_income_prepaid')
							->where('customerno', $customerno)
							->where('price', 'PAY')
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial6($data), 'Log_DataWiz_API_Prepaid_Income_Verification_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = QueryBuilder::for(Income_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where('price', 'PAY')
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid6($data), 'Log_DataWiz_API_Postpaid_Income_Verification_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = QueryBuilder::for(Income_Api_Trial::class)
							->where('customerno', $customerno)
							->where('price', 'PAY')
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(nik) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial6($data), 'Log_DataWiz_API_Trial_Income_Verification_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 7) //Phone History API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$first = DB::connection('mysql_4')->table('api_phonehistory_08_prepaid')
							->where('customerno', $customerno)
							->where('product_api_id', 7)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id');
					 
					$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_prepaid')
							->where('customerno', $customerno)
							->where('product_api_id', 7)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($first);
					 
					$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_prepaid')
							->where('customerno', $customerno)
							->where('product_api_id', 7)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($secnd);
					 
					$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_prepaid')
							->where('customerno', $customerno)
							->where('product_api_id', 7)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($third)
							->orderBy('tgl_hit','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial7($data), 'Log_DataWiz_API_Prepaid_Phone_History_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$first = DB::connection('mysql_4')->table('api_phonehistory_08_postpaid')
							->where('customerno', $customerno)
							->where('product_api_id', 7)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id');
					 
					$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_postpaid')
							->where('customerno', $customerno)
							->where('product_api_id', 7)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($first);
					 
					$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_postpaid')
							->where('customerno', $customerno)
							->where('product_api_id', 7)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($secnd);
					 
					$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_postpaid')
							->where('customerno', $customerno)
							->where('product_api_id', 7)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($third)
							->orderBy('tgl_hit','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid7($data), 'Log_DataWiz_API_Postpaid_Phone_History_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$first = DB::connection('mysql_4')->table('api_phonehistory_08_trial')
							->where('customerno', $customerno)
							->where('product_api_id', 7)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id');
					 
					$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_trial')
							->where('customerno', $customerno)
							->where('product_api_id', 7)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($first);
					 
					$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_trial')
							->where('customerno', $customerno)
							->where('product_api_id', 7)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($secnd);
					 
					$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_trial')
							->where('customerno', $customerno)
							->where('product_api_id', 7)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($third)
							->orderBy('tgl_hit','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial7($data), 'Log_DataWiz_API_Trial_Phone_History_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 8) //SLIK SUMMARY API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_slik_summary_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial8($data), 'Log_DataWiz_API_Prepaid_Slik_Summary_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = QueryBuilder::for(Slik_Summary_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid8($data), 'Log_DataWiz_API_Postpaid_Slik_Summary_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = QueryBuilder::for(Slik_Summary_Api_Trial::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial8($data), 'Log_DataWiz_API_Trial_Slik_Summary_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 9) //Id. Verification API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_demography_verification_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial9($data), 'Log_DataWiz_API_Prepaid_Id._Verification_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = QueryBuilder::for(Demography_Verification_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid9($data), 'Log_DataWiz_API_Postpaid_Id._Verification_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = QueryBuilder::for(Demography_Verification_Api_Trial::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial9($data), 'Log_DataWiz_API_Trial_Id._Verification_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 10) //Demography Foto API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_demography_prepaid')
							->where('ftype', 1)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial10($data), 'Log_DataWiz_API_Prepaid_Demography_Photo_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = QueryBuilder::for(Demography_Api_Postpaid::class)
							->where('ftype', 1)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid10($data), 'Log_DataWiz_API_Postpaid_Demography_Photo_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = QueryBuilder::for(Demography_Api_Trial::class)
							->where('ftype', 1)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial10($data), 'Log_DataWiz_API_Trial_Demography_Photo_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 11) //Address Verification Api
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_address_verification_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial11($data), 'Log_DataWiz_API_Prepaid_Address_Verification_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = QueryBuilder::for(Address_Verification_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid11($data), 'Log_DataWiz_API_Postpaid_Address_Verification_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = QueryBuilder::for(Address_Verification_Api_Trial::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial11($data), 'Log_DataWiz_API_Trial_Address_Verification_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 12) //Negative Record Api
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_negative_record_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nama) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial12($data), 'Log_DataWiz_API_Prepaid_Negative_Record_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = QueryBuilder::for(Negative_Record_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nama) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid12($data), 'Log_DataWiz_API_Postpaid_Negative_Record_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = QueryBuilder::for(Negative_Record_Api_Trial::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nama) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial12($data), 'Log_DataWiz_API_Trial_Negative_Record_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 13) //Home Address Api
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_home_address_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial13($data), 'Log_DataWiz_API_Prepaid_Home_Address_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = QueryBuilder::for(Home_Address_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid13($data), 'Log_DataWiz_API_Postpaid_Home_Address_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = QueryBuilder::for(Home_Address_Api_Trial::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial13($data), 'Log_DataWiz_API_Trial_Home_Address_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 14) //Office Address Api
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_work_address_prepaid') 
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial14($data), 'Log_DataWiz_API_Prepaid_Office_Address_'.$customerno.'_'.$periode.'.xlsx');					
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = QueryBuilder::for(Office_Address_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid14($data), 'Log_DataWiz_API_Postpaid_Office_Address_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = QueryBuilder::for(Office_Address_Api_Trial::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(phoneno) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial14($data), 'Log_DataWiz_API_Trial_Office_Address_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 15) //Phone History 365 API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$first = DB::connection('mysql_4')->table('api_phonehistory_08_prepaid')
							->where('customerno', $customerno)
							->where('product_api_id', 15)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id');
					 
					$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_prepaid')
							->where('customerno', $customerno)
							->where('product_api_id', 15)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($first);
					 
					$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_prepaid')
							->where('customerno', $customerno)
							->where('product_api_id', 15)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($secnd);
					 
					$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_prepaid')
							->where('customerno', $customerno)
							->where('product_api_id', 15)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($third)
							->orderBy('tgl_hit','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial7($data), 'Log_DataWiz_API_Prepaid_Phone_History_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$first = DB::connection('mysql_4')->table('api_phonehistory_08_postpaid')
							->where('customerno', $customerno)
							->where('product_api_id', 15)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id');
					 
					$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_postpaid')
							->where('customerno', $customerno)
							->where('product_api_id', 15)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($first);
					 
					$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_postpaid')
							->where('customerno', $customerno)
							->where('product_api_id', 15)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($secnd);
					 
					$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_postpaid')
							->where('customerno', $customerno)
							->where('product_api_id', 15)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($third)
							->orderBy('tgl_hit','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid7($data), 'Log_DataWiz_API_Postpaid_Phone_History_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$first = DB::connection('mysql_4')->table('api_phonehistory_08_trial')
							->where('customerno', $customerno)
							->where('product_api_id', 15)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id');
					 
					$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_trial')
							->where('customerno', $customerno)
							->where('product_api_id', 15)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($first);
					 
					$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_trial')
							->where('customerno', $customerno)
							->where('product_api_id', 15)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($secnd);
					 
					$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_trial')
							->where('customerno', $customerno)
							->where('product_api_id', 15)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($third)
							->orderBy('tgl_hit','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial7($data), 'Log_DataWiz_API_Trial_Phone_History_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 16) //SLIK DETAIL API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_slik_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial8($data), 'Log_DataWiz_API_Prepaid_Slik_Detail_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = DB::connection('mysql_4')->table('api_slik_postpaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid8($data), 'Log_DataWiz_API_Postpaid_Slik_Detail_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = DB::connection('mysql_4')->table('api_slik_trial')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('MAX(code) AS status_hit'), DB::raw('MAX(nik) AS data_input'), DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial8($data), 'Log_DataWiz_API_Trial_Slik_Detail_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 17) //Phone Age API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_phone_age_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phoneno AS data_input'), DB::raw('created_at AS tgl_hit'), DB::raw('CONCAT(age," days.") AS age'))
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial17($data), 'Log_DataWiz_API_Phone_Age_Prepaid_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = DB::connection('mysql_4')->table('api_phone_age_postpaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phoneno AS data_input'), DB::raw('created_at AS tgl_hit'), DB::raw('CONCAT(age," days.") AS age'))
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid17($data), 'Log_DataWiz_API_Phone_Age_Postpaid_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = DB::connection('mysql_4')->table('api_phone_age_trial')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phoneno AS data_input'), DB::raw('created_at AS tgl_hit'), DB::raw('CONCAT(age," days.") AS age'))
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial17($data), 'Log_DataWiz_API_Phone_Age_Trial_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 18) //Phone Id Match API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_phone_id_match_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phoneno AS data_input'), DB::raw('ktp AS data_input2'), DB::raw('created_at AS tgl_hit'), 'result')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial18($data), 'Log_DataWiz_API_Phone_Id_Match_Prepaid_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = DB::connection('mysql_4')->table('api_phone_id_match_postpaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phoneno AS data_input'), DB::raw('ktp AS data_input2'), DB::raw('created_at AS tgl_hit'), 'result')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid18($data), 'Log_DataWiz_API_Phone_Id_Match_Postpaid_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = DB::connection('mysql_4')->table('api_phone_id_match_trial')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phoneno AS data_input'), DB::raw('ktp AS data_input2'), DB::raw('created_at AS tgl_hit'), 'result')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial18($data), 'Log_DataWiz_API_Phone_Id_Match_Trial_'.$customerno.'_'.$periode.'.xlsx');
				}
			}
			
			if ($product == 19) //Phone History 365 Date API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				
				if ($billingtype === 1) //PREPAID
				{
					$first = DB::connection('mysql_4')->table('api_phonehistory_08_prepaid')
							->where('customerno', $customerno)
							->where('product_api_id', 19)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id');
					 
					$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_prepaid')
							->where('customerno', $customerno)
							->where('product_api_id', 19)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($first);
					 
					$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_prepaid')
							->where('customerno', $customerno)
							->where('product_api_id', 19)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($secnd);
					 
					$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_prepaid')
							->where('customerno', $customerno)
							->where('product_api_id', 19)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($third)
							->orderBy('tgl_hit','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial7($data), 'Log_DataWiz_API_Prepaid_Phone_History_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$first = DB::connection('mysql_4')->table('api_phonehistory_08_postpaid')
							->where('customerno', $customerno)
							->where('product_api_id', 19)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id');
					 
					$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_postpaid')
							->where('customerno', $customerno)
							->where('product_api_id', 19)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($first);
					 
					$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_postpaid')
							->where('customerno', $customerno)
							->where('product_api_id', 19)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($secnd);
					 
					$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_postpaid')
							->where('customerno', $customerno)
							->where('product_api_id', 19)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($third)
							->orderBy('tgl_hit','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid7($data), 'Log_DataWiz_API_Postpaid_Phone_History_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$first = DB::connection('mysql_4')->table('api_phonehistory_08_trial')
							->where('customerno', $customerno)
							->where('product_api_id', 19)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id');
					 
					$secnd = DB::connection('mysql_4')->table('api_phonehistory_62_trial')
							->where('customerno', $customerno)
							->where('product_api_id', 19)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_no_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($first);
					 
					$third = DB::connection('mysql_4')->table('api_phonehistory_md5_08_trial')
							->where('customerno', $customerno)
							->where('product_api_id', 19)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_08) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($secnd);
					 
					$data  = DB::connection('mysql_4')->table('api_phonehistory_md5_62_trial')
							->where('customerno', $customerno)
							->where('product_api_id', 19)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('MAX(code) AS status_hit'),DB::raw('MAX(phone_md5_62) AS data_input'),DB::raw('MAX(created_at) AS tgl_hit'))
							->groupBy('noapi_id')
							->unionAll($third)
							->orderBy('tgl_hit','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial7($data), 'Log_DataWiz_API_Trial_Phone_History_'.$customerno.'_'.$periode.'.xlsx');
				}
			}

			if ($product == 20) //Double Skiptrace API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				//dd($billingtype);
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_double_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phone_input AS data_input'), DB::raw('created_at AS tgl_hit'), 'phone', 'tanggal')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial20($data), 'Log_DataWiz_API_Double_Skiptrace_Prepaid_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = DB::connection('mysql_4')->table('api_double_postpaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phone_input AS data_input'), DB::raw('created_at AS tgl_hit'), 'phone', 'tanggal')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid20($data), 'Log_DataWiz_API_Double_Skiptrace_Postpaid_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = DB::connection('mysql_4')->table('api_double_trial')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phone_input AS data_input'), DB::raw('created_at AS tgl_hit'), 'phone', 'tanggal')
							->orderBy('id','DESC')
							->get();
					//dd($data);
					ob_end_clean();

					return Excel::download(new RptLogTrial20($data), 'Log_DataWiz_API_Double_Skiptrace_Trial_'.$customerno.'_'.$periode.'.xlsx');
				}
			}

			if ($product == 22) //WA Validation API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				//dd($billingtype);
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_whatsapp_validation_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phone_number AS data_input'), DB::raw('created_at AS tgl_hit'), 'phone', 'tanggal')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial20($data), 'Log_DataWiz_API_Whatsapp_Validation_Prepaid_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = DB::connection('mysql_4')->table('api_whatsapp_validation_postpaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phone_number AS data_input'), DB::raw('created_at AS tgl_hit'), 'phone', 'tanggal')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid20($data), 'Log_DataWiz_API_Whatsapp_Validation_Postpaid_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = DB::connection('mysql_4')->table('api_whatsapp_validation_trial')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phone_number AS data_input'), DB::raw('created_at AS tgl_hit'), 'phone', 'tanggal')
							->orderBy('id','DESC')
							->get();
					//dd($data);
					ob_end_clean();

					return Excel::download(new RptLogTrial20($data), 'Log_DataWiz_API_Whatsapp_Validation_Trial_'.$customerno.'_'.$periode.'.xlsx');
				}
			}

			if ($product == 23) //Cellular Validation Pro API
			{
				$sts		= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product)->first();
				$billingtype= $sts->billingtypes;
				//dd($billingtype);
				
				if ($billingtype === 1) //PREPAID
				{
					$data = DB::connection('mysql_4')->table('api_cellular_no_validation_pro_prepaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phone_number AS data_input'), DB::raw('created_at AS tgl_hit'), 'phone', 'tanggal')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogTrial20($data), 'Log_DataWiz_API_CellularNo_Validation_Pro_Prepaid_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 2) //POSTPAID
				{
					$data = DB::connection('mysql_4')->table('api_cellular_no_validation_pro_postpaid')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phone_number AS data_input'), DB::raw('created_at AS tgl_hit'), 'phone', 'tanggal')
							->orderBy('id','DESC')
							->get();

					ob_end_clean();

					return Excel::download(new RptLogPostpaid20($data), 'Log_DataWiz_API_CellularNo_Validation_Pro_Postpaid_'.$customerno.'_'.$periode.'.xlsx');
				}
				
				if ($billingtype === 3) //TRIAL
				{
					$data = DB::connection('mysql_4')->table('api_cellular_no_validation_pro_trial')
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('phone_number AS data_input'), DB::raw('created_at AS tgl_hit'), 'phone', 'tanggal')
							->orderBy('id','DESC')
							->get();
					//dd($data);
					ob_end_clean();

					return Excel::download(new RptLogTrial20($data), 'Log_DataWiz_API_CellularNo_Validation_Pro_Trial_'.$customerno.'_'.$periode.'.xlsx');
				}
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
			DB::disconnect('mysql_2');
			DB::disconnect('mysql_3');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
        }		
	}		

}
