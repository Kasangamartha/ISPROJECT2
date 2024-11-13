<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleIdToUsersTable extends Migration
{
    public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        // Comment out or remove the line that adds 'role_id' if it already exists
        // $table->unsignedBigInteger('role_id')->default(3);

        // Ensure the foreign key constraint is added
        $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
    });
}

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
    }
}
