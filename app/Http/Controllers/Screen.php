<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mod_Files1;
use App\Models\Mod_Trx_h;
use App\Imports\MessageImport1;
use App\Exports\RptStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;
use Maatwebsite\Excel\Facades\Excel;

class Screen extends Controller
{
	public function proseshp(Request $request)
	{
		if(Session::get('userid'))
		{
			$campid			= $request->campid;
			$customerno		= $request->customerno;
			$files		 	= $request->filex;

			$OriginalNames	 = $files->getClientOriginalName();
			$paths			 = $files->move(storage_path('app/public/uploads'), $OriginalNames);
			//dd($OriginalNames);
			
			$filterResult0 = DB::table('trx_screen_no_h')->select(DB::raw('COUNT(id) as tot_id'))->where('nama_file_hp', $OriginalNames)->get();
			foreach ($filterResult0 as $hsl0)
			{
				$tot_id = $hsl0->tot_id;
			}
			
			if ($tot_id > 0)
			{
				return response()->json(['error' => 'Nama file excel sudah ada !!!']);
			}
			else
			{
				Mod_Files1::truncate();
				
				$upd_at	= date('Y-m-d H:i:s');
				
				$cek = DB::table('trx_screen_no_h')->select(DB::raw('COUNT(id) as tid'))->where('id', $campid)->get();
				foreach ($cek as $res)
				{
					$tid = $res->tid;
				}
				
				if ($tid == 0)
				{
					$created_at		= date('Y-m-d H:i:s');
					
					DB::table('trx_screen_no_h')->insert(
						[
							'id'				=> $campid,
							'customerno'		=> $customerno,
							'nama_file_hp'		=> $OriginalNames,
							'created_at'		=> $created_at
						]
					);

					DB::connection('mysql_3')->table('trx_screen_no_h')->insert(
						[
							'id'				=> $campid,
							'customerno'		=> $customerno,
							'nama_file_hp'		=> $OriginalNames,
							'created_at'		=> $created_at
						]
					);

					// import data
					Excel::import(new MessageImport1, $paths);

					$data2 = DB::table('tmp_files1')->select('no_telp','result')->get();
					foreach($data2 as $rowHP)
					{
						$count 		= 1;
						$no_telp	= $rowHP->no_telp;
						$result		= $rowHP->result;
						$updated_at	= date('Y-m-d H:i:s');
				
						DB::table('trx_screen_no_d')->insert(
								[
									'h_id'			=> $campid,
									'phonenovalid'	=> $no_telp,
									'status_no'		=> $result,
									'updated_no'	=> $updated_at,
								]
							);
					}

					$filterResult3 = DB::table('trx_screen_no_d')->select(DB::raw('COUNT(phonenovalid) as no_hp'))->where('h_id', $campid)->get();
					foreach ($filterResult3 as $hsl3)
					{
						$no_hp = $hsl3->no_hp;
					}
					
					$filterResult4 = DB::table('trx_screen_no_d')->select(DB::raw('COUNT(phonenovalid) as no_hp_valid'))->where('h_id', $campid)->where('status_no', 'Live')->get();
					foreach ($filterResult4 as $hsl4)
					{
						$no_hp_valid = $hsl4->no_hp_valid;
					}
					
					DB::table('trx_screen_no_h')
						->where('id', $campid)
						->update(
							[
								'jml_all_no_hp'		=> $no_hp,
								'jml_no_hp_valid'	=> $no_hp_valid,
							]);

					DB::connection('mysql_3')->table('trx_screen_no_h')
						->where('id', $campid)
						->update(
							[
								'jml_all_no_hp'		=> $no_hp,
								'jml_no_hp_valid'	=> $no_hp_valid,
							]);

					unlink(storage_path("app/public/uploads/").$OriginalNames);

					Mod_Files1::truncate();
				}
				else
				{
					return response()->json(['error' => 'Nama file excel sudah ada !!!']);
				}
				/*
				else
				{
					DB::table('trx_screen_no_h')
						->where('id', $campid)
						->update(
							[
								'nama_file_hp'	=> $OriginalNames,
							]);

					// import data
					Excel::import(new MessageImport1, $paths);

					$data2 = DB::table('tmp_files1')->select('no_telp','result')->get();
					foreach($data2 as $rowHP)
					{
						$count 		= 1;
						$no_telp	= $rowHP->no_telp;
						$result		= $rowHP->result;
						$updated_at	= date('Y-m-d H:i:s');
				
						DB::table('trx_screen_no_d')->insert(
								[
									'h_id'			=> $campid,
									'phonenovalid'	=> $no_telp,
									'status_no'		=> $result,
									'updated_no'	=> $updated_at,
								]
							);
							
						DB::connection('mysql_3')->table('trx_screen_no_d')->insert(
								[
									'h_id'			=> $campid,
									'phonenovalid'	=> $no_telp,
									'status_no'		=> $result,
									'updated_no'	=> $updated_at,
								]
							);
					}

					$filterResult3 = DB::table('trx_screen_no_d')->select(DB::raw('COUNT(phonenovalid) as no_hp'))->where('h_id', $campid)->get();
					foreach ($filterResult3 as $hsl3)
					{
						$no_hp = $hsl3->no_hp;
					}
					
					$filterResult4 = DB::table('trx_screen_no_d')->select(DB::raw('COUNT(phonenovalid) as no_hp_valid'))->where('h_id', $campid)->where('status_no', 'Live')->get();
					foreach ($filterResult4 as $hsl4)
					{
						$no_hp_valid = $hsl4->no_hp_valid;
					}
					
					DB::table('trx_screen_no_h')
						->where('id', $campid)
						->update(
							[
								'jml_all_no_hp'		=> $no_hp,
								'jml_no_hp_valid'	=> $no_hp_valid,
							]);

					DB::connection('mysql_3')->table('trx_screen_no_h')
						->where('id', $campid)
						->update(
							[
								'jml_all_no_hp'		=> $no_hp,
								'jml_no_hp_valid'	=> $no_hp_valid,
							]);

					unlink(storage_path("app/public/uploads/").$OriginalNames);

					Mod_Files1::truncate();
				}
				*/
				return response()->json(['success' => 'Done.']);
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

	public function proseswa(Request $request)
	{
		if(Session::get('userid'))
		{
			$campid			= $request->campid;
			$customerno		= $request->customerno;
			$files		 	= $request->filex;

			$OriginalNames	 = $files->getClientOriginalName();
			$paths			 = $files->move(storage_path('app/public/uploads'), $OriginalNames);
			
			$filterResult0 = DB::table('trx_screen_no_h')->select(DB::raw('COUNT(id) as tot_id'))->where('nama_file_wa', $OriginalNames)->get();
			foreach ($filterResult0 as $hsl0)
			{
				$tot_id = $hsl0->tot_id;
			}
			
			if ($tot_id > 0)
			{
				return response()->json(['error' => 'Nama file excel sudah ada !!!']);
			}
			else
			{
				Mod_Files1::truncate();
				
				$upd_at	= date('Y-m-d H:i:s');
				
				$cek = DB::table('trx_screen_no_h')->select(DB::raw('COUNT(id) as tid'))->where('id', $campid)->get();
				foreach ($cek as $res)
				{
					$tid = $res->tid;
				}

				if ($tid == 0)
				{
					$created_at		= date('Y-m-d H:i:s');
					
					DB::table('trx_screen_no_h')->insert(
						[
							'id'				=> $campid,
							'customerno'		=> $customerno,
							'nama_file_wa'		=> $OriginalNames,
							'created_at'		=> $created_at
						]
					);
					
					DB::connection('mysql_3')->table('trx_screen_no_h')->insert(
						[
							'id'				=> $campid,
							'customerno'		=> $customerno,
							'nama_file_wa'		=> $OriginalNames,
							'created_at'		=> $created_at
						]
					);

					// import data
					Excel::import(new MessageImport1, $paths);

					$data2 = DB::table('tmp_files1')->select('no_telp','result')->get();
					foreach($data2 as $rowHP)
					{
						$count 		= 1;
						$no_telp	= $rowHP->no_telp;
						$result		= $rowHP->result;
						$updated_at	= date('Y-m-d H:i:s');
				
						DB::table('trx_screen_wa_d')->insert(
								[
									'h_id'			=> $campid,
									'phonewavalid'	=> $no_telp,
									'status_wa'		=> $result,
									'updated_wa'	=> $updated_at,
								]
							);
					}

					$filterResult3 = DB::table('trx_screen_wa_d')->select(DB::raw('COUNT(phonewavalid) as no_wa'))->where('h_id', $campid)->get();
					foreach ($filterResult3 as $hsl3)
					{
						$no_wa = $hsl3->no_wa;
					}
					
					$filterResult4 = DB::table('trx_screen_wa_d')->select(DB::raw('COUNT(phonewavalid) as no_wa_valid'))->where('h_id', $campid)->where('status_wa', 'WA Active')->get();
					foreach ($filterResult4 as $hsl4)
					{
						$no_wa_valid = $hsl4->no_wa_valid;
					}
					
					DB::table('trx_screen_no_h')
						->where('id', $campid)
						->update(
							[
								'jml_all_no_wa'	=> $no_wa,
								'jml_no_wa_valid'	=> $no_wa_valid,
							]);

					DB::connection('mysql_3')->table('trx_screen_no_h')
						->where('id', $campid)
						->update(
							[
								'jml_all_no_wa'	=> $no_wa,
								'jml_no_wa_valid'	=> $no_wa_valid,
							]);

					unlink(storage_path("app/public/uploads/").$OriginalNames);

					Mod_Files1::truncate();
				}
				else
				{
					return response()->json(['error' => 'Nama file excel sudah ada !!!']);
				}
				/*
				else
				{
					DB::table('trx_screen_no_h')
						->where('id', $campid)
						->update(
							[
								'nama_file_wa'	=> $OriginalNames,
							]);

					// import data
					Excel::import(new MessageImport1, $paths);

					$data2 = DB::table('tmp_files1')->select('no_telp','result')->get();
					foreach($data2 as $rowHP)
					{
						$count 		= 1;
						$no_telp	= $rowHP->no_telp;
						$result		= $rowHP->result;
						$updated_at	= date('Y-m-d H:i:s');
				
						DB::table('trx_screen_wa_d')->insert(
								[
									'h_id'			=> $campid,
									'phonewavalid'	=> $no_telp,
									'status_wa'		=> $result,
									'updated_wa'	=> $updated_at,
								]
							);
					}

					$filterResult3 = DB::table('trx_screen_wa_d')->select(DB::raw('COUNT(phonewavalid) as no_wa'))->where('h_id', $campid)->get();
					foreach ($filterResult3 as $hsl3)
					{
						$no_wa = $hsl3->no_wa;
					}
					
					$filterResult4 = DB::table('trx_screen_wa_d')->select(DB::raw('COUNT(phonewavalid) as no_wa_valid'))->where('h_id', $campid)->where('status_wa', 'WA Active')->get();
					foreach ($filterResult4 as $hsl4)
					{
						$no_wa_valid = $hsl4->no_wa_valid;
					}
					
					DB::table('trx_screen_no_h')
						->where('id', $campid)
						->update(
							[
								'jml_all_no_wa'	=> $no_wa,
								'jml_no_wa_valid'	=> $no_wa_valid,
							]);

					DB::connection('mysql_3')->table('trx_screen_no_h')
						->where('id', $campid)
						->update(
							[
								'jml_all_no_wa'	=> $no_wa,
								'jml_no_wa_valid'	=> $no_wa_valid,
							]);

					unlink(storage_path("app/public/uploads/").$OriginalNames);

					Mod_Files1::truncate();
				}
				*/
				
				return response()->json(['success' => 'Done.']);
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

    public function autocomplete(Request $request)
    {
        $query = $request->get('query');
		  
        $filterResult = DB::table('trx_screen_no_h')->where('nama_file', 'LIKE', '%'.$query.'%')->select('nama_file')->get();

        $data = array();

        foreach ($filterResult as $hsl)
        {
            $data[] = $hsl->nama_file;
        }

        return response()->json($data);
    } 
	
	public function cariFile(Request $request, $id)
	{
		$data = DB::table('trx_screen_no_h')
                ->where('nama_file', $id)
 				->select('id','nama_file')
				->first();
		
		return response()->json($data);
	}
	
	public function download(Request $request, $id)
    {
		$periode	= date('Y-m-d');
		$hid		= $id;
 
		$data = DB::table('trx_screen_no_d') 
				->where('h_id', $hid) 
				->where('trx_screen_no_d.status_no', '!=', '')
				->where('trx_screen_no_d.status_wa', '!=', '')
				->select(DB::raw('@nomor := @nomor + 1 AS No'),'ktpno','phoneno', DB::raw('tanggal as Tanggal'), 'status_no', 'status_wa')
				->orderBy('ktpno', 'ASC')
				->get();

		ob_end_clean();

		return Excel::download(new RptStatus(
					$data
				), 'Screening_Number_'.$periode.'.xlsx');
				
    }

}
