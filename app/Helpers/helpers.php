<?php

use Symfony\Component\HttpFoundation\ParameterBag;

function dataTableGeneralSearch(\Illuminate\Http\Request &$request, \Closure $func)
{
    $search = $request->post('query'); //generalSearch

    if ($search && !empty($search['generalSearch'])) {
        $qs = $request->query->all();
        $query = [];
        if (is_callable($func)) {
            $query = $func($search['generalSearch']);
        }

        $qs = array_merge($qs, $query);

        $request->query = new ParameterBag($qs);

    }
}
