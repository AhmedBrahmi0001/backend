<?php

use App\Models\Client;
use App\Models\Driver;
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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('comment');
            $table->unsignedTinyInteger('rating')->default(0);
            $table->foreignIdFor(Driver::class)
                ->references('id')
                ->on('drivers')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(Client::class)
                ->references('id')
                ->on('clients')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
