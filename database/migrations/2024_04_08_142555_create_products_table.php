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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Creating the 'id' field of type uint with auto-increment
            $table->string('article')->unique(); // Field 'article' of type VARCHAR(255) with a unique index
            $table->string('name')->nullable(); // Field 'name' of type VARCHAR(255)
            $table->enum('status', ['available', 'unavailable']); // Field 'status' of type ENUM with values "available" and "unavailable"
            $table->jsonb('attributes')->nullable(); // Field 'data' of type JSONB for attributes
            $table->timestamps(); // Fields 'created_at' and 'updated_at' to store timestamps
            $table->softDeletes(); // Field 'deleted_at' for soft deletion
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
