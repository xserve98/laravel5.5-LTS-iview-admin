<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-27
 * Time: 下午5:16
 */

namespace App\Console\Commands;
use guiguoershao\WebSocket\WebSocketApp;
use Illuminate\Console\Command;

class WebSocket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket-server:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'websocket server';

    protected $webSocketApp;

    /**
     * Create a new command instance.
     *
     * @param WebSocketApp $webSocketApp
     */
    public function __construct(WebSocketApp $webSocketApp)
    {
        parent::__construct();
        $this->webSocketApp = $webSocketApp;
    }

    /**
     *
     */
    public function handle()
    {
        $this->webSocketApp->start();
    }
}