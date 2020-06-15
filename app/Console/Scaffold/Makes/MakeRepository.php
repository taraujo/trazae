<?php

namespace App\Console\Scaffold\Makes;

use Illuminate\Filesystem\Filesystem;
use App\Console\Scaffold\Scaffold;
use App\Console\Scaffold\Makes\BaseMake;

class MakeRepository extends BaseMake
{

    protected $scaffoldCommandObj;

    public $arq    = 'Repository';
    public $folder = 'Repositories';
    public $stub   = 'repository';

    public function __construct(Scaffold $scaffold, Filesystem $files, $param)
    {
        $this->files               =  $files;
        $this->scaffoldCommandObj  =  $scaffold;
        $this->param               =  $param;
        $this->start();
    }
}
