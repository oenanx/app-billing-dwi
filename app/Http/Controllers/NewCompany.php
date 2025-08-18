<?php

namespace App\Http\Controllers;

use App\Models\M_MCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;
//use Yajra\Datatables\Datatables;

class NewCompany extends Controller
{
    public function index(Request $request)
    {
        if(Session::get('userid'))
        {
            if ($request->ajax()) 
			{
                dataTableGeneralSearch($request, function($search) {
                    return [
                        'filter' => [
                            'general_search' => $search
                        ]
                    ];
                });

				$data = QueryBuilder::for(M_MCustomer::class) //DB::table('billing_ats.customer')
						->where('PRODUCTID', 17)
						->leftJoin('billing_ats.account', 'account.customerno', '=', 'billing_ats.customer.CUSTOMERNO')
						->join('billing_ats.salesagent', 'salesagent.SALESAGENTCODE', '=', 'billing_ats.customer.SALESAGENTCODE')
                        ->join('billing_ats.customer_parent', 'customer_parent.ID', '=', 'billing_ats.customer.PARENTID')
    		            ->select('customer.CUSTOMERNO', 'PARENT_CUSTOMER', 'customer.CUSTOMERNAME', 'salesagent.SALESAGENTNAME', DB::raw('ACTIVATIONDATE AS ACTIVEDATE'), DB::raw('CASE WHEN customer.STATUSCODE = "A" THEN "ACTIVED" ELSE "INACTIVED" END AS STATUSE'))
						->orderBy('billing_ats.customer.CUSTOMERNO','desc')
                        ->distinct()
    		            ->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 10))
						->appends(request()->query());
						
				return response()->paginator($data);
						
            }

            $data1['sales'] = DB::select('select SALESAGENTCODE,SALESAGENTNAME from billing_ats.salesagent where STATUS = 1 ORDER BY SALESAGENTNAME;');

<<<<<<< HEAD
            $data1['product'] = DB::select('select id,productname from billing_ats.master_product WHERE id IN ("7","8") ORDER BY id;');
=======
            $data1['product'] = DB::select('select id,productname from billing_ats.master_product WHERE id = 17 ORDER BY id;');
>>>>>>> bd2846139fb3bf686ad6c312b46f8d84a6ba3bb9

            $data1['groups'] = DB::select('SELECT DISTINCT ID id, PARENT_CUSTOMER parent from billing_ats.customer_parent ORDER BY PARENT_CUSTOMER DESC;');

            $data1['paymethod'] = DB::select('select PAYMENTCODE,PAYMENTMETHOD from billing_ats.paymentmethod ORDER BY PAYMENTCODE;');

            return view('home.master_company.mcustomer')->with($data1);

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
    
