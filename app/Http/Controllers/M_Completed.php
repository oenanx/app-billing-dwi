<?php

namespace App\Http\Controllers;

use App\Models\Mod_Company;
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
use SSH;

class M_Completed extends Controller
{
    public function index(Request $request)
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
						->where('active', 1)
						->join('salesagent', 'salesagent.SALESAGENTCODE', '=', 'master_company.SALESAGENTCODE')	
						->select('master_company.id','customerno','company_name','address','address_npwp','phone_fax','email_pic','email_billing','npwpno','npwpname','activation_date','notes','SALESAGENTNAME',DB::raw('(active) as factive'), DB::raw('(CASE WHEN active = 1 THEN "Active" ELSE "Inactive" END) as active'), 'fcompleted', DB::raw('(CASE WHEN fcompleted = 1 THEN "Completed" WHEN fcompleted = 0 THEN "Not Completed" END) as fcomplete'), 'fftp', DB::raw('(CASE WHEN fftp = 1 THEN "Ada FTP" ELSE "Tidak Ada FTP" END) as fftpdesc'))
						->orderBy('master_company.id','DESC')
						->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 10))
						->appends(request()->query());

                return response()->paginator($data);
			}
			
			return view('home.master_company.complete', compact('sales','customer'));
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
	
    public function complete_cust($id)
	{
		if(Session::get('userid'))
		{
			//dd($id);
			$activation_date	= date('Y-m-d H:i:s');
			
	    	DB::table('master_company')
				->where('id',$id)
				->update(    
					[
						'active' => 1,
						'activation_date' => $activation_date,
						'fcompleted' => 1,
					]);

	        return back()
	        		->with('success','All Registration Data were saved successfully.');
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

    public function sync(Request $request, $id)
	{
		//dd($id);
		if(Session::get('userid'))
		{
			$data1	= DB::table('master_company')->where('customerno', $id)->select('id')->first();
			$comp_id = $data1->id;
			//dd($comp_id);
			
			$data2	= DB::table('master_user_appglobal')->where('company_id', $comp_id)->first();
			//dd($data2);
			
			if(empty($data2) || $data2 == null) //Jika data belum ada di tool datawhiz proc_close
			{
				//return back()->with('error','Harap edit non ftp di sub menu Company dahulu');
				return response()->json(['error' => 'Harap edit non ftp di sub menu Company dahulu']);
			}
			else
			{
				$datax	= DB::connection('mysql_4')->table('master_company')->where('customerno', $id)->where('apptypeid', 2)->first();

				if(empty($datax) || $datax == null) //Jika data belum ada di appglobal
				{
					$data	= DB::table('master_company')
								->where('customerno', $id)
								->select('master_company.id','customerno','company_name','phone_fax','address','address2','address3','address4','address5','zipcode','address_npwp','email_pic','email_billing','npwpno','npwpname','SALESAGENTCODE','notes','active','activation_date','create_by','create_at','discount','tech_pic_name','billing_pic_name','productid','fcompleted')
								->get();
					
					foreach ($data as $company)
					{
						$idx				= $company->id;
						$customerno 		= $company->customerno;
						$company_name		= $company->company_name;
						$phone_fax			= $company->phone_fax;
						$address			= $company->address;
						$address2			= $company->address2;
						$address3			= $company->address3;
						$address4			= $company->address4;
						$address5			= $company->address5;
						$zipcode			= $company->zipcode;
						$address_npwp		= $company->address_npwp;
						$email_pic			= $company->email_pic;
						$email_billing		= $company->email_billing;
						$npwpno				= $company->npwpno;
						$npwpname			= $company->npwpname;
						$SALESAGENTCODE		= $company->SALESAGENTCODE;
						$notes				= $company->notes;
						$active				= $company->active;
						$activation_date	= $company->activation_date;
						$create_by			= 1;
						$create_at			= $company->create_at;
						$discount			= $company->discount;
						$tech_pic_name		= $company->tech_pic_name;
						$billing_pic_name	= $company->billing_pic_name;
						$productid			= $company->productid;
						$fcompleted			= $company->fcompleted;
					}
					
					$id1 = DB::connection('mysql_4')->table('master_company')->insertGetId(
						[
							'customerno' => $customerno, 'company_name' => $company_name, 'phone_fax' => $phone_fax, 'address' => $address, 'address2' => $address2, 'address3' => $address3, 'address4' => $address4, 'address5' => $address5, 'zipcode' => $zipcode, 'address_npwp' => $address_npwp, 'email_pic' => $email_pic, 'email_billing' => $email_billing, 'npwpno' => $npwpno, 'npwpname' => $npwpname, 'SALESAGENTCODE' => $SALESAGENTCODE, 'notes' => $notes, 'active' => $active, 'activation_date' => $activation_date, 'create_by' => 1, 'create_at' => $create_at, 'discount' => $discount, 'tech_pic_name' => $tech_pic_name, 'billing_pic_name' => $billing_pic_name, 'productid' => $productid, 'fcompleted' => $fcompleted, 'concurrent' => 0, 'apptypeid' => 2
						]
					);

					$data	= DB::table('master_paket_customer')
								->where('customerno', $id)
								->select('product_paket_id','customerno')
								->get();
					
					foreach ($data as $company)
					{
						$product_paket_id	= $company->product_paket_id;
						$custno 			= $company->customerno;
					}
					
					DB::connection('mysql_4')->table('master_paket_customer')->insert(
						[
							'product_paket_id'	=> $product_paket_id,
							'customerno'		=> $custno,
							'created_at'		=> date('Y-m-d H:i:s')
						]
					);
					//id,company_id,username,password,passwd,full_name,divisi_name,group_id,active,createdby,createddate,updby,upddate,folder
					$user	= DB::table('master_user_appglobal')
								->where('company_id', $comp_id)
								->select('company_id','username','password','passwd','full_name','divisi_name','group_id','active','createdby','createddate','updby','upddate','folder')
								->get();
					
					foreach ($user as $users)
					{
						$company_id		= $users->company_id;
						$username 		= $users->username;
						$password 		= $users->password;
						$passwd 		= $users->passwd;
						$full_name 		= $users->full_name;
						$divisi_name	= $users->divisi_name;
						$group_id 		= $users->group_id;
						$updby 			= $users->updby;
						$upddate 		= $users->upddate;
						$folders 		= $users->folder;
					}
					
					SSH::run(array(
						'mkdir /DATAWHIZ/'.$folders,
						'chmod +777 /DATAWHIZ/'.$folders,
					));
					//dd('Stop');
					//id,company_id,username,password,passwd,full_name,divisi_name,group_id,active,create_by,create_at,update_by,update_at,folder,apptypeid
					DB::connection('mysql_4')->table('master_user')->insert(
						[
							'company_id'	=> $id1,
							'username'		=> $username,
							'password'		=> $password,
							'passwd'		=> $passwd,
							'full_name'		=> $full_name,
							'divisi_name'	=> $divisi_name,
							'group_id'		=> 2,
							'active'		=> 1,
							'create_by'		=> 1,
							'create_at'		=> date('Y-m-d H:i:s'),
							'folder'		=> $folders,
							'apptypeid'		=> 2
						]
					);

					//kirim notif email username dan password ke pic customer
					$to = $username;
					$cc = env('EMAIL_MIS');
					
					$details = [
						'title' => 'Dear '.$company_name.',',
						'body1' => 'Berikut adalah akses ke Aplikasi Dashboard AppGlobal : ',
						'body2' => 'Url Apps : https://appglobal.atlasat.co.id/datawhiz/',
						'body3' => 'Username : '.$username,
						'body4' => 'Password : '.$passwd,
						'body5' => 'Harap merubah password anda setelah menerima email ini.',
						'body6' => 'Terima kasih.',
					];
				   
					Mail::to($to)->cc($cc)->send(new \App\Mail\NotifUsernameNonSFTP($details));
					
				}
				else //Jika data sudah ada di appglobal
				{
					$dataz	= DB::connection('mysql_4')->table('master_company')->where('customerno', $id)->where('apptypeid', 2)->select('id')->first();
					//dd($dataz->id);
					$comp_id_awal = $dataz->id;
					//dd($comp_id_awal);
					DB::connection('mysql_4')->table('master_user')->where('company_id',$comp_id_awal)->where('apptypeid', 2)->delete();
					
					DB::connection('mysql_4')->table('master_company')->where('customerno',$id)->where('apptypeid', 2)->delete();
					
					$data	= DB::table('master_company')
								->where('customerno', $id)
								->select('master_company.id','customerno','company_name','phone_fax','address','address2','address3','address4','address5','zipcode','address_npwp','email_pic','email_billing','npwpno','npwpname','SALESAGENTCODE','notes','active','activation_date','create_by','create_at','discount','tech_pic_name','billing_pic_name','productid','fcompleted')
								->get();
					
					foreach ($data as $company)
					{
						$idy				= $company->id;
						$customerno 		= $company->customerno;
						$company_name		= $company->company_name;
						$phone_fax			= $company->phone_fax;
						$address			= $company->address;
						$address2			= $company->address2;
						$address3			= $company->address3;
						$address4			= $company->address4;
						$address5			= $company->address5;
						$zipcode			= $company->zipcode;
						$address_npwp		= $company->address_npwp;
						$email_pic			= $company->email_pic;
						$email_billing		= $company->email_billing;
						$npwpno				= $company->npwpno;
						$npwpname			= $company->npwpname;
						$SALESAGENTCODE		= $company->SALESAGENTCODE;
						$notes				= $company->notes;
						$active				= $company->active;
						$activation_date	= $company->activation_date;
						$create_by			= 1;
						$create_at			= $company->create_at;
						$discount			= $company->discount;
						$tech_pic_name		= $company->tech_pic_name;
						$billing_pic_name	= $company->billing_pic_name;
						$productid			= $company->productid;
						$fcompleted			= $company->fcompleted;
					}
					
					$id2 = DB::connection('mysql_4')->table('master_company')->insertGetId(
						[
							'customerno' => $customerno, 'company_name' => $company_name, 'phone_fax' => $phone_fax, 'address' => $address, 'address2' => $address2, 'address3' => $address3, 'address4' => $address4, 'address5' => $address5, 'zipcode' => $zipcode, 'address_npwp' => $address_npwp, 'email_pic' => $email_pic, 'email_billing' => $email_billing, 'npwpno' => $npwpno, 'npwpname' => $npwpname, 'SALESAGENTCODE' => $SALESAGENTCODE, 'notes' => $notes, 'active' => $active, 'activation_date' => $activation_date, 'create_by' => 1, 'create_at' => $create_at, 'discount' => $discount, 'tech_pic_name' => $tech_pic_name, 'billing_pic_name' => $billing_pic_name, 'productid' => $productid, 'fcompleted' => $fcompleted, 'concurrent' => 0, 'apptypeid' => 2
						]
					);					
					//id,company_id,username,password,passwd,full_name,divisi_name,group_id,active,createdby,createddate,updby,upddate,folder
					$user	= DB::table('master_user_appglobal')
								->where('company_id', $comp_id)
								->select('company_id','username','password','passwd','full_name','divisi_name','group_id','active','createdby','createddate','updby','upddate','folder')
								->get();
					
					foreach ($user as $users)
					{
						$company_id		= $users->company_id;
						$username 		= $users->username;
						$password 		= $users->password;
						$passwd 		= $users->passwd;
						$full_name 		= $users->full_name;
						$divisi_name	= $users->divisi_name;
						$group_id 		= $users->group_id;
						$updby 			= $users->updby;
						$upddate 		= $users->upddate;
						$folders 		= $users->folder;
					}
					
					SSH::run(array(
						'mkdir /DATAWHIZ/'.$folders,
						'chmod +777 /DATAWHIZ/'.$folders,
					));
					//dd('Stop');
					//id,company_id,username,password,passwd,full_name,divisi_name,group_id,active,create_by,create_at,update_by,update_at,folder,apptypeid
					DB::connection('mysql_4')->table('master_user')->insert(
						[
							'company_id'	=> $id2,
							'username'		=> $username,
							'password'		=> $password,
							'passwd'		=> $passwd,
							'full_name'		=> $full_name,
							'divisi_name'	=> $divisi_name,
							'group_id'		=> 2,
							'active'		=> 1,
							'create_by'		=> 1,
							'create_at'	=> date('Y-m-d H:i:s'),
							'folder'		=> $folders,
							'apptypeid'		=> 2
						]
					);

					//kirim notif email username dan password ke pic customer
					$to = $username;
					$cc = env('EMAIL_MIS');
					
					$details = [
						'title' => 'Dear '.$company_name.',',
						'body1' => 'Berikut adalah akses ke Aplikasi Dashboard AppGlobal : ',
						'body2' => 'Url Apps : https://appglobal.atlasat.co.id/datawhiz/',
						'body3' => 'Username : '.$username,
						'body4' => 'Password : '.$passwd,
						'body5' => 'Harap merubah password anda setelah menerima email ini.',
						'body6' => 'Terima kasih.',
					];
				   
					Mail::to($to)->cc($cc)->send(new \App\Mail\NotifUsernameNonSFTP($details));

				}

				//return back()->with('success','All Data were synced successfully.');
				return response()->json(['success' => 'All Data were synced successfully.']);
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
