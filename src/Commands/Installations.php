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

        $this->checkViteConfig();

        $packages = $this->getPackageJsonContents();

        if (array_key_exists('scripts', $packages)) {
            $scripts = [
                'dev'  => "npm run development",
                "development" => "mix",
                "watch" => "mix watch",
                "watch-poll" => "mix watch -- --watch-options-poll=1000",
                "hot" => "mix watch --hot",
                "prod" => "npm run production",
                "production" => "mix --production"
            ];


            $packages['scripts'] = $scripts;
        }

        if (array_key_exists('devDependencies', $packages)) {
            $devDependencies = [
                'sass'  => "^1.52.2",
                "sass-loader" => "^12.6.0",
                "resolve-url-loader" => "^4.0.0",
                "laravel-mix" => "^6.0.6"
            ];

            if (isset($packages['devDependencies']['vite'])) {
                unset($packages['devDependencies']['vite']);
                $this->info('vite was removed from package.json. To avoid compiling using laravel-mix');
            }

            if (isset($packages['devDependencies']['laravel-vite-plugin'])) {
                unset($packages['devDependencies']['laravel-vite-plugin']);
                $this->info('laravel-vite-plugin was removed from package.json to avoid issue from laravel-mix');
            }

            $resultDevDependencies = array_unique(array_merge($packages['devDependencies'], $devDependencies));
        }

        if (!array_key_exists('dependencies', $packages)) {
            $dependencies = [
                "@popperjs/core" => "^2.11.5",
                "bootstrap" => "^5.1.3"
            ];

            $packages['dependencies'] = $dependencies;
        }

        $this->newLine();

        $packages['devDependencies'] = $resultDevDependencies;

        ksort($packages['dependencies']);
        ksort($packages['devDependencies']);
        
        file_put_contents($this->packageJsonPath, json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL);
    }

    /**
     * Check if vite.config.js is exist
     * This is to avoid the existing laravel-mix
     *
     * @return void
     */
    private function checkViteConfig()
    {
        if (file_exists(base_path('vite.config.js'))) {
            $this->filesystem->delete(base_path('vite.config.js'));
            $this->line('vite.config.js was deleted to avoid issue from laravel-mix.');
        }
    }

    /**
     * Get Package Json Contents
     *
     * @return array
     */
    protected function getPackageJsonContents(): array
    {
        return json_decode(file_get_contents($this->packageJsonPath), true);
    }
}
