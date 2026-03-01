<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reverse_Api_Postpaid extends Model
{
	protected $connection = 'mysql_4';
    protected $table = 'api_reverse_postpaid';
	protected $primaryKey = 'id';
    const CREATE_AT = 'created_at';
    const UPDATE_AT = 'updated_at';

	//id,customerno,code,message,phoneno,nik,phone,tanggal,messages,start_time,finish_time,noapi_id,created_at,updated_at,fstatus
    protected $fillable = ['customerno','code','message','phoneno','nik','phone','tanggal','messages','start_time','finish_time','noapi_id','fstatus']; 

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('datawhiz_app.api_reverse_postpaid.noapi_id', 'like', '%' . $search . '%')
                     ->orWhere('datawhiz_app.api_reverse_postpaid.nik', 'like', '%' . $search . '%')
					 ->orWhere('datawhiz_app.api_reverse_postpaid.phoneno', 'like', '%' . $search . '%');
    }
}

