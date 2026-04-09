<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class MaintenancePostpaid extends Controller
{
    public function index(Request $request)
    {
		if(Session::get('userid'))
		{
			//jika memang session sudah terdaftar
            $query1 = DB::table('master_maintenance_all')
                        ->where('period', DB::raw('DATE_FORMAT(CURDATE(),"%Y%m")'))
                        ->where('flag', 1)
                        ->where('end_time', '1900-01-01 00:00:00')
                        ->select('flag')
                        ->get();
            

            if (count($query1) == 1)
            {
                return view('home.notif.input_error');
            }
            else 
            {
				return view('home.maintenance_postpaid.all');
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
			DB::disconnect('mysql_4');

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}
	
	public function get_usage(Request $request)
	{
        if(Session::get('userid'))
		{
            $id = DB::table('master_maintenance_all')->insertGetId(
				[
					'period' => date('Ym'),
					'begin_time' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
					'flag' => 1,
					'end_time' => "1900-01-01 00:00:00",
					'crtby' => Session::get('userid'),
					'crtdate' => Carbon::now('Asia/Jakarta')->toDateTimeString()
				]
			);
				
			$month = $request->months;
			$thn = $request->thns;
			$userid = Session::get('userid');
			//dd($month);

            $time = microtime();
            $time = explode(' ', $time);
            $time = $time[1] + $time[0];
            $start = $time;
        
            $period = $thn.$month;		//period bs
            $period2 = $period - 1;		//period usage
			
            if (substr($period2,4,2) == "00")
            {
                $period2 = ($thn - 1)."12";
            }
			//dd($period2);
			
			//Jika di table sum_validno_postpaid dan table sum_skiptrace_postpaid pada period tersebut sudah ada data
			//maka, datanya di hapus dulu lalu di insert ulang.
            $delvalidno		= DB::table('sum_validno_postpaid')->where('sum_validno_postpaid.period',$period2)->delete();
            $delskiptrace	= DB::table('sum_skiptrace_postpaid')->where('sum_skiptrace_postpaid.period',$period2)->delete();
            $delidmatch 	= DB::table('sum_idmatch_postpaid')->where('sum_idmatch_postpaid.period',$period2)->delete();
            $delreverse 	= DB::table('sum_reverse_postpaid')->where('sum_reverse_postpaid.period',$period2)->delete();
            $deldemography	= DB::table('sum_demography_postpaid')->where('sum_demography_postpaid.period',$period2)->delete();
            $delincome		= DB::table('sum_income_postpaid')->where('sum_income_postpaid.period',$period2)->delete();
            $delphonehist	= DB::table('sum_phonehistory_postpaid')->where('sum_phonehistory_postpaid.period',$period2)->delete();
            $delphonehist2	= DB::table('sum_phonehistory_365_postpaid')->where('sum_phonehistory_365_postpaid.period',$period2)->delete();
            $delphonehist3	= DB::table('sum_phonehistory_365_dates_postpaid')->where('sum_phonehistory_365_dates_postpaid.period',$period2)->delete();
            $delsliksumm	= DB::table('sum_sliksummary_postpaid')->where('sum_sliksummary_postpaid.period',$period2)->delete();
            $delidverify	= DB::table('sum_idverification_postpaid')->where('sum_idverification_postpaid.period',$period2)->delete();
            $deldemo_foto	= DB::table('sum_demography_photo_postpaid')->where('sum_demography_photo_postpaid.period',$period2)->delete();
			$deladdr_ver	= DB::table('sum_address_verification_postpaid')->where('sum_address_verification_postpaid.period',$period2)->delete();
			$delnegatifrec	= DB::table('sum_negatif_postpaid')->where('sum_negatif_postpaid.period',$period2)->delete();			
			$delhome_addr	= DB::table('sum_home_address_postpaid')->where('sum_home_address_postpaid.period',$period2)->delete();
			$delwork_addr	= DB::table('sum_office_address_postpaid')->where('sum_office_address_postpaid.period',$period2)->delete();
            $delslikdetail	= DB::table('sum_slikdetail_postpaid')->where('sum_slikdetail_postpaid.period',$period2)->delete();
			$delphone_age	= DB::table('sum_phone_age_postpaid')->where('sum_phone_age_postpaid.period',$period2)->delete();
			$delphone_idm	= DB::table('sum_phone_id_match_postpaid')->where('sum_phone_id_match_postpaid.period',$period2)->delete();
			$deldouble		= DB::table('sum_double_postpaid')->where('sum_double_postpaid.period',$period2)->delete();
			$delcellpro		= DB::table('sum_validno_pro_postpaid')->where('sum_validno_pro_postpaid.period',$period2)->delete();
			$delwavalid		= DB::table('sum_wa_validation_postpaid')->where('sum_wa_validation_postpaid.period',$period2)->delete();
			
			//GET USAGE VALIDNO API POSTPAID FROM Dashboard
			$get1  = DB::connection('mysql_4')->select("CALL sp_trx_validno_monthly('".$period2."');");
			//dd($get);
			foreach($get1 as $row1)
			{
				$period			= $row1->period;
				$customerno		= $row1->customerno;
				$sum_success	= $row1->sum_success;
				$sum_valid		= $row1->sum_valid;
 				$sum_invalid	= $row1->sum_invalid;
				$get_date		= $row1->get_date;
				
				$rate 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 1)->select('rates')->first();
				$rates 			= $rate->rates;
				$totalamount	= ($rates * $sum_success);

				DB::table('sum_validno_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_success'	=> $sum_success,
						'sum_valid'		=> $sum_valid,
						'sum_invalid'	=> $sum_invalid,
						'get_date'		=> $get_date,
						'rates'			=> $rates,
						'totalamount'	=> $totalamount
					]
				);
			}
			
			//GET USAGE SKIPTRACE API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_skiptrace_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_nik		= $row2->sum_nik;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 2)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_nik);

				DB::table('sum_skiptrace_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_nik'		=> $sum_nik,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}

			//GET USAGE idmatch API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_idmatch_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 3)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_idmatch_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_noapi_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE reverse API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_reverse_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 4)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_reverse_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_api_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}

			//GET USAGE demography API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_demography_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 5)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_demography_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_noapi_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE income API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_income_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 6)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_income_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_noapi_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE phonehistory API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_phonehistory_monthly('".$period2."', 7);");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;
				$product_api_id	= $row2->product_api_id;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', $product_api_id)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_phonehistory_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_noapi_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE sliksummary API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_sliksummary_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 8)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_sliksummary_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_nik'		=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}

			//GET USAGE idverification API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_idverification_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 9)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_idverification_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_noapi_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}

			//GET USAGE demography_photo API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_demography_photo_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 10)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_demography_photo_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_noapi_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE Address Verification API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_address_verification_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 11)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_address_verification_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_noapi_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE Negatif Record API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_negative_record_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 12)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_negatif_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_noapi_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE Home Address API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_home_address_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 13)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_home_address_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_noapi_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE Office Address API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_office_address_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 14)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_office_address_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_noapi_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE Phone History 365 API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_phonehistory_monthly('".$period2."', 15);");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;
				$product_api_id	= $row2->product_api_id;

				$rate2 			= DB::table('master_product_api_customer')
									->where('customerno', $customerno)
									->where('product_api_id', $product_api_id)
									->select('rates')
									->first();
									
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_phonehistory_365_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_noapi_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE Slik Detail API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_slikdetail_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 16)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_slikdetail_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_nik'		=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE PHONE AGE API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_phone_age_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 17)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_phone_age_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_api_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE PHONE ID MATCH API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_phone_id_match_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 18)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_phone_id_match_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_api_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE Phone History 365 Dates API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_phonehistory_monthly('".$period2."', 19);");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;
				$product_api_id	= $row2->product_api_id;

				$rate2 			= DB::table('master_product_api_customer')
									->where('customerno', $customerno)
									->where('product_api_id', $product_api_id)
									->select('rates')
									->first();
									
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_phonehistory_365_dates_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_noapi_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE DOUBLE SKIPTRACE API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_double_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 20)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_double_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_api_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE WA Validation API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_wa_validation_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 22)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_wa_validation_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_api_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}
			
			//GET USAGE Cellular Validation Pro API POSTPAID FROM Dashboard
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_cellularno_validation_pro_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 23)->select('rates')->first();
				$rates2 		= $rate2->rates;
				$totalamount2	= ($rates2 * $sum_noapi_id);

				DB::table('sum_validno_pro_postpaid')->insert(
					[
						'period'		=> $period,
						'customerno'	=> $customerno,
						'sum_api_id'	=> $sum_noapi_id,
						'get_date'		=> $get_date,
						'rates'			=> $rates2,
						'totalamount'	=> $totalamount2
					]
				);
			}


            $query1 = DB::table('master_maintenance_all')
                    ->where('id', $id)
                    ->where('period', DB::raw('DATE_FORMAT(CURDATE(),"%Y%m")'))
                    ->where('flag', 1)
                    ->where('crtby', $userid)
                    ->update(['end_time' => Carbon::now('Asia/Jakarta')->toDateTimeString()]);

            $query2 = DB::table('master_maintenance_all')
                    ->where('id', $id)
                    ->where('period', DB::raw('DATE_FORMAT(CURDATE(),"%Y%m")'))
                    ->where('flag', 1)
                    ->where('crtby', $userid)
                    ->update(['updby' => $userid]);

            $query3 = DB::table('master_maintenance_all')
                    ->where('id', $id)
                    ->where('period', DB::raw('DATE_FORMAT(CURDATE(),"%Y%m")'))
                    ->where('flag', 1)
                    ->where('crtby', $userid)
                    ->update(['upddate' => Carbon::now('Asia/Jakarta')->toDateTimeString()]);

            $query4 = DB::table('master_maintenance_all')
                    ->where('id', $id)
                    ->where('period', DB::raw('DATE_FORMAT(CURDATE(),"%Y%m")'))
                    ->where('flag', 1)
                    ->where('crtby', $userid)
                    ->update(['flag' => 2]);
           
            $time = microtime();
            $time = explode(' ', $time);
            $time = $time[1] + $time[0];
            $finish = $time;
            $total_time = round(($finish - $start), 3);

			return response()->json(['success' => $total_time]);
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

    public function proses(Request $request)
    {
        if(Session::get('userid'))
        {
            $id = DB::table('master_maintenance_all')->insertGetId([
					'period' => date('Ym'),
					'begin_time' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
					'flag' => 1,
					'end_time' => "1900-01-01 00:00:00",
					'crtby' => Session::get('userid'),
					'crtdate' => Carbon::now('Asia/Jakarta')->toDateTimeString()
			]);
				
			$month = $request->month;
			$thn = $request->thn;
			$userid = $request->userid;
			
			//dd($month);

            $time = microtime();
            $time = explode(' ', $time);
            $time = $time[1] + $time[0];
            $start = $time;
        
            $period = $thn.$month;		//period bs
            $period2 = $period - 1;		//period usage
            $periodnow = date("Ym");	//period bulan berjalan
            //dd($period);
			
            if (substr($period2,4,2) == "00")
            {
                $period2 = ($thn - 1)."12";
            }

            $period5 = $period;
            if (substr($period5,4,2) == "13")
            {
                $period5 = ($thn + 1)."01";
            }


            $periodtgl = substr($period,0,4).'-'.substr($period,4,2).'-01';
            $periodtglls = substr($period5,0,4).'-'.substr($period5,4,2).'-01';
            $period2tgl = substr($period2,0,4).'-'.substr($period2,4,2).'-01';
            $period5tgl = substr($period5,0,4).'-'.substr($period5,4,2).'-01';

            //dd($period5tgl);
        
            $periodsrv = date('d/m/Y', strtotime($periodtgl)).' - '.date('d/m/Y', strtotime("last day", strtotime($period5tgl)));
            $periodsrvls = date('d/m/Y', strtotime($period2tgl)).' - '.date('d/m/Y', strtotime("last day", strtotime($periodtgl)));
            
            //dd($periodsrvls);
			
			//Bersihkan semua data bs dan bs_detail yang sesuai dengan periode tersebut
            $delbs = DB::table('bs_postpaid')->where('period',$period)->delete();
            //dd($delbs);
            $delbsdetail = DB::table('bs_postpaid_detail')->where('period',$period)->delete();
            //dd($delbsdetail);

            $duedate = substr($period,0,4).'-'.substr($period,4,2).'-20';
            $newstatementdate = date('Y-m-d', strtotime($period5tgl));
			//Baris command di bawah ini di-non-aktifkan per 1 Juli 2024.
            //$newstatementdate = date('Y-m-d', strtotime("last day", strtotime($period5tgl)));
			//------------------------------------------------------------------------------------------------------------------------
            $laststatementdate = $period2tgl;
            $paymentdatevat = date('Y-m-d', strtotime("last day", strtotime($period5tgl)));
            //dd($paymentdatevat);

            $j = 1;
            $customer = DB::select('SELECT distinct (master_company.customerno) cust_no, company_name FROM master_company, master_product_api_customer WHERE master_company.customerno =  master_product_api_customer.customerno AND fapi = 1 AND master_company.customerno NOT IN ("DWH00000020C","DWH00000056C","DWH00000058C","DWH00000071C","DWH00000072C","DWH00000077R","DWH00000078R","DWH00000079R") AND billingtypes = 2 order by master_company.customerno;');
            //dd($customer);
            for($i = 0; $i < count($customer); $i++) 
            {
                $cust_no = $customer[$i]->cust_no;
                
                switch(substr($period2,4,2))
                {
                  case '01':
                   $bulan='I';
                   break;
                  case '02':
                   $bulan='II';
                   break;
                  case '03':
                   $bulan='III';
                   break;
                  case '04':
                   $bulan='IV';
                   break;
                  case '05':
                   $bulan='V';
                   break;
                  case '06':
                   $bulan='VI';
                   break;
                  case '07':
                   $bulan='VII';
                   break;
                  case '08':
                   $bulan='VIII';
                   break;
                  case '09':
                   $bulan='IX';
                   break;
                  case '10':
                   $bulan='X';
                   break;
                  case '11':
                   $bulan='XI';
                   break;
                  case '12':
                   $bulan='XII';
                   break;      
                }  
        
                if ($bulan == 'XII')
                {
                    $bsno1 = str_pad($j, 7, '0', STR_PAD_LEFT).'/DA/'.$bulan.'/'.($thn - 1);
                }
                else
                {
                    $bsno1 = str_pad($j, 7, '0', STR_PAD_LEFT).'/DA/'.$bulan.'/'.$thn;
                }
				
                DB::table('bs_postpaid')->insert(['bsno' => $bsno1, 'period' => $period, 'customerno' => $cust_no]);

                $delbsdetail2 = DB::table('bs_postpaid_detail')->where('PERIOD', $period)->where('CUSTOMERNO', $cust_no)->delete();

                $delbsdetail3 = DB::table('bs_postpaid_detail')->where('PERIOD', $period)->where('amount', 0)->delete();
				

                //PREVIOUS PAYMENT
                $data1 = DB::table('trans_postpaid')
                            ->where(DB::raw('DATE_FORMAT(transactiondate,"%Y%m")'), $period)
                            ->where('transactioncode', 'P')
                            ->where('paymentcode', '!=', 'G')
                            ->where('settlement_status', 0)
                            ->where('customerno', $cust_no)
                            ->select(DB::raw('sum(amount) AS amountz'),'customerno')
                            ->groupBy('customerno')
                            ->get();

                foreach($data1 as $rowz)
                {
                    $amount1 = $rowz->amountz;
                    $cust = $rowz->customerno;

                    $affected = DB::table('bs_postpaid')
                                ->where('bs_postpaid.CUSTOMERNO', $cust)
                                ->where('bs_postpaid.period', $period)
                                ->update(['bs_postpaid.previouspayment' => $amount1]);

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'CUSTOMERNO' => $cust,
                            'description' => "Transfer Payment",
                            'amount' => $amount1 * -1,
                            'PERIOD' => $period
                        ]
                    );
                }
				
				//PAYMENT PPh 23
                $data2 = DB::table('trans_postpaid')
                            ->where(DB::raw('DATE_FORMAT(transactiondate,"%Y%m")'), $period2)
                            ->where('transactioncode', 'P')
                            ->where('paymentcode', 'G')
                            ->where('customerno', '!=', null)
                            ->where('customerno', $cust_no)
                            ->select(DB::raw('SUM(amount) AS amountz'),'customerno')
                            ->groupBy('customerno')
                            ->get();

                foreach($data2 as $rowz2)
                {
                    $amount1 = $rowz2->amountz;
                    $cust = $rowz2->customerno;

                    $affected = DB::table('bs_postpaid')
                                ->where('bs_postpaid.customerno', $cust)
                                ->where('bs_postpaid.period', $period)
                                ->update(['bs_postpaid.previouspayment' => 'bs_postpaid.previouspayment' + (double)$amount1]);

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'CUSTOMERNO' => $cust,
                            'description' => "Payment PPh 23",
                            'amount' => $amount1 * -1,
                            'PERIOD' => $period
                        ]
                    );
                }

                //BALANCED ADJUSTMENT
                $data3 = DB::table('trans_postpaid')
                            ->where(DB::raw('DATE_FORMAT(transactiondate,"%Y%m")'), $period2)
                            ->where('transactioncode', 'B')
                            ->where('customerno', '!=', null)
                            ->where('customerno', $cust_no)
                            ->select(DB::raw('SUM(amount) AS amountz'),'customerno')
                            ->groupBy('customerno')
                            ->get();

                foreach($data3 as $rowz3)
                {
                    $amount1 = $rowz3->amountz;
                    $cust = $rowz3->customerno;

                    $affected = DB::table('bs_postpaid')
                                ->where('bs_postpaid.customerno', $cust)
                                ->where('bs_postpaid.period', $period)
                                ->update(['bs_postpaid.balanceadjustment' => $amount1]);

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'CUSTOMERNO' => $cust,
                            'description' => "Balance Correction",
                            'amount' => $amount1 * -1,
                            'PERIOD' => $period
                        ]
                    );
                }

                //TOTAL DISCOUNT
                $data4 = DB::table('trans_postpaid')
                            ->where(DB::raw('DATE_FORMAT(transactiondate,"%Y%m")'), $period2)
                            ->where('transactioncode', 'D')
                            ->where('customerno', '!=', null)
                            ->where('customerno', $cust_no)
                            ->select(DB::raw('SUM(amount) AS amountz'),'customerno')
                            ->groupBy('customerno')
                            ->get();

                foreach($data4 as $rowz4)
                {
                    $amount1 = $rowz4->amountz;
                    $cust = $rowz4->customerno;

                    $affected = DB::table('bs_postpaid')
                                ->where('bs_postpaid.customerno', $cust)
                                ->where('bs_postpaid.period', $period)
                                ->update(['bs_postpaid.totaldiscount' => $amount1]);

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'CUSTOMERNO' => $cust,
                            'description' => "Discount",
                            'amount' => $amount1 * -1,
                            'PERIOD' => $period
                        ]
                    );
                }

                //USAGE ADJUSTMENT
                $data5 = DB::table('trans_postpaid')
                            ->where(DB::raw('DATE_FORMAT(transactiondate,"%Y%m")'), $period2)
                            ->where('transactioncode', 'U')
                            ->where('customerno', '!=', null)
                            ->where('customerno', $cust_no)
                            ->select(DB::raw('SUM(amount) AS amountz'),'customerno')
                            ->groupBy('customerno')
                            ->get();

                foreach($data5 as $rowz5)
                {
                    $amount1 = $rowz5->amountz;
                    $cust = $rowz5->customerno;

                    $affected = DB::table('bs_postpaid')
                                ->where('bs_postpaid.customerno', $cust)
                                ->where('bs_postpaid.period', $period)
                                ->update(['bs_postpaid.usageadjustment' => $amount1]);

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'CUSTOMERNO' => $cust,
                            'description' => "Balance Correction",
                            'amount' => $amount1 * -1,
                            'PERIOD' => $period
                        ]
                    );
                }

                $delbsdetail4 = DB::table('bs_postpaid_detail')->where('PERIOD', $period)->where('AMOUNT', 0)->delete();				

				//1. Usage Validation Number API Postpaid
				$data_a = DB::table('sum_validno_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Validation Number API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_a as $row_a)
                {
                    $amount1	= $row_a->total;
                    $cust		= $row_a->customerno;
                    $deskripsi	= $row_a->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//2. Usage Skiptrace API Postpaid
				$data_b = DB::table('sum_skiptrace_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Skiptrace API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_b as $row_b)
                {
                    $amount1	= $row_b->total;
                    $cust		= $row_b->customerno;
                    $deskripsi	= $row_b->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//3. USAGE idmatch API POSTPAID FROM Dashboard
				$data_e = DB::table('sum_idmatch_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Id. Match API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_e as $row_e)
                {
                    $amount1	= $row_e->total;
                    $cust		= $row_e->customerno;
                    $deskripsi	= $row_e->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//4. USAGE reverse API POSTPAID FROM Dashboard
				$data_j = DB::table('sum_reverse_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Reverse Skiptrace API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_j as $row_j)
                {
                    $amount1	= $row_j->total;
                    $cust		= $row_j->customerno;
                    $deskripsi	= $row_j->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//5. USAGE demography API POSTPAID FROM Dashboard
				$data_d = DB::table('sum_demography_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Demography Check API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_d as $row_d)
                {
                    $amount1	= $row_d->total;
                    $cust		= $row_d->customerno;
                    $deskripsi	= $row_d->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//6. USAGE income API POSTPAID FROM Dashboard
				$data_g = DB::table('sum_income_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Income Estimate API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_g as $row_g)
                {
                    $amount1	= $row_g->total;
                    $cust		= $row_g->customerno;
                    $deskripsi	= $row_g->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//7. USAGE phonehistory API POSTPAID FROM Dashboard
				$data_h = DB::table('sum_phonehistory_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Phone History API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_h as $row_h)
                {
                    $amount1	= $row_h->total;
                    $cust		= $row_h->customerno;
                    $deskripsi	= $row_h->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//8. USAGE Financial Insight Basic API POSTPAID FROM Dashboard
				$data_i = DB::table('sum_sliksummary_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Financial Insight Basic API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_i as $row_i)
                {
                    $amount1	= $row_i->total;
                    $cust		= $row_i->customerno;
                    $deskripsi	= $row_i->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//9. USAGE idverification API POSTPAID FROM Dashboard
				$data_f = DB::table('sum_idverification_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Id. Verification API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_f as $row_f)
                {
                    $amount1	= $row_f->total;
                    $cust		= $row_f->customerno;
                    $deskripsi	= $row_f->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//10. USAGE demography_photo API POSTPAID FROM Dashboard
				$data_c = DB::table('sum_demography_photo_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Demography Photo Check API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_c as $row_c)
                {
                    $amount1	= $row_c->total;
                    $cust		= $row_c->customerno;
                    $deskripsi	= $row_c->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//11. USAGE Address Validation API POSTPAID FROM Dashboard
				$data_11 = DB::table('sum_address_verification_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Address Validation API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_11 as $row_11)
                {
                    $amount1	= $row_11->total;
                    $cust		= $row_11->customerno;
                    $deskripsi	= $row_11->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//12. USAGE Negative Record API POSTPAID FROM Dashboard
				$data_12 = DB::table('sum_negatif_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Negative Record API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_12 as $row_12)
                {
                    $amount1	= $row_12->total;
                    $cust		= $row_12->customerno;
                    $deskripsi	= $row_12->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//13. USAGE Home Address API POSTPAID FROM Dashboard
				$data_13 = DB::table('sum_home_address_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Home Address API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_13 as $row_13)
                {
                    $amount1	= $row_13->total;
                    $cust		= $row_13->customerno;
                    $deskripsi	= $row_13->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//14. USAGE Office Address API POSTPAID FROM Dashboard
				$data_14 = DB::table('sum_office_address_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Office Address API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_14 as $row_14)
                {
                    $amount1	= $row_14->total;
                    $cust		= $row_14->customerno;
                    $deskripsi	= $row_14->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//15. USAGE phonehistory 365 API POSTPAID FROM Dashboard
				$data_15 = DB::table('sum_phonehistory_365_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Phone History 365 API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_15 as $row_15)
                {
                    $amount1	= $row_15->total;
                    $cust		= $row_15->customerno;
                    $deskripsi	= $row_15->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//16. USAGE Financial Insight Plus API POSTPAID FROM Dashboard
				$data_16 = DB::table('sum_slikdetail_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Financial Insight Plus API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_16 as $row_16)
                {
                    $amount1	= $row_16->total;
                    $cust		= $row_16->customerno;
                    $deskripsi	= $row_16->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//17. USAGE Phone Age API POSTPAID FROM Dashboard
				$data_17 = DB::table('sum_phone_age_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Phone Age API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_17 as $row_17)
                {
                    $amount1	= $row_17->total;
                    $cust		= $row_17->customerno;
                    $deskripsi	= $row_17->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//18. USAGE Phone Id Match API POSTPAID FROM Dashboard
				$data_18 = DB::table('sum_phone_id_match_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Phone Id. Match API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_18 as $row_18)
                {
                    $amount1	= $row_18->total;
                    $cust		= $row_18->customerno;
                    $deskripsi	= $row_18->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//19. USAGE phonehistory 365 Dates API POSTPAID FROM Dashboard
				$data_19 = DB::table('sum_phonehistory_365_dates_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Phone History 365 Dates API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_19 as $row_19)
                {
                    $amount1	= $row_19->total;
                    $cust		= $row_19->customerno;
                    $deskripsi	= $row_19->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//20. USAGE Double Skiptrace API POSTPAID FROM Dashboard
				$data_20 = DB::table('sum_double_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Double Skiptrace API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_20 as $row_20)
                {
                    $amount1	= $row_20->total;
                    $cust		= $row_20->customerno;
                    $deskripsi	= $row_20->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//22. USAGE WA Validation API POSTPAID FROM Dashboard
				$data_22 = DB::table('sum_wa_validation_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"WA Validation API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_22 as $row_22)
                {
                    $amount1	= $row_22->total;
                    $cust		= $row_22->customerno;
                    $deskripsi	= $row_22->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }

				//23. USAGE Cellular Validation Pro API POSTPAID FROM Dashboard
				$data_23 = DB::table('sum_validno_pro_postpaid')
						->where('customerno', $cust_no)
						->where('period', $period2)
						->select('customerno', DB::raw('"Cellular Validation Pro API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
						->get();

				foreach($data_23 as $row_23)
                {
                    $amount1	= $row_23->total;
                    $cust		= $row_23->customerno;
                    $deskripsi	= $row_23->deskripsi;

                    DB::table('bs_postpaid_detail')->insert(
                        [
                            'customerno' => $cust,
                            'description' => $deskripsi,
                            'amount' => $amount1,
                            'period' => $period,
                            'period_service' => $periodsrvls,
                            'prss_id' => 18
                        ]
                    );
                }


                //TOTAL USAGE
                $data12 = DB::table('bs_postpaid_detail')
                            ->where('period', $period)
                            ->where('prss_id', '>', 0)
                            ->where('customerno', '!=', null)
                            ->where('customerno', $cust_no)
                            ->select(DB::raw('ROUND(SUM(amount),0) AS monthly'), 'customerno')
                            ->groupBy('customerno')
                            ->get();

                foreach($data12 as $rowz12)
                {
                    $monthly = $rowz12->monthly;
                    $cust = $rowz12->customerno;

                    $qry1 = DB::table('bs_postpaid')
                            ->where('bs_postpaid.customerno', $cust)
                            ->where('bs_postpaid.period', $period)
                            ->update(['bs_postpaid.totalusage' => $monthly]);

                    $qry2 = DB::table('bs_postpaid')
                            ->where('bs_postpaid.customerno', $cust)
                            ->where('bs_postpaid.period', $period)
                            ->update(['bs_postpaid.totalamount' => $monthly]);

                    $qry3 = DB::table('bs_postpaid')
                            ->where('bs_postpaid.customerno', $cust)
                            ->where('bs_postpaid.period', $period)
                            ->update(['bs_postpaid.duedate' => $duedate]);

                    $qry4 = DB::table('bs_postpaid')
                            ->where('bs_postpaid.customerno', $cust)
                            ->where('bs_postpaid.period', $period)
                            ->update(['bs_postpaid.newstatementdate' => $newstatementdate]);

                    $qry5 = DB::table('bs_postpaid')
                            ->where('bs_postpaid.customerno', $cust)
                            ->where('bs_postpaid.period', $period)
                            ->update(['bs_postpaid.laststatementdate' => $laststatementdate]);

                    $qry6 = DB::table('bs_postpaid')
                            ->where('bs_postpaid.customerno', $cust)
                            ->where('bs_postpaid.period', $period)
                            ->update(['bs_postpaid.paymentdatevat' => $paymentdatevat]);
                }

                //PREVIOUS BALANCE
                $data13 = DB::table('bs_postpaid')
                            ->where('period', $period2)
                            ->where('customerno', $cust_no)
                            ->select(DB::raw('(previousbalance-previouspayment+(totalamount+totalvat)-balanceadjustment-usageadjustment-totaldiscount) AS amountdue'), 'customerno')
                            ->get();

                foreach($data13 as $rowz13)
                {
                    $amountdue = $rowz13->amountdue;
                    $cust = $rowz13->customerno;

                    $qry1 = DB::table('bs_postpaid')
                            ->where('bs_postpaid.customerno', $cust)
                            ->where('bs_postpaid.period', $period)
                            ->update(['bs_postpaid.previousbalance' => $amountdue]);
                }

                //TOTAL VAT
				$qryvat = DB::select("CALL sp_bs_postpaid_vat('".$cust_no."', '".$period."');");

                
				//PPN bs_detail
				$data17 = DB::table('bs_postpaid')
						->where('PERIOD', $period)
						->where('TOTALVAT', '>', '0')
						->where('CUSTOMERNO', $cust_no)
						->select('CUSTOMERNO', 'TOTALVAT', 'PERIOD')
						->get();

                foreach($data17 as $rowz17)
                {
                    $period = $rowz17->PERIOD; 
					$deskripsi = "PPN"; 
                    $vat = $rowz17->TOTALVAT; 
                    $cust = $rowz17->CUSTOMERNO; 
					
					DB::table('bs_postpaid_detail')->insert(
						[
							'CUSTOMERNO' => $cust,
							'description' => $deskripsi,
							'amount' => $vat,
							'PERIOD' => $period
						]
					);
				}
				
				
				//insert into table trans_postpaid
				//Jika data tagihan periode maintenance all terpilih sudah ada di table trans_postpaid maka tidak di insert-kan.
				$cekpay	= DB::table('trans_postpaid')->where('PERIOD', $period)->select(DB::raw('COUNT(PERIOD) AS total'))->first();
				$totalc = $cekpay->total;

				$data18 = DB::table('bs_postpaid')->where('PERIOD', $period)->where('CUSTOMERNO', $cust_no)
						->select('TOTALAMOUNT', 'TOTALVAT')
						->first();
						
				$TOTALAMOUNT = $data18->TOTALAMOUNT;
				$TOTALVAT	 = $data18->TOTALVAT;
				
				if ($totalc == 0)
				{
					//insert into table trans_postpaid
					DB::table('trans_postpaid')->insert(
						[
							'TRANSACTIONDATE' => date('Y-m-01 H:i:s'),
							'CUSTOMERNO' => $cust_no,
							'AMOUNT' => 0,
							'CRT_USER' => $userid,
							'CRT_DATE' => date('Y-m-d H:i:s'),
							'SETTLEMENT_STATUS' => 0,
							'BSNO' => $bsno1,
							'DUEDATE' => $duedate,
							'NOMINAL_TAGIHAN' => ($TOTALAMOUNT + $TOTALVAT),
							'PERIOD' => $period
						]
					);
				}

                $j++;
            }
			
            $query1 = DB::table('master_maintenance_all')
                    ->where('id', $id)
                    ->where('period', DB::raw('DATE_FORMAT(CURDATE(),"%Y%m")'))
                    ->where('flag', 1)
                    ->where('crtby', $userid)
                    ->update(['end_time' => Carbon::now('Asia/Jakarta')->toDateTimeString()]);

            $query2 = DB::table('master_maintenance_all')
                    ->where('id', $id)
                    ->where('period', DB::raw('DATE_FORMAT(CURDATE(),"%Y%m")'))
                    ->where('flag', 1)
                    ->where('crtby', $userid)
                    ->update(['updby' => $userid]);

            $query3 = DB::table('master_maintenance_all')
                    ->where('id', $id)
                    ->where('period', DB::raw('DATE_FORMAT(CURDATE(),"%Y%m")'))
                    ->where('flag', 1)
                    ->where('crtby', $userid)
                    ->update(['upddate' => Carbon::now('Asia/Jakarta')->toDateTimeString()]);

            $query4 = DB::table('master_maintenance_all')
                    ->where('id', $id)
                    ->where('period', DB::raw('DATE_FORMAT(CURDATE(),"%Y%m")'))
                    ->where('flag', 1)
                    ->where('crtby', $userid)
                    ->update(['flag' => 2]);
            
            $time = microtime();
            $time = explode(' ', $time);
            $time = $time[1] + $time[0];
            $finish = $time;
            $total_time = round(($finish - $start), 3);

			return response()->json(['success' => $total_time]);
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
}
