<?php

namespace App\Http\Controllers;

use App\Models\M_MCustomer;
use App\Models\M_MGCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutoController extends Controller
{
    public function autocompleteSearch(Request $request)
    {
        $query = $request->get('query');
		
        $filterResult = DB::table('billing_ats.customer') //M_MCustomer::where('STATUSCODE','A')
						->where('STATUSCODE','A')
						->where('CUSTOMERNO', 'LIKE', '%'.$query.'%')
						->orWhere(DB::raw('UPPER(CUSTOMERNAME)'), 'LIKE', '%'.$query.'%')
						->select('CUSTOMERNO','CUSTOMERNAME')
						->get();
		//dd($filterResult);
        $data = array();

        foreach ($filterResult as $hsl)
        {
			$data[] = $hsl->CUSTOMERNO;
            $data[] = $hsl->CUSTOMERNAME;
        }

        return response()->json($data);
    } 

    public function autocompleteGSearch(Request $request)
    {
        $query = $request->get('query');
        $filterResult = DB::table('billing_ats.customer_parent')->where(DB::raw('UPPER(PARENT_CUSTOMER)'), 'LIKE', '%'. $query. '%')->select('PARENT_CUSTOMER')->orderBy('PARENT_CUSTOMER')->get();

        $data = array();

        foreach ($filterResult as $hsl)
        {
            $data[] = $hsl->PARENT_CUSTOMER;
        }

        return response()->json($data);
    } 
}
