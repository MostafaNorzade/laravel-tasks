<?php

namespace App\Console\Commands;

use App\User;
use App\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs the application';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('key:generate');
        Artisan::call('migrate');

        User::query()->create([
            'name' => 'hi',
            'email' => 'hi@example.com',
            'password' => bcrypt('secret'),
        ]);
        $task1 = Task::query()->create([
            'name' => 'feeding cats',
            'description' => 'The cats get hungry every day.',
        ]);

        tempTags($task1)->tagIt('complete', Carbon::tomorrow()->startOfDay());

        $task2 = Task::query()->create([
            'name' => 'reading book',
            'description' => 'increase your knowledge.',
        ]);

        $task3 = Task::query()->create([
            'name' => 'exercise out doors',
            'description' => 'Take care of health.',
        ]);

        $this->info('You can now login     email: hi@example.com    password: secret');

        return 1;
    }
}
