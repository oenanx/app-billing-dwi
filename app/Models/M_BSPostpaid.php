<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class M_BSPostpaid extends Model
{
	//protected $connection = 'mysql3';
	protected $table = 'bs_postpaid';
    protected $primaryKey = 'ID';
    //const crtdate = 'crtdate';
    //const upddate = 'upddate';

    //BSNO,PERIOD,CUSTOMERNO,USAGEADJUSTMENT,TOTALDISCOUNT,TOTALVAT,PREVIOUSBALANCE,BALANCEADJUSTMENT,PREVIOUSPAYMENT,DUEDATE,NEWSTATEMENTDATE,LASTSTATEMENTDATE,PAYMENTDATEVAT,TOTALAMOUNT,PENALTY,TOTALUSAGE,TOTALMATERAI,TRXH_ID

    protected $fillable = ['BSNO','PERIOD','CUSTOMERNO','USAGEADJUSTMENT','TOTALDISCOUNT','TOTALVAT','PREVIOUSBALANCE','BALANCEADJUSTMENT','PREVIOUSPAYMENT','DUEDATE','NEWSTATEMENTDATE','LASTSTATEMENTDATE','PAYMENTDATEVAT','TOTALAMOUNT','PENALTY','TOTALUSAGE','TOTALMATERAI'];
        
	public static function updateData($editid,$data)
	{
		DB::table('bs_postpaid')->where('ID', $editid)->update($data);
	}
}
