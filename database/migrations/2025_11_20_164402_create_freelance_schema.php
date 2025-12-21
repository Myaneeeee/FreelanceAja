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
        Schema::create('client_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('company_name')->nullable();
            $table->text('company_description')->nullable();
            $table->string('website_url')->nullable();
            $table->timestamps();
        });

        Schema::create('freelancer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('headline')->nullable();
            $table->text('bio')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->decimal('rate_per_hour', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->boolean('is_global')->default(false);
            $table->timestamps();
        });

        Schema::create('freelancer_profile_skill', function (Blueprint $table) {
            $table->foreignId('freelancer_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->primary(['freelancer_profile_id', 'skill_id'], 'fp_skill_primary');
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_profile_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->decimal('budget', 10, 2);
            $table->enum('type', ['fixed_price', 'hourly']);
            $table->enum('status', ['open', 'in_progress', 'completed', 'cancelled'])->default('open');
            $table->date('deadline')->nullable();
            $table->timestamps();
        });

        Schema::create('job_skill', function (Blueprint $table) {
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('skill_id')->constrained()->onDelete('cascade');
            $table->primary(['job_id', 'skill_id']);
        });

        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('freelancer_profile_id')->constrained()->onDelete('cascade');
            $table->text('cover_letter');
            $table->decimal('bid_amount', 10, 2);
            $table->enum('status', ['sent', 'accepted', 'rejected'])->default('sent');
            $table->timestamps();
        });

        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('proposal_id')->constrained()->onDelete('cascade');
            $table->foreignId('freelancer_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_profile_id')->constrained()->onDelete('cascade');
            $table->decimal('final_price', 10, 2);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'completed', 'disputed', 'cancelled'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('proposals');
        Schema::dropIfExists('job_skill');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('freelancer_profile_skill');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('freelancer_profiles');
        Schema::dropIfExists('client_profiles');
    }
};
