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


    public function __construct(FileSystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
        $this->packageJsonPath = base_path('package.json');
    }

    public function handle()
    {
        $this->updatePackageJson();

        $this->info('Larave 2FA Successfully Installed');
        $this->comment('Please run "npm install" and "npm run dev" to build your assets');
    }

    protected function updatePackageJson()
    {
        if (! file_exists($this->packageJsonPath)) {
            return;
        }

        $packages = $this->getPackageJsonContents();

        if (array_key_exists('devDependencies', $packages)) {
            $devDependencies = [
                "@fortawesome/fontawesome-free" => "^5.15.3",
                "@popperjs/core" => "^2.9.2",
                "bootstrap" => "^5.0.1",
                'sass'  => "^1.32.13",
                "sass-loader" => "^11.1.1"
            ];

            $packages['devDependencies'] += $devDependencies;
        }

        ksort($packages['devDependencies']);
        file_put_contents($this->packageJsonPath, json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL);

    }

    protected function getPackageJsonContents() : array
    {
        return json_decode(file_get_contents($this->packageJsonPath), true);
    }

}