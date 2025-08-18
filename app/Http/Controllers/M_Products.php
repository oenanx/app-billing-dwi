<?php
namespace App\Http\Controllers;

use App\Models\Mod_Company;
use App\Models\Mod_Products;
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

class M_Products extends Controller
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

				$data = QueryBuilder::for(Mod_Products::class)
						//->where('active', 1)
						->join('master_company', 'master_company.customerno', '=', 'master_paket_non_paket_customer.customerno')	
						->leftJoin('master_product_lite', 'master_product_lite.id', '=', 'master_paket_non_paket_customer.liteprodid')
						->leftJoin('master_product_paket_lite', 'master_product_paket_lite.id', '=', 'master_paket_non_paket_customer.litepaketid')
						->leftJoin('master_product_paket', 'master_product_paket.id', '=', 'master_paket_non_paket_customer.proprodid')
						->leftJoin('master_paket', 'master_paket.id', '=', 'master_paket_non_paket_customer.propaketid')
						->select('master_company.id','master_paket_non_paket_customer.customerno','master_company.company_name','fcompleted',DB::raw('(CASE WHEN fcompleted = 1 THEN "Completed" WHEN fcompleted = 0 THEN "Not Completed" END) as fcomplete'),'fftp',DB::raw('(CASE WHEN fftp = 0 THEN "Dashboard" WHEN fftp = 1 THEN "SFTP / FTP" WHEN fftp = 2 THEN "Email" ELSE "Google Drive" END) as fftpdesc'),'apptypeid',DB::raw('(CASE WHEN apptypeid = 1 THEN "DataWiz API" WHEN apptypeid = 2 THEN "DataWiz Upload" ELSE "Combined" END) as apptype'),'liteprodtipeid',DB::raw('(CASE WHEN liteprodtipeid = 1 THEN "Non Paket" WHEN liteprodtipeid = 2 THEN "Paket" END) as liteprodtipe'),'liteprodid',DB::raw('(CASE WHEN master_product_lite.product IS NULL THEN "-" ELSE master_product_lite.product END) as product_lite'),'litepaketid',DB::raw('(CASE WHEN master_product_paket_lite.product IS NULL THEN "-" ELSE master_product_paket_lite.product END) as paket_lite'),'proprodtipeid',DB::raw('(CASE WHEN proprodtipeid = 1 THEN "Non Paket" WHEN proprodtipeid = 2 THEN "Paket" END) as proprodtipe'),'proprodid',DB::raw('(CASE WHEN master_product_paket.product IS NULL THEN "-" ELSE master_product_paket.product END) as product_pro'),'propaketid',DB::raw('(CASE WHEN master_paket.nama_paket IS NULL THEN "-" ELSE master_paket.nama_paket END) as paket_pro'))
						->orderBy('master_company.id','DESC')
						->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 10))
						->appends(request()->query());

                return response()->paginator($data);
			}
			
            $data1['product'] = DB::select('select id, product from master_product_paket ORDER BY id;');

            $data1['packet'] = DB::select('select id, nama_paket from master_paket ORDER BY id;');

            $data1['productlite'] = DB::select('select id, product from master_product_lite WHERE fActive = 1 ORDER BY id;');

			$data1['paketlite'] = DB::select('select id, product from master_product_paket_lite WHERE fActive = 1 ORDER BY id;');

			return view('home.master_products.index')->with($data1);
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
			DB::disconnect('mysql_3');
			DB::disconnect('mysql_4');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}

	public function view_products($id)
    {
        if(Session::get('userid'))
        {
			$data = QueryBuilder::for(Mod_Products::class)
					->where('master_company.id', $id)
					//->where('active', 1)
					->join('master_company', 'master_company.customerno', '=', 'master_paket_non_paket_customer.customerno')	
					->leftJoin('master_product_lite', 'master_product_lite.id', '=', 'master_paket_non_paket_customer.liteprodid')
					->leftJoin('master_product_paket_lite', 'master_product_paket_lite.id', '=', 'master_paket_non_paket_customer.litepaketid')
					->leftJoin('master_product_paket', 'master_product_paket.id', '=', 'master_paket_non_paket_customer.proprodid')
					->leftJoin('master_paket', 'master_paket.id', '=', 'master_paket_non_paket_customer.propaketid')
					->select('master_company.id','master_paket_non_paket_customer.customerno','master_company.company_name','fcompleted',DB::raw('(CASE WHEN fcompleted = 1 THEN "Completed" WHEN fcompleted = 0 THEN "Not Completed" END) as fcomplete'),'fftp',DB::raw('(CASE WHEN fftp = 0 THEN "Dashboard" WHEN fftp = 1 THEN "SFTP / FTP" WHEN fftp = 2 THEN "Email" ELSE "Google Drive" END) as fftpdesc'),'apptypeid',DB::raw('(CASE WHEN apptypeid = 1 THEN "Datawhiz Lite" WHEN apptypeid = 2 THEN "Datawhiz Pro" ELSE "Combined" END) as apptype'),'liteprodtipeid',DB::raw('(CASE WHEN liteprodtipeid = 1 THEN "Non Paket" WHEN liteprodtipeid = 2 THEN "Paket" END) as liteprodtipe'),'liteprodid','concurrent',DB::raw('(CASE WHEN master_product_lite.product IS NULL THEN "-" ELSE master_product_lite.product END) as product_lite'),'litepaketid',DB::raw('(CASE WHEN master_product_paket_lite.product IS NULL THEN "-" ELSE master_product_paket_lite.product END) as paket_lite'),'proprodtipeid',DB::raw('(CASE WHEN proprodtipeid = 1 THEN "Non Paket" WHEN proprodtipeid = 2 THEN "Paket" END) as proprodtipe'),'proprodid',DB::raw('(CASE WHEN master_product_paket.product IS NULL THEN "-" ELSE master_product_paket.product END) as product_pro'),'propaketid',DB::raw('(CASE WHEN master_paket.nama_paket IS NULL THEN "-" ELSE master_paket.nama_paket END) as paket_pro'))
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
			DB::disconnect('mysql_3');
			DB::disconnect('mysql_4');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
    }

	public function ins_products(Request $request)
	{
		if(Session::get('userid'))
		{
			//dd($request);

			$customerno 		= $request->customerno;
			$companyid			= $request->companyid;
			$parentid			= $request->parentid;
			$fftp 				= $request->fftp;
			$apptypeid			= $request->apptypeid;
			$create_at 			= date('Y-m-d H:i:s');

			$liteprodtipeid		= $request->liteprodtipeid;
			$liteprodid			= $request->liteprodid;
			$litepaketid		= $request->litepaketid;
			
			$proprodtipeid		= $request->proprodtipeid;
			$proprodid			= $request->proprodid;
			$propaketid			= $request->propaketid;

			if ($fftp == "0") // Dashboard
			{
				$fsync		= 2;
			}
			else
			{
				$fsync		= 0;
			}

			if ($liteprodtipeid === NULL || empty($liteprodtipeid))
			{
				$liteprodtipeid		= 0;
			}
			
			if ($liteprodid === NULL || empty($liteprodid))
			{
				$liteprodid			= 0;
			}
			
			if ($litepaketid === NULL || empty($litepaketid))
			{
				$litepaketid		= 0;
			}
			
			if ($proprodtipeid === NULL || empty($proprodtipeid))
			{
				$proprodtipeid		= 0;
			}
			
			if ($proprodid === NULL || empty($proprodid))
			{
				$proprodid			= 0;
			}
			
			if ($propaketid === NULL || empty($propaketid))
			{
				$propaketid			= 0;
			}
			

			if ($apptypeid == "1") // Datawhiz Lite
			{
				$PRODUCTSID			= 18;
				$liteprodtipeid		= $liteprodtipeid;
				$liteprodid			= $liteprodid;
				$litepaketid		= $litepaketid;
				
				if ($liteprodid == 3)
				{
					$concurrent			= $request->concurrent;
				}
				else if ($liteprodid != 3)
				{
					$concurrent			= 0;
				}
				else 
				{
					return response()->json(['error' => 'Concurrent tidak boleh kosong.']);
				}

				if ($litepaketid == 2 || $litepaketid == 7)
				{
					$concurrent			= $request->concurrent;
				}
				else if ($litepaketid != 2 || $litepaketid != 7)
				{
					$concurrent			= 0;
				}
				else 
				{
					return response()->json(['error' => 'Concurrent tidak boleh kosong.']);
				}
				
				$proprodtipeid		= 0;
				$proprodid			= 0;
				$propaketid			= 0;
			}
			elseif ($apptypeid == "2") // Datawhiz Pro
			{
				$PRODUCTSID			= 17;
				$liteprodtipeid		= 0;
				$liteprodid			= 0;
				$litepaketid		= 0;
				$concurrent			= 0;
				
				$proprodtipeid		= $proprodtipeid;
				$proprodid			= $proprodid;
				$propaketid			= $propaketid;
			}
			elseif ($apptypeid == "3") // Datawhiz Lite + Datawhiz Pro
			{
				$PRODUCTSID			= 19;
				$liteprodtipeid		= $liteprodtipeid;
				$liteprodid			= $liteprodid;
				$litepaketid		= $litepaketid;
				if ($liteprodid == 3)
				{
					$concurrent			= $request->concurrent;
				}
				else
				{
					$concurrent			= 0;
				}

				if ($litepaketid == 2 || $litepaketid == 7)
				{
					$concurrent			= $request->concurrent;
				}
				else
				{
					$concurrent			= 0;
				}
								
				$proprodtipeid		= $proprodtipeid;
				$proprodid			= $proprodid;
				$propaketid			= $propaketid;
			}
			
			//if ($proprodtipeid == "1") //kalau tipe product = 1 --> berarti paket
			//{
			//	$proprodid		= $request->propaketid;
			//}
			//else  //kalau tipe product = 0 --> berarti non paket
			//{
			//	$proprodid		= $request->proprodid;
			//}
			
			$crtby				= $request->crtby;
			$userid				= $request->userid;

			DB::table('billing_ats.customer')
				->where('CUSTOMERNO', $customerno)
				->update(
					[
						'PRODUCTID' => $PRODUCTSID,
					]);

			DB::connection('mysql_2')->table('db_master_ats.customer')
				->where('CUSTOMERNO', $customerno)
				->update(
					[
						'PRODUCTID' => $PRODUCTSID,
					]);

			DB::connection('mysql_3')->table('billing_ats.customer')
				->where('CUSTOMERNO', $customerno)
				->update(
					[
						'PRODUCTID' => $PRODUCTSID,
					]);

			DB::table('master_company')
				->where('customerno', $customerno)
				->update(
					[
						'productid'  => $PRODUCTSID,
						'concurrent' => $concurrent,
						'fftp'		 => $fftp,
						'apptypeid'	 => $apptypeid,
					]);

			DB::connection('mysql_3')->table('master_company')
				->where('customerno', $customerno)
				->update(
					[
						'productid'  => $PRODUCTSID,
						'concurrent' => $concurrent,
						'fftp'		 => $fftp,
						'apptypeid'	 => $apptypeid,
					]);

			DB::table('master_paket_non_paket_customer')->insert(
				[					
                    'parentid'			=> $parentid,
					'customerno'		=> $customerno,
					'liteprodtipeid'	=> $liteprodtipeid,
					'liteprodid'		=> $liteprodid,
					'litepaketid'		=> $litepaketid,
					'proprodtipeid'		=> $proprodtipeid,
					'proprodid'			=> $proprodid,
					'propaketid'		=> $propaketid
				]
			);

			DB::connection('mysql_3')->table('master_paket_non_paket_customer')->insert(
				[					
                    'parentid'			=> $parentid,
					'customerno'		=> $customerno,
					'liteprodtipeid'	=> $liteprodtipeid,
					'liteprodid'		=> $liteprodid,
					'litepaketid'		=> $litepaketid,
					'proprodtipeid'		=> $proprodtipeid,
					'proprodid'			=> $proprodid,
					'propaketid'		=> $propaketid
				]
			);

			DB::table('master_paket_customer')->insert(
				[
					'product_paket_id'	=> $proprodid,
					'customerno'		=> $customerno,
					'created_at'		=> $create_at
				]
			);

			DB::connection('mysql_3')->table('master_paket_customer')->insert(
				[
					'product_paket_id'	=> $proprodid,
					'customerno'		=> $customerno,
					'created_at'		=> $create_at
				]
			);

			return response()->json(['success' => 'Master Product saved successfully.']);
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