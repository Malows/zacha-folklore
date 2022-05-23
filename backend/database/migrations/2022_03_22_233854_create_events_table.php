<?php

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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->date('event_day');
            $table->timestamp('started_at')->nullable();
            $table->boolean('is_active')->default(false);

            $table->unsignedInteger('reserved_tickets')->default(0);
            $table->unsignedInteger('pre_paid_reserved_tickets')->default(0);
            $table->unsignedInteger('common_tickets')->default(0);

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
        Schema::dropIfExists('events');
    }
};
