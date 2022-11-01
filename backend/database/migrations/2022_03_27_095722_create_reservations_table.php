<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('last_name');

            $table->unsignedInteger('amount')->default(1);
            $table->uuid('uuid')->index();

            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->boolean('is_paid')->default(true);
            $table->boolean('is_used')->default(false);

            $table->foreignIdFor(Event::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
