<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod_Invoice extends Model
{
	protected $table = 'invoice_file';
	protected $primaryKey = 'id';
    const CREATE_AT = 'create_at';
    const UPDATE_AT = 'update_at';

	//id,customerno,bsno,period,file_name,path

    protected $fillable = ['customerno','bsno','period','file_name','path','create_by','update_by'];

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('invoice_file.customerno', 'like', '%' . $search . '%')
					 ->orWhere('invoice_file.period', 'like', '%' . $search . '%')
					 ->orWhere('invoice_file.bsno', 'like', '%' . $search . '%')
                     ->orWhere('master_company.company_name', 'like', '%' . $search . '%');
    }
}
?>