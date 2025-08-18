<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod_Rates extends Model
{
    use HasFactory;
	protected $table = 'master_rates';
	protected $primaryKey = 'id';
    const CREATE_AT = 'create_at';
    const UPDATE_AT = 'update_at';

	//id,company_id,manage_service_price,number_price,concurrent_price,senderno_type,pstn_price,gsm_price,billcycleid,storage_price,fstatus,create_by,create_at,update_by,update_at

    protected $fillable = ['company_id','manage_service_price','number_price','concurrent_price','senderno_type','pstn_price','gsm_price','billcycleid','storage_price','fstatus','create_by','update_by'];

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('master_company.customerno', 'like', '%' . $search . '%')
                     ->orWhere('master_company.company_name', 'like', '%' . $search . '%');
    }
	
}
