<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Export;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function downloadExcel($id)
    {
        $file = Export::where('id', $id)->first();
        
        if (!$file) {
            return \abort(404, 'File not found');
        }

        if ($file->user_id != auth()->user()->id && auth()->user()->role != 'super_admin') {
            return \abort(403, 'Unauthorized');
        }

        $id = explode('-', $file->file_name)[1];

        if (!Storage::exists('public/filament_exports/'. $id .'/' . $file->file_name . '.xlsx')) {
            return \abort(404, 'File not found');
        }

        return Storage::download('public/filament_exports/'. $id .'/' . $file->file_name . '.xlsx');

    }
}
