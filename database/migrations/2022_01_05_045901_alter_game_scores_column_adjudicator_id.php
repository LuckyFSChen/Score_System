<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterGameScoresColumnAdjudicatorId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_scores' , function(Blueprint $table){
            $table->renameColumn('adjudicators_id', 'adjudicator_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_scores' , function(Blueprint $table){
            $table->renameColumn('adjudicator_id', 'adjudicators_id');
        });
    }
}
