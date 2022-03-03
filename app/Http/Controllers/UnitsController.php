<?php

namespace App\Http\Controllers;

use App\Events\HeatmapUpdate;
use App\Events\ControllerUpdate;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpMqtt\Client\Exceptions\MqttClientException;
use PhpMqtt\Client\Facades\MQTT;
use PhpMqtt\Client\MqttClient;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

class UnitsController extends Controller
{
    public function index()
    {
        $units = Unit::paginate(8);

        $count = $units->count();

        if ($count == 0) {
            Unit::truncate();
        }

        return view('units')->with('units', $units);
    }

    public function create()
    {
        return view('add_unit');
    }

    public function store(Request $request)
    {
        $controllerConnected = false;
        $messageSent = false;

        $validated = $request->validate([
            'phone_number' => 'required|starts_with:+639|min:13|max:13|unique:units',
        ]);

        try {
            $mqtt = MQTT::connection();

            $mqtt->subscribe('PLMS-ControllerResponse-CLZ', function (string $topic, string $message) use (&$mqtt, &$validated, &$controllerConnected, &$messageSent) {
                if ($message == "ControllerConnected") {
                    $controllerConnected = true;
                    echo "controller 1";

                    // event(new ControllerUpdate("controller 1"));
                }

                if ($message == "MessageSent") {
                    $messageSent = true;

                    Unit::create([
                        'status' => "Pending",
                        'phone_number' => $validated["phone_number"]
                    ]);

                    echo "message 1";
                    // event(new ControllerUpdate("message 1"));

                    $mqtt->interrupt();
                }
            });

            $mqtt->registerLoopEventHandler(
                function (MqttClient $client, float $elapsedTime) use (&$controllerConnected, &$messageSent) {
                    // Controller must be connected within 10 seconds
                    if ($elapsedTime > 10 && !$controllerConnected) {
                        echo "controller 0";
                        // event(new ControllerUpdate("controller 0"));


                        $client->interrupt();
                    }

                    // Controller must be able to send the command to the unit within 20 seconds
                    if ($elapsedTime > 25 && !$messageSent) {
                        echo "message 0";
                        // event(new ControllerUpdate("message 0"));

                        $client->interrupt();
                    }
                }
            );

            $mqtt->publish('PLMS-ControllerCommands-CLZ', "UnitRegister\n" . $validated["phone_number"]);

            $mqtt->loop();

            $mqtt->disconnect();
        } catch (MqttClientException $error) {
            echo $error->__toString();
        }
    }

    public function update(Request $request, String $phone_number)
    {
        $statusCode = 400;

        $fields = $request->validate([
            'status' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $unit = Unit::where('phone_number', $phone_number)->first();

        if ($unit) {
            $unit->update([
                'status' => $fields['status'],
                'latitude' => $fields['latitude'],
                'longitude' => $fields['longitude']
            ]);

            event(new HeatmapUpdate($unit));

            $statusCode = 200;
        }

        return response('', $statusCode);
    }

    public function destroy($id)
    {
        $unit = Unit::find($id);
        if ($unit) {
            $remove = Unit::where('id', $id)->delete();
            return json_encode($remove);
        }
    }

    public function search(Request $request)
    {
        if (!$request->ajax()) abort(404);

        $output = "";
        $searchTerm = $request->searchTerm;
        $selectTerm = $request->selectTerm;

        $unit = Unit::paginate(8);

        if (!empty($searchTerm)) {
            $unit = Unit::where($selectTerm, $searchTerm)
                ->get();
            if ($selectTerm === 'updated_at') {
                $unit = Unit::where('updated_at', 'LIKE', '%' . $searchTerm . "%")
                    ->get();
            }
        }
        $count = $unit->count();
        if ($count <= 0) {
            $output .= "
                <tr border-width: 1px;' class='trbody bg-light client--nav tdhover'>
                    <td class='text-center fs-6 border-top text-danger p-4' colspan ='7'>
                        No Record Found
                    </td>
                </tr>
            ";
        } else {
            foreach ($unit as $unit) {
                $updated_at = \Carbon\Carbon::parse($unit->updated_at)->toDayDateTimeString();

                $output .= "
                <tr id='$unit->id' class='trbody bg-light client--nav tdhover'>
                    <td class='text-danger'>
                        $unit->id
                    </td>
                    <td class=''>
                         $unit->status
                    </td>
                    <td class=''>
                        $unit->phone_number
                    </td>

                    <td class=''>
                         $unit->longitude
                    </td>

                    <td class=''>
                        $unit->latitude
                    </td>

                    <td class=''>
                        $updated_at
                    </td>
                    <td class=''>
                        <button id='delbtn' class='btn border-0 deletebtn'
                            onclick='removeUnit($unit->id)' type='button' data-bs-toggle='modal' data-bs-target='#modalRemove'>
                            <i class='fas fa-trash fs-5 text-danger bs-tooltip-top tooltip-arrow'
                                data-toggle='tooltip' data-bs-placement='top' title='Remove'></i>
                        </button>
                    </td>
                </tr>
                ";
            }
        }
        $data = array(
            'result' => $output,
            'count' => $count
        );
        return json_encode($data);
    }
}
