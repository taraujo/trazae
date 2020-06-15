<?php

namespace App\Console\Scaffold\Makes;

use Illuminate\Filesystem\Filesystem;
use App\Console\Scaffold\Scaffold;
use App\Console\Scaffold\Makes\BaseMake;

class MakeController extends BaseMake
{

    protected $scaffoldCommandObj;

    public $arq    = 'Controller';
    public $folder = 'Controllers';
    public $stub   = 'controller';

    public function __construct(Scaffold $scaffold, Filesystem $files, $param)
    {
        $this->files               =  $files;
        $this->scaffoldCommandObj  =  $scaffold;
        $this->param               =  $param;
        $this->start();
    }
}
