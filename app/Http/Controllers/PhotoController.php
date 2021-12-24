<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $postData = [
            "label" => $request->label,
            "url" => $request->url,
            "file" => $request->file,
            "created_at" => "NOW"
        ];
        $postRef = $this->database->getReference($this->tablename)->push($postData);
        if ($postRef) {
            return response('Photo added successfully.', 200);
        } else {
            return response('Photo not added.', 400);
        }
    }

    public function destroy($id)
    {
        $delData = $this->database->getReference($this->tablename . "/" . $id)->remove();
        if ($delData) {
            return response('Photo deleted successfully.', 200);
        } else {
            return response('Photo not deleted.', 400);
        }
    }
}
