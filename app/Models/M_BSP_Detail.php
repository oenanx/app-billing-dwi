<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class M_BSP_Detail extends Model
{
	//protected $connection = 'mysql3';
	protected $table = 'bs_detail_period';
    protected $primaryKey = 'BD_ID';
    //const crtdate = 'crtdate';
    //const upddate = 'upddate';

    //BD_ID,PERIOD,CUSTOMERNO,DESCRIPTION,PERIOD_SERVICE,AMOUNT,PRSS_ID,TRXH_ID

    protected $fillable = ['PERIOD','CUSTOMERNO','DESCRIPTION','PERIOD_SERVICE','AMOUNT','PRSS_ID','TRXH_ID'];
        
	public static function updateData($editid,$data)
	{
		DB::table('bs_detail_period')->where('BD_ID', $editid)->update($data);
	}
}
