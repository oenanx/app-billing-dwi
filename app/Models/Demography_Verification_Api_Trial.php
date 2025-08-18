<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demography_Verification_Api_Trial extends Model
{
	protected $connection = 'mysql_4';
    protected $table = 'datawhiz_app.api_demography_verification_trial';
	protected $primaryKey = 'id';
    const CREATE_AT = 'created_at';
    const UPDATE_AT = 'updated_at';

	//id,customerno,code,message,nik,nama,tempat_lahir,tanggal_lahir,alamat,name_percent,tempat_lahir_percent,tanggal_lahir_percent,alamat_percent,transaction_id,start_time,finish_time,noapi_id,created_at,updated_at,fstatus,name_search,tempat_lahir_search,tanggal_lahir_search,alamat_search
	
    protected $fillable = ['customerno','code','message','nik','nama','tempat_lahir','tanggal_lahir','alamat','name_percent','tempat_lahir_percent','tanggal_lahir_percent','alamat_percent','transaction_id','start_time','finish_time','noapi_id','fstatus','name_search','tempat_lahir_search','tanggal_lahir_search','alamat_search']; 

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('datawhiz_app.api_demography_verification_trial.nik', 'like', '%' . $search . '%')
                     ->orWhere('datawhiz_app.api_demography_verification_trial.nama', 'like', '%' . $search . '%')
					 ->orWhere('datawhiz_app.api_demography_verification_trial.noapi_id', 'like', '%' . $search . '%');
    }
}

