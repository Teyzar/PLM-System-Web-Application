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
        $units = Unit::paginate(10);

        return view('units')->with('units', $units);
    }

    public function create()
    {
        return view('add_unit');
    }

    public function store(Request $request)
    {
        $rules = [
            'phone_number' => 'required|unique:units|max:13|min:11',
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        }

        $success = Unit::create([
            'active' => true,
            'latitude' => '10.773333',
            'longitude' => '10.1122323',
            'phone_number' => $request->phone_number
        ]);

        if ($success) {
            toast('Unit Succesfully Registered!', 'success');
        } else {
            toast('Unit Failed to Respond!', 'error');
        }
        return redirect()->back();

        // $phone_number = $request->phone_number;

        // $success = true;

        // try {
        //     $mqtt = MQTT::connection();
        //     $mqtt->subscribe('plms-clz/units/response', function (string $topic, string $message) use ($mqtt, $phone_number) {
        //         $data = json_decode($message);

        //         if ($phone_number != $data->phone_number) return;

        //         Unit::create([
        //             'active' => $data->active,
        //             'latitude' => $data->latitude,
        //             'longitude' => $data->longitude,
        //             'phone_number' => $data->phone_number
        //         ]);

        //         $mqtt->interrupt();
        //     });

        //     $mqtt->registerLoopEventHandler(
        //         function (MqttClient $client, float $elapsedTime) use (&$success) {
        //             if ($elapsedTime > 30) {
        //                 $success = false;
        //                 $client->interrupt();
        //             }
        //         }
        //     );

        //     $mqtt->publish('plms-clz/units/register', $phone_number);

        //     $mqtt->loop();

        //     $mqtt->disconnect();
        // } catch (MqttClientException $error) {
        //     $success = false;
        // }

        // if ($success) {
        //     toast('Unit Succesfully Registered!', 'success');
        // } else {
        //     toast('Unit Failed to Respond!', 'error');
        // }

        // return redirect()->back();
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

    public function search(Request $request)
    {
        if (!$request->ajax()) abort(404);

        $output = "";
        $searchTerm = $request->searchTerm;
        $selectTerm = $request->selectTerm;

        $unit = Unit::paginate(10);

        if (!empty($searchTerm)) {
            $unit = Unit::where($selectTerm, $searchTerm)
                ->get();
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
                <tr class='trbody bg-light client--nav tdhover'>
                    <td class=''>
                        $unit->id
                    </td>
                    <td class=''>
                         $unit->active
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
