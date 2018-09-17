<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        $options['path'] = $this->getPaginateUrl();
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function getPaginateUrl()
    {
        $url = url()->full();
        $url_arr = explode('?', $url);
        $url_end = '';

        if(count($url_arr) > 1) {
            $params = explode('&', $url_arr[1]);
            $params_arr = [];
            foreach($params as $key => $value) {
                $param = explode('=', $value);
                $params_arr[$param[0]] = count($param) > 1 ? $param[1] : '';
            }
            $id = 0;
            foreach($params_arr as $key => $value) {
                if($key != 'page') {
                    $prefix = $id == 0 ? '?' : '&';
                    $url_end .= $prefix . $key . '=' . $value;
                    ++$id;
                }
            }
        }
        return $url_arr[0] . $url_end;
    }
}
