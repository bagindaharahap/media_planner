<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * @param string $module   Planning, Notes, Prompt, User, Auth
     * @param string $action   create, update, delete, login, logout
     * @param string $activity Deskripsi aktivitas
     * @param array|null $before Data sebelum perubahan
     * @param array|null $after  Data sesudah perubahan
     */
    public static function log(
        string $module,
        string $action,
        string $activity,
        ?array $before = null,
        ?array $after = null
    ): void {
        // Hapus field sensitif
        $exclude = ['password', 'remember_token', 'updated_at', 'created_at'];

        if ($before) {
            $before = array_diff_key($before, array_flip($exclude));
        }
        if ($after) {
            $after = array_diff_key($after, array_flip($exclude));
        }

        ActivityLog::create([
            'user_id'  => Auth::id(),
            'module'   => $module,
            'action'   => $action,
            'activity' => $activity,
            'before'   => $before,
            'after'    => $after,
        ]);
    }
}
