<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('tasks', 'title')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->string('task_name')->nullable();
                $table->string('status')->default('Pending');
                $table->date('due_date')->nullable();
            });

            DB::table('tasks')->update([
                'task_name' => DB::raw('title'),
                'status' => DB::raw("CASE WHEN completed = 1 THEN 'Completed' ELSE 'Pending' END"),
            ]);

            Schema::table('tasks', function (Blueprint $table) {
                $table->dropColumn(['title', 'completed']);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tasks', 'task_name')) {
            Schema::table('tasks', function (Blueprint $table) {
                $table->string('title')->nullable();
                $table->boolean('completed')->default(false);
            });

            DB::table('tasks')->update([
                'title' => DB::raw('task_name'),
                'completed' => DB::raw("CASE WHEN status = 'Completed' THEN 1 ELSE 0 END"),
            ]);

            Schema::table('tasks', function (Blueprint $table) {
                $table->dropColumn(['task_name', 'status', 'due_date']);
            });
        }
    }
};