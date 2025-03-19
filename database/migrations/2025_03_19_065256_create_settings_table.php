<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->timestamps();
        });

        // Insert default office location
        DB::table('settings')->insert([
            ['key' => 'office_latitude', 'value' => '6.6357887'],
            ['key' => 'office_longitude', 'value' => '80.7119126'],
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
};

