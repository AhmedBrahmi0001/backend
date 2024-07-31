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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code')->unique();
            $table->date('delivered_date')->nullable();
            $table->string('pickup_address');
            $table->string('deliver_address');
            $table->string('latitude_pickup_address')->nullable();
            $table->string('longitude_pickup_address')->nullable();
            $table->string('latitude_deliver_address')->nullable();
            $table->string('longitude_deliver_address')->nullable();
            $table->unsignedTinyInteger('quantity')->default(0);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->enum('etat',['pending','accepted','ongoing','delivered','rejected','cancelled'])->default('pending');
            $table->foreignIdFor(Client::class)
                ->references('id')
                ->on('clients')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
                 $table->foreignIdFor(Driver::class)
                ->references('id')
                ->on('drivers')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
