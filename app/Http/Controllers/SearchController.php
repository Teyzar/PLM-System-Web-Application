<?php

namespace App\Http\Controllers;

use App\Models\Lineman;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $output = "";
            $accounts = Lineman::orderBy('created_at', 'desc')->paginate(10);

            if (!empty($request->search)) {
                $accounts = Lineman::where('name', 'LIKE', '%' . $request->search . "%")
                    ->orWhere('email', 'LIKE', '%' . $request->search . "%")
                    ->orWhere('barangay', 'LIKE', '%' . $request->search . "%")
                    ->orWhere('created_at', 'LIKE', '%' . $request->search . "%")
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
            }

            $trow = $accounts->count();

            if ($accounts) {
                foreach ($accounts as $key => $acc) {
                    $output .= "<tr style='font-family: 'Montserrat', sans-serif; border-width: 1px;' class = 'trbody bg-light border border-dark'>" .
                        '<td class="fs-6 text-black border-top fw-bolder">' . ucfirst($acc->name) . '</td>' .
                        '<td class="text-black fs-6 border-top fw-bolder">' . $acc->email . '</td>' .
                        '<td class="text-black fs-6 text-capitalize border-top fw-bolder">' . $acc->barangay . '</td>' .
                        '<td class="text-black fs-6 text-capitalize border-top fw-bolder">' . \Carbon\Carbon::parse($acc->created_at)->toDayDateTimeString() . '</td>' .
                        '<td>' . "<a id= 'resetbtn' class = 'resetbtn' data-bs-toggle='modal'
                        data-bs-target='#modalDelete' onclick='Destroy($acc->id)' ><i class='fas fa-sync-alt text-success fs-6' data-toggle='tooltip' title='password reset' ></i>" . '</a></td>' .
                        '<td>' . "<a class = 'editbtn' onclick='LoadAccountDetails($acc->id)'
                        data-bs-toggle='modal' data-bs-target='#modalForm2'><i class='fas fa-user-edit text-primary fs-6' data-toggle='tooltip' title='edit'></i>" . '</a></td>' .
                        '<td>' . "<a id= 'delbtn' class = 'deletebtn' data-bs-toggle='modal'
                        data-bs-target='#modalDelete' onclick='Destroy($acc->id)' ><i class='fas fa-trash fs-6 text-danger' data-toggle='tooltip' title='delete'></i>" . '</a></td>' .
                        '</tr>';
                }
                if ($trow <= 0) {
                    $output = "<tr style='font-family: 'Montserrat', sans-serif; border-width: 1px;' class = 'trbody bg-light border border-dark'><td class = 'text-center fs-6 border-top fw-bolder text-danger p-4' colspan ='7'>No Record Found</td></tr>";
                }
            }
            $data = array(
                'success' => $output,
                'count' => $trow
            );
            echo json_encode($data);
        }
    }
}
