<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\ParameterBag;

class M_CompanyAPI extends Controller
{
    public function autocompleteAPISearch(Request $request)
    {
        $query = $request->get('query');
		  
        $filterResult = DB::table('master_company')->where('billingtype', '=', 2)->where('fapi', 1)->where('company_name', 'LIKE', '%'.$query.'%')->orWhere('customerno', 'LIKE', '%'.$query.'%')->select('customerno', 'company_name')->get();
		//dd($data);

        $data = array();

        foreach ($filterResult as $hsl)
        {
			$data[] = $hsl->customerno;
            $data[] = $hsl->company_name;
        }

        return response()->json($data);
    } 
	
	public function cariAPICustomer(Request $request, $id)
	{
		$data = DB::table('master_company')
				->where('fapi', 1)
                ->where('customerno', $id)
				->orWhere('company_name', $id)
				->select('id AS companyid','customerno','company_name')
				->first();
		//dd($data);
		
		return response()->json($data);
	}
}
