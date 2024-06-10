<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('destinataires', function (Blueprint $table) {
            $table->id();
            $table->string('nom_dest')->required();
            $table->string('prenom_dest')->required();
            $table->string('telephone_dest')->required();
            $table->string('first_email')->required();
            $table->string('second_email')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('structure_id')->nullable();
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('structure_id')->references('id')->on('structures');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinataires');
    }
};
