<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhoneHistory_Api_Prepaid extends Model
{
	protected $connection = 'mysql_4';
    protected $table = 'datawhiz_app.api_phonehistory_prepaid';
	protected $primaryKey = 'id';
    const CREATE_AT = 'created_at';
    const UPDATE_AT = 'updated_at';
	
	//id,customerno,code,message,phone_no,phone_md5,date_time,duration,group_name,kategori,start_time,finish_time,noapi_id,created_at,updated_at
    protected $fillable = ['customerno','code','message','phone_no','phone_md5','date_time','duration','group_name','kategori','start_time','finish_time','noapi_id'];  

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('datawhiz_app.api_phonehistory_prepaid.phone_no', 'like', '%' . $search . '%')
                     ->orWhere('datawhiz_app.api_phonehistory_prepaid.phone_md5', 'like', '%' . $search . '%')
					 ->orWhere('datawhiz_app.api_phonehistory_prepaid.noapi_id', 'like', '%' . $search . '%');
    }
}

