<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod_Trx_FTP extends Model
{
    use HasFactory;

	//protected $connection = 'mysql3';
	protected $table = 'trx_ftp';
	protected $primaryKey = 'id';
    const create_at = 'create_at';
    const update_at = 'update_at';
	
	//id,ftpid,customerno,nama_file_download,get_time,get_by,nama_file_upload,ukuran_file,status_kirim,send_time,fproses,create_by,create_at,update_by,update_at

    protected $fillable = ['ftpid','customerno','nama_file_download','get_time','get_by','nama_file_upload','ukuran_file','status_kirim','send_time','fproses','create_by','update_by'];

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('master_company.company_name', 'like', '%' . $search . '%')
                     ->orWhere('trx_ftp.nama_file_download', 'like', '%' . $search . '%')
                     ->orWhere('trx_ftp.nama_file_upload', 'like', '%' . $search . '%')
                     ->orWhere('master_ftp.ip_ftp', 'like', '%' . $search . '%');
    }
}
