<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valid_No_Api_Prepaid extends Model
{
	protected $connection = 'mysql_4';
    protected $table = 'datawhiz_app.api_valid_no_prepaid';
	protected $primaryKey = 'id';
    const CREATE_AT = 'created_at';
    const UPDATE_AT = 'updated_at';

	//id,customerno,phone_number,success,message,result_outcome,result_reference,noapi_id,url_hook,created_at,updated_at
    protected $fillable = ['customerno','phone_number','success','message','result_outcome','result_reference','noapi_id','url_hook']; 

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('datawhiz_app.api_valid_no_prepaid.phone_number', 'like', '%' . $search . '%')
                     ->orWhere('datawhiz_app.api_valid_no_prepaid.success', 'like', '%' . $search . '%')
					 ->orWhere('datawhiz_app.api_valid_no_prepaid.noapi_id', 'like', '%' . $search . '%');
    }
}

