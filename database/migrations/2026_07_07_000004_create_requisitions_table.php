<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionsTable extends Migration
{
    public function up()
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('requester')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('requisitions');
    }
}
