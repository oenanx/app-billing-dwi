<?php
namespace App\Http\Controllers;

use App\Mail\SentMail;
use App\Models\Mod_Company;
use App\Models\Valid_No_Api_Postpaid;
use App\Models\Skiptrace_Api_Postpaid;
use App\Models\IdMatch_Api_Postpaid;
use App\Models\Demography_Api_Postpaid;
use App\Models\Income_Api_Postpaid;
use App\Models\PhoneHistory_Api_Postpaid;
use App\Models\Slik_Summary_Api_Postpaid;
use App\Models\Demography_Verification_Api_Postpaid;
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
use Maatwebsite\Excel\Facades\Excel;

class RegistrationPostpaid extends Controller
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


			return view('home.registrasipostpaid.registrasi', compact('sales','customer'))->with($data1);
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
			
			$billingtype		= 2;
			
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
                $d1 = DB::table('master_company')
						->where('master_company.fapi', 1)
						->whereIn('master_company.billingtype', [1, 2])
						->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,4,1)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,4,1)) END) AS d1'))
						->first();

                $d2 = DB::table('master_company')
						->where('master_company.fapi', 1)
						->whereIn('master_company.billingtype', [1, 2])
                        ->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 1 ELSE MAX(SUBSTR(customerno,5,7))+1 END) AS d2'))
                        ->first();

                if ($d2->d2 <= 9 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA0000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA00000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA0000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA00",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA0",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA",(CASE WHEN max(SUBSTR(customerno,4,8)) IS NULL THEN 1 ELSE max(SUBSTR(customerno,4,8)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
            }

            if ($CUSTOMERTYPECODE == "B")
            {        
                $d1 = DB::table('master_company')
						->whereIn('master_company.billingtype', [1, 2])
						->where('master_company.fapi', 1)
						->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,4,1)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,4,1)) END) AS d1'))
						->first();

                $d2 = DB::table('master_company')
						->whereIn('master_company.billingtype', [1, 2])
						->where('master_company.fapi', 1)
                        ->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 1 ELSE MAX(SUBSTR(customerno,5,7))+1 END) AS d2'))
                        ->first();

                if ($d2->d2 <= 9 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA0000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA00000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA0000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA00",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA0",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA",(CASE WHEN max(SUBSTR(customerno,4,8)) IS NULL THEN 1 ELSE max(SUBSTR(customerno,4,8)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
            }

            if ($CUSTOMERTYPECODE == "R")
            {        
                $d1 = DB::table('master_company')
						->whereIn('master_company.billingtype', [1, 2])
						->where('master_company.fapi', 1)
						->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,4,1)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,4,1)) END) AS d1'))
						->first();

                $d2 = DB::table('master_company')
						->whereIn('master_company.billingtype', [1, 2])
						->where('master_company.fapi', 1)
                        ->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 1 ELSE MAX(SUBSTR(customerno,5,7))+1 END) AS d2'))
                        ->first();

                if ($d2->d2 <= 9 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA0000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA00000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA0000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA00",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA0",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('master_company')
								  ->whereIn('master_company.billingtype', [1, 2])
								  ->where('master_company.fapi', 1)
                                  ->select(DB::raw('CONCAT("DWA",(CASE WHEN max(SUBSTR(customerno,4,8)) IS NULL THEN 1 ELSE max(SUBSTR(customerno,4,8)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
            }

            $CUSTOMERNO = $CUSTNO->CUSTOMERNO;
            //dd($CUSTOMERNO);
	        
	        $active 			= $request->flive;
			$tech_pic_name		= "";
			$fcompleted			= 0;
			$activation_date	= date('Y-m-d H:i:s');
			
	        //id,customerno,company_name,phone_fax,address,address2,address3,address4,address5,zipcode,address_npwp,email_pic,email_billing,npwpno,npwpname,SALESAGENTCODE,notes,active,activation_date,create_by,create_at,update_by,update_at,discount,tech_pic_name,billing_pic_name,productid,invtypeid,fftp,fcompleted,parentid,apptypeid,billingtype,fapi

			$id1 = DB::table('master_company')->insertGetId([
				'customerno' => $CUSTOMERNO, 'company_name' => $CUSTOMERNAME, 'phone_fax' => $PHONE1, 'address' => $BILLINGADDRESS1, 'address2' => $BILLINGADDRESS2, 'address3' => $BILLINGADDRESS3, 'address4' => $BILLINGADDRESS4, 'address5' => $BILLINGADDRESS5, 'zipcode' => $ZIPCODE, 'address_npwp' => $NPWPADDRESS, 'email_pic' => $EMAIL, 'email_billing' => $EMAIL, 'npwpno' => $NPWP, 'npwpname' => $COMPANYNAME, 'SALESAGENTCODE' => $SALESAGENTCODE, 'notes' => $REMARKS, 'active' => $active, 'activation_date' => $activation_date, 'create_by' => $create_by, 'create_at' => $create_at, 'discount' => $DISCOUNT, 'tech_pic_name' => $tech_pic_name, 'billing_pic_name' => $ATTENTION, 'productid' => 17, 'invtypeid' => $INVTYPEID, 'fftp' => 0, 'fcompleted' => $fcompleted, 'parentid' => $PARENTID, 'apptypeid' => 1, 'billingtype' => $billingtype, 'fapi' => 1
			]);
		
			DB::connection('mysql_3')->table('master_company')->insert([
				'customerno' => $CUSTOMERNO, 'company_name' => $CUSTOMERNAME, 'phone_fax' => $PHONE1, 'address' => $BILLINGADDRESS1, 'address2' => $BILLINGADDRESS2, 'address3' => $BILLINGADDRESS3, 'address4' => $BILLINGADDRESS4, 'address5' => $BILLINGADDRESS5, 'zipcode' => $ZIPCODE, 'address_npwp' => $NPWPADDRESS, 'email_pic' => $EMAIL, 'email_billing' => $EMAIL, 'npwpno' => $NPWP, 'npwpname' => $COMPANYNAME, 'SALESAGENTCODE' => $SALESAGENTCODE, 'notes' => $REMARKS, 'active' => $active, 'activation_date' => $activation_date, 'create_by' => $create_by, 'create_at' => $create_at, 'discount' => $DISCOUNT, 'tech_pic_name' => $tech_pic_name, 'billing_pic_name' => $ATTENTION, 'productid' => 17, 'invtypeid' => $INVTYPEID, 'fftp' => 0, 'fcompleted' => $fcompleted, 'parentid' => $PARENTID, 'apptypeid' => 1, 'billingtype' => $billingtype, 'fapi' => 1
			]);
		
			DB::connection('mysql_4')->table('master_company')->insert([
				'customerno' => $CUSTOMERNO, 'company_name' => $CUSTOMERNAME, 'phone_fax' => $PHONE1, 'address' => $BILLINGADDRESS1, 'address2' => $BILLINGADDRESS2, 'address3' => $BILLINGADDRESS3, 'address4' => $BILLINGADDRESS4, 'address5' => $BILLINGADDRESS5, 'zipcode' => $ZIPCODE, 'address_npwp' => $NPWPADDRESS, 'email_pic' => $EMAIL, 'email_billing' => $EMAIL, 'npwpno' => $NPWP, 'npwpname' => $COMPANYNAME, 'SALESAGENTCODE' => $SALESAGENTCODE, 'notes' => $REMARKS, 'active' => $active, 'activation_date' => $activation_date, 'create_by' => $create_by, 'create_at' => $create_at, 'discount' => $DISCOUNT, 'tech_pic_name' => $tech_pic_name, 'billing_pic_name' => $ATTENTION, 'productid' => 17, 'invtypeid' => $INVTYPEID, 'fftp' => 0, 'fcompleted' => $fcompleted, 'parentid' => $PARENTID, 'apptypeid' => 1, 'billingtype' => $billingtype, 'fapi' => 1
			]);

			$prodapi1			= $request->prodapi1;
			$rates1				= $request->rates1;
			$prodapi2			= $request->prodapi2;
			$rates2				= $request->rates2;
			$prodapi3			= $request->prodapi3;
			$rates3				= $request->rates3;
			
			//id,customerno,product_api_id,fstatus,rates,quota,remainquota,start_trial,end_trial,created_by,created_at
			if ($prodapi1 == 1 || $prodapi1 == "1")
			{
				DB::table('master_product_api_customer')->insert([
					'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi1, 'fstatus' => 1, 'rates' => $rates1, 'created_by' => $create_by, 'created_at' => $create_at
				]);

				DB::connection('mysql_3')->table('master_product_api_customer')->insert([
					'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi1, 'fstatus' => 1, 'rates' => $rates1, 'created_by' => $create_by, 'created_at' => $create_at
				]);

				DB::connection('mysql_4')->table('master_product_api_customer')->insert([
					'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi1, 'fstatus' => 1, 'rates' => $rates1, 'created_by' => $create_by, 'created_at' => $create_at
				]);
			}
			
			if ($prodapi2 == 2 || $prodapi2 == "2")
			{
				DB::table('master_product_api_customer')->insert([
					'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi2, 'fstatus' => 1, 'rates' => $rates2, 'created_by' => $create_by, 'created_at' => $create_at
				]);

				DB::connection('mysql_3')->table('master_product_api_customer')->insert([
					'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi2, 'fstatus' => 1, 'rates' => $rates2, 'created_by' => $create_by, 'created_at' => $create_at
				]);

				DB::connection('mysql_4')->table('master_product_api_customer')->insert([
					'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi2, 'fstatus' => 1, 'rates' => $rates2, 'created_by' => $create_by, 'created_at' => $create_at
				]);
			}
			
			if ($prodapi3 == 3 || $prodapi3 == "3")
			{
				DB::table('master_product_api_customer')->insert([
					'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi3, 'fstatus' => 1, 'rates' => $rates3, 'created_by' => $create_by, 'created_at' => $create_at
				]);

				DB::connection('mysql_3')->table('master_product_api_customer')->insert([
					'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi3, 'fstatus' => 1, 'rates' => $rates3, 'created_by' => $create_by, 'created_at' => $create_at
				]);

				DB::connection('mysql_4')->table('master_product_api_customer')->insert([
					'customerno' => $CUSTOMERNO, 'product_api_id' => $prodapi3, 'fstatus' => 1, 'rates' => $rates3, 'created_by' => $create_by, 'created_at' => $create_at
				]);
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

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
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

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
    }

	public function view_services($id)
    {
        if(Session::get('userid'))
        {
			$data = DB::table('master_product_api_customer')
					->where('master_product_api_customer.customerno', $id)
					->where('master_company.billingtype', 2)
					->where('master_product_api.fActive', 1)
					->where('master_company.fapi', 1)
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

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
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


	    	DB::table('master_company')->where('master_company.fapi', 1)->where('id',$id)->delete(); 			
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

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
    }

	public function update_rates(Request $request)
	{
		if(Session::get('userid'))
		{
			//dd($request);
			$editid		= $request->id3; // => "2"
			$customerno	= $request->customerno3; // => "DWA00000002C"
			$prodapi1	= $request->prodapi1; // => "on"
			$rates1		= $request->rates1; // => "100"
			$prodapi2	= $request->prodapi2; // => "on"
			$rates2		= $request->rates2; // => "100"
			$prodapi3	= $request->prodapi3; // => "on"
			$rates3		= $request->rates3; // => "10"
			//dd($prodapi1);
			$create_by	= Session::get('userid'); //$request->create_by;
	        $create_at	= date('Y-m-d H:i:s');
			
			DB::select("CALL sp_backup_rates_to_history('".$customerno."');");
			DB::connection('mysql_3')->select("CALL sp_backup_rates_to_history('".$customerno."');");
			DB::connection('mysql_4')->select("CALL sp_backup_rates_to_history('".$customerno."');");
			
			if ($prodapi1 == "on")
			{
				//dd("Product API 1 == On");			
				DB::table('master_product_api_customer')->insert([
					'customerno' => $customerno, 'product_api_id' => 1, 'fstatus' => 1, 'rates' => $rates1, 'created_by' => $create_by, 'created_at' => $create_at
				]);

				DB::connection('mysql_3')->table('master_product_api_customer')->insert([
					'customerno' => $customerno, 'product_api_id' => 1, 'fstatus' => 1, 'rates' => $rates1, 'created_by' => $create_by, 'created_at' => $create_at
				]);

				DB::connection('mysql_4')->table('master_product_api_customer')->insert([
					'customerno' => $customerno, 'product_api_id' => 1, 'fstatus' => 1, 'rates' => $rates1, 'created_by' => $create_by, 'created_at' => $create_at
				]);
			}
			
			if ($prodapi2 == "on")
			{
				//dd("Product API 2 == On");
				DB::table('master_product_api_customer')->insert([
					'customerno' => $customerno, 'product_api_id' => 2, 'fstatus' => 1, 'rates' => $rates2, 'created_by' => $create_by, 'created_at' => $create_at
				]);

				DB::connection('mysql_3')->table('master_product_api_customer')->insert([
					'customerno' => $customerno, 'product_api_id' => 2, 'fstatus' => 1, 'rates' => $rates2, 'created_by' => $create_by, 'created_at' => $create_at
				]);

				DB::connection('mysql_4')->table('master_product_api_customer')->insert([
					'customerno' => $customerno, 'product_api_id' => 2, 'fstatus' => 1, 'rates' => $rates2, 'created_by' => $create_by, 'created_at' => $create_at
				]);
			}
			
			
			if ($prodapi3 == "on")
			{
				//dd("Product API 3 == On");
				DB::table('master_product_api_customer')->insert([
					'customerno' => $customerno, 'product_api_id' => 3, 'fstatus' => 1, 'rates' => $rates3, 'created_by' => $create_by, 'created_at' => $create_at
				]);

				DB::connection('mysql_3')->table('master_product_api_customer')->insert([
					'customerno' => $customerno, 'product_api_id' => 3, 'fstatus' => 1, 'rates' => $rates3, 'created_by' => $create_by, 'created_at' => $create_at
				]);

				DB::connection('mysql_4')->table('master_product_api_customer')->insert([
					'customerno' => $customerno, 'product_api_id' => 3, 'fstatus' => 1, 'rates' => $rates3, 'created_by' => $create_by, 'created_at' => $create_at
				]);
			}

			return back()
	            ->with('success','Master Product - Rates was updated successfully.');
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

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
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
			return view('home.master_postpaid.viewusage', compact('custno','produk'))->with($data);
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
				if ($request->ajax()) 
				{
					$data = QueryBuilder::for(Valid_No_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('(CASE WHEN success = 1 THEN "SUCCESS" ELSE "FAILED" END) AS status_hit'),DB::raw('phone_number AS data_input'),DB::raw('created_at AS tgl_hit'))
							->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
							->orderBy('id','DESC')
							->paginate($request->query('perpage', 1000000))
							->appends(request()->query());

					return response()->paginator($data);
				}
			}
			
			if ($product == 2) //Skiptrace API
			{
				if ($request->ajax()) 
				{
					$data = QueryBuilder::for(Skiptrace_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('nik AS data_input'),DB::raw('created_at AS tgl_hit'))
							->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
							->orderBy('id','DESC')
							->paginate($request->query('perpage', 1000000))
							->appends(request()->query());

					return response()->paginator($data);
				}
			}
			
			if ($product == 3) //Id. Match API
			{
				if ($request->ajax()) 
				{
					$data = QueryBuilder::for(IdMatch_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('nik AS data_input'),DB::raw('created_at AS tgl_hit'))
							->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
							->orderBy('id','DESC')
							->paginate($request->query('perpage', 1000000))
							->appends(request()->query());

					return response()->paginator($data);
				}
			}
			
			/*if ($product == 4) //Reverse Skiptrace API
			{
				if ($request->ajax()) 
				{
					$data = QueryBuilder::for(Mod_Trx_FTP::class)

							->orderBy('trx_ftp.id','DESC')
							->paginate($request->query('perpage', 1000000))
							->appends(request()->query());

					return response()->paginator($data);
				}
			}*/
			
			if ($product == 5) //Demography API
			{
				if ($request->ajax()) 
				{
					$data = QueryBuilder::for(Demography_Api_Postpaid::class)
							->where('ftype', 2)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('nik AS data_input'),DB::raw('created_at AS tgl_hit'))
							->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
							->orderBy('id','DESC')
							->paginate($request->query('perpage', 1000000))
							->appends(request()->query());

					return response()->paginator($data);
				}
			}
			
			if ($product == 6) //Income Verification API
			{
				if ($request->ajax()) 
				{
					$data = QueryBuilder::for(Income_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('nik AS data_input'),DB::raw('created_at AS tgl_hit'))
							->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
							->orderBy('id','DESC')
							->paginate($request->query('perpage', 1000000))
							->appends(request()->query());

					return response()->paginator($data);
				}
			}
			
			if ($product == 7) //Phone History API
			{
				if ($request->ajax()) 
				{
					$data = QueryBuilder::for(PhoneHistory_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('(CASE WHEN phone_no = "" THEN phone_md5 ELSE phone_no END) AS data_input'),DB::raw('created_at AS tgl_hit'))
							->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
							->orderBy('id','DESC')
							->paginate($request->query('perpage', 1000000))
							->appends(request()->query());

					return response()->paginator($data);
				}
			}
			
			if ($product == 8) //SLIK API
			{
				if ($request->ajax()) 
				{
					$data = QueryBuilder::for(Slik_Summary_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('nik AS data_input'), DB::raw('created_at AS tgl_hit'))
							->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
							->orderBy('id','DESC')
							->paginate($request->query('perpage', 1000000))
							->appends(request()->query());

					return response()->paginator($data);
				}
			}
			
			if ($product == 9) //Id. Verification API
			{
				if ($request->ajax()) 
				{
					$data = QueryBuilder::for(Demography_Verification_Api_Postpaid::class)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('nik AS data_input'), DB::raw('created_at AS tgl_hit'))
							->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
							->orderBy('id','DESC')
							->paginate($request->query('perpage', 1000000))
							->appends(request()->query());

					return response()->paginator($data);
				}
			}
			
			if ($product == 10) //Demography Foto API
			{
				if ($request->ajax()) 
				{
					$data = QueryBuilder::for(Demography_Api_Postpaid::class)
							->where('ftype', 1)
							->where('customerno', $customerno)
							->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
							->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('nik AS data_input'), DB::raw('created_at AS tgl_hit'))
							->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
							->orderBy('id','DESC')
							->paginate($request->query('perpage', 1000000))
							->appends(request()->query());

					return response()->paginator($data);
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
				$data = DB::connection('mysql_4')->select("CALL View_Usage_Customer_Postpaid_Monthly('".$customerno."', '".$periode."');");

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

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}		

	public function downloadlog(Request $request, $params)
    {
        if(Session::get('userid'))
		{
			$pieces		= explode(";", $params);
			$periode	= $pieces[0];
			$product	= $pieces[1];
			$customerno	= $pieces[2];

			if ($product == 1) //Validation API
			{
				$data = QueryBuilder::for(Valid_No_Api_Postpaid::class)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id',DB::raw('(CASE WHEN success = 1 THEN "SUCCESS" ELSE "FAILED" END) AS status_hit'),DB::raw('phone_number AS data_input'),DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogPostpaid1($data), 'Log_DataWiz_API_Postpaid_Validation_No_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			if ($product == 2) //Skiptrace API
			{
				$data = QueryBuilder::for(Skiptrace_Api_Postpaid::class)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('nik AS data_input'),DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogPostpaid2($data), 'Log_DataWiz_API_Postpaid_Skiptrace_No_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			if ($product == 3) //Id. Match API
			{
				$data = QueryBuilder::for(IdMatch_Api_Postpaid::class)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('nik AS data_input'),DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogPostpaid3($data), 'Log_DataWiz_API_Postpaid_Id._Match_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			/*if ($product == 4) //Reverse Skiptrace API
			{
				$data = QueryBuilder::for(Mod_Trx_FTP::class)

						->orderBy('trx_ftp.id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogPostpaid4($data), 'Log_DataWiz_API_Postpaid_Reverse_Skiptrace_'.$customerno.'_'.$periode.'.xlsx');
			}*/
			
			if ($product == 5) //Demography API
			{
				$data = QueryBuilder::for(Demography_Api_Postpaid::class)
						->where('ftype', 2)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('nik AS data_input'),DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogPostpaid5($data), 'Log_DataWiz_API_Postpaid_Demography_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			if ($product == 6) //Income Verification API
			{
				$data = QueryBuilder::for(Income_Api_Postpaid::class)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('nik AS data_input'),DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogPostpaid6($data), 'Log_DataWiz_API_Postpaid_Income_Verification_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			if ($product == 7) //Phone History API
			{
				$data = QueryBuilder::for(PhoneHistory_Api_Postpaid::class)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('(CASE WHEN phone_no = "" THEN phone_md5 ELSE phone_no END) AS data_input'),DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogPostpaid7($data), 'Log_DataWiz_API_Postpaid_Phone_History_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			if ($product == 8) //SLIK API
			{
				$data = QueryBuilder::for(Slik_Summary_Api_Postpaid::class)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('nik AS data_input'), DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogPostpaid8($data), 'Log_DataWiz_API_Postpaid_Slik_Summary_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			if ($product == 9) //Id. Verification API
			{
				$data = QueryBuilder::for(Demography_Verification_Api_Postpaid::class)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('nik AS data_input'), DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogPostpaid9($data), 'Log_DataWiz_API_Postpaid_Id._Verification_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			if ($product == 10) //Demography Foto API
			{
				$data = QueryBuilder::for(Demography_Api_Postpaid::class)
						->where('ftype', 1)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('nik AS data_input'), DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogPostpaid10($data), 'Log_DataWiz_API_Postpaid_Demography_Photo_'.$customerno.'_'.$periode.'.xlsx');
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

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}		
}
