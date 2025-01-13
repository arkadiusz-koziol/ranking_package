<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRankingUsersTable extends Migration
{
    public function up(): void
    {
        Schema::create('ranking_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ranking_id')->constrained('rankings')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('data', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ranking_users');
    }
}
