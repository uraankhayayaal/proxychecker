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
        Schema::create('_queries', function (Blueprint $table) {
            $table->id();
            $table->longText('addresses');
            $table->timestamps();
        });

        Schema::create('_proxies', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->integer('port');
            $table->string('type')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('speed')->nullable();
            $table->float('timeout')->nullable();
            $table->string('externalIp')->nullable();
            $table->time('checkedAt')->nullable();
            $table->unsignedBigInteger('queryId');
            $table->timestamps();

            $table->foreign('queryId')->references('id')->on('_queries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_proxies');

        Schema::dropIfExists('_queries');
    }
};
