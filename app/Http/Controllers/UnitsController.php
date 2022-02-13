<?php

namespace App\Http\Controllers;

use App\Events\HeatmapUpdate;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpMqtt\Client\Exceptions\MqttClientException;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\MqttClient;

class UnitsController extends Controller
{
    public function index()
    {
        $units = Unit::get();

        return view('units')->with('units', $units);
    }

    public function create()
    {
        return view('add_unit');
    }

    public function store(Request $request)
    {
        $rules = [
            'phone_number' => 'required|unique:units',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        }

        $phone_number = $request->phone_number;

        $success = true;

        try {
            $mqtt = MQTT::connection();
            $mqtt->subscribe('plms-clz/units/response', function (string $topic, string $message) use ($mqtt, $phone_number) {
                $data = json_decode($message);

                if ($phone_number != $data->phone_number) return;

                Unit::create([
                    'active' => $data->active,
                    'latitude' => $data->latitude,
                    'longitude' => $data->longitude,
                    'phone_number' => $data->phone_number
                ]);

                $mqtt->interrupt();
            });

            $mqtt->registerLoopEventHandler(
                function (MqttClient $client, float $elapsedTime) use (&$success) {
                    if ($elapsedTime > 30) {
                        $success = false;
                        $client->interrupt();
                    }
                }
            );

            $mqtt->publish('plms-clz/units/register', $phone_number);

            $mqtt->loop();

            $mqtt->disconnect();
        } catch (MqttClientException $error) {
            $success = false;
        }

        if ($success) {
            toast('Unit Succesfully Registered!', 'success');
        } else {
            toast('Unit Failed to Respond!', 'error');
        }

        return redirect()->back();
    }

    public function update(Request $request, String $phone_number)
    {
        $statusCode = 400;

        $fields = $request->validate([
            'active' => 'required|boolean',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $unit = Unit::where('phone_number', $phone_number)->first();

        if ($unit) {
            $unit->update([
                'active' => $fields['active'],
                'latitude' => $fields['latitude'],
                'longitude' => $fields['longitude']
            ]);

            event(new HeatmapUpdate($unit));

            $statusCode = 200;
        }

        return response('', $statusCode);
    }

    public function clear()
    {
        Unit::all()->delete();

        toast('Data succesfully cleared.', 'success');

        return redirect()->back();
    }
}
