<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address_Verification_Api_Prepaid extends Model
{
	protected $connection = 'mysql_4';
    protected $table = 'datawhiz_app.api_address_verification_prepaid';
	protected $primaryKey = 'id';
    const CREATE_AT = 'created_at';
    const UPDATE_AT = 'updated_at';
	
	//id,customerno,code,message,nik,alamat,alamat_search,alamat_percent,transaction_id,start_time,finish_time,noapi_id,created_at,updated_at,fstatus,percentage
    protected $fillable = ['customerno','code','message','nik','alamat','alamat_search','alamat_percent','transaction_id','start_time','finish_time','noapi_id','fstatus','percentage'];  

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('datawhiz_app.api_address_verification_prepaid.nik', 'like', '%' . $search . '%')
					 ->orWhere('datawhiz_app.api_address_verification_prepaid.noapi_id', 'like', '%' . $search . '%');
    }
}

