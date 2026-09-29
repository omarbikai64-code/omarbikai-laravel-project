<?php

namespace App\Console\Commands;

use App\Models\ApiKey;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateApiKey extends Command
{
    protected $signature = 'api-key:generate {name=DefaultClient}';
    protected $description = 'Generate a new API token for client access';

    public function handle()
    {
        $token = 'sk_' . Str::random(32);
        
        ApiKey::create([
            'name' => $this->argument('name'),
            'key' => $token,
            'is_active' => true,
        ]);

        $this->info("API Key generated successfully!");
        $this->line("Token: <fg=green>{$token}</>");
        
        return Command::SUCCESS;
    }
}