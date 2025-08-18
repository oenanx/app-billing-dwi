<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SFTPConnection;
use App\Mail\NotifUpload;
use App\Mail\NotifUploadNonSFTP;
use App\Models\Mod_Trx_FTP;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;
use Maatwebsite\Excel\Facades\Excel;
use SSH;

class UploadFTP extends Controller
{
    public function index(Request $request)
    {
		if(Session::get('userid'))
		{
			return view('home.uploadftp.index');
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

    public function dttable(Request $request)
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

			$data = QueryBuilder::for(Mod_Trx_FTP::class)
					->where('master_company.active', 1)
					//->where('master_company.fftp', 1)
					->leftJoin('master_ftp', 'master_ftp.id', '=', 'trx_ftp.ftpid')	
					->join('master_company', 'master_company.customerno', '=', 'trx_ftp.customerno')	
					->select('trx_ftp.id', 'trx_ftp.customerno','master_company.company_name','ip_ftp','nama_file_download','get_time','get_by',DB::raw('CASE WHEN fproses = 1 THEN "Download" WHEN fproses = 2 THEN "Upload" END as fproses'),DB::raw('CASE WHEN nama_file_upload IS NULL THEN "-" ELSE nama_file_upload END AS nama_file_upload'),DB::raw('CASE WHEN send_time IS NULL THEN "-" ELSE send_time END AS send_time'),DB::raw('FORMAT((ukuran_file / 1024),0) as ukuran_file'),'fftp')
					->orderBy('trx_ftp.id','DESC')
					->allowedFilters(
						AllowedFilter::scope('general_search')
					)
					->paginate($request->query('perpage', 10))
					->appends(request()->query());

			return response()->paginator($data);
		}

        return view('home.uploadftp.index');
	}

