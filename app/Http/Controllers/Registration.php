<?php
namespace App\Http\Controllers;

use App\Mail\SentMail;
use App\Models\Mod_Company;
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

class Registration extends Controller
{
    public function index(Request $request)
    {
		if(Session::get('userid'))
		{
			//jika memang session sudah terdaftar
			$username = Session::get('userid');

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
						//->leftJoin('master_product_paket', 'master_product_paket.id', '=', 'master_paket_customer.product_paket_id') 
						->select('master_company.id','master_company.customerno','company_name','address','address_npwp','phone_fax','email_pic','email_billing','npwpno','npwpname','activation_date','notes','SALESAGENTNAME', DB::raw('(active) as factive'), DB::raw('(CASE WHEN product_paket_id < 5 THEN (SELECT product FROM master_product_paket WHERE master_product_paket.id = product_paket_id) ELSE (SELECT nama_paket FROM master_paket WHERE master_paket.id = product_paket_id) END) AS paket'), DB::raw('(CASE WHEN active = 1 THEN "Active" ELSE "Inactive" END) as active'), DB::raw('(CASE WHEN fcompleted = 1 THEN "Completed" ELSE "Not Completed" END) as fcompleted'))
						->orderBy('master_company.id','DESC')
						->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 10))
						->appends(request()->query());

