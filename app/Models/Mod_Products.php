<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod_Products extends Model
{
	protected $connection = 'mysql';
	protected $table = 'master_paket_non_paket_customer';
	protected $primaryKey = 'id';
    //const CREATE_AT = 'create_at';
    //const UPDATE_AT = 'update_at';

	//id,parentid,customerno,liteprodtipeid,liteprodid,litepaketid,proprodtipeid,proprodid,propaketid
    protected $fillable = ['parentid','customerno','liteprodtipeid','liteprodid','litepaketid','proprodtipeid','proprodid','propaketid'];

	public static function Update_Cpy($editid,$data)
	{
		//print_r($data);
		//exit();
		DB::table('master_paket_non_paket_customer')->where('id', $editid)->update($data);
		DB::connection('mysql_3')->table('master_paket_non_paket_customer')->where('id', $editid)->update($data);
	}

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('parentid', 'like', '%' . $search . '%')
                     ->orWhere('customerno', 'like', '%' . $search . '%')
                     ->orWhere('master_company.company_name', 'like', '%' . $search . '%');
    }
}
?>