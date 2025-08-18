<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demography_Api_Postpaid extends Model
{
	protected $connection = 'mysql_4';
    protected $table = 'datawhiz_app.api_demography_postpaid';
	protected $primaryKey = 'id';
    const CREATE_AT = 'created_at';
    const UPDATE_AT = 'updated_at';

	//id,customerno,code,message,nik,alamat,golongan_darah,tanggal_lahir,tempat_lahir,ibu,pekerjaan,kabupaten,no_kk,kecamatan,kelurahan,status_perkawinan,nama,pendidikan,kewarganegaraan,kota_terbit,propinsi,agama,rt,rw,jenis_kelamin,photo,transaction_id,price,start_time,finish_time,noapi_id,url_hook,created_at,updated_at,fstatus,ftype
    protected $fillable = ['customerno','code','message','nik','alamat','golongan_darah','tanggal_lahir','tempat_lahir','ibu','pekerjaan','kabupaten','no_kk','kecamatan','kelurahan','status_perkawinan','nama','pendidikan','kewarganegaraan','kota_terbit','propinsi','agama','rt','rw','jenis_kelamin','photo','transaction_id','price','start_time','finish_time','noapi_id','url_hook','ftype']; 

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('datawhiz_app.api_demography_postpaid.nik', 'like', '%' . $search . '%')
                     ->orWhere('datawhiz_app.api_demography_postpaid.noapi_id', 'like', '%' . $search . '%')
					 ->orWhere('datawhiz_app.api_demography_postpaid.nama', 'like', '%' . $search . '%');
    }
}

