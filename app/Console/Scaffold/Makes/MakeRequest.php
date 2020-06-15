<?php

namespace App\Console\Scaffold\Makes;

use Illuminate\Filesystem\Filesystem;
use App\Console\Scaffold\Scaffold;
use App\Console\Scaffold\Makes\BaseMake;

class MakeRequest extends BaseMake
{

    protected $scaffoldCommandObj;

    public $arq    = 'Request';
    public $folder = 'Requests';
    public $stub   = 'request';

    public function __construct(Scaffold $scaffold, Filesystem $files, $param)
    {
        $this->files               =  $files;
        $this->scaffoldCommandObj  =  $scaffold;
        $this->param               =  $param;
        $this->start();
    }
}
