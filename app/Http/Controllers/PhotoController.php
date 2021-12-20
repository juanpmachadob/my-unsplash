<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function store(Photo $photo){
        $photo = new Photo();
    }
    
    public function destroy(Photo $photo){
        $photo->delete();
        return response()->json(["msg" => "Photo deleted successfully."]);
    }
}
