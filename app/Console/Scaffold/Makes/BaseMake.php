<?php

namespace App\Console\Scaffold\Makes;

class BaseMake
{
    protected function start()
    {
        $name        =  $this->param['modelo'] . $this->arq . '.php';
        $this->param['path']  =  $this->tratarPathFile();

        $path = substr(__DIR__, 0, -22) . "Http/" . $this->folder . "/" . $this->param['path'] . $name;
        
        if ($this->files->exists($path)) {
            return $this->scaffoldCommandObj->comment("x $name");
        }

        $this->files->put($path, $this->compileControllerServicesStub());
        $this->scaffoldCommandObj->comment("+ $name");
    }

    protected function compileControllerServicesStub()
    {
        $stub = $this->files->get(substr(__DIR__, 0, -5) . 'Modelos/' . $this->stub . '.stub');
        $this->buildStub($stub);
        return $stub;
    }

    protected function compileViewsStub()
    {
        $stub = $this->files->get(substr(__DIR__, 0, -5) . 'Modelos/views/' . $this->stub . '.stub');
        $this->buildStub($stub);
        return $stub;
    }

    protected function buildStub(&$template)
    {
        $this->param['path']  =  $this->tratarPath();

        $template             =  str_replace("{{objeto}}", strtolower($this->param['modelo']), $template);
        $template             =  str_replace("{{modelo}}", $this->param['modelo'], $template);

        if (empty($this->param['path'])) {
            $path_stub = "";
        } else {
            $path_stub = "\\" . $this->param['path'];
            $path_stub = substr($path_stub, 0, strlen($path_stub) - 1);
        }

        $template             =  str_replace("{{path}}", $path_stub, $template);

        $path_view            =  str_replace("\\", ".", $path_stub);
        $path_view            = (empty($path_view)) ? "" : $path_view . ".";

        $template             = str_replace(
            "{{path_view}}",
            strtolower(substr($path_view, 1) . $this->param['modelo']),
            $template
        );

        $template             = str_replace(
            "{{route_detalhar}}",
            strtolower($this->param['modelo'] . '.detalhar'),
            $template
        );
        $template             = str_replace(
            "{{route_editar}}",
            strtolower($this->param['modelo'] . '.editar'),
            $template
        );
        $template             = str_replace(
            "{{route_listar}}",
            strtolower($this->param['modelo'] . '.listar'),
            $template
        );

        return $template;
    }

    public function getParametros($input)
    {
        $param = explode("_", $input);
        $result = [];
        foreach ($param as $p) {
            $dados  = explode(":", $p);
            $acao   = $dados[0];
            $valor  = $dados[1];
            $r = $this->verificarComando($acao, $valor);
            $result = array_merge($result, $r);
        }
        return $result;
    }

    public function verificarComando($acao, $valor)
    {
        switch ($acao) {
            case 'md':
                $param['modelo'] = $valor;
                break;
            case 'pt':
                $param['path'] = $valor;
                break;
            case 'pre':
                $param['prefixo'] = $valor;
                break;
        }
        return $param;
    }

    public function tratarPathFile()
    {
        if ($this->param['path'] == '/') {
            $path = "/";
        } else {
            $path = $this->param['path'];
        }
        return $path;
    }

    public function tratarPath()
    {
        if ($this->param['path'] == '/') {
            $path = "";
        } else {
            $path = $this->param['path'];
        }
        $path  =  str_replace("/", "\\", $path);
        return $path;
    }
}
