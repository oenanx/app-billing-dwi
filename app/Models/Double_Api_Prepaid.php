<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Double_Api_Prepaid extends Model
{
	protected $connection = 'mysql_4';
    protected $table = 'api_double_prepaid';
	protected $primaryKey = 'id';
    const CREATE_AT = 'created_at';
    const UPDATE_AT = 'updated_at';

	//id,customerno,code,message,phone_input,phone,tanggal,messages,start_time,finish_time,noapi_id,created_at,updated_at,fstatus
    protected $fillable = ['customerno','code','message','phone_input','phone','tanggal','messages','start_time','finish_time','noapi_id','fstatus']; 

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('datawhiz_app.api_double_prepaid.noapi_id', 'like', '%' . $search . '%')
                     ->orWhere('datawhiz_app.api_double_prepaid.phone_input', 'like', '%' . $search . '%')
					 ->orWhere('datawhiz_app.api_double_prepaid.phone', 'like', '%' . $search . '%');
    }
}

