<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bullets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index()->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('collection_id')->index()->nullable()->constrained()->onDelete('cascade');
            $table->string('type');
            $table->string('name');
            $table->string('state');
            $table->boolean('priority')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bullets');
    }
};
