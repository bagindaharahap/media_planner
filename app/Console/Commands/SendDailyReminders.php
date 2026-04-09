<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Planning;
use App\Models\Note;
use App\Models\User;
use App\Notifications\SystemNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;

class SendDailyReminders extends Command
{
    protected $signature = 'reminders:send';

    protected $description = 'Kirim pengingat H-3, H-2, H-1 untuk konten dan catatan';

    public function handle(): int
    {
        $daysToRemind = [
            1 => 'Besok (H-1)',
            2 => 'Lusa (H-2)',
            3 => 'Dalam 3 hari (H-3)',
        ];

        foreach ($daysToRemind as $days => $label) {
            $targetDate = Carbon::now()->addDays($days)->toDateString();

            // 1. PENGINGAT KONTEN (BOARD)
            $contents = Planning::whereDate('due_date', $targetDate)
                ->where('status', '!=', 'published')
                ->get();

            foreach ($contents as $content) {
                $assignees = $content->assigned ?? [];

                foreach ($assignees as $assignee) {
                    $name = $assignee['name'] ?? null;
                    if (empty($name)) {
                        continue;
                    }

                    $user = User::where('name', $name)->first();
                    if ($user) {
                        $user->notify(new SystemNotification(
                            "Jadwal Tayang $label",
                            "Persiapkan konten \"{$content->title}\". Jadwal rilis: $label.",
                            'warning',
                            route('board.index')
                        ));
                    }
                }
            }

            // 2. PENGINGAT CALENDAR NOTES
            $notes = Note::whereDate('date', $targetDate)->get();
            foreach ($notes as $note) {
                if (!empty($note->user_id)) {
                    $owner = User::find($note->user_id);
                    if ($owner) {
                        $owner->notify(new SystemNotification(
                            "Pengingat Catatan $label",
                            "Agenda: \"{$note->title}\" jatuh pada $label.",
                            'warning',
                            route('calendar.index')
                        ));
                    }
                }
            }
        }

        // 3. OVERDUE: konten lewat due_date tapi masih belum published
        // Gunakan due_date; fallback ke schedule_date jika ada kolom tersebut
        $overdue = Planning::where(function ($q) {
                $today = Carbon::today()->toDateString();
                $q->whereDate('due_date', '<', $today);
                if (Schema::hasColumn('plannings', 'schedule_date')) {
                    $q->orWhereDate('schedule_date', '<', $today);
                }
            })
            ->whereIn('status', ['backlog', 'progress', 'review', 'revisi', 'hold_on'])
            ->get();

        if ($overdue->isNotEmpty()) {
            $admins = User::whereIn('role', ['Admin', 'admin'])->get();
        }

        foreach ($overdue as $content) {
            $assignees = $content->assigned ?? [];

            // Notify admins
            Notification::send($admins ?? collect(), new SystemNotification(
                'Deadline Terlewat',
                "Konten \"{$content->title}\" melewati tenggat tetapi masih {$content->status}.",
                'error',
                route('board.index')
            ));

            // Notify assignees
            foreach ($assignees as $assignee) {
                $name = $assignee['name'] ?? $assignee['label'] ?? null;
                if ($name) {
                    $user = User::where('name', $name)->first();
                    if ($user) {
                        $user->notify(new SystemNotification(
                            'Deadline Terlewat',
                            "Konten \"{$content->title}\" sudah melewati due date, status: {$content->status}.",
                            'warning',
                            route('board.index')
                        ));
                        continue;
                    }
                }
                // Fallback: kirim ke semua planner jika tidak ketemu nama
                $planners = User::whereIn('role', ['Planner', 'Content Planner', 'planner', 'content planner'])->get();
                Notification::send($planners, new SystemNotification(
                    'Deadline Terlewat',
                    "Konten \"{$content->title}\" sudah melewati due date, status: {$content->status}.",
                    'warning',
                    route('board.index')
                ));
            }
        }

        $this->info('Pengingat harian berhasil dikirim.');
        return Command::SUCCESS;
    }
}
