<?php

namespace App\Console\Commands;

use App\Ai\Agents\SupportAgent;
use App\Models\User;
use Illuminate\Console\Command;

use function Laravel\Prompts\text;

class Support extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:support';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::query()->first();
        $conversationId = '';

        while (true) {
            $prompt = text('Enter you queries...');

            $response = SupportAgent::make()
                ->continue($conversationId, as: $user)
                ->prompt($prompt);

            $conversationId = $response->conversationId;
            $this->info((string) $response);
        }
    }
}
