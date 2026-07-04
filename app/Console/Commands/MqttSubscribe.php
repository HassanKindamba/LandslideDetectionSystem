<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\SensorData;

class MqttSubscribe extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'Sikiliza data ya sensor kutoka ESP32 kupitia MQTT';

    public function handle()
    {
        $server   = 'broker.hivemq.com';
        $port     = 1883;
        $clientId = 'laravel-landslide-subscriber';

        $mqtt = new MqttClient($server, $port, $clientId);
        $connectionSettings = new ConnectionSettings();

        $this->info('Kuunganisha kwenye MQTT Broker...');
        $mqtt->connect($connectionSettings, true);
        $this->info('Imeunganika! Kusikiliza topic: landslide/sensor1/data');

        $mqtt->subscribe('landslide/sensor1/data', function ($topic, $message) {
            $this->info("Data imepokelewa: {$message}");

            $data = json_decode($message, true);

            if ($data) {
                $soil = $data['moisture'] ?? 0;
                $vibration = $data['vibration'] ?? 0; // 0 au 1
                $tilt = $data['tilt'] ?? 0;            // 0 au 1

                // Logic maalum kwa Wokwi (digital switches 0/1)
                if ($tilt == 1 || $vibration == 1) {
                    // Mtikisiko au mwinuko umegundulika -> hatari ya papo hapo
                    $risk = "HIGH";
                } elseif ($soil > 70) {
                    $risk = "HIGH";
                } elseif ($soil > 50) {
                    $risk = "MEDIUM";
                } else {
                    $risk = "LOW";
                }

                SensorData::create([
                    'soil_moisture' => $soil,
                    'vibration'     => $vibration,
                    'tilt'          => $tilt,
                    'risk_level'    => $risk,
                ]);

                $this->info("Imehifadhiwa database. Risk level: {$risk}");
            } else {
                $this->error('JSON haikusomeka vizuri.');
            }
        }, 0);

        $mqtt->loop(true);
    }
}