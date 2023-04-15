<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\QueryException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role', 45);

            $table->charset = 'utf16';
            $table->collation = 'utf16_general_ci';
            $table->engine = 'InnoDB';
        });

        DB::table('role')->insert([
            ['id' => 1, 'role' => 'Administratieve medewerkers'],
            ['id' => 2, 'role' => 'Wetenschappelijke medewerkers'],
            ['id' => 3, 'role' => 'Administrator'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        if (Schema::hasTable('users')) {
            try {
                Schema::drop('users');
            } catch(QueryException $e) {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropForeign(['role_id']);
                });
            }
        }
        Schema::dropIfExists('role');
    }
};
