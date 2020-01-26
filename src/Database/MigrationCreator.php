<?php

namespace Orchestra\Canvas\Database;

use Illuminate\Support\Str;
use InvalidArgumentException;
use Orchestra\Canvas\Core\Presets\Laravel;
use Orchestra\Canvas\Core\Presets\Preset;

class MigrationCreator extends \Illuminate\Database\Migrations\MigrationCreator
{
    /**
     * Canvas preset.
     *
     * @var \Orchestra\Canvas\Presets\Preset
     */
    protected $preset;

    /**
     * Create a new migration creator instance.
     */
    public function __construct(Preset $preset)
    {
        $this->files = $preset->filesystem();
        $this->preset = $preset;
    }

    /**
     * Create a new migration at the given path.
     *
     * @param  string  $name
     * @param  string  $path
     * @param  string|null  $table
     * @param  bool  $create
     *
     * @throws \Exception
     *
     * @return string
     */
    public function create($name, $path, $table = null, $create = false)
    {
        $name = \trim(\implode('_', [Str::slug($this->preset->config('migration.prefix', ''), '_'), $name]), '_');

        if (! $this->files->isDirectory($path)) {
            if ($this->preset instanceof Laravel) {
                throw new InvalidArgumentException("Path {$path} doesn't exists.");
            }

            $this->files->makeDirectory($path, 0755, true, true);
        }

        return parent::create($name, $path, $table, $create);
    }

    /**
     * Get the path to the stubs.
     *
     * @return string
     */
    public function stubPath()
    {
        return __DIR__.'/../../storage/database/migrations';
    }
}
