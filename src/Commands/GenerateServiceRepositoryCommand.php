<?php

namespace JayPatel\ServiceRepositoryPackage\Commands;
use Illuminate\Console\Command;

class GenerateServiceRepositoryCommand extends Command
{
    protected $signature = 'make:service-repository {model}';
    protected $description = 'Generate files for a service repository pattern';

    public function handle()
    {
        $modelName = $this->argument('model');

        // Call methods to generate files
        $this->generateRepositoryInterface($modelName);
        $this->generateRepository($modelName);
        $this->generateServiceInterface($modelName);
        $this->generateService($modelName);
        $this->generateModel($modelName);
        $this->generateApiController($modelName);

        $this->info("Serive Repository Files for the '$modelName' model generated successfully!");
    }

    protected function generateModel($modelName)
    {
        $this->call('make:model', [
            'name' => "{$modelName}",
            '-m' => true,
        ]);
    }

    protected function generateRepositoryInterface($modelName)
    {
        $content = $this->getStubContent('RepositoryInterface', $modelName);
        $this->generateFile("Repositories/Interfaces/{$modelName}RepositoryInterface", $content);
    }

    protected function generateRepository($modelName)
    {
        $content = $this->getStubContent('Repository', $modelName);
        $this->generateFile("Repositories/{$modelName}Repository", $content);
    }

    protected function generateServiceInterface($modelName)
    {
        $content = $this->getStubContent('ServiceInterface', $modelName);
        $this->generateFile("Services/Interfaces/{$modelName}ServiceInterface", $content);
    }

    protected function generateService($modelName)
    {
        $content = $this->getStubContent('Service', $modelName);
        $this->generateFile("Services/{$modelName}Service", $content);
    }

    protected function generateApiController($controllerName)
    {
        $this->call('make:controller', [
            'name' => 'API\\' . $controllerName . 'Controller',
            '--api' => true,
        ]);
    }

    protected function generateFile($path, $content)
    {
        $filePath = app_path("$path.php");

        // Ensure the directory exists
        $directory = dirname($filePath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Create the file
        if (!file_exists($filePath)) {
            file_put_contents($filePath, $content);
            $this->info("File created successfully: $path");
        } else {
            $this->error("File already exists: $path");
        }
    }

    protected function getStubContent($fileType, $modelName)
    {
        // $stubPath = __DIR__ . "/stubs/{$fileType}.stub";
        $stubPath = base_path("app/stubs/{$fileType}.stub");
        $content = file_get_contents($stubPath);

        // Replace placeholders with actual values
        $content = str_replace('::modelName::', $modelName, $content);

        return $content;
    }

    protected function getNamespace($fileType)
    {
        // Return the namespace based on the file type
        switch ($fileType) {
            case 'RepositoryInterface':
            case 'Repository':
                return 'Repositories\Interfaces';
            case 'ServiceInterface':
            case 'Service':
                return 'Services\Interfaces';
            default:
                return '';
        }
    }
}
