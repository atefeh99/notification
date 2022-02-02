<?php
namespace App\Console\Commands;

use App\Http\Services\NotificationService;
use Exception;
use Illuminate\Console\Command;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\MqttClient;
use Symfony\Component\Console\Input\InputOption;

class Subscribe extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'subscribe';
    public $port;
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "subscribe the application on the topics";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        printf("listening");
        try {
            $host = env('MQTT_HOST');
            $port = env('MQTT_PORT');
            $username = env('MQTT_USERNAME');
            $password = env('MQTT_PASSWORD');
            $clean_session = false;

            $clientId = rand(5, 15);
            $connection_settings = new ConnectionSettings();
            $connection_settings = $connection_settings
                ->setUsername($username)
                ->setPassword($password)
                ->setKeepAliveInterval(120);
            $mqtt = new MqttClient($host, $port, $clientId);
            $mqtt->connect($connection_settings, $clean_session);

            $mqtt->subscribe('#', function ($topic, $message) {
                printf("Received message on topic [%s]: %s\n", $topic, $message);
                $msg = json_decode($message,true);
                $msg['topic'] = $topic;
                NotificationService::createItem($msg);
            }, 1);
            $mqtt->loop(true);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

}
