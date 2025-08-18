<?php
namespace App\Http\Controllers;

use App\Mail\SentMail;
use App\Models\Mod_CompanyApi;
use App\Models\Mod_ProductsApi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;

class RegistrationPrepaid extends Controller
{
    public function newregistration(Request $request)
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

            $data1['sales'] = DB::select('select SALESAGENTCODE,SALESAGENTNAME from billing_ats.salesagent where STATUS = 1 ORDER BY SALESAGENTNAME;');

            //$data1['product'] = DB::select('select id, product from master_product_paket ORDER BY id;');

            //$data1['packet'] = DB::select('select id, nama_paket from master_paket ORDER BY id;');

            //$data1['ratestype'] = DB::select('select id, ratetype from master_ratestype ORDER BY id;');

            //$data1['nonstd'] = DB::select('select id, basedon from master_non_std_basedon ORDER BY id;');

            $data1['groups'] = DB::select('SELECT DISTINCT ID id, PARENT_CUSTOMER parent from billing_ats.customer_parent ORDER BY PARENT_CUSTOMER DESC;');


            $data1['paymethod'] = DB::select('select PAYMENTCODE,PAYMENTMETHOD from billing_ats.paymentmethod ORDER BY PAYMENTCODE;');


			return view('home.registrasiprepaid.registrasi', compact('sales','customer'))->with($data1);
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

