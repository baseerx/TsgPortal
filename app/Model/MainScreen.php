<?php
namespace App\Model;
use Illuminate\Database\Eloquent\Model;
class MainScreen extends Model
{
    protected $fillable=['uid','datetime','assetno','lassetno','tangorintang','companycode','assettype','classification','category','units','inuse','inphysicalinv','detaildesc','assettagno','ownedorleased','manufacturer','assetsno','indicator','countryoforigin','warrentydetails','pono','location','custodian','approvedbudget','assetcost','currentcost','scrapvalue','captdate','acqdate','usefullife','remaininglife','depmethod','deprate','depreciation','accumdep','impcharges','accumimplosses','depchargeacc','costcenter','revdate','revamount','deprevamount','accdeprevamount','planretirdate','lcompany','lagreementno','lagreementdate','lstartdate','leaselen','allocatedto','assetcode'];
    public $primaryKey='mid';
    public $table='mainscreen';
    public $timestamps=false;
}
