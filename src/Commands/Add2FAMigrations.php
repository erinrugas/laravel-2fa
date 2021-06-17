<?php

namespace ErinRugas\Laravel2fa\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

class Add2FAMigrations extends Command
{
    /**
     * Class name
     */
    const ADD_TWO_FACTOR_AUTH_COLUMN_CLASS = 'AddTwoFactorAuthColumnTo{table}Table';

    /**
     * Laravel FileSystem
     *
     * \Illuminate\Filesystem\Filesystem
     */
    private $fileSystem;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-2fa:migration {table=users : Table name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add two factor authentiation column';

    /**
     * Stub path
     *
     * @var string
     */
    public $stub = __DIR__ . '/../stubs/add-two-factor-column.stub';

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $fileSystem)
    {
        parent::__construct();

        $this->fileSystem = $fileSystem;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->table = is_null($this->argument('table')) ? 'users' : $this->argument('table');

        $path = $this->getPath();
        if ($this->fileSystem->exists($path)) {
            return $this->error("{$path} is already exists");
        }

        $this->fileSystem->put($path, $this->compileMigration());
        $fileName = pathinfo($path, PATHINFO_FILENAME);

        $this->info("Please run 'php artisan migrate' or 'php artisan migrate --path=database/migrations/{$fileName}.php'");
    }

    /**
     * Compile the two factor migration stub
     *
     * @return void
     */
    protected function compileMigration()
    {
        $stub = $this->fileSystem->get($this->stub);

        $this->replaceClassName($stub)
            ->replaceTableName($stub);

        return $stub;
    }

    /**
     * Generate migration for two factor auth
     *
     * @param $migration
     * @return string
     */
    public function getPath()
    {
        return base_path() . '/database/migrations/' . date('Y_m_d_His') . '_' . 'add_two_factor_auth_column_to_' . $this->table . '_table.php';
    }

    /**
     * Replace table name in stub
     *
     * @param $stub
     * @return $this
     */
    protected function replaceTableName(&$stub)
    {
        $stub = str_replace('{{ table }}', $this->table, $stub);

        return $this;
    }

    /**
     * Replace class name in the stub
     *
     * @param $stub
     * @return $this
     */
    protected function replaceClassName(&$stub)
    {
        $migrationClass = str_replace('{table}', ucwords(Str::camel($this->table)), static::ADD_TWO_FACTOR_AUTH_COLUMN_CLASS);

        $stub = str_replace('{{ class }}', $migrationClass, $stub);

        return $this;
    }
}
