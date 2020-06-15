<?php

namespace App\Console\Scaffold\Makes;

use App\Console\Scaffold\Scaffold;
use Illuminate\Filesystem\Filesystem;

class MakeView extends BaseMake
{
    protected $scaffoldCommandObj;

    protected $views = [
        '_form',
        'cadastrar',
        'listar',
        'editar',
        'detalhar'
    ];

    public $arq    = 'Service';
    public $folder = 'Services';
    public $stub   = 'service';

    public function __construct(Scaffold $scaffold, Filesystem $files, $param)
    {
        $this->files               =  $files;
        $this->scaffoldCommandObj  =  $scaffold;
        $this->param               =  $param;
        $this->createViews();
    }

    private function createViews()
    {
        foreach ($this->views as $view) {
            $this->startView($view);
        }
    }

    protected function startView($view)
    {
        $name        =  $view . '.blade.php';
        $this->param['path']  =  $this->tratarPathFile();

        $path = base_path() . '/resources/views/' . strtolower($this->param['path']);
        if (!$this->files->exists($path)) {
            mkdir($path);
        }

        $path = $path . strtolower($this->param['modelo']);
        if (!$this->files->exists($path)) {
            mkdir($path);
        }

        $stub = $this->files->get(substr(__DIR__, 0, -5) . 'Modelos/views/'. $view . '.stub');
        $stub             =  str_replace("{{objeto}}", strtolower($this->param['modelo']), $stub);
        $stub             =  str_replace("{{modelo}}", $this->param['modelo'], $stub);

        if (empty($this->param['path'])) {
            $path_stub = "";
        } else {
            $path_stub = "\\".$this->param['path'];
            $path_stub = substr($path_stub, 0, strlen($path_stub)-1);
        }

        $stub      =  str_replace("{{path}}", $path_stub, $stub);

        $path_view =  str_replace("\\", ".", $path_stub);
        $path_view =  (empty($path_view)) ? "" : $path_view.".";

        $stub      =  str_replace("{{path_view}}", strtolower(substr($path_view, 1).$this->param['modelo']), $stub);

        $stub      =  str_replace("{{route_detalhar}}", strtolower($this->param['modelo'].'.detalhar'), $stub);
        $stub      =  str_replace("{{route_editar}}", strtolower($this->param['modelo'].'.editar'), $stub);
        $stub      =  str_replace("{{route_listar}}", strtolower($this->param['modelo'].'.listar'), $stub);

        $this->files->put($path . '/' . $name, $stub);
        $this->scaffoldCommandObj->comment("+ $name");
    }
}