                return response()->paginator($data);
			}
			
			return view('home.registrasi.company', compact('sales','customer'));
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

			return redirect('/')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}
 
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

            $data1['product'] = DB::select('select id, product from master_product_paket ORDER BY id;');

            $data1['packet'] = DB::select('select id, nama_paket from master_paket ORDER BY id;');

            $data1['ratestype'] = DB::select('select id, ratetype from master_ratestype ORDER BY id;');

            $data1['nonstd'] = DB::select('select id, basedon from master_non_std_basedon ORDER BY id;');

            $data1['groups'] = DB::select('SELECT DISTINCT ID id, PARENT_CUSTOMER parent from billing_ats.customer_parent ORDER BY PARENT_CUSTOMER DESC;');

            $data1['paymethod'] = DB::select('select PAYMENTCODE,PAYMENTMETHOD from billing_ats.paymentmethod ORDER BY PAYMENTCODE;');

			return view('home.registrasi.registrasi', compact('sales','customer'))->with($data1);
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

			return redirect('/')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}
 
    public function autocompleteSearch(Request $request)
    {
        $query = $request->get('query');
		  
        $filterResult = DB::table('billing_ats.customer')->where('STATUSCODE', 'A')->where('PRODUCTID', 17)->where('CUSTOMERNAME', 'LIKE', '%'.$query.'%')->select('CUSTOMERNAME')->get();
		//dd($data);

        $data = array();

        foreach ($filterResult as $hsl)
        {
            $data[] = $hsl->CUSTOMERNAME;
        }

        return response()->json($data);
    } 
	
	public function cariCustomer(Request $request, $id)
	{
		$data = DB::table('billing_ats.customer')
				->where('STATUSCODE', 'A')
				->where('PRODUCTID', 17)
				->where('CUSTOMERNAME', 'LIKE', '%'.$id.'%')
				->select('CUSTOMERNO','CUSTOMERNAME','ACTIVATIONDATE','EMAIL','SALESAGENTCODE','DISCOUNT','NPWP','COMPANYNAME','NPWPADDRESS', 'BILLINGADDRESS1','BILLINGADDRESS2','BILLINGADDRESS3','BILLINGADDRESS4','BILLINGADDRESS5','ZIPCODE','ATTENTION',DB::raw('CASE WHEN PHONE1 IS NULL OR PHONE1 = "" THEN "-" ELSE CASE WHEN PHONE2 IS NULL OR PHONE2 = "" THEN PHONE1 ELSE CONCAT(PHONE1,"/",PHONE2) END END as PHONE'))
				->first();
		//dd($data);
		
		return response()->json($data);
	}
	
	public function getcompany(Request $request)
	{
        $companyid = $request->cpy_name;

        $data = DB::table('billing_ats.customer')
					->where('STATUSCODE', 'A')
					->where('PRODUCTID', 17)
					->select('CUSTOMERNO', 'CUSTOMERNAME', 'SALESAGENTCODE', 'BILLINGADDRESS1', 'BILLINGADDRESS2', 'BILLINGADDRESS3', 'BILLINGADDRESS4', 'BILLINGADDRESS5', 'ZIPCODE', 'PHONE1', 'COMPANYNAME', 'NPWP', 'NPWPADDRESS', 'EMAIL')
					->orderBy('CUSTOMERNO','DESC')
					->get();

		return response()->json($data);
        //echo json_encode($data);
    }
	
	public function InsertReg(Request $request)
	{
		if(Session::get('userid'))
		{
			//CUSTOMERNO,CUSTOMERNAME,CUSTOMERTYPECODE,ACTIVATIONDATE,STATUSCODE,SALESAGENTCODE,BILLINGADDRESS1,BILLINGADDRESS2,BILLINGADDRESS3,BILLINGADDRESS4,BILLINGADDRESS5,ZIPCODE,ATTENTION,PHONE1,PHONE2,EMAIL,PAYMENTCODE,VATFREE,SENDVAT,COMPANYNAME,NPWP,NPWPADDRESS,DISTERMDATE,DISCOUNT,REMARKS,CRT_USER,CRT_DATE,UPD_USER,UPD_DATE,SPLIT,PARENTID,PRODUCTID,FPRINTCDRSTDXLS,FPRINTCDRSTDCSV,FPRINTCDRSTDPDF

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

			$fftp 				= $request->fftp;
			$useremail			= $request->useremail;
			$passwd				= $request->passwd;
			$cpasswd			= $request->cpasswd;
			$fullname			= $request->fullname;
			$divname			= $request->divname;
			$folname			= $request->folname;
				
			if($fftp == 0) // Jika non SFTP / non FTP
			{
				//Cek dahulu apakah email sudah ada di database?
				$cek = DB::table('master_user_appglobal')
						->where('username', $useremail)
						->select(DB::raw('COUNT(id) as tot_id'))
						->get();
				foreach ($cek as $cekitem)
				{
					$tot_id = $cekitem->tot_id;
				}
			
				if ($tot_id !== 0)
				{
					return response()->json(['error' => 'Username email sudah ada !!!']);
				}
			}
			
			if ($request->PRODUCTTIPE == "1") //kalau tipe product = 1 --> berarti paket
			{
				$PRODUCTID		= $request->PACKETID;
			}
			else  //kalau tipe product = 0 --> berarti non paket
			{
				$PRODUCTID		= $request->PRODUCTID;
			}
			
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
                $d1 = DB::table('billing_ats.customer')
						->whereIn('productid', [17])
						->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,4,1)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,4,1)) END) AS d1'))
						->first();

                $d2 = DB::table('billing_ats.customer')
						->whereIn('productid', [17])
                        ->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 1 ELSE MAX(SUBSTR(customerno,5,7))+1 END) AS d2'))
                        ->first();

                if ($d2->d2 <= 9 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH0000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH00000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH0000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH00",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH0",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH",(CASE WHEN max(SUBSTR(customerno,4,8)) IS NULL THEN 1 ELSE max(SUBSTR(customerno,4,8)) END)+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
            }

            if ($CUSTOMERTYPECODE == "B")
            {        
                $d1 = DB::table('billing_ats.customer')
						->whereIn('productid', [17])
						->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,4,1)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,4,1)) END) AS d1'))
						->first();

                $d2 = DB::table('billing_ats.customer')
						->whereIn('productid', [17])
                        ->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 1 ELSE MAX(SUBSTR(customerno,5,7))+1 END) AS d2'))
                        ->first();

                if ($d2->d2 <= 9 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH0000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH00000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH0000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH00",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH0",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH",(CASE WHEN max(SUBSTR(customerno,4,8)) IS NULL THEN 1 ELSE max(SUBSTR(customerno,4,8)) END)+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
            }

            if ($CUSTOMERTYPECODE == "R")
            {        
                $d1 = DB::table('billing_ats.customer')
						->whereIn('productid', [17])
						->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,4,1)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,4,1)) END) AS d1'))
						->first();

                $d2 = DB::table('billing_ats.customer')
						->whereIn('productid', [17])
                        ->select(DB::raw('(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 1 ELSE MAX(SUBSTR(customerno,5,7))+1 END) AS d2'))
                        ->first();

                if ($d2->d2 <= 9 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH0000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH000000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH00000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH0000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 99999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH000",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH00",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH0",(CASE WHEN MAX(SUBSTR(customerno,5,7)) IS NULL THEN 0 ELSE MAX(SUBSTR(customerno,5,7)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('billing_ats.customer')
								  ->whereIn('productid', [17])
                                  ->select(DB::raw('CONCAT("DWH",(CASE WHEN max(SUBSTR(customerno,4,8)) IS NULL THEN 1 ELSE max(SUBSTR(customerno,4,8)) END)+1,"R") AS CUSTOMERNO'))
                                  ->first();
                }
            }

            $CUSTOMERNO = $CUSTNO->CUSTOMERNO;
            //dd($CUSTOMERNO);
	        
            DB::table('billing_ats.customer')->insert(
                [
                    'CUSTOMERNO'		=> $CUSTOMERNO,
                    'CUSTOMERNAME'		=> $CUSTOMERNAME,
                    'CUSTOMERTYPECODE'	=> $CUSTOMERTYPECODE,
                    'ACTIVATIONDATE'	=> $ACTIVATIONDATE,
                    'STATUSCODE'		=> $STATUSCODE,
                    'SALESAGENTCODE'	=> $SALESAGENTCODE,
                    'BILLINGADDRESS1'	=> $BILLINGADDRESS1,
                    'BILLINGADDRESS2'	=> $BILLINGADDRESS2,
                    'BILLINGADDRESS3'	=> $BILLINGADDRESS3,
                    'BILLINGADDRESS4'	=> $BILLINGADDRESS4,
                    'BILLINGADDRESS5'	=> $BILLINGADDRESS5,
                    'ZIPCODE'			=> $ZIPCODE,
                    'ATTENTION'			=> $ATTENTION,
                    'PHONE1'			=> $PHONE1,
                    'PHONE2'			=> $PHONE2,
                    'EMAIL'				=> $EMAIL,
                    'PAYMENTCODE'		=> $PAYMENTCODE,
                    'VATFREE'			=> $VATFREE,
                    'SENDVAT'			=> $SENDVAT,
                    'COMPANYNAME'		=> $COMPANYNAME,
                    'NPWP'				=> $NPWP,
                    'NPWPADDRESS'		=> $NPWPADDRESS,
                    'DISTERMDATE'		=> $DISTERMDATE,
                    'DISCOUNT'			=> $DISCOUNT,
                    'REMARKS'			=> $REMARKS,
                    'CRT_USER'			=> $CRT_USER,
                    'CRT_DATE'			=> $CRT_DATE,
                    'SPLIT'				=> $SPLIT,
                    'PARENTID'			=> $PARENTID,
                    'PRODUCTID'			=> 17
                ]
            );

            DB::connection('mysql_2')->table('db_master_ats.customer')->insert(
                [
                    'CUSTOMERNO'		=> $CUSTOMERNO,
                    'CUSTOMERNAME'		=> $CUSTOMERNAME,
                    'CUSTOMERTYPECODE'	=> $CUSTOMERTYPECODE,
                    'ACTIVATIONDATE'	=> $ACTIVATIONDATE,
                    'STATUSCODE'		=> $STATUSCODE,
                    'SALESAGENTCODE'	=> $SALESAGENTCODE,
                    'BILLINGADDRESS1'	=> $BILLINGADDRESS1,
                    'BILLINGADDRESS2'	=> $BILLINGADDRESS2,
                    'BILLINGADDRESS3'	=> $BILLINGADDRESS3,
                    'BILLINGADDRESS4'	=> $BILLINGADDRESS4,
                    'BILLINGADDRESS5'	=> $BILLINGADDRESS5,
                    'ZIPCODE'			=> $ZIPCODE,
                    'ATTENTION'			=> $ATTENTION,
                    'PHONE1'			=> $PHONE1,
                    'PHONE2'			=> $PHONE2,
                    'EMAIL'				=> $EMAIL,
                    'PAYMENTCODE'		=> $PAYMENTCODE,
                    'VATFREE'			=> $VATFREE,
                    'SENDVAT'			=> $SENDVAT,
                    'COMPANYNAME'		=> $COMPANYNAME,
                    'NPWP'				=> $NPWP,
                    'NPWPADDRESS'		=> $NPWPADDRESS,
                    'DISTERMDATE'		=> $DISTERMDATE,
                    'DISCOUNT'			=> $DISCOUNT,
                    'REMARKS'			=> $REMARKS,
                    'CRT_USER'			=> $CRT_USER,
                    'CRT_DATE'			=> $CRT_DATE,
                    'SPLIT'				=> $SPLIT,
                    'PARENTID'			=> $PARENTID,
                    'PRODUCTID'			=> 17
                ]
            );

            DB::connection('mysql_3')->table('billing_ats.customer')->insert(
                [
                    'CUSTOMERNO'		=> $CUSTOMERNO,
                    'CUSTOMERNAME'		=> $CUSTOMERNAME,
                    'CUSTOMERTYPECODE'	=> $CUSTOMERTYPECODE,
                    'ACTIVATIONDATE'	=> $ACTIVATIONDATE,
                    'STATUSCODE'		=> $STATUSCODE,
                    'SALESAGENTCODE'	=> $SALESAGENTCODE,
                    'BILLINGADDRESS1'	=> $BILLINGADDRESS1,
                    'BILLINGADDRESS2'	=> $BILLINGADDRESS2,
                    'BILLINGADDRESS3'	=> $BILLINGADDRESS3,
                    'BILLINGADDRESS4'	=> $BILLINGADDRESS4,
                    'BILLINGADDRESS5'	=> $BILLINGADDRESS5,
                    'ZIPCODE'			=> $ZIPCODE,
                    'ATTENTION'			=> $ATTENTION,
                    'PHONE1'			=> $PHONE1,
                    'PHONE2'			=> $PHONE2,
                    'EMAIL'				=> $EMAIL,
                    'PAYMENTCODE'		=> $PAYMENTCODE,
                    'VATFREE'			=> $VATFREE,
                    'SENDVAT'			=> $SENDVAT,
                    'COMPANYNAME'		=> $COMPANYNAME,
                    'NPWP'				=> $NPWP,
                    'NPWPADDRESS'		=> $NPWPADDRESS,
                    'DISTERMDATE'		=> $DISTERMDATE,
                    'DISCOUNT'			=> $DISCOUNT,
                    'REMARKS'			=> $REMARKS,
                    'CRT_USER'			=> $CRT_USER,
                    'CRT_DATE'			=> $CRT_DATE,
                    'SPLIT'				=> $SPLIT,
                    'PARENTID'			=> $PARENTID,
                    'PRODUCTID'			=> 17
                ]
            );

	        $active 			= 0;
			$tech_pic_name		= "";
			$fcompleted			= 0;
			$activation_date	= ""; //date('Y-m-d H:i:s');
	        //id,customerno,company_name,phone_fax,address,address2,address3,address4,address5,zipcode,address_npwp,email_pic,email_billing,npwpno,npwpname,SALESAGENTCODE,notes,active,activation_date,create_by,create_at,update_by,update_at,discount,tech_pic_name,billing_pic_name,productid,invtypeid,fftp,fcompleted

			$id1 = DB::table('master_company')->insertGetId(
				[
					'customerno'			=> $CUSTOMERNO,
					'company_name'			=> $CUSTOMERNAME,
					'phone_fax'				=> $PHONE1,
					'address'				=> $BILLINGADDRESS1,
					'address2'				=> $BILLINGADDRESS2,
					'address3'				=> $BILLINGADDRESS3,
					'address4'				=> $BILLINGADDRESS4,
					'address5'				=> $BILLINGADDRESS5,
					'zipcode'				=> $ZIPCODE,
					'address_npwp'			=> $NPWPADDRESS,
					'email_pic'				=> $EMAIL,
					'email_billing'			=> $EMAIL,
					'npwpno'				=> $NPWP,
					'npwpname'				=> $COMPANYNAME,
					'SALESAGENTCODE'		=> $SALESAGENTCODE,
					'notes'					=> $REMARKS,
					'active'				=> $active,
					'create_by'				=> $create_by,
					'create_at'				=> $create_at,
					'discount'				=> $DISCOUNT,
					'tech_pic_name'			=> $tech_pic_name,
					'billing_pic_name'		=> $ATTENTION,
					'productid'				=> 17,
					'invtypeid'				=> $INVTYPEID,
					'fcompleted'			=> $fcompleted,
					'fftp' 					=> $fftp,
                    'parentid' 				=> $PARENTID
				]
			);
		
			DB::connection('mysql_3')->table('master_company')->insert(
				[
					'customerno'			=> $CUSTOMERNO,
					'company_name'			=> $CUSTOMERNAME,
					'phone_fax'				=> $PHONE1,
					'address'				=> $BILLINGADDRESS1,
					'address2'				=> $BILLINGADDRESS2,
					'address3'				=> $BILLINGADDRESS3,
					'address4'				=> $BILLINGADDRESS4,
					'address5'				=> $BILLINGADDRESS5,
					'zipcode'				=> $ZIPCODE,
					'address_npwp'			=> $NPWPADDRESS,
					'email_pic'				=> $EMAIL,
					'email_billing'			=> $EMAIL,
					'npwpno'				=> $NPWP,
					'npwpname'				=> $COMPANYNAME,
					'SALESAGENTCODE'		=> $SALESAGENTCODE,
					'notes'					=> $REMARKS,
					'active'				=> $active,
					'create_by'				=> $create_by,
					'create_at'				=> $create_at,
					'discount'				=> $DISCOUNT,
					'tech_pic_name'			=> $tech_pic_name,
					'billing_pic_name'		=> $ATTENTION,
					'productid'				=> 17,
					'invtypeid'				=> $INVTYPEID,
					'fcompleted'			=> $fcompleted,
					'fftp' 					=> $fftp,
                    'parentid' 				=> $PARENTID
				]
			);

			if($fftp == 0) // Jika non SFTP / non FTP
			{
				DB::table('master_user_appglobal')->insert(
					[
						'company_id'	=> $id1,
						'username'		=> $useremail,
						'password'		=> Hash::make($passwd),
						'passwd'		=> $cpasswd,
						'full_name'		=> $fullname,
						'divisi_name'	=> $divname,
						'group_id'		=> 2,
						'active'		=> 1,
						'createdby'		=> $create_by,
						'createddate'	=> $create_at,
						'folder'		=> $folname
					]
				);
				
				DB::connection('mysql_4')->table('master_user')->insert(
					[
						'company_id'	=> $id1,
						'username'		=> $useremail,
						'password'		=> Hash::make($passwd),
						'passwd'		=> $cpasswd,
						'full_name'		=> $fullname,
						'divisi_name'	=> $divname,
						'group_id'		=> 2,
						'active'		=> 1,
						'create_by'		=> 1,
						'create_at'		=> $create_at,
						'folder'		=> $folname,
						'apptypeid'		=> 2
					]
				);
			}
			
			if($fftp == 1) // Jika SFTP / FTP
			{			
				$ip_ftp 			= $request->ip_ftp;
				$username 			= $request->username;
				$password 			= $request->password;
				$jam_awal_download 	= $request->jam_awal_download;
				$jam_akhir_download = $request->jam_akhir_download;
				$folder_download	= $request->folder_download;
				$jam_awal_upload 	= $request->jam_awal_upload;
				$jam_akhir_upload 	= $request->jam_akhir_upload;
				$folder_upload		= $request->folder_upload;
				$pic_email 			= $request->pic_email;
				$protocol 			= $request->protocol;
				$port 				= $request->port;
				$folderlokal		= $request->folderlokal;
				//id,companyid,ip_ftp,username,password,jam_awal_download,jam_akhir_download,folder_download,jam_awal_upload,jam_akhir_upload,folder_upload,create_by,create_at,update_by,update_at,pic_email,protocol,port,folderlokal
				
				DB::table('master_ftp')->insert(
					[
						'companyid' 			=> $id1,
						'ip_ftp' 				=> $ip_ftp,
						'username' 				=> $username,
						'passwd' 				=> $password,
						'jam_awal_download' 	=> $jam_awal_download,
						'jam_akhir_download'	=> $jam_akhir_download,
						'folder_download'		=> $folder_download,
						'jam_awal_upload' 		=> $jam_awal_upload,
						'jam_akhir_upload' 		=> $jam_akhir_upload,
						'folder_upload' 		=> $folder_upload,
						'create_by' 			=> $create_by,
						'create_at' 			=> $create_at,
						'pic_email'				=> $pic_email,
						'protocol'				=> $protocol,
						'port'					=> $port,
						'folderlokal'			=> $folderlokal
					]
				);
				
				DB::connection('mysql_3')->table('master_ftp')->insert(
					[
						'companyid' 			=> $id1,
						'ip_ftp' 				=> $ip_ftp,
						'username' 				=> $username,
						'passwd' 				=> $password,
						'jam_awal_download' 	=> $jam_awal_download,
						'jam_akhir_download'	=> $jam_akhir_download,
						'folder_download'		=> $folder_download,
						'jam_awal_upload' 		=> $jam_awal_upload,
						'jam_akhir_upload' 		=> $jam_akhir_upload,
						'folder_upload' 		=> $folder_upload,
						'create_by' 			=> $create_by,
						'create_at' 			=> $create_at,
						'pic_email'				=> $pic_email,
						'protocol'				=> $protocol,
						'port'					=> $port,
						'folderlokal'			=> $folderlokal
					]
				);
			}

			$data1 		= DB::table('master_company')->where('id', $id1)->select('customerno')->get();
			foreach ($data1 as $res1)
			{
				$custno = $res1->customerno;
			}

			DB::table('master_paket_customer')->insert(
				[
					'product_paket_id'		=> $PRODUCTID,
					'customerno'			=> $custno,
					'created_at'			=> $create_at
				]
			);

			DB::connection('mysql_3')->table('master_paket_customer')->insert(
				[
					'product_paket_id'		=> $PRODUCTID,
					'customerno'			=> $custno,
					'created_at'			=> $create_at
				]
			);

			//return back()->with('success','Master Company saved successfully.');
			return response()->json(['success' => $custno]);
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

			return redirect('/')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}

	public function InsertRates(Request $request)
	{
		if(Session::get('userid'))
		{
			$customerno		= $request->customerno;
			$ratestype		= $request->ratestype;
			$basedon		= $request->basedon;
			$basedon1		= $request->basedon1;
			$product_price	= $request->product_price;			
			$rates_hp		= $request->hp_price;
			$rates_wa		= $request->wa_price;
			$prodid			= $request->prodid;

	        $create_at		= date('Y-m-d H:i:s');

			//table master_rates
			//id,customerno,product_paket_id,ratestypeid,non_std_basedon,non_std_basedon_wa,rates,rates_hp,rates_wa,fstatus,created_at,updated_at
			
			DB::table('master_rates')->insert(
				[
					'customerno'			=> $customerno,
					'product_paket_id'		=> $prodid,
					'ratestypeid'			=> $ratestype,
					'non_std_basedon'		=> $basedon,
					'non_std_basedon_wa'	=> $basedon1,
					'rates'					=> $product_price,
					'rates_hp'				=> $rates_hp,
					'rates_wa'				=> $rates_wa,
					'fstatus'				=> 1,
					'created_at'			=> $create_at
				]
			);
			
			DB::connection('mysql_3')->table('master_rates')->insert(
				[
					'customerno'			=> $customerno,
					'product_paket_id'		=> $prodid,
					'ratestypeid'			=> $ratestype,
					'non_std_basedon'		=> $basedon,
					'non_std_basedon_wa'	=> $basedon1,
					'rates'					=> $product_price,
					'rates_hp'				=> $rates_hp,
					'rates_wa'				=> $rates_wa,
					'fstatus'				=> 1,
					'created_at'			=> $create_at
				]
			);

			//return back()->with('success','Master User & Account saved successfully.');
			return response()->json(['success' => 'Rates Customer saved successfully.']);
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

			return redirect('/')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}

	public function Completed(Request $request)
	{
		if(Session::get('userid'))
		{
			$customerno			= $request->customerno;
			$activation_date	= date('Y-m-d H:i:s');

	        //isrecord,sized,pathftp,userftp,passwdftp

			DB::table('master_company')
				->where('customerno', $customerno)
				->update(
					[
						'active' => 1,
						'activation_date' => $activation_date,
						'fcompleted' => 1,
					]);

			DB::connection('mysql_3')->table('master_company')
				->where('customerno', $customerno)
				->update(
					[
						'active' => 1,
						'activation_date' => $activation_date,
						'fcompleted' => 1,
					]);
			
			//return back()->with('success','Master Company saved successfully.');
			return response()->json(['success' => 'All Registration Data were saved successfully.']);
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

			return redirect('/')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}

	public function view_cust($id)
    {
        if(Session::get('userid'))
        {
			$data = DB::table('master_company')
					->where('master_company.id', $id)
					->where('active', 1)
					->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company.SALESAGENTCODE')	
					->join('master_paket_customer', 'master_paket_customer.customerno', '=', 'master_company.customerno')
					//->join('master_product_paket', 'master_product_paket.id', '=', 'master_paket_customer.product_paket_id') 
					->select('master_company.id','master_company.customerno','company_name','address','address2','address3','address4','address5','zipcode','address_npwp','phone_fax','email_pic','email_billing','npwpno','npwpname','master_company.SALESAGENTCODE','SALESAGENTNAME','activation_date','notes',DB::raw('(active) as factive'), DB::raw('(CASE WHEN active = 1 THEN "Active" ELSE "Inactive" END) as active'), 'master_paket_customer.product_paket_id', DB::raw('(CASE WHEN product_paket_id < 5 THEN (SELECT product FROM master_product_paket WHERE master_product_paket.id = product_paket_id) ELSE (SELECT nama_paket FROM master_paket WHERE master_paket.id = product_paket_id) END) as paket'))
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

			return redirect('/')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
    }

    public function deleteReg($id)
	{
		if(Session::get('userid'))
		{
			$data1 		= DB::table('master_company')->where('id', $id)->select('customerno')->get();
			foreach ($data1 as $res1)
			{
				$custno = $res1->customerno;
			}

	    	DB::table('billing_ats.customer')->where('billing_ats.customer.CUSTOMERNO',$custno)->delete(); 
	    	DB::connection('mysql_2')->table('db_master_ats.customer')->where('db_master_ats.customer.CUSTOMERNO',$custno)->delete(); 			
	    	DB::connection('mysql_3')->table('billing_ats.customer')->where('billing_ats.customer.CUSTOMERNO',$custno)->delete(); 
			
			
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

			return redirect('/')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
    }

	/*
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

			return redirect('/')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
		}
	}
	*/
}
