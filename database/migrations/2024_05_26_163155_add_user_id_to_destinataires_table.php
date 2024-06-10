<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToDestinatairesTable extends Migration
{
    public function up()
    {
        Schema::table('destinataires', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('destinataires', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
