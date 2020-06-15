<?php

namespace App\Console\Scaffold\Makes;

use Illuminate\Filesystem\Filesystem;
use App\Console\Scaffold\Scaffold;
use App\Console\Scaffold\Makes\BaseMake;

class MakeService extends BaseMake
{

    protected $scaffoldCommandObj;

    public $arq    = 'Service';
    public $folder = 'Services';
    public $stub   = 'service';

    public function __construct(Scaffold $scaffold, Filesystem $files, $param)
    {
        $this->files               =  $files;
        $this->scaffoldCommandObj  =  $scaffold;
        $this->param               =  $param;
        $this->start();
    }
}
