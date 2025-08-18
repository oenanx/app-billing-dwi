<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod_Rates extends Model
{
    use HasFactory;
	
	//protected $connection = 'mysql3';
	protected $table = 'master_rates';
	protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	//id,customerno,product_paket_id,ratestypeid,non_std_basedon,non_std_basedon_wa,rates,fstatus,created_at,updated_at

    protected $fillable = ['customerno','product_paket_id','ratestypeid','non_std_basedon','non_std_basedon_wa','rates','fstatus'];

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('master_rates.customerno', 'like', '%' . $search . '%')
                     ->orWhere('master_company.company_name', 'like', '%' . $search . '%');
    }
	
}
