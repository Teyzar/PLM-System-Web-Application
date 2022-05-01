<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentsApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'ability:accessIncidents']);
    }

    public function units(Request $request, $id) {
        $incident = Incident::find($id);

        if (!$incident) abort(404);

        $units = $incident->units()->get();

        return $units;
    }
}
