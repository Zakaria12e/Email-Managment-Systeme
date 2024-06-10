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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('exped_nom')->required();
            $table->string('exped_org')->nullable();
            $table->string('email_exped')->required();
            $table->timestamp('date_exped')->required();
            $table->text('sujet')->required();
            $table->text('contenu')->required();
            $table->timestamp('dead_line')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('nbr_env')->default(0);
            $table->string('status');
            $table->text('to')->required();
            $table->text('cc')->nullable();
            $table->text('cci')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
