<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home_Address_Api_Prepaid extends Model
{
	protected $connection = 'mysql_4';
    protected $table = 'datawhiz_app.api_home_address_prepaid';
	protected $primaryKey = 'id';
    const CREATE_AT = 'created_at';
    const UPDATE_AT = 'updated_at';
	
	//id,customerno,code,message,phoneno,address,token,level,request_id,status_digi,start_time,finish_time,noapi_id,created_at,updated_at,fstatus

    protected $fillable = ['customerno','code','message','phoneno','address','token','level','request_id','status_digi','start_time','finish_time','noapi_id','fstatus'];  

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('datawhiz_app.api_home_address_prepaid.phoneno', 'like', '%' . $search . '%')
					 ->orWhere('datawhiz_app.api_home_address_prepaid.noapi_id', 'like', '%' . $search . '%');
    }
}

