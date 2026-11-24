<?php

use App\Models\ActivityLog;

if (!function_exists('log_activity')) {
    /**
     * Log an activity
     */
    function log_activity(string $action, ?string $description = null, $model = null): void
    {
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'model_type'  => $model ? get_class($model) : null,
            'model_id'    => $model?->id,
            'description' => $description,
            'ip_address'  => request()->ip(),
        ]);
    }
}