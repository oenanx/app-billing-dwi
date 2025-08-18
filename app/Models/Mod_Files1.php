<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod_Files1 extends Model
{
    use HasFactory;

	//protected $connection = 'mysql_3';
	protected $table = 'tmp_files1';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
	
    protected $fillable = ['no_telp','result'];
}
