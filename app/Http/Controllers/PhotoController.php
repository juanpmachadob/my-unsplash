<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $photo = [
            "label" => $request->label,
            "url" => $request->url,
            "created_at" => date('Y-m-d H:i')
        ];
        $postRef = $this->database->getReference($this->tableName)->push($photo);
        if ($postRef) {
            if ($request->hasFile("image")) {
                $postKey = $postRef->getKey();
                $image = $request->file("image");
                $fileName = $postKey . "." . $image->getClientOriginalExtension();
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
