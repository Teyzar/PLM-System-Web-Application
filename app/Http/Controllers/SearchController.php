<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // $products = Accounts::where('name', 'LIKE', '%' . $request->search . "%")->get();


        if ($request->ajax()) {
            $output = "";
            $accounts = Accounts::where('name', 'LIKE', '%' . $request->search . "%")
                ->orWhere('email', 'LIKE', '%' . $request->search . "%")
                ->orWhere('baranggay', 'LIKE', '%' . $request->search . "%")
                ->orWhere('created_at', 'LIKE', '%' . $request->search . "%")
                ->orderBy('name', 'asc')
                ->get();
                $trow = $accounts->count();

            if ($accounts) {
                foreach ($accounts as $key => $acc) {
                    $output .= '<tr style="font-family: sans-serif">' .
                        '<td><a href="/accounts/' . $acc->id . '/edit"
                        class="fs-6 text-decoration-none text-capitalize text-muted">' . ucfirst($acc->name) . '</a></td>' .
                        '<td>' . $acc->email . '</td>' .
                        '<td class="text-capitalize">' . $acc->baranggay . '</td>' .
                        '<td>' . $acc->created_at . '</td>' .
                        '<td>' . $acc->updated_at . '</td>' .
                        '<td class="justify-content-center d-flex p-1">' . "<a class = 'btn btn-outline-primary fs-6 py-1 px-4' href=" . "./accounts/" . "$acc->id/edit >Edit" . '</a></td>' .
                        '</tr>';
                }
               if ($trow <= 0) {
                    $output = '<tr><td class = "text-center fs-6 text-danger p-4" colspan ="5">No Record Found</td></tr>';
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
