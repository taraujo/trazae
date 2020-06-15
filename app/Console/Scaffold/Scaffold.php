<?php

namespace App\Console\Scaffold;

use App\Console\Scaffold\Makes\MakeView;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use App\Console\Scaffold\Makes\MakeController;
use App\Console\Scaffold\Makes\MakeService;
use App\Console\Scaffold\Makes\MakeRepository;
use App\Console\Scaffold\Makes\MakeRequest;
use App\Console\Scaffold\Makes\MakeEntity;

class Scaffold extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scaffold:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criar estrutura (CRUD) de uma entidade';

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
        $this->composer = app()['composer'];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->param['modelo']         =   $this->ask('Nome do modelo? [Teste]');
        $this->param['path']           =   "/";
        $header = "scaffolding: {".$this->param['path'].$this->param['modelo']."}";
        $footer = str_pad('', strlen($header), '-');
        $dump = str_pad('>DUMP AUTOLOAD<', strlen($header), ' ', STR_PAD_BOTH);

        $this->line("\n----------- $header -----------\n");

        $this->makeController();
        $this->makeService();
        $this->makeRepository();
        $this->makeRequest();
        $this->makeEntity();

        $this->line("\n----------- $footer -----------");

        $view         =   $this->ask('Deseja criar as views? [y = Sim, n = Não]');
        if ($view == 'y') {
            $this->makeViews();
        }

        $this->comment("----------- $dump -----------");

        $this->composer->dumpAutoloads();
        $this->error("Nao esqueca de adicionar as 'migrate' e 'routes'");
    }

    /**
     * Criando o Controller
     */
    public function makeController()
    {
        new MakeController($this, $this->files, $this->param);
    }

    /**
     * Criando o Service
     */
    public function makeService()
    {
        new MakeService($this, $this->files, $this->param);
    }

    /**
     * Criando o Repository
     */
    public function makeRepository()
    {
        new MakeRepository($this, $this->files, $this->param);
    }

    /**
     * Criando a Request
     */
    public function makeRequest()
    {
        new MakeRequest($this, $this->files, $this->param);
    }

    /**
     * Criando o Entity
     */
    public function makeEntity()
    {
        new MakeEntity($this, $this->files, $this->param);
    }

    /**
     * Criando as Views
     */
    private function makeViews()
    {
        new MakeView($this, $this->files, $this->param);
    }
}
