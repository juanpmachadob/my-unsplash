<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Kreait\Firebase\Database;
use Kreait\Firebase\Storage;

class PhotoController extends Controller
{
    public function __construct(Database $database, Storage $storage)
    {
        $this->database = $database;
        $this->tableName = "photos";
        $this->storage = $storage;
        $this->storagePath = "photos/";
    }

    public function index()
    {
        $photos = $this->database->getReference($this->tableName)->getValue();
        return $photos;
    }

    public function store(Request $request)
    {
        $request->validate([
            "label" => "required|min:2|max:28",
            "url" => "required_without:image|url",
            "image" => "required_without:url|image|mimes:png,jpg,jpeg|max:512"
        ]);

        $postRef = $this->database->getReference($this->tableName)->push(
            [
                "label" => $request->label,
                "url" => $request->url,
                "created_at" => now() // date('Y-m-d H:i')
            ]
        );

        if ($postRef) {
            if ($request->hasFile("image")) {
                $image = $request->file("image");
                $fileName = $postRef->getKey() . "." . $image->getClientOriginalExtension();
                $localFolder = public_path("firebase-temp-uploads") . "/";

                if ($image->move($localFolder, $fileName)) {
                    $uploadedfile = fopen($localFolder . $fileName, "r");
                    $this->storage->getBucket()->upload($uploadedfile, [
                        "name" => $this->storagePath . $fileName
                    ]);
                    
                    unlink($localFolder . $fileName);
                } else {
                    return response('Photo file not uploaded.', 400);
                }
            }
            return response('Photo added successfully.', 200);
        } else {
            return response('Photo not added.', 400);
        }
    }

    public function uploadImage(Request $request, $key)
    {
        if ($request->hasFile("image")) {
            $image = $request->file("image");
            $fileName = $key . "." . $image->getClientOriginalExtension();
            $localFolder = public_path("firebase-temp-uploads") . "/";
            if ($image->move($localFolder, $fileName)) {
                $uploadedfile = fopen($localFolder . $fileName, "r");
                $this->storage->getBucket()->upload($uploadedfile, [
                    "name" => $this->storagePath . $fileName
                ]);
                unlink($localFolder . $fileName);
            }
        }
    }

    public function destroy($id)
    {
        $delData = $this->database->getReference($this->tableName . "/" . $id)->remove();
        if ($delData) {
            return response('Photo deleted successfully.', 200);
        } else {
            return response('Photo not deleted.', 400);
        }
    }
}
