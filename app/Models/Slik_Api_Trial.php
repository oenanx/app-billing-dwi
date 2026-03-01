<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slik_Api_Trial extends Model
{
	protected $connection = 'mysql_4';
    protected $table = 'datawhiz_app.api_slik_trial';
	protected $primaryKey = 'id';
    const CREATE_AT = 'created_at';
    const UPDATE_AT = 'updated_at';

	//id,customerno,status,code,message,name,tgllahir,nik,npwp,gender,tempat_lahir,nama_ibu,address,custtype,tenant,request_reff_id,fapi,filetxt,start_time,finish_time,noapi_id,created_at,updated_at,fstatus

    protected $fillable = ['customerno','status','code','message','name','tgllahir','nik','npwp','gender','tempat_lahir','nama_ibu','address','custtype','tenant','request_reff_id','fapi','filetxt','start_time','finish_time','noapi_id','fstatus']; 

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('datawhiz_app.api_slik_trial.nik', 'like', '%' . $search . '%')
                     ->orWhere('datawhiz_app.api_slik_trial.noapi_id', 'like', '%' . $search . '%')
					 ->orWhere('datawhiz_app.api_slik_trial.name', 'like', '%' . $search . '%');
    }
}

