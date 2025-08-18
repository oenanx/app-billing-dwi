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

            $delskiptrace	= DB::table('sum_demography_photo_postpaid')->where('sum_demography_photo_postpaid.period',$period2)->delete();
            $delskiptrace	= DB::table('sum_demography_postpaid')->where('sum_demography_postpaid.period',$period2)->delete();
            $delskiptrace	= DB::table('sum_idmatch_postpaid')->where('sum_idmatch_postpaid.period',$period2)->delete();
            $delskiptrace	= DB::table('sum_idverification_postpaid')->where('sum_idverification_postpaid.period',$period2)->delete();
            $delskiptrace	= DB::table('sum_income_postpaid')->where('sum_income_postpaid.period',$period2)->delete();
            $delskiptrace	= DB::table('sum_phonehistory_postpaid')->where('sum_phonehistory_postpaid.period',$period2)->delete();
            $delskiptrace	= DB::table('sum_sliksummary_postpaid')->where('sum_sliksummary_postpaid.period',$period2)->delete();
            $delskiptrace	= DB::table('sum_reverse_postpaid')->where('sum_reverse_postpaid.period',$period2)->delete();
			
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
			$get2  = DB::connection('mysql_4')->select("CALL sp_trx_phonehistory_monthly('".$period2."');");
			//dd($get);
			foreach($get2 as $row2)
			{
				$period			= $row2->period;
				$customerno		= $row2->customerno;
				$sum_noapi_id	= $row2->sum_noapi_id;
				$get_date		= $row2->get_date;

				$rate2 			= DB::table('master_product_api_customer')->where('customerno', $customerno)->where('product_api_id', 7)->select('rates')->first();
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
						'sum_noapi_id'	=> $sum_noapi_id,
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
            $newstatementdate = date('Y-m-d', strtotime("last day", strtotime($period5tgl)));
            $laststatementdate = $period2tgl;
            $paymentdatevat = date('Y-m-d', strtotime("last day", strtotime($period5tgl)));
            //dd($paymentdatevat);

            $j = 1;
            $customer = DB::select('SELECT distinct (customerno) cust_no FROM master_company WHERE fapi = 1 AND customerno != "" AND billingtype = 2 order by customerno;');
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

				//Usage Validation Number API Postpaid
				$data_a = DB::table('sum_validno_postpaid')
						->where('sum_validno_postpaid.customerno', $cust_no)
						->where('sum_validno_postpaid.period', $period2)
						->select('sum_validno_postpaid.customerno', DB::raw('"Validation Number API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
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

				//Usage Skiptrace API Postpaid
				$data_b = DB::table('sum_skiptrace_postpaid')
						->where('sum_skiptrace_postpaid.customerno', $cust_no)
						->where('sum_skiptrace_postpaid.period', $period2)
						->select('sum_skiptrace_postpaid.customerno', DB::raw('"Skiptrace API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
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

				//USAGE demography_photo API POSTPAID FROM Dashboard
				$data_c = DB::table('sum_demography_photo_postpaid')
						->where('sum_demography_photo_postpaid.customerno', $cust_no)
						->where('sum_demography_photo_postpaid.period', $period2)
						->select('sum_demography_photo_postpaid.customerno', DB::raw('"Demography Photo Check API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
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

				//USAGE demography API POSTPAID FROM Dashboard
				$data_d = DB::table('sum_demography_postpaid')
						->where('sum_demography_postpaid.customerno', $cust_no)
						->where('sum_demography_postpaid.period', $period2)
						->select('sum_demography_postpaid.customerno', DB::raw('"Demography Check API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
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

				//USAGE idmatch API POSTPAID FROM Dashboard
				$data_e = DB::table('sum_idmatch_postpaid')
						->where('sum_idmatch_postpaid.customerno', $cust_no)
						->where('sum_idmatch_postpaid.period', $period2)
						->select('sum_idmatch_postpaid.customerno', DB::raw('"Id. Match API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
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

				//USAGE idverification API POSTPAID FROM Dashboard
				$data_f = DB::table('sum_idverification_postpaid')
						->where('sum_idverification_postpaid.customerno', $cust_no)
						->where('sum_idverification_postpaid.period', $period2)
						->select('sum_idverification_postpaid.customerno', DB::raw('"Id. Verification API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
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

				//USAGE income API POSTPAID FROM Dashboard
				$data_g = DB::table('sum_income_postpaid')
						->where('sum_income_postpaid.customerno', $cust_no)
						->where('sum_income_postpaid.period', $period2)
						->select('sum_income_postpaid.customerno', DB::raw('"Income Estimate API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
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

				//USAGE phonehistory API POSTPAID FROM Dashboard
				$data_h = DB::table('sum_phonehistory_postpaid')
						->where('sum_phonehistory_postpaid.customerno', $cust_no)
						->where('sum_phonehistory_postpaid.period', $period2)
						->select('sum_phonehistory_postpaid.customerno', DB::raw('"Phone History API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
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

				//USAGE sliksummary API POSTPAID FROM Dashboard
				$data_i = DB::table('sum_sliksummary_postpaid')
						->where('sum_sliksummary_postpaid.customerno', $cust_no)
						->where('sum_sliksummary_postpaid.period', $period2)
						->select('sum_sliksummary_postpaid.customerno', DB::raw('"Credit History API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
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

				//USAGE reverse API POSTPAID FROM Dashboard
				$data_j = DB::table('sum_reverse_postpaid')
						->where('sum_reverse_postpaid.customerno', $cust_no)
						->where('sum_reverse_postpaid.period', $period2)
						->select('sum_reverse_postpaid.customerno', DB::raw('"Reverse Skiptrace API Postpaid" AS deskripsi'), DB::raw('totalamount as total'))
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
