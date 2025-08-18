<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Mod_login extends Model
{
    //fungsi cek session
    protected $table = "account_user";
    protected $primaryKey = 'id';
    const CREATED_AT = 'create_at';
    const UPDATED_AT = 'update_at';

    protected $fillable = ['user_name','full_name','divisi_name','passwd','company_id','account_group_id','active','create_by','update_by'];

	public static function updateData($loginid, $data)
	{
		DB::table('account_user')->where('user_name', $loginid)->update($data);
	}
	
}
