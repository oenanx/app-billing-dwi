<?php
namespace App\Http\Controllers;

use App\Models\M_MGCustomer;
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

class GCustomer extends Controller
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

				$data = QueryBuilder::for(M_MGCustomer::class) //DB::table('billing_ats.customer_parent')
    		            ->select(DB::raw('ID AS IDS'), 'PARENT_CUSTOMER', 'CRT_USER', DB::raw('DATE_FORMAT(CRT_DATE,"%d-%m-%Y") AS CRTE_DATE'))
						->orderBy('ID','desc')
						->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 10))
						->appends(request()->query());

                return response()->paginator($data);
            }

            return view('home.master_company.mgcustomer');

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
    
    public function insert(Request $request)
    {
        if(Session::get('userid'))
        {
	        $PARENT_CUSTOMER    = $request->parent;
	        $BILLINGADDRESS1    = $request->addr1;
	        $BILLINGADDRESS2    = $request->addr2;
	        $BILLINGADDRESS3    = $request->addr3;
	        $BILLINGADDRESS4    = $request->addr4;
	        $BILLINGADDRESS5    = $request->addr5;
	        $ZIPCODE  	        = $request->zipcode;
			$ATTENTION  	    = $request->attention;
			$PHONE1  	        = $request->Phone;
			$PHONE2  	        = $request->Phone2;
			$EMAIL  	        = $request->email;
			$VATFREE  	        = $request->freevat;
			$SENDVAT  	        = $request->vatinv;
			$COMPANYNAME  	    = $request->npwpname;
			$NPWP  	        	= $request->npwp;
			$NPWPADDRESS  	    = $request->npwpaddr;
	        $CRT_USER 	        = $request->userid;
	        $CRT_DATE 	        = date('Y-m-d H:i:s');

            DB::table('billing_ats.customer_parent')->insert(
                [
                    'PARENT_CUSTOMER' 	=> $PARENT_CUSTOMER,
                    'CRT_USER' 			=> $CRT_USER,
                    'CRT_DATE' 			=> $CRT_DATE,
					'BILLINGADDRESS1' 	=> $BILLINGADDRESS1,
					'BILLINGADDRESS2' 	=> $BILLINGADDRESS2,
					'BILLINGADDRESS3' 	=> $BILLINGADDRESS3,
					'BILLINGADDRESS4' 	=> $BILLINGADDRESS4,
					'BILLINGADDRESS5' 	=> $BILLINGADDRESS5,
					'ZIPCODE' 			=> $ZIPCODE,
					'ATTENTION' 		=> $ATTENTION,
					'PHONE1' 			=> $PHONE1,
					'PHONE2' 			=> $PHONE2,
					'EMAIL' 			=> $EMAIL,
					'VATFREE' 			=> $VATFREE,
					'SENDVAT' 			=> $SENDVAT,
					'COMPANYNAME' 		=> $COMPANYNAME,
					'NPWP' 				=> $NPWP,
					'NPWPADDRESS' 		=> $NPWPADDRESS
                ]
            );
            
            DB::connection('mysql_2')->table('db_master_ats.customer_parent')->insert(
                [
                    'PARENT_CUSTOMER' 	=> $PARENT_CUSTOMER,
                    'CRT_USER' 			=> $CRT_USER,
                    'CRT_DATE' 			=> $CRT_DATE,
					'BILLINGADDRESS1' 	=> $BILLINGADDRESS1,
					'BILLINGADDRESS2' 	=> $BILLINGADDRESS2,
					'BILLINGADDRESS3' 	=> $BILLINGADDRESS3,
					'BILLINGADDRESS4' 	=> $BILLINGADDRESS4,
					'BILLINGADDRESS5' 	=> $BILLINGADDRESS5,
					'ZIPCODE' 			=> $ZIPCODE,
					'ATTENTION' 		=> $ATTENTION,
					'PHONE1' 			=> $PHONE1,
					'PHONE2' 			=> $PHONE2,
					'EMAIL' 			=> $EMAIL,
					'VATFREE' 			=> $VATFREE,
					'SENDVAT' 			=> $SENDVAT,
					'COMPANYNAME' 		=> $COMPANYNAME,
					'NPWP' 				=> $NPWP,
					'NPWPADDRESS' 		=> $NPWPADDRESS
                ]
            );

            DB::connection('mysql_3')->table('billing_ats.customer_parent')->insert(
                [
                    'PARENT_CUSTOMER' 	=> $PARENT_CUSTOMER,
                    'CRT_USER' 			=> $CRT_USER,
                    'CRT_DATE' 			=> $CRT_DATE,
					'BILLINGADDRESS1' 	=> $BILLINGADDRESS1,
					'BILLINGADDRESS2' 	=> $BILLINGADDRESS2,
					'BILLINGADDRESS3' 	=> $BILLINGADDRESS3,
					'BILLINGADDRESS4' 	=> $BILLINGADDRESS4,
					'BILLINGADDRESS5' 	=> $BILLINGADDRESS5,
					'ZIPCODE' 			=> $ZIPCODE,
					'ATTENTION' 		=> $ATTENTION,
					'PHONE1' 			=> $PHONE1,
					'PHONE2' 			=> $PHONE2,
					'EMAIL' 			=> $EMAIL,
					'VATFREE' 			=> $VATFREE,
					'SENDVAT' 			=> $SENDVAT,
					'COMPANYNAME' 		=> $COMPANYNAME,
					'NPWP' 				=> $NPWP,
					'NPWPADDRESS' 		=> $NPWPADDRESS
                ]
            );

	        return back()
	            ->with('success','You have successfully Inserted a new Group Customer.');
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

    public function edit(Request $request)
    {
        if(Session::get('userid'))
        {
            $editid             = $request->id2;
	        $PARENT_CUSTOMER    = $request->parent2;
	        $BILLINGADDRESS1    = $request->addr12;
	        $BILLINGADDRESS2    = $request->addr22;
	        $BILLINGADDRESS3    = $request->addr32;
	        $BILLINGADDRESS4    = $request->addr42;
	        $BILLINGADDRESS5    = $request->addr52;
	        $ZIPCODE  	        = $request->zipcode2;

			$ATTENTION  	    = $request->attention2;
			$PHONE1  	        = $request->telp3;
			$PHONE2  	        = $request->telp4;
			$EMAIL  	        = $request->email2;
			$VATFREE  	        = $request->freevat2;
			$SENDVAT  	        = $request->sendvat2;
			$COMPANYNAME  	    = $request->npwpname2;
			$NPWP  	        	= $request->npwp2;
			$NPWPADDRESS  	    = $request->npwpaddr2;

	        $UPD_USER 	        = $request->userid2;
	        $UPD_DATE 	        = date('Y-m-d H:i:s');

            DB::table('billing_ats.customer_parent')
				->where('ID', $editid)
				->update(['PARENT_CUSTOMER' => $PARENT_CUSTOMER, 'UPD_USER' => $UPD_USER, 'UPD_DATE' => $UPD_DATE, 'BILLINGADDRESS1' => $BILLINGADDRESS1, 'BILLINGADDRESS2' => $BILLINGADDRESS2, 'BILLINGADDRESS3' => $BILLINGADDRESS3, 'BILLINGADDRESS4' => $BILLINGADDRESS4, 'BILLINGADDRESS5' => $BILLINGADDRESS5, 'ZIPCODE' => $ZIPCODE, 'ATTENTION' => $ATTENTION, 'PHONE1' => $PHONE1, 'PHONE2' => $PHONE2, 'EMAIL' => $EMAIL, 'VATFREE' => $VATFREE, 'SENDVAT' => $SENDVAT, 'COMPANYNAME' => $COMPANYNAME, 'NPWP' => $NPWP, 'NPWPADDRESS' => $NPWPADDRESS]);

            DB::connection('mysql_2')->table('db_master_ats.customer_parent')
				->where('ID', $editid)
				->update(['PARENT_CUSTOMER' => $PARENT_CUSTOMER, 'UPD_USER' => $UPD_USER, 'UPD_DATE' => $UPD_DATE, 'BILLINGADDRESS1' => $BILLINGADDRESS1, 'BILLINGADDRESS2' => $BILLINGADDRESS2, 'BILLINGADDRESS3' => $BILLINGADDRESS3, 'BILLINGADDRESS4' => $BILLINGADDRESS4, 'BILLINGADDRESS5' => $BILLINGADDRESS5, 'ZIPCODE' => $ZIPCODE, 'ATTENTION' => $ATTENTION, 'PHONE1' => $PHONE1, 'PHONE2' => $PHONE2, 'EMAIL' => $EMAIL, 'VATFREE' => $VATFREE, 'SENDVAT' => $SENDVAT, 'COMPANYNAME' => $COMPANYNAME, 'NPWP' => $NPWP, 'NPWPADDRESS' => $NPWPADDRESS]);

            DB::connection('mysql_3')->table('billing_ats.customer_parent')
				->where('ID', $editid)
				->update(['PARENT_CUSTOMER' => $PARENT_CUSTOMER, 'UPD_USER' => $UPD_USER, 'UPD_DATE' => $UPD_DATE, 'BILLINGADDRESS1' => $BILLINGADDRESS1, 'BILLINGADDRESS2' => $BILLINGADDRESS2, 'BILLINGADDRESS3' => $BILLINGADDRESS3, 'BILLINGADDRESS4' => $BILLINGADDRESS4, 'BILLINGADDRESS5' => $BILLINGADDRESS5, 'ZIPCODE' => $ZIPCODE, 'ATTENTION' => $ATTENTION, 'PHONE1' => $PHONE1, 'PHONE2' => $PHONE2, 'EMAIL' => $EMAIL, 'VATFREE' => $VATFREE, 'SENDVAT' => $SENDVAT, 'COMPANYNAME' => $COMPANYNAME, 'NPWP' => $NPWP, 'NPWPADDRESS' => $NPWPADDRESS]);

	        return back()
	            ->with('success','Master Group Customer was Updated Successfully.');
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

    public function cariGCustomer(Request $request, $id)
    {
        if(Session::get('userid'))
        {
            $data = DB::table('billing_ats.customer_parent')
                    ->where('PARENT_CUSTOMER', 'like', '%' . $id . '%')
                    ->select('ID', 'PARENT_CUSTOMER', 'BILLINGADDRESS1', 'BILLINGADDRESS2', 'BILLINGADDRESS3', 'BILLINGADDRESS4', 'BILLINGADDRESS5', 'ZIPCODE', 'ATTENTION', 'PHONE1', 'PHONE2', 'EMAIL', DB::raw('CASE WHEN VATFREE = "Y" THEN "Yes" ELSE "No" END AS VATFREE'), DB::raw('VATFREE AS VATFREECODE'), DB::raw('CASE WHEN SENDVAT = "Y" THEN "Yes" ELSE "No" END AS SENDVAT'), DB::raw('SENDVAT AS SENDVATCODE'), 'COMPANYNAME', 'NPWP', 'NPWPADDRESS')
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

			return redirect('/')->with('alert','You were Logout');
			echo "<script>window.close();</script>";
        }
    }

    public function view(Request $request,  $id)
    {
        if(Session::get('userid'))
        {
            $data = DB::table('billing_ats.customer_parent')
                    ->where('ID', $id)
                    ->select('ID', 'PARENT_CUSTOMER', 'CRT_USER', 'CRT_DATE', 'BILLINGADDRESS1', 'BILLINGADDRESS2', 'BILLINGADDRESS3', 'BILLINGADDRESS4', 'BILLINGADDRESS5', 'ZIPCODE', 'ATTENTION', 'PHONE1', 'PHONE2', 'EMAIL', DB::raw('CASE WHEN VATFREE = "Y" THEN "Yes" ELSE "No" END AS VATFREE'), DB::raw('VATFREE AS VATFREECODE'), DB::raw('CASE WHEN SENDVAT = "Y" THEN "Yes" ELSE "No" END AS SENDVAT'), DB::raw('SENDVAT AS SENDVATCODE'),'COMPANYNAME','NPWP','NPWPADDRESS')
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

    public function delete(Request $request,  $id)
    {
        if(Session::get('userid'))
        {
            DB::table('billing_ats.customer_parent')->where('ID',$id)->delete(); 

            DB::connection('mysql_2')->table('db_master_ats.customer_parent')->where('ID', $id)->delete(); 
            
            DB::connection('mysql_3')->table('billing_ats.customer_parent')->where('ID', $id)->delete(); 
            
           return back()->with('success','A Group Customer was deleted successfully.');
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
}

