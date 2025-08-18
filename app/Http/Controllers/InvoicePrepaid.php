<?php

namespace App\Http\Controllers;

//use App\Models\Mod_Invoice;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class InvoicePrepaid extends Controller
{
    public function index(Request $request)
    {
        if(Session::get('userid'))
        {
            $data1['tgl'] = DB::select('SELECT BL_CODE,BL_DESC FROM sys_month WHERE BL_CODE = (SELECT DATE_FORMAT(CURDATE(),"%m"));');
            $data1['thn'] = DB::select('SELECT DATE_FORMAT(CURDATE(), "%Y") AS TAHUN;');
			$data1['period'] = DB::select('SELECT DISTINCT PERIOD FROM bs ORDER BY PERIOD DESC;');

            return view('home.invoiceprepaid.index')->with($data1);
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
	
	/*
    public function datatable(Request $request)
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

				$data = QueryBuilder::for(Mod_Invoice::class)
						->where('master_company.active',1)
						->where('master_company.invtypeid', 2)
						->join('master_company', 'master_company.customerno', '=', 'invoice_file.customerno')
						->select('invoice_file.id','master_company.customerno', 'master_company.company_name', 'bsno', 'period', DB::raw('file_name as filename'), 'path')
						->orderBy('master_company.customerno','DESC')
						->allowedFilters(
							AllowedFilter::scope('general_search')
						)
						->paginate($request->query('perpage', 10))
						->appends(request()->query());

                return response()->paginator($data);
			}

			return view('home.invoice.index');
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

	public function download($id)
	{
		//dd($id);
		$datas = DB::table('invoice_file')
				->where('id', $id)
				->select('path','file_name')
				->get();

		foreach ($datas as $user)
		{
			$url_media 		= $user->path;
			$file_names		= $user->file_name;
			
			$paths = 'public/invoice/';
			if(Storage::exists($paths.$file_names))
			{
				return Storage::download($paths.$file_names);
			}
			else
			{
				echo "<script>window.close();</script>";
			}
		}
	}

    public function delete(Request $request, $id)
    {
        if(Session::get('userid'))
        {
			$datas = DB::table('invoice_file')
					->where('id', $id)
					->select('path','file_name')
					->get();

			foreach ($datas as $user)
			{
				//$url_media 		= $user->path;
				$file_names		= $user->file_name;
			}
			
			$paths = 'public/invoice/';
			
			Storage::delete($paths.$file_names);
			
            DB::table('invoice_file')->where('invoice_file.id',$id)->delete();    
            
            return back()
                    ->with('success','This Invoice have been deleted successfully.');
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
	*/
}
