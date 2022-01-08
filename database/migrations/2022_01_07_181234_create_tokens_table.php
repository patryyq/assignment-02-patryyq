<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class CreateTokensTable extends Migration
{
    public function up()
    {
        Schema::create('tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->unique();
            $table->string('code_2fa')->nullable();
            $table->string('token')->nullable();
            $table->timestamp('code_2fa_updated_at')->nullable();
            $table->timestamp('token_updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tokens');
    }
}
