<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
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
    protected $description = 'Create a new service with its structure';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $serviceName = $this->argument('name');
        $servicePath = app_path("Services/{$serviceName}");

        $directories = [
            "{$servicePath}/Controllers",
            "{$servicePath}/Models",
            "{$servicePath}/Repositories",
            "{$servicePath}/Services",
            "{$servicePath}/DTOs",
            "{$servicePath}/Contracts",
            "{$servicePath}/Facades",
            "{$servicePath}/Providers",
        ];

        foreach ($directories as $directory) {
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
                $this->info("Created directory: {$directory}");
            }
        }

        $this->createFileFromStub('controller', $serviceName, 'Controllers');
        $this->createFileFromStub('model', $serviceName, 'Models');
        $this->createFileFromStub('repository', $serviceName, 'Repositories');
        $this->createFileFromStub('service', $serviceName, 'Services');
        $this->createFileFromStub('DTO', $serviceName, 'DTOs');
        $this->createFileFromStub('contract', $serviceName, 'Contracts');
        $this->createFileFromStub('facade', $serviceName, 'Facades');
        $this->createFileFromStub('serviceProvider', $serviceName, 'Providers');

        $this->info("Service {$serviceName} created successfully.");
    }

    protected function createFileFromStub($type, $serviceName, $subDir)
    {
        $type = ucfirst($type);
        $stubPath = resource_path("stubs/{$type}.stub");
        $content = File::get($stubPath);
        $content = str_replace('{{serviceName}}', $serviceName, $content);

        if ($type === 'Model') {
            $fileName = "{$serviceName}.php";
        } else {
            $fileName = "{$serviceName}{$type}.php";
        }
        $filePath = app_path("Services/{$serviceName}/{$subDir}/{$fileName}");

        if (!File::exists($filePath)) {
            File::put($filePath, $content);
            $this->info("Created file: {$filePath}");
        } else {
            $this->error("File already exists: {$filePath}");
        }
    }
}
