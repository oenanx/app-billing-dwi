<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod_ProductsApi extends Model
{
	protected $connection = 'mysql_4';
	protected $table = 'datawhiz_app.master_product_api_customer';
	protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

	//id,customerno,product_api_id,fstatus,rates,quota,remainquota,start_trial,end_trial,created_by,created_at,updated_by,updated_at
    protected $fillable = ['customerno','product_api_id','fstatus','rates','quota','remainquota','start_trial','end_trial','created_by','updated_by'];

	public static function Update_Cpy($editid,$data)
	{
		//print_r($data);
		//exit();
		DB::connection('mysql')->table('master_product_api_customer')->where('id', $editid)->update($data);
		DB::connection('mysql_3')->table('master_product_api_customer')->where('id', $editid)->update($data);
		DB::connection('mysql_4')->table('master_product_api_customer')->where('id', $editid)->update($data);
	}

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('master_company.parentid', 'like', '%' . $search . '%')
                     ->orWhere('customerno', 'like', '%' . $search . '%')
                     ->orWhere('master_company.company_name', 'like', '%' . $search . '%');
    }
}
?>