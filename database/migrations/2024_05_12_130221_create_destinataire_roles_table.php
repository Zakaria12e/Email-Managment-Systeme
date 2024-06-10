<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('destinataire_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('destinataire_id');
            $table->unsignedBigInteger('role_id');
            $table->foreign('destinataire_id')->references('id')->on('destinataires')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->primary(['destinataire_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinataire_roles');
    }
};
