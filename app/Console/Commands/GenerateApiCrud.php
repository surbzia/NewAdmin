<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use App\Models\Permission;
class GenerateApiCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ycrud:generate {table}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate files like model, controller, policy';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $table = Str::studly(Str::singular($this->argument('table')));
        // echo $table;
        $bar = $this->output->createProgressBar(5);
        $bar->start();
        $bar->advance();
        Artisan::call('make:model',[
            'name'=>$table,
        ]);
        $bar->advance();
        Artisan::call('make:resource',[
            'name'=>$table.'Resource',
        ]);
        $bar->advance();
        Artisan::call('make:policy',[
            'name'=>$table.'Policy',
            '--model'=>$table,
        ]);
        $bar->advance();
        Artisan::call('make:request',[
            'name'=>$table.'Request',
        ]);
        $bar->advance();
        Artisan::call('make:controller',[
            'name'=>$table.'Controller',
            // '--requests'=>'true',//$table.'Request',
            '--model'=>$table,
            '--api'=>'true',
        ]);
        $bar->advance();
        Permission::create([
            'name'=>Str::slug($table.' List', '-'),
            'title'=>$table.' List',
        ]);
        $bar->advance();
        Permission::create([
            'name'=>Str::slug($table.' View', '-'),
            'title'=>$table.' View',
        ]);
        $bar->advance();
        Permission::create([
            'name'=>Str::slug($table.' Create', '-'),
            'title'=>$table.' Create',
        ]);
        $bar->advance();
        Permission::create([
            'name'=>Str::slug($table.' Edit', '-'),
            'title'=>$table.' Edit',
        ]);
        $bar->advance();
        Permission::create([
            'name'=>Str::slug($table.' Delete', '-'),
            'title'=>$table.' Delete',
        ]);
        $bar->finish();
        // return $table;
    }
}
