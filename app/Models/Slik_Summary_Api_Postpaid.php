<?php
namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slik_Summary_Api_Postpaid extends Model
{
	protected $connection = 'mysql_4';
    protected $table = 'datawhiz_app.api_slik_summary_postpaid';
	protected $primaryKey = 'id';
    const CREATE_AT = 'created_at';
    const UPDATE_AT = 'updated_at';

	//id,customerno,status,code,message,name,tgllahir,nik,npwp,gender,tempat_lahir,address,custtype,tenant,request_reff_id,start_time,finish_time,noapi_id,created_at,updated_at,fstatus,fasilitasid,ljk,ljkName,fac_type,tanggalMulai,tanggalJatuhTempo,tenor,sisaTenor,plafonAwal,plafon,outstandingPrincipal,sukuBungaImbalan,Int_type,installment,kualitasTerakhir,jumlahHariTunggakan,kondisiKet,policy_result

    protected $fillable = ['customerno','status','code','message','name','tgllahir','nik','npwp','gender','tempat_lahir','address','custtype','tenant','request_reff_id','start_time','finish_time','noapi_id','fstatus','fasilitasid','ljk','ljkName','fac_type','tanggalMulai','tanggalJatuhTempo','tenor','sisaTenor','plafonAwal','plafon','outstandingPrincipal','sukuBungaImbalan','Int_type','installment','kualitasTerakhir','jumlahHariTunggakan','kondisiKet','policy_result']; 

    public function scopeGeneralSearch(Builder $query, string $search): Builder
    {
        return $query->where('datawhiz_app.api_slik_summary_postpaid.nik', 'like', '%' . $search . '%')
                     ->orWhere('datawhiz_app.api_slik_summary_postpaid.noapi_id', 'like', '%' . $search . '%')
					 ->orWhere('datawhiz_app.api_slik_summary_postpaid.name', 'like', '%' . $search . '%');
    }
}

