<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income_Api_Trial extends Model
{
	protected $connection = 'mysql_4';
    protected $table = 'datawhiz_app.api_income_trial';
	protected $primaryKey = 'id';
    const CREATE_AT = 'created_at';
    const UPDATE_AT = 'updated_at';
	//id,customerno,code,message,nik,name,npwp,net_income,asset,liabilities,year,transaction_id,price,start_time,finish_time,noapi_id,url_hook,created_at,updated_at,fstatus
    protected $fillable = ['customerno','code','message','nik','name','npwp','net_income','asset','liabilities','year','transaction_id','price','start_time','finish_time','noapi_id','url_hook','fstatus']; 

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('datawhiz_app.api_income_trial.nik', 'like', '%' . $search . '%')
                     ->orWhere('datawhiz_app.api_income_trial.noapi_id', 'like', '%' . $search . '%')
					 ->orWhere('datawhiz_app.api_income_trial.name', 'like', '%' . $search . '%');
    }
}

