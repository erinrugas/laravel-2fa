<?php

namespace ErinRugas\Laravel2fa\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class Installations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-2fa:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Laravel 2FA';

    /**
     * Laravel File System
     *
     * @var $filesystem
     */
    public $filesystem;

    /**
     * package.json path
     *
     * @var string
     */
    public $packageJsonPath;


    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
        $this->packageJsonPath = base_path('package.json');
    }

    public function handle()
    {
        $this->updatePackageJson();

        //copy js
        $this->filesystem->ensureDirectoryExists(resource_path('js'));
        $this->filesystem->copyDirectory(__DIR__ . '/../resources/js', resource_path('js'));

        //copy sass
        $this->filesystem->ensureDirectoryExists(resource_path('scss'));
        $this->filesystem->copyDirectory(__DIR__ . '/../resources/scss', resource_path('scss'));

        $this->filesystem->copy(__DIR__ . '/../webpack.mix.js', base_path('webpack.mix.js'));

        //copy controllers
        $this->filesystem->ensureDirectoryExists(app_path('Http/Controllers/Auth'));
        $this->filesystem->copyDirectory(__DIR__ . '/../Http/Controllers/Auth', app_path('Http/Controllers/Auth'));
        
        $this->filesystem->ensureDirectoryExists(app_path('Http/Controllers'));
        $this->filesystem->copyDirectory(__DIR__ . '/../Http/Controllers', app_path('Http/Controllers'));

        //copy models
        $this->filesystem->ensureDirectoryExists(app_path('Models'));
        $this->filesystem->copyDirectory(__DIR__ . '/../Models', app_path('Models'));
        
        //copy request
        $this->filesystem->ensureDirectoryExists(app_path('Http/Requests'));
        $this->filesystem->copyDirectory(__DIR__ . '/../Http/Requests', app_path('Http/Requests'));

        //copy routes
        $this->filesystem->copyDirectory(__DIR__ . '/../routes', base_path('routes'));

        //copy views
        $this->filesystem->ensureDirectoryExists(resource_path('views'));
        $this->filesystem->copyDirectory(__DIR__ . '/../resources/views', resource_path('views'));

        $this->info('Laravel 2FA Successfully Installed');
        $this->comment('Please run "npm install" and "npm run dev" to build your assets');
    }

    /**
     * Update package.json
     *
     * @return void
     */
    protected function updatePackageJson()
    {
        if (! file_exists($this->packageJsonPath)) {
            return;
        }

        $packages = $this->getPackageJsonContents();

        if (array_key_exists('devDependencies', $packages)) {
            $devDependencies = [
                "@popperjs/core" => "^2.9.2",
                "bootstrap" => "^5.0.2",
                'sass'  => "^1.32.13",
                "sass-loader" => "^11.1.1",
                "resolve-url-loader" => "^4.0.0"
            ];
            
            $result = array_unique(array_merge($packages['devDependencies'], $devDependencies));
        }
        $packages['devDependencies'] = $result;

        ksort($packages['devDependencies']);
        file_put_contents($this->packageJsonPath, json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL);
    }

    /**
     * Get Package Json Contents
     *
     * @return array
     */
    protected function getPackageJsonContents() : array
    {
        return json_decode(file_get_contents($this->packageJsonPath), true);
    }

}