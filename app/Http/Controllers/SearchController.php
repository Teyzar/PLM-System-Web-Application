<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // $products = Accounts::where('name', 'LIKE', '%' . $request->search . "%")->get();


        if ($request->ajax()) {
            $output = "";
            $products = Accounts::where('name', 'LIKE', '%' . $request->search . "%")->get();


            if ($products) {
                foreach ($products as $key => $product) {
                    return $output .= '<tr style="font-family: sans-serif">' .
                        '<td><a href="/accounts/' . $product->id . '/edit"
                        class="fs-6 text-decoration-none text-capitalize text-muted">' . ucfirst($product->name) . '</a></td>' .
                        '<td>' . $product->email . '</td>' .
                        '<td class="text-capitalize">' . $product->baranggay . '</td>' .
                        '<td>' . $product->created_at . '</td>' .
                        '<td>' . $product->updated_at . '</td>' .
                        '<td class="justify-content-end d-flex">' . "<a class = 'btn btn-outline-primary fs-6 py-1 px-4' href=" . "./accounts/" . "$product->id/edit >Edit" . '</a></td>' .
                        '</tr>';
                }
            }
            return $output .= '
                <div class="center">
                    <span class = "d-flex fs-5 text-muted text-capitalize">No record found</span>
                </div>';
        }
    }
}
