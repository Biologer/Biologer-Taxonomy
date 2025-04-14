<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCountryTaxonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('country_taxon', function (Blueprint $table) {
            $table->boolean('restricted')->nullable();
            $table->boolean('allochthonous')->nullable();
            $table->boolean('invasive')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('country_taxon', function (Blueprint $table) {
            $table->dropColumn('restricted');
            $table->dropColumn('allochthonous');
            $table->dropColumn('invasive');
        });
    }
}
