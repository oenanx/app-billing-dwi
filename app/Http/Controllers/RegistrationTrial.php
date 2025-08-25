<?php
namespace App\Http\Controllers;

use App\Mail\SentMail;
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
use Yajra\Datatables\Datatables;


class RegistrationTrial extends Controller
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
			
			$produk = DB::connection('mysql_4')->table('datawhiz_app.master_product_api')->where('fActive', 1)->select('id', 'product')->orderBy('id','ASC')->get();
			$tproduk = DB::connection('mysql_4')->table('datawhiz_app.master_product_api')->where('fActive', 1)->select(DB::raw('COUNT(id) AS tot_data'))->first();
			$totaldata = $tproduk->tot_data;
            $data1['sales'] = DB::select('select SALESAGENTCODE,SALESAGENTNAME from billing_ats.salesagent where STATUS = 1 ORDER BY SALESAGENTNAME;');

            //$data1['product'] = DB::select('select id, product from master_product_paket ORDER BY id;');

            //$data1['packet'] = DB::select('select id, nama_paket from master_paket ORDER BY id;');

            //$data1['ratestype'] = DB::select('select id, ratetype from master_ratestype ORDER BY id;');

            //$data1['nonstd'] = DB::select('select id, basedon from master_non_std_basedon ORDER BY id;');

            $data1['groups'] = DB::select('SELECT DISTINCT ID id, PARENT_CUSTOMER parent from billing_ats.customer_parent ORDER BY PARENT_CUSTOMER DESC;');

            $data1['paymethod'] = DB::select('select PAYMENTCODE,PAYMENTMETHOD from billing_ats.paymentmethod ORDER BY PAYMENTCODE;');


			return view('home.registrasitrial.registrasi', compact('sales','produk','totaldata'))->with($data1);
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
			$tproduk = DB::connection('mysql_4')->table('datawhiz_app.master_product_api')->where('fActive', 1)->select(DB::raw('COUNT(id) AS tot_data'))->first();
			$totaldata = $tproduk->tot_data;
			//for ($x = 1; $x <= $totaldata; $x++)
			//{
			//	echo "apitrial".$x." : ".$request->apitrial[$x];
			//	echo "<br />";
			//}
			//dd("test");
			
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
			$INVTYPEID			= 1; //$request->INVTYPEID;

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
                $d1 = DB::table('master_company')
						->where('fapi', 1)
						->whereIn('master_company.billingtype', [1, 2])
						->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,4,1)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,4,1)) END) AS d1'))
						->first();

                $d2 = DB::table('master_company')
						->where('fapi', 1)
						->whereIn('master_company.billingtype', [1, 2])
                        ->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 1 ELSE MAX(SUBSTR(customerno,5,7))+1 END) AS d2'))
                        ->first();

                if ($d2->d2 <= 9 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH0000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH00000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH0000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH00",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH0",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH",(CASE WHEN max(SUBSTR(customerno,4,8)) IS NULL THEN 1 ELSE max(SUBSTR(customerno,4,8)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
            }

            if ($CUSTOMERTYPECODE == "B")
            {        
                $d1 = DB::table('master_company')
						->where('fapi', 1)
						->whereIn('master_company.billingtype', [1, 2])
						->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,4,1)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,4,1)) END) AS d1'))
						->first();

                $d2 = DB::table('master_company')
						->where('fapi', 1)
						->whereIn('master_company.billingtype', [1, 2])
                        ->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 1 ELSE MAX(SUBSTR(customerno,5,7))+1 END) AS d2'))
                        ->first();

                if ($d2->d2 <= 9 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH0000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH00000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH0000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH00",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH0",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH",(CASE WHEN max(SUBSTR(customerno,4,8)) IS NULL THEN 1 ELSE max(SUBSTR(customerno,4,8)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
            }

            if ($CUSTOMERTYPECODE == "R")
            {        
                $d1 = DB::table('master_company')
						->where('fapi', 1)
						->whereIn('master_company.billingtype', [1, 2])
						->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,4,1)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,4,1)) END) AS d1'))
						->first();

                $d2 = DB::table('master_company')
						->where('fapi', 1)
						->whereIn('master_company.billingtype', [1, 2])
                        ->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 1 ELSE MAX(SUBSTR(customerno,5,7))+1 END) AS d2'))
                        ->first();

                if ($d2->d2 <= 9 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH0000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH00000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH0000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH00",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH0",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('master_company')
								  ->where('fapi', 1)
								  ->whereIn('master_company.billingtype', [1, 2])
                                  ->select(DB::raw('CONCAT("DWH",(CASE WHEN max(SUBSTR(customerno,4,8)) IS NULL THEN 1 ELSE max(SUBSTR(customerno,4,8)) END)+1,"R") AS CUSTOMERNO'))
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
			
	        //id,customerno,company_name,phone_fax,address,address2,address3,address4,address5,zipcode,address_npwp,email_pic,email_billing,npwpno,npwpname,SALESAGENTCODE,notes,active,activation_date,create_by,create_at,update_by,update_at,discount,tech_pic_name,billing_pic_name,productid,invtypeid,fftp,fcompleted,concurrent,parentid,apptypeid,start_trial,end_trial,quotatrial,remainquota,billingtype,fapi

			DB::table('master_company')->insert([
				'customerno' => $CUSTOMERNO, 'company_name' => $CUSTOMERNAME, 'phone_fax' => $PHONE1, 'address' => $BILLINGADDRESS1, 'address2' => $BILLINGADDRESS2, 'address3' => $BILLINGADDRESS3, 'address4' => $BILLINGADDRESS4, 'address5' => $BILLINGADDRESS5, 'zipcode' => $ZIPCODE, 'address_npwp' => $NPWPADDRESS, 'email_pic' => $EMAIL, 'email_billing' => $EMAIL, 'npwpno' => $NPWP, 'npwpname' => $COMPANYNAME, 'SALESAGENTCODE' => $SALESAGENTCODE, 'notes' => $REMARKS, 'active' => $active, 'activation_date' => $activation_date, 'create_by' => $create_by, 'create_at' => $create_at, 'discount' => $DISCOUNT, 'tech_pic_name' => $tech_pic_name, 'billing_pic_name' => $ATTENTION, 'productid' => 18, 'invtypeid' => $INVTYPEID, 'fftp' => $fftp, 'fcompleted' => $fcompleted, 'concurrent' => 0, 'parentid' => $PARENTID, 'apptypeid' => 1, 'billingtype' => 1, 'fapi' => 1
			]);
		
			DB::connection('mysql_3')->table('master_company')->insert([
				'customerno' => $CUSTOMERNO, 'company_name' => $CUSTOMERNAME, 'phone_fax' => $PHONE1, 'address' => $BILLINGADDRESS1, 'address2' => $BILLINGADDRESS2, 'address3' => $BILLINGADDRESS3, 'address4' => $BILLINGADDRESS4, 'address5' => $BILLINGADDRESS5, 'zipcode' => $ZIPCODE, 'address_npwp' => $NPWPADDRESS, 'email_pic' => $EMAIL, 'email_billing' => $EMAIL, 'npwpno' => $NPWP, 'npwpname' => $COMPANYNAME, 'SALESAGENTCODE' => $SALESAGENTCODE, 'notes' => $REMARKS, 'active' => $active, 'activation_date' => $activation_date, 'create_by' => $create_by, 'create_at' => $create_at, 'discount' => $DISCOUNT, 'tech_pic_name' => $tech_pic_name, 'billing_pic_name' => $ATTENTION, 'productid' => 18, 'invtypeid' => $INVTYPEID, 'fftp' => $fftp, 'fcompleted' => $fcompleted, 'concurrent' => 0, 'parentid' => $PARENTID, 'apptypeid' => 1, 'billingtype' => 1, 'fapi' => 1
			]);
		
			DB::connection('mysql_4')->table('master_company')->insert([
				'customerno' => $CUSTOMERNO, 'company_name' => $CUSTOMERNAME, 'phone_fax' => $PHONE1, 'address' => $BILLINGADDRESS1, 'address2' => $BILLINGADDRESS2, 'address3' => $BILLINGADDRESS3, 'address4' => $BILLINGADDRESS4, 'address5' => $BILLINGADDRESS5, 'zipcode' => $ZIPCODE, 'address_npwp' => $NPWPADDRESS, 'email_pic' => $EMAIL, 'email_billing' => $EMAIL, 'npwpno' => $NPWP, 'npwpname' => $COMPANYNAME, 'SALESAGENTCODE' => $SALESAGENTCODE, 'notes' => $REMARKS, 'active' => $active, 'activation_date' => $activation_date, 'create_by' => $create_by, 'create_at' => $create_at, 'discount' => $DISCOUNT, 'tech_pic_name' => $tech_pic_name, 'billing_pic_name' => $ATTENTION, 'productid' => 18, 'invtypeid' => $INVTYPEID, 'fftp' => $fftp, 'fcompleted' => $fcompleted, 'concurrent' => 0, 'parentid' => $PARENTID, 'apptypeid' => 1, 'billingtype' => 1, 'fapi' => 1
			]);

			/*
			if ($active == 1 || $active == "1") //Jika Live
			{
				//id,customerno,product_api_id,fstatus,rates,quota,remainquota,start_trial,end_trial,created_by,created_at
				for ($i = 1; $i <= $totaldata; $i++)
				{
					if ($request->apilive[$i] !== "")
					{
						DB::table('master_product_api_customer')->insert([
							'customerno' => $CUSTOMERNO, 'product_api_id' => $request->apilive[$i], 'fstatus' => $active, 'rates' => $request->rateslive[$i], 'quota' => $request->quotalive[$i], 'created_by' => $create_by, 'created_at' => $create_at
						]);

						DB::connection('mysql_3')->table('master_product_api_customer')->insert([
							'customerno' => $CUSTOMERNO, 'product_api_id' => $request->apilive[$i], 'fstatus' => $active, 'rates' => $request->rateslive[$i], 'quota' => $request->quotalive[$i], 'created_by' => $create_by, 'created_at' => $create_at
						]);

						DB::connection('mysql_4')->table('master_product_api_customer')->insert([
							'customerno' => $CUSTOMERNO, 'product_api_id' => $request->apilive[$i], 'fstatus' => $active, 'rates' => $request->rateslive[$i], 'quota' => $request->quotalive[$i], 'created_by' => $create_by, 'created_at' => $create_at
						]);
					}
				}
			}
			*/
			
			if ($active == 2 || $active == "2") //Jika Trial
			{
				//id,customerno,product_api_id,fstatus,rates,quota,remainquota,start_trial,end_trial,created_by,created_at
				for ($j = 1; $j <= $totaldata; $j++)
				{
					if ($request->apitrial[$j] !== "")
					{
						DB::table('master_product_api_customer')->insert([
							'customerno' => $CUSTOMERNO, 'product_api_id' => $request->apitrial[$j], 'fstatus' => 2, 'rates' => $request->ratestrial[$j], 'quota' => $request->quotatrial[$j], 'start_trial' => $request->start_trial[$j], 'end_trial' => $request->end_trial[$j], 'created_by' => $create_by, 'created_at' => $create_at
						]);

						DB::connection('mysql_3')->table('master_product_api_customer')->insert([
							'customerno' => $CUSTOMERNO, 'product_api_id' => $request->apitrial[$j], 'fstatus' => 2, 'rates' => $request->ratestrial[$j], 'quota' => $request->quotatrial[$j], 'start_trial' => $request->start_trial[$j], 'end_trial' => $request->end_trial[$j], 'created_by' => $create_by, 'created_at' => $create_at
						]);

						DB::connection('mysql_4')->table('master_product_api_customer')->insert([
							'customerno' => $CUSTOMERNO, 'product_api_id' => $request->apitrial[$j], 'fstatus' => 2, 'rates' => $request->ratestrial[$j], 'quota' => $request->quotatrial[$j], 'start_trial' => $request->start_trial[$j], 'end_trial' => $request->end_trial[$j], 'created_by' => $create_by, 'created_at' => $create_at
						]);
					}
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

			return redirect('http://192.168.100.100/app-portal/exit')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}

	public function view_cust($id)
    {
        if(Session::get('userid'))
        {
			$data = DB::table('master_company')
					->where('master_company.fapi', 1)
					->where('master_company.customerno', $id)
					->where('master_company.billingtype', 1)
					->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company.SALESAGENTCODE')	
					->select('master_company.id','master_company.customerno','company_name','address','address2','address3','address4','address5','zipcode','address_npwp','phone_fax','email_pic','email_billing','npwpno','npwpname','master_company.SALESAGENTCODE','SALESAGENTNAME','activation_date','notes','invtypeid',DB::raw('(CASE WHEN master_company.invtypeid = 1 THEN "Periodic" WHEN master_company.invtypeid = 2 THEN "Monthly" END) as invtype'),DB::raw('(master_company.active) as factive'), DB::raw('(CASE WHEN master_company.active = 1 THEN "Active" WHEN master_company.active = 2 THEN "Trial" ELSE "Inactive" END) as active'), DB::raw('(CASE WHEN master_company.fcompleted = 1 THEN "Completed" ELSE "Not Complete" END) as fcomplete'))
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

	public function add_servis(Request $request, $id)
	{
        if(Session::get('userid'))
		{
			//dd($id);
			$custno 	= $id;
			//$cpy		= DB::table('master_company')->where('fapi', 1)->where('customerno', $id)->select('master_company.customerno')->first();
			//$custno 	= $cpy->customerno;
			
			$sts		= DB::connection('mysql_4')->table('master_company')->where('fapi', 1)->where('customerno', $id)->select('active','billingtype')->first();
			$status		= $sts->active;
			$billingtype= $sts->billingtype;

			$total 		= DB::connection('mysql_4')->select("CALL sp_totaldataexclude('".$custno."');");
			$total_data	= $total[0]->total_data;
			//dd($total_data);
			
			$mindata	= DB::connection('mysql_4')->select("CALL sp_mindataexclude('".$custno."');");
			$min_data	= $mindata[0]->min_data;

			$tproduk	= DB::connection('mysql_4')->table('datawhiz_app.master_product_api')->where('fActive', 1)->select(DB::raw('COUNT(id) AS tot_data'))->first();
			$totaldata	= $tproduk->tot_data;

			$product	= DB::connection('mysql_4')->select("CALL sp_addservis('".$custno."');");

			//return response()->json($data);
			return view('home.master_trial.addservis', compact('custno','status','billingtype','total_data','min_data','totaldata','product'));
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

	public function InsertAPI(Request $request)
	{
        if(Session::get('userid'))
		{
			//dd(count($request->idt));
			$customerno		= $request->customerno;
			$billingtype	= $request->billingtype;
			$active			= $request->active;
			$create_by		= $request->create_by;
			$create_at 		= date('Y-m-d H:i:s');
			
			/*
			if ($active == 1 || $active == "1") //Jika Live
			{
				for ($i = 1; $i <= count($request->idl); $i++)
				{
					if ($request->idl[$i] !== null)
					{
						//echo $i." : ".$request->idl[$i]." --> ".$request->quotatrial[$i]." --> ".$request->ratestrial[$i]." --> ".$request->start_trial[$i]." --> ".$request->end_trial[$i];
						//echo "<br />";
						DB::table('master_product_api_customer')->insert([
							'customerno' => $customerno, 'product_api_id' => $request->idl[$i], 'fstatus' => $active, 'rates' => $request->rateslive[$i], 'quota' => $request->quotalive[$i], 'created_by' => $create_by, 'created_at' => $create_at
						]);

						DB::connection('mysql_3')->table('master_product_api_customer')->insert([
							'customerno' => $customerno, 'product_api_id' => $request->idl[$i], 'fstatus' => $active, 'rates' => $request->rateslive[$i], 'quota' => $request->quotalive[$i], 'created_by' => $create_by, 'created_at' => $create_at
						]);

						DB::connection('mysql_4')->table('master_product_api_customer')->insert([
							'customerno' => $customerno, 'product_api_id' => $request->idl[$i], 'fstatus' => $active, 'rates' => $request->rateslive[$i], 'quota' => $request->quotalive[$i], 'created_by' => $create_by, 'created_at' => $create_at
						]);
					}
				}
				//dd("test");
			}
			*/
			
			if ($active == 2 || $active == "2") //Jika Trial
			{
				for ($j = 1; $j <= count($request->idt); $j++)
				{
					if ($request->idt[$j] !== null)
					{
						//echo $j." : ".$request->idt[$j]." --> ".$request->quotatrial[$j]." --> ".$request->ratestrial[$j]." --> ".$request->start_trial[$j]." --> ".$request->end_trial[$j];
						//echo "<br />";
						DB::table('master_product_api_customer')->insert([
							'customerno' => $customerno, 'product_api_id' => $request->idt[$j], 'fstatus' => $active, 'rates' => $request->ratestrial[$j], 'quota' => $request->quotatrial[$j], 'start_trial' => $request->start_trial[$j], 'end_trial' => $request->end_trial[$j], 'created_by' => $create_by, 'created_at' => $create_at
						]);

						DB::connection('mysql_3')->table('master_product_api_customer')->insert([
							'customerno' => $customerno, 'product_api_id' => $request->idt[$j], 'fstatus' => $active, 'rates' => $request->ratestrial[$j], 'quota' => $request->quotatrial[$j], 'start_trial' => $request->start_trial[$j], 'end_trial' => $request->end_trial[$j], 'created_by' => $create_by, 'created_at' => $create_at
						]);

						DB::connection('mysql_4')->table('master_product_api_customer')->insert([
							'customerno' => $customerno, 'product_api_id' => $request->idt[$j], 'fstatus' => $active, 'rates' => $request->ratestrial[$j], 'quota' => $request->quotatrial[$j], 'start_trial' => $request->start_trial[$j], 'end_trial' => $request->end_trial[$j], 'created_by' => $create_by, 'created_at' => $create_at
						]);
					}
				}
				//dd("test");
			}
		
			return response()->json(['success' => 'Master API saved successfully.']);
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
	
	public function topup_token(Request $request, $id)
	{
        if(Session::get('userid'))
		{
			$custno 	= $id;
			//$cpy		= DB::connection('mysql_4')->table('master_company')->where('fapi', 1)->where('id', $id)->select('master_company.customerno')->first();
			//$custno 	= $cpy->customerno;
			
			$sts		= DB::connection('mysql_4')->table('master_company')->where('fapi', 1)->where('customerno', $custno)->select('active','billingtype')->first();
			$status		= $sts->active;
			$billingtype= $sts->billingtype;

			$total 		= DB::select("CALL sp_totaldatainclude('".$custno."');");
			$total_data	= $total[0]->total_data;
			//dd($total_data);
			
			$mindata	= DB::select("CALL sp_mindatainclude('".$custno."');");
			$min_data	= $mindata[0]->min_data;

			$tproduk = DB::connection('mysql_4')->table('datawhiz_app.master_product_api')->where('fActive', 1)->select(DB::raw('COUNT(id) AS tot_data'))->first();
			$totaldata = $tproduk->tot_data;

			$product	= DB::select("CALL sp_addservisinclude('".$custno."');");

			//return response()->json($data);
			return view('home.master_trial.topup', compact('custno','status','billingtype','total_data','min_data','totaldata','product'));
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

	public function proses_topup(Request $request)
	{
        if(Session::get('userid'))
		{
			//dd($request);
			$customerno		= $request->customerno;
			$billingtype	= $request->billingtype;
			$active			= $request->active;
			$updated_by		= $request->create_by;
			$updated_at 	= date('Y-m-d H:i:s');
			
			/*
			if ($active == 1 || $active == "1") //Jika Live
			{
				for ($i = 1; $i <= count($request->idl); $i++)
				{
					if ($request->idl[$i] !== null)
					{
						//echo $i." : ".$request->idl[$i]." --> ".$request->quotatrial[$i]." --> ".$request->ratestrial[$i]." --> ".$request->start_trial[$i]." --> ".$request->end_trial[$i];
						//echo "<br />";
						DB::table('master_product_api_customer')
							->where('customerno', $customerno)
							->where('product_api_id', $request->idl[$i])
							->update([
										'rates' => $request->rateslive[$i], 
										'quota' => $request->quotalive[$i], 
										'updated_by' => $updated_by, 
										'updated_at' => $updated_at
									]);

						DB::connection('mysql_3')->table('master_product_api_customer')
							->where('customerno', $customerno)
							->where('product_api_id', $request->idl[$i])
							->update([
										'rates' => $request->rateslive[$i], 
										'quota' => $request->quotalive[$i], 
										'updated_by' => $updated_by, 
										'updated_at' => $updated_at
									]);

						DB::connection('mysql_4')->table('master_product_api_customer')
							->where('customerno', $customerno)
							->where('product_api_id', $request->idl[$i])
							->update([
										'rates' => $request->rateslive[$i], 
										'quota' => $request->quotalive[$i], 
										'updated_by' => $updated_by, 
										'updated_at' => $updated_at
									]);
					}
				}
			}
			*/
			
			if ($active == 2 || $active == "2") //Jika Trial
			{
				for ($j = 1; $j <= count($request->idt); $j++)
				{
					if ($request->idt[$j] !== null)
					{
						//echo $j." : ".$request->idt[$j]." --> ".$request->quotatrial[$j]." --> ".$request->ratestrial[$j]." --> ".$request->start_trial[$j]." --> ".$request->end_trial[$j];
						//echo "<br />";
						DB::table('master_product_api_customer')
							->where('customerno', $customerno)
							->where('product_api_id', $request->idt[$j])
							->update([
										'rates' => $request->ratestrial[$j], 
										'quota' => $request->quotatrial[$j], 
										'start_trial' => $request->start_trial[$j], 
										'end_trial' => $request->end_trial[$j], 
										'updated_by' => $updated_by, 
										'updated_at' => $updated_at
									]);

						DB::connection('mysql_3')->table('master_product_api_customer')
							->where('customerno', $customerno)
							->where('product_api_id', $request->idt[$j])
							->update([
										'rates' => $request->ratestrial[$j], 
										'quota' => $request->quotatrial[$j], 
										'start_trial' => $request->start_trial[$j], 
										'end_trial' => $request->end_trial[$j], 
										'updated_by' => $updated_by, 
										'updated_at' => $updated_at
									]);

						DB::connection('mysql_4')->table('master_product_api_customer')
							->where('customerno', $customerno)
							->where('product_api_id', $request->idt[$j])
							->update([
										'rates' => $request->ratestrial[$j], 
										'quota' => $request->quotatrial[$j], 
										'start_trial' => $request->start_trial[$j], 
										'end_trial' => $request->end_trial[$j], 
										'updated_by' => $updated_by, 
										'updated_at' => $updated_at
									]);
					}
				}
			}
					
			return response()->json(['success' => 'Master API updated successfully.']);
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

	public function view_services(Request $request, $id)
    {
        if(Session::get('userid'))
        {
			/*
			$sales  = DB::table('salesagent')
						->where('STATUS', 1)
						->select('SALESAGENTCODE','SALESAGENTNAME')
						->orderBy('SALESAGENTCODE','ASC')
						->get();
			
			$produk = DB::connection('mysql_4')->table('master_product_api')->where('fActive', 1)->select('id', 'product')->orderBy('id','ASC')->get();
			$tproduk = DB::connection('mysql_4')->table('master_product_api')->where('fActive', 1)->select(DB::raw('COUNT(id) AS tot_data'))->first();
			$totaldata = $tproduk->tot_data;
            $data1['sales'] = DB::select('select SALESAGENTCODE,SALESAGENTNAME from billing_ats.salesagent where STATUS = 1 ORDER BY SALESAGENTNAME;');

            $data1['groups'] = DB::select('SELECT DISTINCT ID id, PARENT_CUSTOMER parent from billing_ats.customer_parent ORDER BY PARENT_CUSTOMER DESC;');

            $data1['paymethod'] = DB::select('select PAYMENTCODE,PAYMENTMETHOD from billing_ats.paymentmethod ORDER BY PAYMENTCODE;');
			*/
			$updated_by		= $request->create_by;
			$updated_at 	= date('Y-m-d H:i:s');

			$servis	= DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno', $id)->orderby('product_api_id', 'ASC')->get();
			foreach ($servis as $s)
			{
				$productid	= $s->product_api_id;
				//$fstatus	= $s->fstatus;
				$rates		= $s->rates;
				$usedquota	= $s->remainquota;
				$end_trial	= $s->end_trial;

				DB::table('master_product_api_customer')
					->where('customerno', $id)
					->where('product_api_id', $productid)
					->update([
								'rates' => $rates, 
								'remainquota' => $usedquota, 
								'end_trial' => $end_trial, 
								'updated_by' => $updated_by, 
								'updated_at' => $updated_at
							]);

				DB::connection('mysql_3')->table('master_product_api_customer')
					->where('customerno', $id)
					->where('product_api_id', $productid)
					->update([
								'rates' => $rates, 
								'remainquota' => $usedquota, 
								'end_trial' => $end_trial, 
								'updated_by' => $updated_by, 
								'updated_at' => $updated_at
							]);
			}
			
			if ($request->ajax()) 
			{
				//$data = QueryBuilder::for(Mod_ProductsApi::class)   
				$data = DB::table('master_product_api_customer')
						->where('master_company.fapi', 1)
						->where('master_company.customerno', $id)
						->where('master_company.billingtype', 1)
						->join('master_company', 'master_company.customerno', '=', 'master_product_api_customer.customerno')	
						->join('master_product_api', 'master_product_api.id', '=', 'master_product_api_customer.product_api_id')	
						->select('master_product_api_customer.product_api_id','master_product_api.product','master_product_api_customer.rates','master_product_api_customer.quota','master_product_api_customer.remainquota','master_product_api_customer.start_trial','master_product_api_customer.end_trial')
                        ->orderBy('product_api_id','ASC')
						//->paginate($request->query('perpage', 10000000))
						//->appends(request()->query());

				//return response()->json($data);
						->get();

                return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
			}

			//return view('home.registrasitrial.registrasi', compact('sales','produk','totaldata'))->with($data1);
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
			return view('home.master_trial.viewusage', compact('custno','produk'))->with($data);
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
					$data = QueryBuilder::for(Valid_No_Api_Trial::class)
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
					$data = QueryBuilder::for(Skiptrace_Api_Trial::class)
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
					$data = QueryBuilder::for(IdMatch_Api_Trial::class)
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
					$data = QueryBuilder::for(Demography_Api_Trial::class)
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
					$data = QueryBuilder::for(Income_Api_Trial::class)
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
					$data = QueryBuilder::for(PhoneHistory_Api_Trial::class)
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
					$data = QueryBuilder::for(Slik_Summary_Api_Trial::class)
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
					$data = QueryBuilder::for(Demography_Verification_Api_Trial::class)
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
					$data = QueryBuilder::for(Demography_Api_Trial::class)
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
				$data = DB::connection('mysql_4')->select("CALL View_Usage_Customer_Trial_Monthly('".$customerno."', '".$periode."');");

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
				$data = QueryBuilder::for(Valid_No_Api_Trial::class)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id',DB::raw('(CASE WHEN success = 1 THEN "SUCCESS" ELSE "FAILED" END) AS status_hit'),DB::raw('phone_number AS data_input'),DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogTrial1($data), 'Log_DataWiz_API_Trial_Validation_No_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			if ($product == 2) //Skiptrace API
			{
				$data = QueryBuilder::for(Skiptrace_Api_Trial::class)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('nik AS data_input'),DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogTrial2($data), 'Log_DataWiz_API_Trial_Skiptrace_No_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			if ($product == 3) //Id. Match API
			{
				$data = QueryBuilder::for(IdMatch_Api_Trial::class)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('nik AS data_input'),DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogTrial3($data), 'Log_DataWiz_API_Trial_Id._Match_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			/*if ($product == 4) //Reverse Skiptrace API
			{
				$data = QueryBuilder::for(Mod_Trx_FTP::class)

						->orderBy('trx_ftp.id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogTrial4($data), 'Log_DataWiz_API_Trial_Reverse_Skiptrace_'.$customerno.'_'.$periode.'.xlsx');
			}*/
			
			if ($product == 5) //Demography API
			{
				$data = QueryBuilder::for(Demography_Api_Trial::class)
						->where('ftype', 2)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('nik AS data_input'),DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogTrial5($data), 'Log_DataWiz_API_Trial_Demography_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			if ($product == 6) //Income Verification API
			{
				$data = QueryBuilder::for(Income_Api_Trial::class)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('nik AS data_input'),DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogTrial6($data), 'Log_DataWiz_API_Trial_Income_Verification_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			if ($product == 7) //Phone History API
			{
				$data = QueryBuilder::for(PhoneHistory_Api_Trial::class)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id',DB::raw('code AS status_hit'),DB::raw('(CASE WHEN phone_no = "" THEN phone_md5 ELSE phone_no END) AS data_input'),DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogTrial7($data), 'Log_DataWiz_API_Trial_Phone_History_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			if ($product == 8) //SLIK API
			{
				$data = QueryBuilder::for(Slik_Summary_Api_Trial::class)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('nik AS data_input'), DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogTrial8($data), 'Log_DataWiz_API_Trial_Slik_Summary_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			if ($product == 9) //Id. Verification API
			{
				$data = QueryBuilder::for(Demography_Verification_Api_Trial::class)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('nik AS data_input'), DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogTrial9($data), 'Log_DataWiz_API_Trial_Id._Verification_'.$customerno.'_'.$periode.'.xlsx');
			}
			
			if ($product == 10) //Demography Foto API
			{
				$data = QueryBuilder::for(Demography_Api_Trial::class)
						->where('ftype', 1)
						->where('customerno', $customerno)
						->where(DB::raw('DATE_FORMAT(created_at,"%Y%m")'), $periode)
						->select('noapi_id', DB::raw('code AS status_hit'), DB::raw('nik AS data_input'), DB::raw('created_at AS tgl_hit'))
						->groupBy('noapi_id', 'status_hit', 'data_input', 'tgl_hit')
						->orderBy('id','DESC')
						->get();

				ob_end_clean();

				return Excel::download(new RptLogTrial10($data), 'Log_DataWiz_API_Trial_Demography_Photo_'.$customerno.'_'.$periode.'.xlsx');
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
	
	public function del_api(Request $request, $id)
	{
        if(Session::get('userid'))
		{
			$custno 	= $id;
			//$cpy		= DB::connection('mysql_4')->table('master_company')->where('fapi', 1)->where('id', $id)->select('master_company.customerno')->first();
			//$custno 	= $cpy->customerno;
			
			$sts		= DB::connection('mysql_4')->table('master_company')->where('fapi', 1)->where('customerno', $custno)->select('active','billingtype')->first();
			$status		= $sts->active;
			$billingtype= $sts->billingtype;

			$total 		= DB::select("CALL sp_totaldatainclude('".$custno."');");
			$total_data	= $total[0]->total_data;
			//dd($total_data);
			
			$mindata	= DB::select("CALL sp_mindatainclude('".$custno."');");
			$min_data	= $mindata[0]->min_data;

			$tproduk 	= DB::connection('mysql_4')->table('datawhiz_app.master_product_api')->where('fActive', 1)->select(DB::raw('COUNT(id) AS tot_data'))->first();
			$totaldata 	= $tproduk->tot_data;

			$product	= DB::select("CALL sp_addservisinclude('".$custno."');");

			//return response()->json($data);
			return view('home.master_trial.del_api', compact('custno','status','billingtype','total_data','min_data','totaldata','product'));
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

	public function proses_del(Request $request)
	{
        if(Session::get('userid'))
		{
			//dd($request);
			$customerno		= $request->customerno;
			$billingtype	= $request->billingtype;
			$active			= $request->active;
			$updated_by		= $request->create_by;
			$updated_at 	= date('Y-m-d H:i:s');
			
			/*
			if ($active == 1 || $active == "1") //Jika Live
			{
				for ($i = 1; $i <= count($request->idl); $i++)
				{
					if ($request->idl[$i] !== null)
					{
						//echo $i." : ".$request->idl[$i]." --> ".$request->quotatrial[$i]." --> ".$request->ratestrial[$i]." --> ".$request->start_trial[$i]." --> ".$request->end_trial[$i];
						//echo "<br />";
						DB::table('master_product_api_customer')
							->where('customerno', $customerno)
							->where('product_api_id', $request->idl[$i])
							->delete();

						DB::connection('mysql_3')->table('master_product_api_customer')
							->where('customerno', $customerno)
							->where('product_api_id', $request->idl[$i])
							->delete();

						DB::connection('mysql_4')->table('master_product_api_customer')
							->where('customerno', $customerno)
							->where('product_api_id', $request->idl[$i])
							->delete();
					}
				}
			}
			*/
			
			if ($active == 2 || $active == "2") //Jika Trial
			{
				for ($j = 1; $j <= count($request->idt); $j++)
				{
					if ($request->idt[$j] !== null)
					{
						//echo $j." : ".$request->idt[$j]." --> ".$request->quotatrial[$j]." --> ".$request->ratestrial[$j]." --> ".$request->start_trial[$j]." --> ".$request->end_trial[$j];
						//echo "<br />";
						DB::table('master_product_api_customer')
							->where('customerno', $customerno)
							->where('product_api_id', $request->idt[$j])
							->delete();

						DB::connection('mysql_3')->table('master_product_api_customer')
							->where('customerno', $customerno)
							->where('product_api_id', $request->idt[$j])
							->delete();

						DB::connection('mysql_4')->table('master_product_api_customer')
							->where('customerno', $customerno)
							->where('product_api_id', $request->idt[$j])
							->delete();
					}
				}
			}
					
			return response()->json(['success' => 'Master API deleted successfully.']);
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

    public function deleteReg(Request $request, $id)
	{
		if(Session::get('userid'))
		{
			$custno = $id;

	    	DB::table('master_company')->where('master_company.fapi', 1)->where('customerno',$custno)->delete(); 			
	    	DB::connection('mysql_3')->table('master_company')->where('master_company.fapi', 1)->where('customerno',$custno)->delete(); 
	    	DB::connection('mysql_4')->table('master_company')->where('master_company.fapi', 1)->where('customerno',$custno)->delete(); 
			
			DB::table('master_product_api_customer')->where('customerno',$custno)->delete();
			DB::connection('mysql_3')->table('master_product_api_customer')->where('customerno',$custno)->delete();
			DB::connection('mysql_4')->table('master_product_api_customer')->where('customerno',$custno)->delete();

			DB::connection('mysql_4')->table('datawhiz_api.tokens')->where('customerno',$custno)->delete();
			
	        return back()
	        		->with('success','All data Registration Customer was deleted successfully.');
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

	public function update_cust(Request $request)
	{
		if(Session::get('userid'))
        {
			//$data 				= array();
			$editid				= $request->custno2;
			$current_date_time 	= date('Y-m-d H:i:s');
			//dd($editid);

			DB::table('master_company')->where('master_company.fapi', 1)->where('customerno', $editid)
			->update(
				[
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
				'invtypeid' => $request->invtype2,
				'update_by' => $request->updateby,
				'update_at'	=> $current_date_time,
				]
			);

			DB::connection('mysql_3')->table('master_company')->where('master_company.fapi', 1)->where('customerno', $editid)
			->update(
				[
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
				'invtypeid' => $request->invtype2,
				'update_by' => $request->updateby,
				'update_at'	=> $current_date_time,
				]
			);

			DB::connection('mysql_4')->table('master_company')->where('master_company.fapi', 1)->where('customerno', $editid)
			->update(
				[
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
				'invtypeid' => $request->invtype2,
				'update_by' => $request->updateby,
				'update_at'	=> $current_date_time,
				]
			);

			return back()->with('success','Master Customer was updated successfully.');
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

}
