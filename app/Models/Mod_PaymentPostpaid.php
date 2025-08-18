<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod_PaymentPostpaid extends Model
{
    use HasFactory;

	//protected $connection = 'mysql3';
	protected $table = 'trans_postpaid';
    protected $primaryKey = 'TR_ID';
    const CRT_DATE = 'CRT_DATE';
    const UPD_DATE = 'UPD_DATE';

    //TR_ID,ENTRYDATE,TRANSACTIONDATE,TRANSACTIONCODE,CUSTOMERNO,AMOUNT,PAYMENTCODE,INFO,RECEIPTNO,CRT_USER,CRT_DATE,UPD_USER,UPD_DATE,SETTLEMENT_STATUS,BSNO,DUEDATE,NOMINAL_TAGIHAN,PERIOD
    protected $fillable = ['ENTRYDATE','TRANSACTIONDATE','TRANSACTIONCODE','CUSTOMERNO','AMOUNT','PAYMENTCODE','INFO','RECEIPTNO','CRT_USER','UPD_USER','SETTLEMENT_STATUS','BSNO','DUEDATE','NOMINAL_TAGIHAN','PERIOD'];
        
	public static function updateData($editid,$data)
	{	
		//dd($editid);
		//dd($data);
		DB::table('trans_postpaid')->where('trans_postpaid.TR_ID', $editid)->update($data);
	}
}
