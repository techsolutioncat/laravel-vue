<?php
/**
 * Created by PhpStorm.
 * User: solom
 * Date: 7/12/2020
 * Time: 12:40 AM
 */

namespace App\Helpers;


use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class EmergeRouteHelper
{
    /**
     * Change collection to paginate
     *
     * @param $items
     * @param $per_page
     * @return LengthAwarePaginator
     */
    public static function customPaginate($items, $per_page, $fullUrl='')
    {
        $page_start = request('page', 1);
        $offSet    = ($page_start * $per_page) - $per_page;

        $items_for_current_page = $items->slice($offSet, $per_page);

        return new LengthAwarePaginator(
            $items_for_current_page, $items->count(),
            $per_page,
            Paginator::resolveCurrentPage(),
            ['path' => self::setUrl($fullUrl != '' ? $fullUrl : Paginator::resolveCurrentPath())]
        );
    }

    public static function setUrl($fullUrl, $key='page') {
        if (strpos($fullUrl, '?') === false) return $fullUrl;

        list($basePath, $segments) = explode('?', $fullUrl);

        $rs = explode('&', $segments);
        $params = [];
        foreach ($rs AS $el) {
            if (strpos($el, $key.'=') === false) {
                $params[] = $el;
            }
        }
        return $basePath . (!empty($params) ? ('?' . implode('&', $params)) : '') ;
    }
}
