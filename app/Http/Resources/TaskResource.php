<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

use function filter_var;


class TaskResource extends JsonResource
{

    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "created_at" => (new Carbon("$this->created_at"))->format('Y-m-d'),
            "due_date" => (new Carbon("$this->due_date"))->format('Y-m-d'),
            "status" => $this->status,
            "priority" => $this->priority,
            "image_path" => filter_var($this->image_path, FILTER_VALIDATE_URL) ? $this->image_path : Storage::url($this->image_path),
            "project_id" => $this->project_id,
            "project" => $this->project ? new ProjectResource($this->project) : null,
            "assigned_user_id" => $this->assigned_user_id,
            "assignedTo" => $this->assignedTo ? new UserResource($this->assignedTo) : null,
            "createdBy" => new UserResource($this->createdBy),
            "updatedBy" => new UserResource($this->updatedBy),
        ];
    }
}