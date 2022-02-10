<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lineman;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

class LinemanController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $linemen = Lineman::orderBy('created_at', 'desc')->paginate(10);

        return view('lineman')->with('linemen', $linemen);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email'    => 'required|email|unique:linemen',
            'barangay' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'barangay' => $request->barangay,
            'password' => Hash::make("plmsystem")
        ];

        Lineman::create($data);

        toast('Account registered successfully!', 'success');

        return redirect()->back();
    }

    public function show(Request $request, String $id)
    {
        if (!$request->wantsJson()) abort(404);

        $lineman = Lineman::find($id);

        return json_encode($lineman);
    }

    public function update(Request $request, String $id)
    {
        $lineman = Lineman::find($id);

        $rules = [
            'updatename' => 'required',
            'updatebarangay' => 'required'
        ];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        }

        $lineman->name = $request->input('updatename');
        $lineman->email = $request->input('updateemail');
        $lineman->barangay = $request->input('updatebarangay');

        $lineman->update();

        toast('Account updated successfully!', 'success');

        return redirect('/lineman');
    }

    public function destroy(String $id)
    {
        Lineman::where('id', $id)->delete();

        toast('Account deleted successfully!', 'success');

        return back();
    }

    public function search(Request $request)
    {
        if (!$request->ajax()) abort(404);

        $output = "";
        $searchTerm = $request->searchTerm;
        $linemen = Lineman::orderBy('created_at', 'desc')->paginate(10);

        if (!empty($searchTerm)) {
            $linemen = Lineman::where('name', 'LIKE', '%' . $searchTerm . "%")
                ->orWhere('email', 'LIKE', '%' . $searchTerm . "%")
                ->orWhere('barangay', 'LIKE', '%' . $searchTerm . "%")
                ->orWhere('created_at', 'LIKE', '%' . $searchTerm . "%")
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }

        $count = $linemen->count();
        if ($count <= 0) {
            $output .= "
                    <tr border-width: 1px;' class='trbody bg-light border border-dark'>
                            <td class='text-center fs-6 border-top text-danger p-4' colspan ='7'>
                                No Record Found
                            </td>
                    </tr> ";
        } else {
            foreach ($linemen as $lineman) {
                $created_at = Carbon::parse($lineman->created_at)->toDayDateTimeString();

                $output .= "
                        <tr class='trbody bg-light border border-dark'>
                            <td class='fs-6 text-black border-top text-capitalize'>
                                $lineman->name
                            </td>

                            <td class='text-black fs-6 border-top'>
                                $lineman->email
                            </td>

                            <td class='text-black fs-6 text-capitalize border-top'>
                                $lineman->barangay
                            </td>

                            <td class='text-black fs-6 text-capitalize border-top'>
                                $created_at
                            </td>

                            <td>
                                <a id= 'resetbtn' class='resetbtn' data-bs-toggle='modal' data-bs-target='#modalReset' onclick='Reset($lineman->id)'>
                                    <i class='fas fa-sync-alt text-success fs-6' data-toggle='tooltip' title='Reset password'></i>
                                </a>
                            </td>

                            <td>
                                <a class='editbtn' onclick='LoadAccountDetails($lineman->id)' data-bs-toggle='modal' data-bs-target='#modalForm2'>
                                    <i class='fas fa-user-edit text-primary fs-6' data-toggle='tooltip' title='Edit'></i>
                                </a>
                            </td>

                            <td>
                                <a id= 'delbtn' class='deletebtn' data-bs-toggle='modal' data-bs-target='#modalDelete' onclick='Destroy($lineman->id)'>
                                    <i class='fas fa-trash fs-6 text-danger' data-toggle='tooltip' title='Delete'></i>
                                </a>
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

    public function reset(Request $request, String $id)
    {
        $lineman = Lineman::find($id);
        $checkbox = $request->checkbox;
        $data = array(
            'lineman' => $lineman,
            'checkbox' => $checkbox
        );
        if ($checkbox === "0") {
            return json_encode($data['checkbox']);
        } else {
            $lineman->password = Hash::make("plmsystem");
            $lineman->update();
            toast('Password has been reset!', 'success');
            return json_encode($data['lineman']);
        }
    }
}
