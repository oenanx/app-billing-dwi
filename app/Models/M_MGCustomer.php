<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_MGCustomer extends Model
{
	protected $table = 'billing_ats.customer_parent';
    protected $primaryKey = 'ID';
    const CREATED_AT = 'CRT_DATE';
    const UPDATED_AT = 'UPD_DATE';

    protected $fillable = ['PARENT_CUSTOMER','CRT_USER','UPD_USER','BILLINGADDRESS1','BILLINGADDRESS2','BILLINGADDRESS3','BILLINGADDRESS4','BILLINGADDRESS5','ZIPCODE','ATTENTION','PHONE1','PHONE2','EMAIL','VATFREE','SENDVAT','COMPANYNAME','NPWP','NPWPADDRESS'];
        
	public static function updateData($editid,$data)
	{
		DB::table('billing_ats.customer_parent')->where('billing_ats.customer_parent.ID', $editid)->update($data);
		
		DB::connection('mysql_2')->table('db_master_ats.customer_parent')->where('db_master_ats.customer_parent.ID', $editid)->update($data);

		DB::connection('mysql_3')->table('billing_ats.customer_parent')->where('billing_ats.customer_parent.ID', $editid)->update($data);
	}

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('billing_ats.customer_parent.ID', 'like', '%' . $search . '%')
                     ->orWhere('billing_ats.customer_parent.PARENT_CUSTOMER', 'like', '%' . $search . '%')
					 ->orWhere('billing_ats.customer_parent.COMPANYNAME', 'like', '%' . $search . '%')
					 ->orWhere('billing_ats.customer_parent.NPWP', 'like', '%' . $search . '%');
    }
}
