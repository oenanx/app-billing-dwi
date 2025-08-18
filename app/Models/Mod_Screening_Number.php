<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod_Screening_Number extends Model
{
    use HasFactory;

	protected $connection = 'mysql_3';
	protected $table = 'tmp_number';
    protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
	
    protected $fillable = ['ktpno','phoneno','tanggal','id_urut'];
}
