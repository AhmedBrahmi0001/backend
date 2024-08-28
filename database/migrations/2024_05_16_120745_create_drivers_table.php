<?php

use App\Models\Place;
use App\Models\User;
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
        Schema::create('drivers', function (Blueprint $table) {
             $table->id();
             $table->string('name');
             $table->decimal('price', 8, 2)->default(0);
             $table->string('image')->nullable();
             $table->foreignIdFor(Place::class)
                ->references('id')
                ->on('places')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
                $table->timestamps();
             $table->unsignedTinyInteger('is_active')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
