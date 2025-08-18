<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;


class TransformDataTableRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {


        if ($request->ajax()) {
            $qs = $request->query->all();

            $pagination = $request->post('pagination');
            if ($pagination && isset($pagination['page']) && isset($pagination['perpage'])) {
                $qs = array_merge($qs, $pagination);
            }

            $sort = $request->post('sort');
            if ($sort && !empty($sort['field']) && !empty($sort['sort'])) {
                $direction = $sort['sort'] === 'desc' ? '-' : '';

                $qs['sort'] = $direction . $sort['field'];
            }

            $request->query = new ParameterBag($qs);
        }



        return $next($request);
    }
}