	public function InsertReg(Request $request)
	{
		if(Session::get('userid'))
		{
			//dd($request);
			$PARENTID			= $request->PARENTID;
			$CUSTOMERNAME		= $request->CUSTOMERNAME;
			$ACTIVATIONDATE		= $request->ACTIVATIONDATE;
			$STATUSCODE			= $request->STATUSCODE;
			$DISTERMDATE		= $request->DISTERMDATE;
			$DISCOUNT			= "N"; //$request->DISCOUNT;
			$SALESAGENTCODE		= $request->SALESAGENTCODE;
			$CUSTOMERTYPECODE	= $request->CUSTOMERTYPECODE;
			$PAYMENTCODE		= $request->PAYMENTCODE;
			$SPLIT				= 0;   //$request->SPLIT;
			$ATTENTION			= $request->ATTENTION;
			$PHONE1				= $request->PHONE1;
			$PHONE2				= $request->PHONE2;
			$EMAIL				= $request->EMAIL;
			$VATFREE			= $request->VATFREE;
			$SENDVAT			= $request->SENDVAT;
			$NPWP				= $request->NPWP;
			$COMPANYNAME		= $request->COMPANYNAME;
			$BILLINGADDRESS1	= $request->BILLINGADDRESS1;
			$BILLINGADDRESS2	= $request->BILLINGADDRESS2;
			$BILLINGADDRESS3	= $request->BILLINGADDRESS3;
			$BILLINGADDRESS4	= $request->BILLINGADDRESS4;
			$BILLINGADDRESS5	= $request->BILLINGADDRESS5;
			$ZIPCODE			= $request->ZIPCODE;
			$NPWPADDRESS		= $request->NPWPADDRESS;
			$REMARKS			= $request->REMARKS;
			$INVTYPEID			= $request->INVTYPEID;

			$fftp 				= 0;
			
			$billingtype		= 1;
			
			$CRT_USER			= Session::get('userid'); //$request->CRT_USER;
			$CRT_DATE			= date('Y-m-d H:i:s');
			$create_by			= Session::get('userid'); //$request->create_by;
	        $create_at 			= date('Y-m-d H:i:s');

            if ($DISTERMDATE == "" || empty($DISTERMDATE))
            {
                $DISTERMDATE = "1900-01-01 00:00:00";
            }

            if ($CUSTOMERTYPECODE == "C")
            {        
                $d1 = DB::table('master_company_api')
						->whereIn('master_company_api.billingtype', [1, 2])
						->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,4,1)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,4,1)) END) AS d1'))
						->first();

                $d2 = DB::table('master_company_api')
						->whereIn('master_company_api.billingtype', [1, 2])
                        ->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 1 ELSE MAX(SUBSTR(customerno,5,7))+1 END) AS d2'))
                        ->first();

                if ($d2->d2 <= 9 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA0000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA00000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA0000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA00",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA0",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA",(CASE WHEN max(SUBSTR(customerno,4,8)) IS NULL THEN 1 ELSE max(SUBSTR(customerno,4,8)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
            }

            if ($CUSTOMERTYPECODE == "B")
            {        
                $d1 = DB::table('master_company_api')
						->whereIn('master_company_api.billingtype', [1, 2])
						->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,4,1)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,4,1)) END) AS d1'))
						->first();

                $d2 = DB::table('master_company_api')
						->whereIn('master_company_api.billingtype', [1, 2])
                        ->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 1 ELSE MAX(SUBSTR(customerno,5,7))+1 END) AS d2'))
                        ->first();

                if ($d2->d2 <= 9 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA0000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA00000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA0000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA00",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA0",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA",(CASE WHEN max(SUBSTR(customerno,4,8)) IS NULL THEN 1 ELSE max(SUBSTR(customerno,4,8)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
            }

            if ($CUSTOMERTYPECODE == "R")
            {        
                $d1 = DB::table('master_company_api')
						->whereIn('master_company_api.billingtype', [1, 2])
						->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,4,1)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,4,1)) END) AS d1'))
						->first();

                $d2 = DB::table('master_company_api')
						->whereIn('master_company_api.billingtype', [1, 2])
                        ->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 1 ELSE MAX(SUBSTR(customerno,5,7))+1 END) AS d2'))
                        ->first();

                if ($d2->d2 <= 9 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA0000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA00000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA0000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA00",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA0",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('master_company_api')
								  ->whereIn('master_company_api.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWA",(CASE WHEN max(SUBSTR(customerno,4,8)) IS NULL THEN 1 ELSE max(SUBSTR(customerno,4,8)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
            }

            $CUSTOMERNO = $CUSTNO->CUSTOMERNO;
            //dd($CUSTOMERNO);
	        
	        $active 			= $request->flive;
			$tech_pic_name		= "";
			$fcompleted			= 0;
			if ($active == 1 || $active == "1")
			{
				$activation_date	= date('Y-m-d H:i:s');
			}
			else
			{
				$activation_date	= "";
			}
	        //id,customerno,company_name,phone_fax,address,address2,address3,address4,address5,zipcode,address_npwp,email_pic,email_billing,npwpno,npwpname,SALESAGENTCODE,notes,active,activation_date,create_by,create_at,update_by,update_at,discount,tech_pic_name,billing_pic_name,productid,invtypeid,fftp,fcompleted,parentid,apptypeid,billingtype

			$id1 = DB::table('master_company_api')->insertGetId([
				'customerno' => $CUSTOMERNO, 'company_name' => $CUSTOMERNAME, 'phone_fax' => $PHONE1, 'address' => $BILLINGADDRESS1, 'address2' => $BILLINGADDRESS2, 'address3' => $BILLINGADDRESS3, 'address4' => $BILLINGADDRESS4, 'address5' => $BILLINGADDRESS5, 'zipcode' => $ZIPCODE, 'address_npwp' => $NPWPADDRESS, 'email_pic' => $EMAIL, 'email_billing' => $EMAIL, 'npwpno' => $NPWP, 'npwpname' => $COMPANYNAME, 'SALESAGENTCODE' => $SALESAGENTCODE, 'notes' => $REMARKS, 'active' => $active, 'activation_date' => $activation_date, 'create_by' => $create_by, 'create_at' => $create_at, 'discount' => $DISCOUNT, 'tech_pic_name' => $tech_pic_name, 'billing_pic_name' => $ATTENTION, 'productid' => 17, 'invtypeid' => $INVTYPEID, 'fftp' => $fftp, 'fcompleted' => $fcompleted, 'parentid' => $PARENTID, 'apptypeid' => 1, 'billingtype' => $billingtype
			]);
		
			DB::connection('mysql_3')->table('master_company_api')->insert([
				'customerno' => $CUSTOMERNO, 'company_name' => $CUSTOMERNAME, 'phone_fax' => $PHONE1, 'address' => $BILLINGADDRESS1, 'address2' => $BILLINGADDRESS2, 'address3' => $BILLINGADDRESS3, 'address4' => $BILLINGADDRESS4, 'address5' => $BILLINGADDRESS5, 'zipcode' => $ZIPCODE, 'address_npwp' => $NPWPADDRESS, 'email_pic' => $EMAIL, 'email_billing' => $EMAIL, 'npwpno' => $NPWP, 'npwpname' => $COMPANYNAME, 'SALESAGENTCODE' => $SALESAGENTCODE, 'notes' => $REMARKS, 'active' => $active, 'activation_date' => $activation_date, 'create_by' => $create_by, 'create_at' => $create_at, 'discount' => $DISCOUNT, 'tech_pic_name' => $tech_pic_name, 'billing_pic_name' => $ATTENTION, 'productid' => 17, 'invtypeid' => $INVTYPEID, 'fftp' => $fftp, 'fcompleted' => $fcompleted, 'parentid' => $PARENTID, 'apptypeid' => 1, 'billingtype' => $billingtype
			]);
		
			DB::connection('mysql_4')->table('master_company_api')->insert([
				'customerno' => $CUSTOMERNO, 'company_name' => $CUSTOMERNAME, 'phone_fax' => $PHONE1, 'address' => $BILLINGADDRESS1, 'address2' => $BILLINGADDRESS2, 'address3' => $BILLINGADDRESS3, 'address4' => $BILLINGADDRESS4, 'address5' => $BILLINGADDRESS5, 'zipcode' => $ZIPCODE, 'address_npwp' => $NPWPADDRESS, 'email_pic' => $EMAIL, 'email_billing' => $EMAIL, 'npwpno' => $NPWP, 'npwpname' => $COMPANYNAME, 'SALESAGENTCODE' => $SALESAGENTCODE, 'notes' => $REMARKS, 'active' => $active, 'activation_date' => $activation_date, 'create_by' => $create_by, 'create_at' => $create_at, 'discount' => $DISCOUNT, 'tech_pic_name' => $tech_pic_name, 'billing_pic_name' => $ATTENTION, 'productid' => 17, 'invtypeid' => $INVTYPEID, 'fftp' => $fftp, 'fcompleted' => $fcompleted, 'parentid' => $PARENTID, 'apptypeid' => 1, 'billingtype' => $billingtype
			]);

			if ($active == 1 || $active == "1") //Jika Live
			{
				//id,customerno,product_api_id,fstatus,rates,quota,remainquota,start_trial,end_trial,created_by,created_at
				$prodapi1			= $request->prodapi1;
				$quota1				= $request->quota1;
				$rates1				= $request->rates1;
				
				$prodapi2			= $request->prodapi2;
				$quota2				= $request->quota2;
				$rates2				= $request->rates2;
				
				$prodapi3			= $request->prodapi3;
				$quota3				= $request->quota3;
				$rates3				= $request->rates3;
				
				if ($prodapi1 == 1 || $prodapi1 == "1")
				{
					DB::table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi1, 'fstatus' => 1, 'rates' => $rates1, 'quota' => $quota1,  'created_by' => $create_by, 'created_at' => $create_at
					]);

					DB::connection('mysql_3')->table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi1, 'fstatus' => 1, 'rates' => $rates1, 'quota' => $quota1, 'created_by' => $create_by, 'created_at' => $create_at
					]);

					DB::connection('mysql_4')->table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi1, 'fstatus' => 1, 'rates' => $rates1, 'quota' => $quota1, 'created_by' => $create_by, 'created_at' => $create_at
					]);
				}
				
				if ($prodapi2 == 2 || $prodapi2 == "2")
				{
					DB::table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi2, 'fstatus' => 1, 'rates' => $rates2, 'quota' => $quota2, 'created_by' => $create_by, 'created_at' => $create_at
					]);

					DB::connection('mysql_3')->table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi2, 'fstatus' => 1, 'rates' => $rates2, 'quota' => $quota2, 'created_by' => $create_by, 'created_at' => $create_at
					]);

					DB::connection('mysql_4')->table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi2, 'fstatus' => 1, 'rates' => $rates2, 'quota' => $quota2, 'created_by' => $create_by, 'created_at' => $create_at
					]);
				}
				
				if ($prodapi3 == 3 || $prodapi3 == "3")
				{
					DB::table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi3, 'fstatus' => 1, 'rates' => $rates3, 'quota' => $quota3, 'created_by' => $create_by, 'created_at' => $create_at
					]);

					DB::connection('mysql_3')->table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi3, 'fstatus' => 1, 'rates' => $rates3, 'quota' => $quota3, 'created_by' => $create_by, 'created_at' => $create_at
					]);

					DB::connection('mysql_4')->table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi3, 'fstatus' => 1, 'rates' => $rates3, 'quota' => $quota3, 'created_by' => $create_by, 'created_at' => $create_at
					]);
				}
			}
			
			
			if ($active == 2 || $active == "2") //Jika Trial
			{
				//id,customerno,product_api_id,fstatus,rates,quota,remainquota,start_trial,end_trial,created_by,created_at
				$prodapitrial1		= $request->prodapitrial1;
				$quotatrial1		= $request->quotatrial1;
				$ratetrial1			= $request->ratetrial1;
				$start_trial1		= $request->start_trial1;
				$end_trial1			= $request->end_trial1;
				$prodapitrial2		= $request->prodapitrial2;
				$quotatrial2		= $request->quotatrial2;
				$ratetrial2			= $request->ratetrial2;
				$start_trial2		= $request->start_trial2;
				$end_trial2			= $request->end_trial2;
				$prodapitrial3		= $request->prodapitrial3;
				$quotatrial3		= $request->quotatrial3;
				$ratetrial3			= $request->ratetrial3;
				$start_trial3		= $request->start_trial3;
				$end_trial3			= $request->end_trial3;
				
				if ($prodapitrial1 == 1 || $prodapitrial1 == "1")
				{
					DB::table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapitrial1, 'fstatus' => 2, 'rates' => $ratetrial1, 'quota' => $quotatrial1, 'start_trial' => $start_trial1, 'end_trial' => $end_trial1, 'created_by' => $create_by, 'created_at' => $create_at
					]);

					DB::connection('mysql_3')->table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapitrial1, 'fstatus' => 2, 'rates' => $ratetrial1, 'quota' => $quotatrial1, 'start_trial' => $start_trial1, 'end_trial' => $end_trial1, 'created_by' => $create_by, 'created_at' => $create_at
					]);

					DB::connection('mysql_4')->table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapitrial1, 'fstatus' => 2, 'rates' => $ratetrial1, 'quota' => $quotatrial1, 'start_trial' => $start_trial1, 'end_trial' => $end_trial1, 'created_by' => $create_by, 'created_at' => $create_at
					]);
				}
				
				if ($prodapitrial2 == 2 || $prodapitrial2 == "2")
				{
					DB::table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapitrial2, 'fstatus' => 2, 'rates' => $ratetrial2, 'quota' => $quotatrial2, 'start_trial' => $start_trial2, 'end_trial' => $end_trial2, 'created_by' => $create_by, 'created_at' => $create_at
					]);

					DB::connection('mysql_3')->table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapitrial2, 'fstatus' => 2, 'rates' => $ratetrial2, 'quota' => $quotatrial2, 'start_trial' => $start_trial2, 'end_trial' => $end_trial2, 'created_by' => $create_by, 'created_at' => $create_at
					]);

					DB::connection('mysql_4')->table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapitrial2, 'fstatus' => 2, 'rates' => $ratetrial2, 'quota' => $quotatrial2, 'start_trial' => $start_trial2, 'end_trial' => $end_trial2, 'created_by' => $create_by, 'created_at' => $create_at
					]);
				}
				
				if ($prodapitrial3 == 3 || $prodapitrial3 == "3")
				{					
					DB::table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapitrial3, 'fstatus' => 2, 'rates' => $ratetrial3, 'quota' => $quotatrial3, 'start_trial' => $start_trial3, 'end_trial' => $end_trial3, 'created_by' => $create_by, 'created_at' => $create_at
					]);

					DB::connection('mysql_3')->table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapitrial3, 'fstatus' => 2, 'rates' => $ratetrial3, 'quota' => $quotatrial3, 'start_trial' => $start_trial3, 'end_trial' => $end_trial3, 'created_by' => $create_by, 'created_at' => $create_at
					]);

					DB::connection('mysql_4')->table('master_product_api_customer')->insert([
						'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapitrial3, 'fstatus' => 2, 'rates' => $ratetrial3, 'quota' => $quotatrial3, 'start_trial' => $start_trial3, 'end_trial' => $end_trial3, 'created_by' => $create_by, 'created_at' => $create_at
					]);
				}
			}
			
		
			//return back()->with('success','Master Company saved successfully.');
			return response()->json(['success' => 'Master Company saved successfully.']);
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

	public function view_cust($id)
    {
        if(Session::get('userid'))
        {
			$data = DB::table('master_company_api')
					->where('master_company_api.id', $id)
					->where('master_company_api.billingtype', 1)
					->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company_api.SALESAGENTCODE')	
					->select('master_company_api.id','master_company_api.customerno','company_name','address','address2','address3','address4','address5','zipcode','address_npwp','phone_fax','email_pic','email_billing','npwpno','npwpname','master_company_api.SALESAGENTCODE','SALESAGENTNAME','activation_date','notes',DB::raw('(master_company_api.active) as factive'), DB::raw('(CASE WHEN master_company_api.active = 1 THEN "Active" WHEN master_company_api.active = 2 THEN "Trial" ELSE "Inactive" END) as active'))
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
					->where('master_company_api.billingtype', 1)
					->where('master_product_api.fActive', 1)
					->join('master_product_api', 'master_product_api.id', '=', 'master_product_api_customer.product_api_id')	
					->join('master_company_api', 'master_company_api.customerno', '=', 'master_product_api_customer.customerno')	
					->select('master_product_api_customer.customerno','master_company_api.company_name','master_product_api_customer.product_api_id','master_product_api.product',DB::raw('(master_company_api.active) as factive'),DB::raw('(CASE WHEN master_company_api.active = 1 THEN "Active" WHEN master_company_api.active = 2 THEN "Trial" ELSE "Inactive" END) as active'),'master_product_api_customer.rates','master_product_api_customer.quota','master_product_api_customer.start_trial','master_product_api_customer.end_trial')
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

    public function deleteReg($id)
	{
		if(Session::get('userid'))
		{
			$data1 	= DB::table('master_company')->where('id', $id)->select('customerno')->first();
			$custno = $data1->customerno;

	    	DB::table('master_ftp')->where('companyid',$id)->delete(); 			
	    	DB::connection('mysql_3')->table('master_ftp')->where('companyid',$id)->delete(); 
			
			
	    	DB::table('master_rates')->where('customerno',$custno)->delete(); 
	    	DB::connection('mysql_3')->table('master_rates')->where('customerno',$custno)->delete(); 


	    	DB::table('master_paket_customer')->where('customerno',$custno)->delete(); 			
	    	DB::connection('mysql_3')->table('master_paket_customer')->where('customerno',$custno)->delete(); 


	    	DB::table('master_company')->where('id',$id)->delete(); 			
	    	DB::connection('mysql_3')->table('master_company')->where('id',$id)->delete(); 
			
	        return back()
	        		->with('success','All Data Company was deleted successfully.');
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

	public function update_cust(Request $request)
	{
		if(Session::get('userid'))
        {
			$data 				= array();
			$editid				= $request->id2;
			$current_date_time 	= date('Y-m-d H:i:s');
			//dd($editid);
			
			$data = array(
				'company_name' => $request->cpy_name2, 
				'address' => $request->cpy_addr21, 
				'address2' => $request->cpy_addr22, 
				'address3' => $request->cpy_addr23, 
				'address4' => $request->cpy_addr24, 
				'address5' => $request->cpy_addr25, 
				'zipcode' => $request->cpy_zipcode2, 
				'npwpno' => $request->npwpno2,
				'npwpname' => $request->npwpname2,
				'address_npwp' => $request->bill_addr2, 
				'phone_fax' => $request->phone2, 
				'email_pic' => $request->cpy_email2, 
				'email_billing' => $request->bill_email2, 
				'SALESAGENTCODE' => $request->sales2,
				'notes'  => $request->notes2, 
				'activation_date' => $request->startdate2, 
				'active' => $request->status2,
				'update_by' => $request->updby,
				'isrecord' => $request->record2,
				'sized' => $request->sized2,
				'userftp' => $request->userftp2,
				'passwdftp' => $request->passwdftp2
			);

			Mod_Company::Update_Cpy($editid, $data);

			return back()
	            ->with('success','Master Customer was updated successfully.');
		}
		else
		{
            //jika session belum terdaftar, maka redirect ke halaman login
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

	public function update_services(Request $request)
	{
		
	}
	
	public function topup_token(Request $request)
	{
		
	}
}
