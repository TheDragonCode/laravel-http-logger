<?php

declare(strict_types=1);

use DragonCode\LaravelHttpLogger\Concerns\HasTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    use HasTable;

    public function up()
    {
        $this->connection()->create($this->getLogsTableName(), function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable()->index();
            $table->string('method');
            $table->string('scheme');
            $table->string('host');
            $table->smallInteger('port')->nullable();
            $table->string('path');

            $table->json('query');
            $table->json('payload');
            $table->json('headers');

            $table->ipAddress('ip')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        $this->connection()->dropIfExists($this->getLogsTableName());
    }

    protected function connection(): Builder
    {
        return Schema::connection($this->getLogsConnectionName());
    }
};
