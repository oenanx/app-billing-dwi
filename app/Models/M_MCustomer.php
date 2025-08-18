<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_MCustomer extends Model
{
	protected $table = 'billing_ats.customer';
    protected $primaryKey = 'billing_ats.customer.CUSTOMERNO';
    //const CREATED_AT = 'CRT_DATE';
    //const UPDATED_AT = 'UPD_DATE';

    protected $fillable = ['CUSTOMERNAME','CUSTOMERTYPECODE','ACTIVATIONDATE','STATUSCODE','SALESAGENTCODE','BILLINGADDRESS1','BILLINGADDRESS2','BILLINGADDRESS3','BILLINGADDRESS4','BILLINGADDRESS5','ZIPCODE','ATTENTION','PHONE1','PHONE2','EMAIL','PAYMENTCODE','VATFREE','SENDVAT','COMPANYNAME','NPWP','NPWPADDRESS','DISTERMDATE','DISCOUNT','REMARKS','CRT_USER','UPD_USER','SPLIT','PARENTID','PRODUCTID'];
        
	public static function updateData($editid,$data)
	{
		DB::table('billing_ats.customer')->where('CUSTOMERNO', $editid)->update($data);
		
		//DB::connection('mysql_2')->table('db_master_ats.customer')->where('CUSTOMERNO', $editid)->update($data);
	}
	
    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('billing_ats.customer.CUSTOMERNO', 'like', '%' . $search . '%')
                     ->orWhere('billing_ats.salesagent.SALESAGENTNAME', 'like', '%' . $search . '%')
                     ->orWhere('billing_ats.customer.CUSTOMERNAME', 'like', '%' . $search . '%');
    }

}