    public function insert(Request $request)
    {
        if(Session::get('userid'))
        {
			//dd($request);
	        $CUSTOMERNAME       = $request->custname;
            $ACTIVATIONDATE     = $request->actdate;
	        $STATUSCODE    	    = $request->status;
	        $DISTERMDATE   	    = $request->disdate;
	        $DISCOUNT      	    = $request->disc;

	        $SALESAGENTCODE     = $request->salesname;
	        $CUSTOMERTYPECODE   = $request->ctype;
	        $PAYMENTCODE        = $request->paymenttype;
	        $SPLIT    	        = $request->split;

	        $ATTENTION 	        = $request->attention;
	        $PHONE1    	        = $request->Phone;
	        $PHONE2             = $request->Phone2;
	        $EMAIL    	        = $request->email;

	        $VATFREE 	        = $request->freevat;
	        $SENDVAT   	        = $request->vatinv;
	        $NPWP               = $request->npwp;
	        $COMPANYNAME        = $request->npwpname;

	        $BILLINGADDRESS1    = $request->addr1;
	        $BILLINGADDRESS2    = $request->addr2;
	        $BILLINGADDRESS3    = $request->addr3;
	        $BILLINGADDRESS4    = $request->addr4;
	        $BILLINGADDRESS5    = $request->addr5;
	        $ZIPCODE  	        = $request->zipcode;
	        $NPWPADDRESS        = $request->npwpaddr;
	        $REMARKS  	        = $request->remarks;

            $PARENTID           = $request->parentcustomerid;
            $PRODUCTID          = $request->prodid;

	        $CRT_USER 	        = $request->userid;
	        $CRT_DATE 	        = date('Y-m-d H:i:s');

            if ($DISTERMDATE == "" || empty($DISTERMDATE))
            {
                $DISTERMDATE = "1900-01-01 00:00:00";
            }

            if ($CUSTOMERTYPECODE == "C")
            {        
                $d1 = DB::table('billing_ats.customer')
                        ->select(DB::raw('(MAX(SUBSTR(customerno,4,1))) AS d1'))
                        ->first();

                $d2 = DB::table('billing_ats.customer')
                        ->select(DB::raw('(MAX(SUBSTR(customerno,5,7))+1) AS d2'))
                        ->first();

                if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
                                  ->select(DB::raw('CONCAT("IDN0",max(SUBSTR(customerno,5,7))+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('billing_ats.customer')
                                  ->select(DB::raw('CONCAT("IDN",max(SUBSTR(customerno,4,8))+1,"C") AS CUSTOMERNO'))
                                  ->first();
                }
            }

            if ($CUSTOMERTYPECODE == "B")
            {        
                $d1 = DB::table('billing_ats.customer')
                        ->select(DB::raw('(MAX(SUBSTR(customerno,4,1))) AS d1'))
                        ->first();

                $d2 = DB::table('billing_ats.customer')
                        ->select(DB::raw('(MAX(SUBSTR(customerno,5,7))+1) AS d2'))
                        ->first();

                if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
                                  ->select(DB::raw('CONCAT("IDN0",MAX(SUBSTR(customerno,5,7))+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('billing_ats.customer')
                                  ->select(DB::raw('CONCAT("IDN",MAX(SUBSTR(customerno,4,8))+1,"B") AS CUSTOMERNO'))
                                  ->first();
                }
            }

            if ($CUSTOMERTYPECODE == "R")
            {        
                $d1 = DB::table('billing_ats.customer')
                        ->select(DB::raw('(MAX(SUBSTR(customerno,4,1))) AS d1'))
                        ->first();

                $d2 = DB::table('billing_ats.customer')
                        ->select(DB::raw('(MAX(SUBSTR(customerno,5,7))+1) AS d2'))
                        ->first();

                if ($d2->d2 <= 9999999 && $d1->d1 == 0)
                {
                    $CUSTNO = DB::table('billing_ats.customer')
                                  ->select(DB::raw('CONCAT("IDN0",MAX(SUBSTR(customerno,5,7))+1,"RES") AS CUSTOMERNO'))
                                  ->first();
                }
                else
                {
                    $CUSTNO = DB::table('billing_ats.customer')
                                  ->select(DB::raw('CONCAT("IDN",MAX(SUBSTR(customerno,4,8))+1,"RES") AS CUSTOMERNO'))
                                  ->first();
                }
            }

            $CUSTOMERNO = $CUSTNO->CUSTOMERNO;
            //dd($CUSTOMERNO);
	        //M_MCustomer::insertData($CUSTOMERNO,$CUSTOMERNAME,$CUSTOMERTYPECODE,$ACTIVATIONDATE,$STATUSCODE,$SALESAGENTCODE,$BILLINGADDRESS1,$BILLINGADDRESS2,$BILLINGADDRESS3,$BILLINGADDRESS4,$BILLINGADDRESS5,$ZIPCODE,$ATTENTION,$PHONE1,$PHONE2,$EMAIL,$PAYMENTCODE,$VATFREE,$SENDVAT,$COMPANYNAME,$NPWP,$NPWPADDRESS,$DISTERMDATE,$DISCOUNT,$REMARKS,$CRT_USER,$CRT_DATE,$SPLIT);

            //CUSTOMERNO,CUSTOMERNAME,CUSTOMERTYPECODE,ACTIVATIONDATE,STATUSCODE,SALESAGENTCODE,BILLINGADDRESS1,BILLINGADDRESS2,BILLINGADDRESS3,BILLINGADDRESS4,BILLINGADDRESS5,ZIPCODE,ATTENTION,PHONE1,PHONE2,EMAIL,PAYMENTCODE,VATFREE,SENDVAT,COMPANYNAME,NPWP,NPWPADDRESS,DISTERMDATE,DISCOUNT,REMARKS,CRT_USER,CRT_DATE,SPLIT

            DB::table('billing_ats.customer')->insert(
                [
                    'CUSTOMERNO' => $CUSTOMERNO, 'CUSTOMERNAME' => $CUSTOMERNAME, 'CUSTOMERTYPECODE' => $CUSTOMERTYPECODE, 'ACTIVATIONDATE' => $ACTIVATIONDATE, 'STATUSCODE' => $STATUSCODE, 'SALESAGENTCODE' => $SALESAGENTCODE, 'BILLINGADDRESS1' => $BILLINGADDRESS1, 'BILLINGADDRESS2' => $BILLINGADDRESS2, 'BILLINGADDRESS3' => $BILLINGADDRESS3, 'BILLINGADDRESS4' => $BILLINGADDRESS4, 'BILLINGADDRESS5' => $BILLINGADDRESS5, 'ZIPCODE' => $ZIPCODE, 'ATTENTION' => $ATTENTION, 'PHONE1' => $PHONE1, 'PHONE2' => $PHONE2, 'EMAIL' => $EMAIL, 'PAYMENTCODE' => $PAYMENTCODE, 'VATFREE' => $VATFREE, 'SENDVAT' => $SENDVAT, 'COMPANYNAME' => $COMPANYNAME, 'NPWP' => $NPWP, 'NPWPADDRESS' => $NPWPADDRESS, 'DISTERMDATE' => $DISTERMDATE, 'DISCOUNT' => $DISCOUNT, 'REMARKS' => $REMARKS, 'CRT_USER' => $CRT_USER, 'CRT_DATE' => $CRT_DATE, 'SPLIT' => $SPLIT, 'PARENTID' => $PARENTID, 'PRODUCTID' => $PRODUCTID
                ]
            );

            DB::connection('mysql_2')->table('db_master_ats.customer')->insert(
                [
                    'CUSTOMERNO' => $CUSTOMERNO, 'CUSTOMERNAME' => $CUSTOMERNAME, 'CUSTOMERTYPECODE' => $CUSTOMERTYPECODE, 'ACTIVATIONDATE' => $ACTIVATIONDATE, 'STATUSCODE' => $STATUSCODE, 'SALESAGENTCODE' => $SALESAGENTCODE, 'BILLINGADDRESS1' => $BILLINGADDRESS1, 'BILLINGADDRESS2' => $BILLINGADDRESS2, 'BILLINGADDRESS3' => $BILLINGADDRESS3, 'BILLINGADDRESS4' => $BILLINGADDRESS4, 'BILLINGADDRESS5' => $BILLINGADDRESS5, 'ZIPCODE' => $ZIPCODE, 'ATTENTION' => $ATTENTION, 'PHONE1' => $PHONE1, 'PHONE2' => $PHONE2, 'EMAIL' => $EMAIL, 'PAYMENTCODE' => $PAYMENTCODE, 'VATFREE' => $VATFREE, 'SENDVAT' => $SENDVAT, 'COMPANYNAME' => $COMPANYNAME, 'NPWP' => $NPWP, 'NPWPADDRESS' => $NPWPADDRESS, 'DISTERMDATE' => $DISTERMDATE, 'DISCOUNT' => $DISCOUNT, 'REMARKS' => $REMARKS, 'CRT_USER' => $CRT_USER, 'CRT_DATE' => $CRT_DATE, 'SPLIT' => $SPLIT, 'PARENTID' => $PARENTID, 'PRODUCTID' => $PRODUCTID
                ]
            );

            DB::connection('mysql_3')->table('billats_new.customer')->insert(
                [
                    'CUSTOMERNO' => $CUSTOMERNO, 'CUSTOMERNAME' => $CUSTOMERNAME, 'CUSTOMERTYPECODE' => $CUSTOMERTYPECODE, 'ACTIVATIONDATE' => $ACTIVATIONDATE, 'STATUSCODE' => $STATUSCODE, 'SALESAGENTCODE' => $SALESAGENTCODE, 'BILLINGADDRESS1' => $BILLINGADDRESS1, 'BILLINGADDRESS2' => $BILLINGADDRESS2, 'BILLINGADDRESS3' => $BILLINGADDRESS3, 'BILLINGADDRESS4' => $BILLINGADDRESS4, 'BILLINGADDRESS5' => $BILLINGADDRESS5, 'ZIPCODE' => $ZIPCODE, 'ATTENTION' => $ATTENTION, 'PHONE1' => $PHONE1, 'PHONE2' => $PHONE2, 'EMAIL' => $EMAIL, 'PAYMENTCODE' => $PAYMENTCODE, 'VATFREE' => $VATFREE, 'SENDVAT' => $SENDVAT, 'COMPANYNAME' => $COMPANYNAME, 'NPWP' => $NPWP, 'NPWPADDRESS' => $NPWPADDRESS, 'DISTERMDATE' => $DISTERMDATE, 'DISCOUNT' => $DISCOUNT, 'REMARKS' => $REMARKS, 'CRT_USER' => $CRT_USER, 'CRT_DATE' => $CRT_DATE, 'SPLIT' => $SPLIT, 'PARENTID' => $PARENTID, 'PRODUCTID' => $PRODUCTID
                ]
            );

	        return back()
	            ->with('success','You have successfully Inserted a new Customer.');
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

    public function edit(Request $request)
    {
        if(Session::get('userid'))
        {
            $editid             = $request->custno2;
	        $CUSTOMERNAME       = $request->custname2;
            $ACTIVATIONDATE     = $request->actdate2;
	        $STATUSCODE    	    = $request->status2;
	        $DISTERMDATE   	    = $request->disdate2;
	        $DISCOUNT      	    = $request->disc2;
	        $SALESAGENTCODE     = $request->salesname2;
	        $CUSTOMERTYPECODE   = $request->ctype2;
	        $PAYMENTCODE        = $request->paymenttype2;
	        $SPLIT    	        = $request->split2;
	        $ATTENTION 	        = $request->attention2;
	        $PHONE1    	        = $request->Phone2a;
	        $PHONE2             = $request->Phone22;
	        $EMAIL    	        = $request->email2;
	        $VATFREE 	        = $request->freevat2;
	        $SENDVAT   	        = $request->vatinv2;
	        $NPWP               = $request->npwp2;
	        $COMPANYNAME        = $request->npwpname2;
	        $BILLINGADDRESS1    = $request->addr12;
	        $BILLINGADDRESS2    = $request->addr22;
	        $BILLINGADDRESS3    = $request->addr32;
	        $BILLINGADDRESS4    = $request->addr42;
	        $BILLINGADDRESS5    = $request->addr52;
	        $ZIPCODE  	        = $request->zipcode2;
	        $NPWPADDRESS        = $request->npwpaddr2;
	        $REMARKS  	        = $request->remarks2;
            $PRODUCTID          = $request->product2;
	        $UPD_USER 	        = $request->userid2;
	        $UPD_DATE 	        = date('Y-m-d H:i:s');

            if ($DISTERMDATE == "" || empty($DISTERMDATE))
            {
                $DISTERMDATE = "1900-01-01 00:00:00";
            }
            //dd($editid);

            //$data = array('CUSTOMERNAME' => $CUSTOMERNAME, 'CUSTOMERTYPECODE' => $CUSTOMERTYPECODE, 'ACTIVATIONDATE' => $ACTIVATIONDATE, 'STATUSCODE' => $STATUSCODE, 'SALESAGENTCODE' => $SALESAGENTCODE, 'BILLINGADDRESS1' => $BILLINGADDRESS1, 'BILLINGADDRESS2' => $BILLINGADDRESS2, 'BILLINGADDRESS3' => $BILLINGADDRESS3, 'BILLINGADDRESS4' => $BILLINGADDRESS4, 'BILLINGADDRESS5' => $BILLINGADDRESS5, 'ZIPCODE' => $ZIPCODE, 'ATTENTION' => $ATTENTION, 'PHONE1' => $PHONE1, 'PHONE2' => $PHONE2, 'EMAIL' => $EMAIL, 'PAYMENTCODE' => $PAYMENTCODE, 'VATFREE' => $VATFREE, 'SENDVAT' => $SENDVAT, 'COMPANYNAME' => $COMPANYNAME, 'NPWP' => $NPWP, 'NPWPADDRESS' => $NPWPADDRESS, 'DISTERMDATE' => $DISTERMDATE, 'DISCOUNT' => $DISCOUNT, 'REMARKS' => $REMARKS, 'UPD_USER' => $UPD_USER, 'UPD_DATE' => $UPD_DATE, 'SPLIT' => $SPLIT, 'PRODUCTID' => $PRODUCTID);

		    //M_MCustomer::updateData($editid, $data);
			
			DB::table('billing_ats.customer')
<<<<<<< HEAD
					->where('CUSTOMERNO', $editid)
					->update(
						[
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
							'UPD_USER'			=> $UPD_USER, 
							'UPD_DATE'			=> $UPD_DATE, 
							'SPLIT'				=> $SPLIT, 
							'PRODUCTID'			=> $PRODUCTID
						]
					);
=======
			->where('CUSTOMERNO', $editid)
			->update(
				[
					'CUSTOMERNAME' => $CUSTOMERNAME, 'CUSTOMERTYPECODE' => $CUSTOMERTYPECODE, 'ACTIVATIONDATE' => $ACTIVATIONDATE, 'STATUSCODE' => $STATUSCODE, 'SALESAGENTCODE' => $SALESAGENTCODE, 'BILLINGADDRESS1' => $BILLINGADDRESS1, 'BILLINGADDRESS2' => $BILLINGADDRESS2, 'BILLINGADDRESS3' => $BILLINGADDRESS3, 'BILLINGADDRESS4' => $BILLINGADDRESS4, 'BILLINGADDRESS5' => $BILLINGADDRESS5, 'ZIPCODE' => $ZIPCODE, 'ATTENTION' => $ATTENTION, 'PHONE1' => $PHONE1, 'PHONE2' => $PHONE2, 'EMAIL' => $EMAIL, 'PAYMENTCODE' => $PAYMENTCODE, 'VATFREE' => $VATFREE, 'SENDVAT' => $SENDVAT, 'COMPANYNAME' => $COMPANYNAME, 'NPWP' => $NPWP, 'NPWPADDRESS' => $NPWPADDRESS, 'DISTERMDATE' => $DISTERMDATE, 'DISCOUNT' => $DISCOUNT, 'REMARKS' => $REMARKS, 'UPD_USER' => $UPD_USER, 'UPD_DATE' => $UPD_DATE, 'SPLIT' => $SPLIT, 'PRODUCTID' => $PRODUCTID
				]
			);
>>>>>>> bd2846139fb3bf686ad6c312b46f8d84a6ba3bb9

			DB::connection('mysql_2')->table('db_master_ats.customer')
			->where('CUSTOMERNO', $editid)
			->update(
				[
<<<<<<< HEAD
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
					'UPD_USER'			=> $UPD_USER, 
					'UPD_DATE'			=> $UPD_DATE, 
					'SPLIT'				=> $SPLIT, 
					'PRODUCTID'			=> $PRODUCTID
				]);
=======
					'CUSTOMERNAME' => $CUSTOMERNAME, 'CUSTOMERTYPECODE' => $CUSTOMERTYPECODE, 'ACTIVATIONDATE' => $ACTIVATIONDATE, 'STATUSCODE' => $STATUSCODE, 'SALESAGENTCODE' => $SALESAGENTCODE, 'BILLINGADDRESS1' => $BILLINGADDRESS1, 'BILLINGADDRESS2' => $BILLINGADDRESS2, 'BILLINGADDRESS3' => $BILLINGADDRESS3, 'BILLINGADDRESS4' => $BILLINGADDRESS4, 'BILLINGADDRESS5' => $BILLINGADDRESS5, 'ZIPCODE' => $ZIPCODE, 'ATTENTION' => $ATTENTION, 'PHONE1' => $PHONE1, 'PHONE2' => $PHONE2, 'EMAIL' => $EMAIL, 'PAYMENTCODE' => $PAYMENTCODE, 'VATFREE' => $VATFREE, 'SENDVAT' => $SENDVAT, 'COMPANYNAME' => $COMPANYNAME, 'NPWP' => $NPWP, 'NPWPADDRESS' => $NPWPADDRESS, 'DISTERMDATE' => $DISTERMDATE, 'DISCOUNT' => $DISCOUNT, 'REMARKS' => $REMARKS, 'UPD_USER' => $UPD_USER, 'UPD_DATE' => $UPD_DATE, 'SPLIT' => $SPLIT, 'PRODUCTID' => $PRODUCTID
				]
			);
			
			DB::connection('mysql_3')->table('billats_new.customer')
			->where('CUSTOMERNO', $editid)
			->update(
				[
					'CUSTOMERNAME' => $CUSTOMERNAME, 'CUSTOMERTYPECODE' => $CUSTOMERTYPECODE, 'ACTIVATIONDATE' => $ACTIVATIONDATE, 'STATUSCODE' => $STATUSCODE, 'SALESAGENTCODE' => $SALESAGENTCODE, 'BILLINGADDRESS1' => $BILLINGADDRESS1, 'BILLINGADDRESS2' => $BILLINGADDRESS2, 'BILLINGADDRESS3' => $BILLINGADDRESS3, 'BILLINGADDRESS4' => $BILLINGADDRESS4, 'BILLINGADDRESS5' => $BILLINGADDRESS5, 'ZIPCODE' => $ZIPCODE, 'ATTENTION' => $ATTENTION, 'PHONE1' => $PHONE1, 'PHONE2' => $PHONE2, 'EMAIL' => $EMAIL, 'PAYMENTCODE' => $PAYMENTCODE, 'VATFREE' => $VATFREE, 'SENDVAT' => $SENDVAT, 'COMPANYNAME' => $COMPANYNAME, 'NPWP' => $NPWP, 'NPWPADDRESS' => $NPWPADDRESS, 'DISTERMDATE' => $DISTERMDATE, 'DISCOUNT' => $DISCOUNT, 'REMARKS' => $REMARKS, 'UPD_USER' => $UPD_USER, 'UPD_DATE' => $UPD_DATE, 'SPLIT' => $SPLIT, 'PRODUCTID' => $PRODUCTID
				]
			);
>>>>>>> bd2846139fb3bf686ad6c312b46f8d84a6ba3bb9

	        return back()
	            ->with('success','Master Customer Updated Successfully.');
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

    public function editgroup(Request $request)
    {
        if(Session::get('userid'))
        {
            $customerno         = $request->oldcustomerno;
	        $oldparentid        = $request->oldparentid;
            $newparentid        = $request->newparentid;

	        $UPD_USER 	        = $request->userid3;
	        $UPD_DATE 	        = date('Y-m-d H:i:s');

            DB::table('billing_ats.customer')
				->where('customer.CUSTOMERNO', $customerno)
				->update(['customer.PARENTID' => $newparentid, 'UPD_USER' => $UPD_USER, 'UPD_DATE' => $UPD_DATE]);

            DB::connection('mysql_2')->table('db_master_ats.customer')
				->where('customer.CUSTOMERNO', $customerno)
				->update(['customer.PARENTID' => $newparentid, 'UPD_USER' => $UPD_USER, 'UPD_DATE' => $UPD_DATE]);
<<<<<<< HEAD
=======

            DB::connection('mysql_3')->table('billats_new.customer')
				->where('customer.CUSTOMERNO', $customerno)
				->update(['customer.PARENTID' => $newparentid, 'UPD_USER' => $UPD_USER, 'UPD_DATE' => $UPD_DATE]);
>>>>>>> bd2846139fb3bf686ad6c312b46f8d84a6ba3bb9

	        return back()
	            ->with('success','Master Group Customer Updated Successfully.');
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

    public function cariCustomer(Request $request, $id)
    {
        if(Session::get('userid'))
        {
            $data = DB::table('billing_ats.customer')
                    ->where('CUSTOMERNAME', 'like', '%' . $id . '%')
                    ->select('CUSTOMERNO', 'CUSTOMERNAME')
                    ->distinct()
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

    public function view(Request $request,  $id)
    {
        if(Session::get('userid'))
        {
            $data = DB::table('billing_ats.customer')
                    ->where('customer.CUSTOMERNO', $id)
                    ->join('billing_ats.paymentmethod', 'paymentmethod.PAYMENTCODE', '=', 'customer.PAYMENTCODE')
                    ->join('billing_ats.salesagent', 'salesagent.SALESAGENTCODE', '=', 'customer.SALESAGENTCODE')
                    ->join('billing_ats.master_product', 'master_product.id', '=', 'customer.PRODUCTID')
                    ->join('billing_ats.customer_parent', 'customer_parent.ID', '=', 'customer.PARENTID')
                    ->select('customer.CUSTOMERNO', 'CUSTOMERNAME', DB::raw('CASE WHEN CUSTOMERTYPECODE = "C" THEN "CORPORATE" WHEN CUSTOMERTYPECODE = "B" THEN "RESELLER" WHEN CUSTOMERTYPECODE = "R" THEN "RESIDENTIAL" END AS CUSTOMERTYPECODE'), DB::raw('CUSTOMERTYPECODE AS CUSTOMERTYPEID'), 'ACTIVATIONDATE', DB::raw('CASE WHEN STATUSCODE = "A" THEN "Actived" ELSE "Not Actived" END AS STATUSCODE'), DB::raw('STATUSCODE AS STATUSID'), 'SALESAGENTNAME', 'customer.SALESAGENTCODE', 'BILLINGADDRESS1', 'BILLINGADDRESS2', 'BILLINGADDRESS3', 'BILLINGADDRESS4', 'BILLINGADDRESS5', 'ZIPCODE','ATTENTION', 'PHONE1', 'PHONE2', 'EMAIL', 'paymentmethod.PAYMENTMETHOD', 'customer.PAYMENTCODE', DB::raw('CASE WHEN VATFREE = "N" THEN "No" ELSE "Yes" END AS VATFREE'), DB::raw('VATFREE AS VATFREEID'), DB::raw('CASE WHEN SENDVAT = "Y" THEN "Yes" ELSE "No" END AS SENDVAT'), DB::raw('SENDVAT AS SENDVATID'), 'COMPANYNAME', 'NPWP', 'NPWPADDRESS', DB::raw('CASE WHEN DISTERMDATE = "0000-00-00" THEN "" ELSE DISTERMDATE END AS DISTERMDATE'), DB::raw('CASE WHEN DISCOUNT = "N" THEN "No" ELSE "Yes" END AS DISCOUNT'), DB::raw('DISCOUNT AS DISCOUNTID'), 'REMARKS', 'SPLIT', 'customer.PRODUCTID', 'productname', 'customer.PARENTID', 'PARENT_CUSTOMER', DB::raw('CASE WHEN SPLIT = 0 THEN "No" ELSE "Yes" END AS SPLITINV'))
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

    public function delete(Request $request,  $id)
    {
        if(Session::get('userid'))
        {
            DB::table('billing_ats.customer')->where('customer.CUSTOMERNO',$id)->delete();    
<<<<<<< HEAD
            
            DB::connection('mysql_2')->table('db_master_ats.customer')->where('customer.CUSTOMERNO',$id)->delete();    
=======
            
            DB::connection('mysql_2')->table('db_master_ats.customer')->where('customer.CUSTOMERNO',$id)->delete();    
            
            DB::connection('mysql_3')->table('billats_new.customer')->where('customer.CUSTOMERNO',$id)->delete();    
>>>>>>> bd2846139fb3bf686ad6c312b46f8d84a6ba3bb9

            return back()
                    ->with('success','A Customer was deleted successfully.');
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
