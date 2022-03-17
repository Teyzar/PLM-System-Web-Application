<?php

namespace App\Http\Controllers;

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
        $units = Unit::paginate(8);

        $count = $units->count();

        if ($count == 0) {
            Unit::truncate();
        }

        return view('units')->with('units', $units);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add_unit');
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
                <tr id='$unit->id' class='trbody bg-light client--nav tdhover data'>
                    <td class='text-danger ps-3'>
                        $unit->id
                    </td>
                    <td class='ps-3'>
                         $unit->status
                    </td>
                    <td class='ps-3'>
                        $unit->phone_number
                    </td>

                    <td class='ps-3'>
                         $unit->longitude
                    </td>

                    <td class='ps-3'>
                        $unit->latitude
                    </td>

                    <td class='ps-3'>
                        $updated_at
                    </td>
                    <td class='pe-4'>
                        <button id='delbtn' class='btn border-0 deletebtn float-end p-0'
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
