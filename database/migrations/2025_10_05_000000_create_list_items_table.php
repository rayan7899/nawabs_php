<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('list_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->unsignedSmallInteger('status');
            $table->timestamp('need_at')->nullable();
            $table->foreignId('needed_by')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->foreignId('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            
            $table->unique(['list_id', 'item_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('list_items');
    }
};