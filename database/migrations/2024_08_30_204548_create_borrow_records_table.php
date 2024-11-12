<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
 
    public function up(): void
    {
        Schema::create('borrow_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->date('borrowed_at');
            $table->date('due_date')->nullable();
            $table->date('returned_at')->nullable();
            $table->timestamps();
        });
    }
           


    

    /**
     * Reverse the m
     * igrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_records');
    }
};
