<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Kreait\Firebase;
use Kreait\Firebase\Database;

class PhotoController extends Controller
{
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = "photos";
    }

    public function index()
    {
        $photos = $this->database->getReference($this->tablename)->getValue();
        return $photos;
    }

    public function store(Request $request)
    {
        // $photo = new Photo();
        $postData = [
            "label" => $request->label,
            "url" => $request->url,
            "file" => $request->file
        ];
        $postRef = $this->database->getReference($this->tablename)->push($postData);
        if ($postRef) {
            return response('Photo added successfully.', 201);
        } else {
            return response('Error.', 400);
        }
    }

    public function destroy(Photo $photo)
    {
        $photo->delete();
        return response()->json(["msg" => "Photo deleted successfully."]);
    }
}
