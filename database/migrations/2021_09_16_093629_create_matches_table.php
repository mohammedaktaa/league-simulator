<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('week_id');
            $table->foreignId('host_team_id');
            $table->foreignId('guest_team_id');
            $table->text('description');
            $table->unsignedSmallInteger('host_team_score')->nullable();
            $table->unsignedSmallInteger('guest_team_score')->nullable();
            $table->unsignedSmallInteger('host_team_points')->nullable();
            $table->unsignedSmallInteger('guest_team_points')->nullable();
            $table->tinyInteger('played')->default(0);
            $table->timestamps();

            $table->foreign('week_id')->references('id')->on('weeks');
            $table->foreign('host_team_id')->references('id')->on('teams');
            $table->foreign('guest_team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
