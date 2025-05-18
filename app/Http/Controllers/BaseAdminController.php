<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class BaseAdminController extends Controller
{
    /**
     * Default number of items per page
     */
    protected $defaultPerPage = 10;
    
    /**
     * Apply pagination to a query based on request parameters
     *
     * @param Builder $query
     * @param Request $request
     * @param string $defaultSortField
     * @param string $defaultDirection
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginateResults($query, Request $request, $defaultSortField = 'created_at', $defaultDirection = 'desc')
    {
        // Get pagination parameters
        $perPage = (int) $request->query('per_page', $this->defaultPerPage);
        
        // Add sorting if needed
        $sortField = $request->query('sort', $defaultSortField);
        $direction = $request->query('direction', $defaultDirection);
        
        if ($sortField && $direction) {
            $query->orderBy($sortField, $direction);
        }
        
        return $query->paginate($perPage)->withQueryString();
    }
}