<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'task_id' => $this->task_id,
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->getTaskStatus($this->due_date),
        ];
    }

    private function getTaskStatus($due_date)
    {
        $defaultStatus = 'Not Urgent';

        if ($due_date === null) {
            return $defaultStatus;
        }

        // Use UTC format for date storing and calculation for consistency across diff timezone
        $dueDate = Carbon::parse($due_date);
        $now = Carbon::now('UTC');

        if ($dueDate->isPast()) {
            return 'Overdue';
        }

        if ($dueDate->diffInDays($now) <= 7) {
            return 'Due Soon';
        }

        return $defaultStatus;
    }
}
