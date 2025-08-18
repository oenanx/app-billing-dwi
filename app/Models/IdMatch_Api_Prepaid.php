<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdMatch_Api_Prepaid extends Model
{
	protected $connection = 'mysql_4';
    protected $table = 'datawhiz_app.api_idmatch_prepaid';
	protected $primaryKey = 'id';
    const CREATE_AT = 'created_at';
    const UPDATE_AT = 'updated_at';
	
	//id,customerno,code,message,nik,real_name,name_percent,request_id,status_digi,start_time,finish_time,noapi_id,created_at,updated_at,fstatus,name_input
    protected $fillable = ['customerno','code','message','nik','real_name','name_percent','request_id','status_digi','start_time','finish_time','noapi_id','fstatus','name_input']; 

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('datawhiz_app.api_idmatch_prepaid.nik', 'like', '%' . $search . '%')
                     ->orWhere('datawhiz_app.api_idmatch_prepaid.noapi_id', 'like', '%' . $search . '%')
					 ->orWhere('datawhiz_app.api_idmatch_prepaid.real_name', 'like', '%' . $search . '%');
    }
}

