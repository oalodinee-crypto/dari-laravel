<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');
        $teams = config('permission.teams');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        // إنشاء جدول الصلاحيات (Spatie Permission)
        Schema::create($tableNames['permissions'] ?? 'permissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        // إنشاء جدول الأدوار
        Schema::create($tableNames['roles'] ?? 'roles', function (Blueprint $table) use ($teams, $columnNames) {
            $table->bigIncrements('id');
            if ($teams || config('permission.testing')) {
                $table->unsignedBigInteger($columnNames['team_foreign_key'] ?? 'team_id')->nullable();
                $table->index($columnNames['team_foreign_key'] ?? 'team_id', 'roles_team_foreign_key_index');
            }
            $table->string('name');
            $table->string('guard_name');
            $table->timestamps();
            if ($teams || config('permission.testing')) {
                $table->unique([$columnNames['team_foreign_key'] ?? 'team_id', 'name', 'guard_name']);
            } else {
                $table->unique(['name', 'guard_name']);
            }
        });

        // جدول ربط النماذج بالصلاحيات
        Schema::create($tableNames['model_has_permissions'] ?? 'model_has_permissions', function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key'] ?? 'model_id');
            $table->index([$columnNames['model_morph_key'] ?? 'model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'] ?? 'permissions')
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key'] ?? 'team_id');
                $table->index($columnNames['team_foreign_key'] ?? 'team_id', 'model_has_permissions_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'] ?? 'team_id', 'permission_id', $columnNames['model_morph_key'] ?? 'model_id', 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            } else {
                $table->primary(['permission_id', $columnNames['model_morph_key'] ?? 'model_id', 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
            }
        });

        // جدول ربط النماذج بالأدوار
        Schema::create($tableNames['model_has_roles'] ?? 'model_has_roles', function (Blueprint $table) use ($tableNames, $columnNames, $teams) {
            $table->unsignedBigInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key'] ?? 'model_id');
            $table->index([$columnNames['model_morph_key'] ?? 'model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'] ?? 'roles')
                ->onDelete('cascade');
            if ($teams) {
                $table->unsignedBigInteger($columnNames['team_foreign_key'] ?? 'team_id');
                $table->index($columnNames['team_foreign_key'] ?? 'team_id', 'model_has_roles_team_foreign_key_index');

                $table->primary([$columnNames['team_foreign_key'] ?? 'team_id', 'role_id', $columnNames['model_morph_key'] ?? 'model_id', 'model_type'],
                    'model_has_roles_role_model_type_primary');
            } else {
                $table->primary(['role_id', $columnNames['model_morph_key'] ?? 'model_id', 'model_type'],
                    'model_has_roles_role_model_type_primary');
            }
        });

        // جدول ربط الأدوار بالصلاحيات
        Schema::create($tableNames['role_has_permissions'] ?? 'role_has_permissions', function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'] ?? 'permissions')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'] ?? 'roles')
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    public function down(): void
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and target tables not set.');
        }

        Schema::drop($tableNames['role_has_permissions'] ?? 'role_has_permissions');
        Schema::drop($tableNames['model_has_roles'] ?? 'model_has_roles');
        Schema::drop($tableNames['model_has_permissions'] ?? 'model_has_permissions');
        Schema::drop($tableNames['roles'] ?? 'roles');
        Schema::drop($tableNames['permissions'] ?? 'permissions');
    }
};
