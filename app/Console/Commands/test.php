<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        print_r('start');
        $data = [
            'title' => 'Mindfulness: 100 Days Transforming Daily Life',
            'author' => 'Charles',
            'status' => 'published',
        ];
        Post::create($data);
        print_r('end');
        exit;
        return Command::SUCCESS;
    }
}
