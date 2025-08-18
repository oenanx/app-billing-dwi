<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skiptrace_Api_Prepaid extends Model
{
	protected $connection = 'mysql_4';
    protected $table = 'datawhiz_app.api_skiptrace_prepaid';
	protected $primaryKey = 'id';
    const CREATE_AT = 'created_at';
    const UPDATE_AT = 'updated_at';

	//id,customerno,nik,code,message,phone_number,regis_date,transaction_id,start_time,finish_time,noapi_id,url_hook,created_at,updated_at
    protected $fillable = ['customerno','nik','code','message','phone_number','regis_date','transaction_id','start_time','finish_time','noapi_id','url_hook']; 

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('datawhiz_app.api_skiptrace_prepaid.nik', 'like', '%' . $search . '%')
                     ->orWhere('datawhiz_app.api_skiptrace_prepaid.noapi_id', 'like', '%' . $search . '%')
					 ->orWhere('datawhiz_app.api_skiptrace_prepaid.phone_number', 'like', '%' . $search . '%');
    }
}

