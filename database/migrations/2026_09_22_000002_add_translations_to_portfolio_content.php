<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('title_id')->nullable()->after('title_en');
            $table->text('bio_en')->nullable()->after('bio');
            $table->text('bio_id')->nullable()->after('bio_en');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('title_id')->nullable()->after('title_en');
            $table->text('description_en')->nullable()->after('description');
            $table->text('description_id')->nullable()->after('description_en');
            $table->string('category_en', 100)->nullable()->after('category');
            $table->string('category_id', 100)->nullable()->after('category_en');
        });

        Schema::table('experiences', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('title_id')->nullable()->after('title_en');
            $table->text('description_en')->nullable()->after('description');
            $table->text('description_id')->nullable()->after('description_en');
        });

        Schema::table('awards', function (Blueprint $table) {
            $table->string('title_en')->nullable()->after('title');
            $table->string('title_id')->nullable()->after('title_en');
            $table->text('description_en')->nullable()->after('description');
            $table->text('description_id')->nullable()->after('description_en');
        });

        DB::table('profiles')->update([
            'title_en' => DB::raw('title'), 'title_id' => DB::raw('title'),
            'bio_en' => DB::raw('bio'), 'bio_id' => DB::raw('bio'),
        ]);
        DB::table('projects')->update([
            'title_en' => DB::raw('title'), 'title_id' => DB::raw('title'),
            'description_en' => DB::raw('description'), 'description_id' => DB::raw('description'),
            'category_en' => DB::raw('category'), 'category_id' => DB::raw('category'),
        ]);
        DB::table('experiences')->update([
            'title_en' => DB::raw('title'), 'title_id' => DB::raw('title'),
            'description_en' => DB::raw('description'), 'description_id' => DB::raw('description'),
        ]);
        DB::table('awards')->update([
            'title_en' => DB::raw('title'), 'title_id' => DB::raw('title'),
            'description_en' => DB::raw('description'), 'description_id' => DB::raw('description'),
        ]);
    }

    public function down(): void
    {
        Schema::table('awards', fn (Blueprint $table) => $table->dropColumn(['title_en', 'title_id', 'description_en', 'description_id']));
        Schema::table('experiences', fn (Blueprint $table) => $table->dropColumn(['title_en', 'title_id', 'description_en', 'description_id']));
        Schema::table('projects', fn (Blueprint $table) => $table->dropColumn(['title_en', 'title_id', 'description_en', 'description_id', 'category_en', 'category_id']));
        Schema::table('profiles', fn (Blueprint $table) => $table->dropColumn(['title_en', 'title_id', 'bio_en', 'bio_id']));
    }
};
