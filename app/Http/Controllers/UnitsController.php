<?php

namespace App\Http\Controllers;

use App\Events\UnitRefreshUpdate;
use App\Events\UnitRegisterUpdate;
use App\Models\Unit;
use Illuminate\Http\Request;
use PhpMqtt\Client\Exceptions\MqttClientException;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\MqttClient;
use RealRashid\SweetAlert\Facades\Alert;

class UnitsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::all();

        $count = $units->count();

        if ($count == 0) {
            Unit::truncate();
        }

        return view('units')->with('units', $units);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $controllerConnected = false;
        $messageSent = false;

        $validated = $request->validate([
            'phone_number' => 'required|starts_with:+639|min:13|max:13|unique:units',
        ]);

        event(new UnitRegisterUpdate("start"));

        try {
            $mqtt = MQTT::connection();

            $mqtt->subscribe('PLMS-ControllerResponse-CLZ', function (string $topic, string $message) use (&$mqtt, &$validated, &$controllerConnected, &$messageSent) {
                if ($message == "ControllerConnected") {
                    $controllerConnected = true;
                    event(new UnitRegisterUpdate("controller 1"));
                }

                if ($message == "MessageSent") {
                    $messageSent = true;

                    Unit::create([
                        'status' => "Pending",
                        'phone_number' => $validated["phone_number"]
                    ]);

                    event(new UnitRegisterUpdate("message 1"));

                    $mqtt->interrupt();
                }
            });

            $mqtt->registerLoopEventHandler(
                function (MqttClient $client, float $elapsedTime) use (&$controllerConnected, &$messageSent) {
                    // Controller must be connected within 10 seconds
                    if ($elapsedTime > 10 && !$controllerConnected) {
                        event(new UnitRegisterUpdate("controller 0"));

                        $client->interrupt();
                    }

                    // Controller must be able to send the command to the unit within 20 seconds
                    if ($elapsedTime > 25 && !$messageSent) {
                        event(new UnitRegisterUpdate("message 0"));

                        $client->interrupt();
                    }
                }
            );

            $mqtt->publish('PLMS-ControllerCommands-CLZ', "UnitRegister\n" . $validated["phone_number"]);

            event(new UnitRegisterUpdate("published"));

            $mqtt->loop();

            $mqtt->disconnect();
        } catch (MqttClientException $error) {
            event(new UnitRegisterUpdate($error->__toString()));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $unit = Unit::find($id);
        if ($unit) {
            Unit::where('id', $id)->delete();
            Alert::success('Success', 'Unit Deleted Succesfuly!');
            return redirect()->back();
        }
    }

    /**
     * Sends a unit update request to a unit.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function refresh(Request $request, $id)
    {
        $unit = Unit::find($id);
        $messageSent = false;
        $controllerConnected = false;

        if (!$unit) return abort(400);

        try {
            $mqtt = MQTT::connection();

            $mqtt->subscribe('PLMS-ControllerResponse-CLZ', function (string $topic, string $message) use (&$mqtt, &$controllerConnected, &$messageSent) {
                if ($message == "ControllerConnected") {
                    $controllerConnected = true;
                    event(new UnitRefreshUpdate("controller 1"));
                }

                if ($message == "MessageSent") {
                    $messageSent = true;

                    event(new UnitRefreshUpdate("message 1"));

                    $mqtt->interrupt();
                }
            });

            $mqtt->registerLoopEventHandler(
                function (MqttClient $client, float $elapsedTime) use (&$controllerConnected, &$messageSent) {
                    // Controller must be connected within 10 seconds
                    if ($elapsedTime > 10 && !$controllerConnected) {
                        event(new UnitRefreshUpdate("controller 0"));

                        $client->interrupt();
                    }

                    // Controller must be able to send the command to the unit within 20 seconds
                    if ($elapsedTime > 25 && !$messageSent) {
                        event(new UnitRefreshUpdate("message 0"));

                        $client->interrupt();
                    }
                }
            );

            $mqtt->publish('PLMS-ControllerCommands-CLZ', "UnitUpdate\n" . $unit->phone_number);

            event(new UnitRefreshUpdate("published"));

            $mqtt->loop();

            $mqtt->disconnect();
        } catch (MqttClientException $error) {
            event(new UnitRefreshUpdate($error->__toString()));
        }
    }
}
