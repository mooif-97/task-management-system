<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\TaskResource;

class Task extends Model
{
    use HasFactory; 

    // auto increment PK
    protected $primaryKey = 'task_id';
    protected $keyType = 'int'; // Data type of the key
    public $incrementing = true; // Enable auto-increment

    protected $table = "task";
    protected $fillable = ['title', 'description', 'created_by', 'due_date'];

    private static $defaultPageSize = 10;
    private static $defaultPage = 1;
    private static $allowedOrderColumns = ['title', 'created_at', 'description', 'due_date'];
    private static $allowedOrder = ['asc', 'desc'];

    public static function getTasksByFilterAndPagination(array $filter)
    {
        $query = self::query();

        $pageSize = $filter['page_size'] ?? self::$defaultPageSize;
        $page = $filter['page'] ?? self::$defaultPage;

        if (isset($filter['title_search']) && !empty($filter['title_search'])) {
            $exactSearch = isset($filter['exact_title_search']) ? $filter['exact_title_search'] : false;
            // determine whether to use exact search
            // LIKE operator is different by DB type
            $operator = $exactSearch ? '=' : (DB::getDriverName() == 'pgsql' ? 'ILIKE' : 'LIKE');
            $value = $exactSearch ? $filter['title_search'] : '%' . $filter['title_search'] . '%';
            $query->where('title', $operator, $value);
        }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

        if(isset($filter['order_by']) && !empty($filter['order_by']) && in_array($filter['order_by'], self::$allowedOrderColumns)){
            // default order to asc if order value is invalid
            $order = isset($filter['order']) && !empty($filter['order']) && in_array($filter['order'], self::$allowedOrder) ? $filter['order'] : 'asc';
            // make timestamp columns appear last if its value is null
            if (in_array($filter['order_by'], ['created_at', 'due_date'])){
                $query->orderByRaw("{$filter['order_by']} IS NULL, {$filter['order_by']} {$order}");
            }
            else {
                $query->orderBy($filter['order_by'], $order);
            }
            
        } else {
            // lets default order by due_date asc
            $query->orderByRaw('due_date IS NULL, due_date ASC');
        }

        $tasks = $query->paginate($pageSize);

        return TaskResource::collection($tasks->items())->additional([
            'page_details' => [
                'current_page' => $tasks->currentPage(),
                'page_size' => $tasks->perPage(),
                'total' => $tasks->total(),
                'last_page' => $tasks->lastPage(),
                'next_page_url' => $tasks->nextPageUrl(),
                'prev_page_url' => $tasks->previousPageUrl(),
            ],
        ]);
    }
}