	public function upload($id)
    {
        if(Session::get('userid'))
        {
			$data = DB::table('trx_ftp')
					->where('trx_ftp.id', $id)
					->join('master_company', 'master_company.customerno', '=', 'trx_ftp.customerno')	
					->select('trx_ftp.id',DB::raw('master_company.id AS cid'),'master_company.customerno','company_name','fftp','trxidappglobal','parentid')
					->first();
					
			$trx_ftp_id		= $data->id;
			$company_id		= $data->cid;
			$customerno		= $data->customerno;
			$company_name	= $data->company_name;
			$fftp			= $data->fftp;
			$trxidappglobal	= $data->trxidappglobal;
			$parentid		= $data->parentid;

			//return response()->json($data);
			return view('home.uploadftp.proses', compact('trx_ftp_id','company_id','customerno','company_name','fftp','trxidappglobal','parentid'));
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

	public function proses(Request $request)
	{
		if(Session::get('userid'))
		{
			//dd($request);
			$trxid			= $request->trxid;
			$custid			= $request->custid;
			$customerno		= $request->customerno;
			$fftp			= $request->fftp;
			$parentid		= $request->parentid;
			$files		 	= $request->filex;
			$created_at		= date('Y-m-d H:i:s');
			$jammenit		= date('H:i');
			$update_by		= $request->updby;
			$cust_email		= '';
			$folder			= '';

			$getSize		= $files->getSize();
			$extension 		= $files->getClientOriginalExtension();
			$OriginalNames	= $files->getClientOriginalName();
			
			$leftid			= Str::substr($OriginalNames, 0, 5);
			if ($parentid == $leftid)
			{
				$fileName	= Str::replace($parentid, 'RESULT', $OriginalNames);
				$paths		= $files->move(storage_path('app/public/uploads'), $fileName);
			}
			else
			{
				$fileName	= $OriginalNames;
				$paths		= $files->move(storage_path('app/public/uploads'), $fileName);
			}
			//dd($paths);

			$Result1 = DB::table('master_ftp')->select('id','ip_ftp','username','passwd','folder_upload','pic_email','protocol')->where('companyid', $custid)->get();
			foreach ($Result1 as $hsl0)
			{
				$id				= $hsl0->id;
				$ip_ftp			= $hsl0->ip_ftp;
				$username		= $hsl0->username;
				$passwd			= $hsl0->passwd;
				$folder_upload	= $hsl0->folder_upload;
				$pic_email		= $hsl0->pic_email;
				$protocol		= $hsl0->protocol;
			}

			$Result2   = DB::table('master_company')->select('company_name')->where('id', $custid)->get();
			foreach ($Result2 as $hsl1)
			{
				$company_name	= $hsl1->company_name;
			}
			
			if ($fftp == "1" || $fftp == 1) //SFTP & FTP
			{
				//dd("SFTP / FTP");	
				if($protocol === "sftp")
				{
					//dd("SFTP");				
					config([
							'filesystems.disks.sftp'.$id => [
							'driver'	=> 'sftp',
							'host'		=> $ip_ftp,
							'username'	=> $username,
							'password'	=> $passwd,
						],
					]);
					
					$upload = Storage::disk('sftp'.$id)->put($folder_upload."/".$fileName, fopen($paths, 'r+'));
					
					if ($upload === true)
					{
						$status_code = 200;

						DB::table('trx_ftp')
							->where('customerno', $customerno)
							->where('fproses', 1)
							->where('id', $trxid) 
							->update(
								[
									'nama_file_upload'	=> $fileName,
									'ukuran_file'		=> $getSize,
									'status_kirim'		=> $status_code,
									'send_time'			=> date('Y-m-d H:i:s'),
									'fproses'			=> 2,
									'update_by'			=> $update_by,
									'update_at'			=> date('Y-m-d H:i:s'),
								]);

						//unlink(storage_path("app/public/uploads/").$fileName);
						
						//kirim notif email ke pic customer
						$to = $pic_email;
						$cc = env('EMAIL_MIS');
						
						$details = [
							'title' => 'Dear '.$company_name.',',
							'body1' => 'Berikut adalah Upload File Result to '.$ip_ftp.' : ',
							'body2' => '- ['.$jammenit.'] ['.$fileName.']',
							'body3' => 'Terima kasih.',
						];
					   
						Mail::to($to)->cc($cc)->send(new \App\Mail\NotifUpload($details));
						
						return response()->json(['success' => 'success']);
					}
					else
					{
						$status_code = 400;

						DB::table('trx_ftp')
							->where('customerno', $customerno)
							->where('fproses', 1)
							->update(
								[
									'nama_file_upload'	=> $OriginalNames,
									'ukuran_file'		=> $getSize,
									'status_kirim'		=> $status_code,
									'send_time'			=> date('Y-m-d H:i:s'),
									'fproses'			=> 1,
									'update_by'			=> $update_by,
									'update_at'			=> date('Y-m-d H:i:s'),
								]);

						unlink(storage_path("app/public/uploads/").$OriginalNames);
						
						return response()->json(['error' => $upload]);
					}			
				}
				else if($protocol === "ftp")
				{
					//dd("FTP");		
					config([
							'filesystems.disks.ftp'.$id => [
							'driver'	=> 'ftp',
							'host'		=> $ip_ftp,
							'username'	=> $username,
							'password'	=> $passwd,
						],
					]);
					
					$upload = Storage::disk('ftp'.$id)->put($folder_upload."/".$fileName, fopen($paths, 'r+'));
					
					if ($upload === true)
					{
						$status_code = 200;

						DB::table('trx_ftp')
							->where('customerno', $customerno) 
							->where('id', $trxid) 
							->update(
								[
									'nama_file_upload'	=> $fileName,
									'ukuran_file'		=> $getSize,
									'status_kirim'		=> $status_code,
									'send_time'			=> date('Y-m-d H:i:s'),
									'fproses'			=> 2,
									'update_by'			=> $update_by,
									'update_at'			=> date('Y-m-d H:i:s'),
								]);

						//unlink(storage_path("app/public/uploads/").$fileName);
						
						//kirim notif email ke pic customer
						$to = $pic_email;
						$cc = env('EMAIL_MIS');
						
						$details = [
							'title' => 'Dear '.$company_name.',',
							'body1' => 'Berikut adalah Upload File Result to '.$ip_ftp.' : ',
							'body2' => '- ['.$jammenit.'] ['.$fileName.']',
							'body3' => 'Terima kasih.',
						];
					   
						Mail::to($to)->cc($cc)->send(new \App\Mail\NotifUpload($details));
						
						return response()->json(['success' => 'success']);
					}
					else
					{
						$status_code = 400;

						DB::table('trx_ftp')
							->where('customerno', $customerno)
							->update(
								[
									'nama_file_upload'	=> $OriginalNames,
									'ukuran_file'		=> $getSize,
									'status_kirim'		=> $status_code,
									'send_time'			=> date('Y-m-d H:i:s'),
									'fproses'			=> 1,
									'update_by'			=> $update_by,
									'update_at'			=> date('Y-m-d H:i:s'),
								]);

						unlink(storage_path("app/public/uploads/").$OriginalNames);
						
						return response()->json(['error' => $upload]);
					}			
				}
			}
			else //non SFTP
			{
				//dd("SFTP / FTP");
				$trxidapp = $request->trxidapp;
				$Email = DB::table('master_user_appglobal')->select('username','folder')->where('company_id', $custid)->get();
				foreach ($Email as $mail)
				{
					$cust_email		= $mail->username;
					$folder			= $mail->folder;
				}

				//$idx = 1;
				//config([
				//		'filesystems.disks.sftp' => [
				//		'driver'	=> 'sftp',
				//		'host'		=> env('SFTP_HOST1'),
				//		'username'	=> env('SFTP_USERNAME1'),
				//		'password'	=> env('SFTP_PASSWORD1'),
				//	],
				//]);
				
				$upload = SSH::put($paths, '/DATAWHIZ/'.$folder.'/' . $fileName);
				//Storage::disk('sftp')->put("app/public/uploads/".$fileName, fopen($paths, 'r+'));
				//dd($upload);
				if ($upload === null)
				{
					$status_code = 200;

					DB::table('trx_ftp')
						->where('customerno', $customerno)
						->where('fproses', 1)
						->where('id', $trxid) 
						->update(
							[
								'nama_file_upload'	=> $fileName,
								'ukuran_file'		=> $getSize,
								'status_kirim'		=> $status_code,
								'send_time'			=> date('Y-m-d H:i:s'),
								'fproses'			=> 2,
								'update_by'			=> $update_by,
								'update_at'			=> date('Y-m-d H:i:s'),
							]);

					DB::connection('mysql_4')->table('trx_ftp')
						->where('customerno', $customerno)
						->where('fproses', 1)
						->where('id', $trxidapp)
						->update(
							[
								'nama_file_download'	=> $fileName,
								'ukuran_file'			=> $getSize,
								'status_kirim'			=> $status_code,
								'get_by'				=> 'upload',
								'fproses'				=> 2,
								'update_by'				=> 1,
								'update_at'				=> date('Y-m-d H:i:s'),
							]);
				
					//unlink(storage_path("app/public/uploads/").$fileName);
					
					//kirim notif email ke pic customer
					$to = $cust_email;
					$cc = env('EMAIL_MIS');
					
					$details = [
						'title' => 'Dear '.$company_name.',',
						'body1' => 'Berikut adalah Upload File Result to - ['.$jammenit.'] ['.$fileName.'] : ',
						'body2' => 'Sudah dapat anda download pada AppGlobal (https://appglobal.atlasat.co.id/datawhiz/)',
						'body3' => 'Terima kasih.',
					];
				   
					Mail::to($to)->cc($cc)->send(new \App\Mail\NotifUploadNonSFTP($details));
					
					return response()->json(['success' => 'success']);
				}
				else
				{
					$status_code = 400;

					DB::table('trx_ftp')
						->where('customerno', $customerno)
						->where('fproses', 1)
						->update(
							[
								'nama_file_upload'	=> $OriginalNames,
								'ukuran_file'		=> $getSize,
								'status_kirim'		=> $status_code,
								'send_time'			=> date('Y-m-d H:i:s'),
								'fproses'			=> 1,
								'update_by'			=> $update_by,
								'update_at'			=> date('Y-m-d H:i:s'),
							]);
				
					unlink(storage_path("app/public/uploads/").$OriginalNames);
					
					return response()->json(['error' => $upload]);
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

}
