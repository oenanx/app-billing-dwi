<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negative_Record_Api_Prepaid extends Model
{
	protected $connection = 'mysql_4';
    protected $table = 'datawhiz_app.api_negative_record_prepaid';
	protected $primaryKey = 'id';
    const CREATE_AT = 'created_at';
    const UPDATE_AT = 'updated_at';
	
	//id,customerno,nama,percentage,tahun,code,message,person_entity_id,full_name,first_name,middle_name,surname,similarity,birth_date,source_info,source_info_code,country_name,occupation_category,source_info_desc,image_profile,url_detail,url_pdf_detail,transaction_id,price,start_time,finish_time,noapi_id,created_at,updated_at,fstatus

    protected $fillable = ['customerno','nama','percentage','tahun','code','message','person_entity_id','full_name','first_name','middle_name','surname','similarity','birth_date','source_info','source_info_code','country_name','occupation_category','source_info_desc','image_profile','url_detail','url_pdf_detail','transaction_id','price','start_time','finish_time','noapi_id','fstatus'];  

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('datawhiz_app.api_negative_record_prepaid.nama', 'like', '%' . $search . '%')
					 ->orWhere('datawhiz_app.api_negative_record_prepaid.noapi_id', 'like', '%' . $search . '%');
    }
}

