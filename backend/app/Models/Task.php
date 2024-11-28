<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use App\Http\Resources\TaskResource;

class Task extends Model
{
    // auto increment PK
    protected $primaryKey = 'task_id';
    protected $keyType = 'int'; // Data type of the key
    public $incrementing = true; // Enable auto-increment

    protected $table = "task";
    protected $fillable = ['title', 'description', 'created_by', 'due_date'];

    private static $defaultPageSize = 10;
    private static $defaultPage = 1;

    public static function getTasksByFilterAndPagination(array $filter)
    {
        $query = self::query();

        $pageSize = $filter['page_size'] ?? self::$defaultPageSize;
        $page = $filter['page'] ?? self::$defaultPage;

        if (isset($filter['title_search'])) {
            $exactSearch = $filter['excact_title_search'];
            // determine whether to use exact search
            $operator = $exactSearch ? '=' : 'ILIKE';
            $value = $exactSearch ? $filter['title_search'] : '%' . $filter['title_search'] . '%';
            $query->where('title', $operator, $value);
        }

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });

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