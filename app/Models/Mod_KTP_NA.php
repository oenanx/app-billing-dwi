<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod_KTP_NA extends Model
{
    use HasFactory;

	//protected $connection = 'mysql3';
	protected $table = 'tmp_ktp_not_hp';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
	
    protected $fillable = ['id','ktpno'];
}
