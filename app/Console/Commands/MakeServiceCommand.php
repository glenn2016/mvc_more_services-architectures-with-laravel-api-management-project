<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;


class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un service dans app/Services';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $className = str($name)->studly()->finish('Service');
        $servicePath = app_path("Services/{$className}.php");

        if (File::exists($servicePath)) {
            $this->error(" Le service {$className} existe déjà.");
            return;
        }

        if (!File::isDirectory(app_path('Services'))) {
            File::makeDirectory(app_path('Services'), recursive: true);
        }

        $content = <<<PHP
        <?php

        namespace App\Services;

        class {$className}
        {
            //
        }
        PHP;

        File::put($servicePath, $content);
        $this->info(" Service {$className} créé avec succès !");
    }
}
