<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class M_BS_Detail_Postpaid extends Model
{
	//protected $connection = 'mysql3';
	protected $table = 'bs_postpaid_detail';
    protected $primaryKey = 'BD_ID';
    //const crtdate = 'crtdate';
    //const upddate = 'upddate';

    //PERIOD,CUSTOMERNO,DESCRIPTION,PERIOD_SERVICE,AMOUNT,PRSS_ID

    protected $fillable = ['PERIOD','CUSTOMERNO','DESCRIPTION','PERIOD_SERVICE','AMOUNT','PRSS_ID'];
        
	public static function updateData($editid,$data)
	{
		DB::table('bs_postpaid_detail')->where('BD_ID', $editid)->update($data);
	}
}
