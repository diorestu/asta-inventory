<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service 
                            {name : The name of the service}
                            {--i|interface : Create an interface for the service}
                            {--f|force : Create the service even if it already exists}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The filesystem instance.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = trim($this->argument('name'));
        $interface = $this->option('interface');
        $force = $this->option('force');

        // Determine service name and namespace
        if (Str::contains($name, '/')) {
            $segments = explode('/', $name);
            $serviceName = array_pop($segments);
            $namespace = implode('\\', $segments);
            $directory = app_path('Services/' . implode('/', $segments));
        } else {
            $serviceName = $name;
            $namespace = '';
            $directory = app_path('Services');
        }

        // Create directory if it doesn't exist
        if (!$this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }

        // Create service file
        $servicePath = $directory . '/' . $serviceName . '.php';

        if ($this->files->exists($servicePath) && !$force) {
            $this->error('Service already exists!');
            return 1;
        }

        $stub = $this->getServiceStub();
        $stub = str_replace('{{namespace}}', $namespace ? '\\' . $namespace : '', $stub);
        $stub = str_replace('{{service}}', $serviceName, $stub);

        $this->files->put($servicePath, $stub);
        $this->info('Service created successfully: ' . $serviceName);

        // Create interface if requested
        if ($interface) {
            $interfaceDirectory = $directory . '/Interfaces';

            if (!$this->files->isDirectory($interfaceDirectory)) {
                $this->files->makeDirectory($interfaceDirectory, 0755, true);
            }

            $interfacePath = $interfaceDirectory . '/' . $serviceName . 'Interface.php';

            if ($this->files->exists($interfacePath) && !$force) {
                $this->error('Interface already exists!');
                return 1;
            }

            $interfaceStub = $this->getInterfaceStub();
            $interfaceStub = str_replace('{{namespace}}', $namespace ? '\\' . $namespace : '', $interfaceStub);
            $interfaceStub = str_replace('{{service}}', $serviceName, $interfaceStub);

            $this->files->put($interfacePath, $interfaceStub);
            $this->info('Interface created successfully: ' . $serviceName . 'Interface');
        }

        return 0;
    }

    /**
     * Get the service stub file.
     *
     * @return string
     */
    protected function getServiceStub()
    {
        return <<<'EOT'
<?php

namespace App\Services{{namespace}};

class {{service}} 
{
    // Implement your service methods here
}
EOT;
    }

    /**
     * Get the interface stub file.
     *
     * @return string
     */
    protected function getInterfaceStub()
    {
        return <<<'EOT'
<?php

interface {{service}}Interface
{
    // Define your service interface methods here
}
EOT;
    }
}