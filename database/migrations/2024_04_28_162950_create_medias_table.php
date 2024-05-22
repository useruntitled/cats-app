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
        Schema::create('medias', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->primary('uuid');

            $table->foreignId('user_id')->constrained();

            $table->string('href')->nullable()->default(null);

            $table->nullableMorphs('mediaAble');

            $table->string('format')->nullable()->default(null);

            $table->integer('width')->nullable()->default(null);

            $table->integer('height')->nullable()->default(null);

            $table->text('base64_preview')->nullable()->default(null);

            $table->boolean('is_video')->nullable()->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $files = Storage::disk('media')->allFiles();

        Storage::disk('media')->delete($files);

        Schema::dropIfExists('medias');
    }
};
