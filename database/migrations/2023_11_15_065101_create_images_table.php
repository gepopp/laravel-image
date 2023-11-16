<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create( 'images', function ( Blueprint $table ) {
            $table->id();
            $table->string('filename');
            $table->string( 'path' )->nullable();
            $table->string( 'webp_path' )->nullable();
            $table->string( 'url' )->nullable();
            $table->string( 'webp_url' )->nullable();
            $table->string( 'mime' )->nullable();
            $table->unsignedInteger( 'width' )->nullable();
            $table->unsignedInteger( 'height' )->nullable();
            $table->unsignedInteger( 'size' )->nullable();
            $table->json( 'sizes' )->nullable();
            $table->json( 'webp_sizes' )->nullable();
            $table->text( 'srcset' )->nullable();
            $table->text( 'webp_srcset' )->nullable();
            $table->string( 'alt' )->nullable();
            $table->json( 'meta' )->nullable();
            $table->softDeletes();
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'images' );
    }
};
