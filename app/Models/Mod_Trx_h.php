<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mod_Trx_h extends Model
{
    use HasFactory;

	protected $connection = 'mysql_3';
	protected $table = 'trx_screen_no_h';
	protected $primaryKey = 'id';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
	
	//id,customerno,nama_file,jml_ktp,jml_ktp_null_hp,jml_ktp_with_hp,jml_no_hp,created_at,updated_at,nama_file_hp,nama_file_wa,jml_all_no_hp,jml_no_hp_valid,jml_all_no_wa,jml_no_wa_valid,fcompleted
    protected $fillable = ['customerno','nama_file','jml_ktp','jml_ktp_null_hp','jml_ktp_with_hp','jml_no_hp','nama_file_hp','nama_file_wa','jml_all_no_hp','jml_no_hp_valid','jml_all_no_wa','jml_no_wa_valid','fcompleted'];

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('master_company.company_name', 'like', '%' . $search . '%')
                     ->orWhere('trx_screen_no_h.nama_file', 'like', '%' . $search . '%')
                     ->orWhere('trx_screen_no_h.nama_file_hp', 'like', '%' . $search . '%')
                     ->orWhere('trx_screen_no_h.nama_file_wa', 'like', '%' . $search . '%');
    }
	
	public function setPublishedAtAttribute($value)
	{
		$this->attributes['created_at'] =  Carbon::parse($value);
	}
}
