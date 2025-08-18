<?php

namespace App\Http\Controllers;

use App\Models\Mod_Company;
use App\Models\Mod_Rates;
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

class M_Rates extends Controller
{
    public function index(Request $request)
    {
		if(Session::get('userid'))
		{
			//jika memang session sudah terdaftar
			$username = Session::get('username');

            $ratestype = DB::select('select id, ratetype from master_ratestype ORDER BY id;');

            $nonstd = DB::select('select id, basedon from master_non_std_basedon ORDER BY id;');

            $product = DB::select('select id, product from master_product_paket ORDER BY id;');

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
						->where('master_company.customerno', '!=', "")
						//->join('master_paket_customer', 'master_paket_customer.customerno', '=', 'master_company.customerno')
						->join('master_rates', 'master_rates.customerno', '=', 'master_company.customerno')	
						//->join('master_product_paket', 'master_product_paket.id', '=', 'master_rates.product_paket_id') 
						->join('master_ratestype', 'master_ratestype.id', '=', 'master_rates.ratestypeid')	
						->select('master_rates.id','master_company.customerno','company_name','master_rates.rates','master_rates.rates_hp', 'master_rates.rates_wa','product_paket_id','ratestypeid','non_std_basedon','non_std_basedon_wa',DB::raw('(CASE WHEN product_paket_id < 5 THEN (SELECT product FROM master_product_paket WHERE master_product_paket.id = product_paket_id) ELSE (SELECT nama_paket FROM master_paket WHERE master_paket.id = product_paket_id) END) as product_paket'), DB::raw('master_ratestype.ratetype as ratetype'),'master_rates.fstatus', DB::raw('(CASE WHEN master_rates.fstatus = 1 THEN "ACTIVED" ELSE "INACTIVED" END) as status_name'), 'fftp', DB::raw('(CASE WHEN fftp = 0 THEN "Dashboard" WHEN fftp = 1 THEN "SFTP / FTP" WHEN fftp = 2 THEN "Email" ELSE "Google Drive" END) as media'),'apptypeid',DB::raw('(CASE WHEN apptypeid = 1 THEN "DataWiz API" WHEN apptypeid = 2 THEN "DataWiz Upload" ELSE "Combined" END) as apptype'))
						->orderBy('master_company.customerno','DESC')
						->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 10))
						->appends(request()->query());

                return response()->paginator($data);
			}
			
			return view('home.master_rates.rates', compact('ratestype','nonstd','product'));
			//return view('home.master_rates.rates');
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
	
	public function cariCompany(Request $request, $id)
	{
		$data = DB::table('master_company')
                ->where('active', 1)
                ->where('customerno', '!=', "")
                ->where('company_name', $id)
                ->leftJoin('master_rates', 'master_rates.customerno', '=', 'master_company.customerno')
                ->select('master_rates.id','rates','master_rates.customerno','company_name')
                ->first();
		//dd($data);
		
		return response()->json($data);
	}

    public function autoSearch(Request $request)
    {
        $query = $request->get('query');
		  
        $filterResult = DB::table('master_company')->where('active', 1)->where('customerno', '!=', "")->where('company_name', 'LIKE', '%'.$query.'%')->select('company_name')->get();
		//dd($data);

        $data = array();

        foreach ($filterResult as $hsl)
        {
            $data[] = $hsl->company_name;
        }

        return response()->json($data);
    } 

	public function view_rates($id)
    {
        if(Session::get('userid'))
        {
			$data = QueryBuilder::for(Mod_Company::class) //DB::table('customer_rates')
					->where('master_company.id', $id)
					//->join('master_paket_customer', 'master_paket_customer.customerno', '=', 'master_company.customerno')
					->join('master_rates', 'master_rates.customerno', '=', 'master_company.customerno')	
					->join('master_product_paket', 'master_product_paket.id', '=', 'master_rates.product_paket_id') 
					->join('master_ratestype', 'master_ratestype.id', '=', 'master_rates.ratestypeid')	
					->select('master_company.id','master_company.customerno','company_name','master_rates.rates','master_rates.product_paket_id','ratestypeid','non_std_basedon', DB::raw('(CASE WHEN non_std_basedon = 0 THEN "Non" WHEN non_std_basedon = 1 THEN "Yes" END) as hp_live'),'non_std_basedon_wa', DB::raw('(CASE WHEN non_std_basedon_wa = 0 THEN "Non" WHEN non_std_basedon_wa = 1 THEN "Yes" END) as wa_live'),DB::raw('(CASE WHEN product_paket_id < 5 THEN (SELECT product FROM master_product_paket WHERE master_product_paket.id = product_paket_id) ELSE (SELECT nama_paket FROM master_paket WHERE master_paket.id = product_paket_id) END) as product_paket'), DB::raw('master_ratestype.ratetype as ratetypes'),'master_rates.rates_hp', 'master_rates.rates_wa', 'master_rates.fstatus', DB::raw('(CASE WHEN master_rates.fstatus = 1 THEN "ACTIVED" ELSE "INACTIVED" END) as status_name'))
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
