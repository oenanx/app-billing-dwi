<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod_CompanyApi extends Model
{
	protected $connection = 'mysql';
	protected $table = 'master_company_api';
	protected $primaryKey = 'id';
    const CREATE_AT = 'create_at';
    const UPDATE_AT = 'update_at';

	//id,customerno,company_name,phone_fax,address,address2,address3,address4,address5,zipcode,address_npwp,email_pic,email_billing,npwpno,npwpname,SALESAGENTCODE,notes,active,activation_date,create_by,create_at,update_by,update_at,discount,tech_pic_name,billing_pic_name,productid,invtypeid,fftp,fcompleted,parentid,apptypeid,billingtype

    protected $fillable = ['customerno','company_name','phone_fax','address','address2','address3','address4','address5','zipcode','address_npwp','email_pic','email_billing','npwpno','npwpname','SALESAGENTCODE','notes','active','activation_date','create_by','update_by','discount','tech_pic_name','billing_pic_name','productid','invtypeid','fftp','fcompleted','parentid','apptypeid','billingtype'];

	public static function Update_Cpy($editid,$data)
	{
		//print_r($data);
		//exit();
		DB::table('master_company_api')->where('id', $editid)->update($data);
		DB::connection('mysql_3')->table('master_company_api')->where('id', $editid)->update($data);
	}

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('email_billing', 'like', '%' . $search . '%')
                     ->orWhere('salesagent.SALESAGENTNAME', 'like', '%' . $search . '%')
                     ->orWhere('master_company_api.customerno', 'like', '%' . $search . '%')
                     ->orWhere('master_company_api.company_name', 'like', '%' . $search . '%');
    }
}
?>