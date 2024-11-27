<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
class TaskModel extends Model
{
    // auto increment PK
    protected $primaryKey = 'task_id';
    protected $keyType = 'int'; // Data type of the key
    public $incrementing = true; // Enable auto-increment
    
    protected $table = "task";
    protected $fillable = ['title', 'description'];

    public static function getItemsByFilterAndPagination(array $filter) {
        $query = self::query();
        
        $pageSize = $filter['page_size'] ?? 10;
        $page = $filter['page'] ?? 0;

        // apply filtering and build where query
        if(isset($filter['title_search'])){
            $query->where('title', $filter['title_search']);
        }

        if(isset($filter['description_search'])){
            $query->where('description', $filter['description_search']);
        }
       
        Paginator::currentPageResolver(function() use ($page) {
            return $page;
        });

        return $query->paginate($pageSize);
    }

}