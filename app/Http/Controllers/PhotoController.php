<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use DateTime;
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
        $tempPhotos = $this->database->getReference($this->tableName)->getValue();
        if ($tempPhotos) {
            $photos = array_map(function ($item) {
                foreach ($item as $key => $value) {
                    if ($key == 'image') {
                        $imageReference = $this->storage->getBucket()->object($this->storagePath . $value);
                        if ($imageReference->exists()) {
                            $item["url"] = $imageReference->signedUrl(new DateTime("tomorrow"));
                        } else {
                            $item["url"] = null;
                        }
                    }
                }
                return $item;
            }, $tempPhotos);
            return array_reverse($photos);
        } else {
            return null;
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            "label" => "required|min:2|max:28",
            "url" => "required_without:image|nullable",
            "image" => "required_without:url|nullable|image|mimes:png,jpg,jpeg|max:512"
        ]);

        $newPostKey = $this->database->getReference($this->tableName)->push()->getKey();
        $optionKey = null;
        $optionValue = null;

        if ($request->hasFile("image")) {
            $optionKey = "image";
            $image = $request->file("image");
            $optionValue = $newPostKey . "." . $image->getClientOriginalExtension();
            $localFolder = public_path("firebase-temp-uploads") . "/";
            if ($image->move($localFolder, $optionValue)) {
                $uploadedfile = fopen($localFolder . $optionValue, "r");
                $this->storage->getBucket()->upload(
                    $uploadedfile,
                    [
                        "name" => $this->storagePath . $optionValue
                    ]
                );
                unlink($localFolder . $optionValue);
            } else {
                return response('Photo file not uploaded.', 400);
            }
        } else {
            $optionValue = $request->url;
            $optionKey = "url";
        }

        $postRef = $this->database->getReference()->update([
            $this->tableName . "/" . $newPostKey => [
                "label" => strtoupper($request->label),
                $optionKey => $optionValue,
                "created_at" => now()
            ]
        ]);

        if ($postRef) {
            return response('Photo added successfully.', 200);
        } else {
            return response('Photo not added.', 400);
        }
    }

    public function search(Request $request)
    {
        //There is no exact function to query using '%like%'
        $key = strtoupper($request->label);
        $tempPhotos = $this->database->getReference('photos')
            ->orderByChild('label')
            ->startAt($key)
            ->limitToFirst(100)
            ->getValue();
        $photos = array();
        foreach ($tempPhotos as $item) {
            if (str_contains($item['label'], $key)) {
                array_push($photos, $item);
            }
        }
        return $photos;
    }

    public function destroy($id)
    {
        $photo = $this->database->getReference($this->tableName . "/" . $id);
        if (array_key_exists("file", $photo->getValue())) {
            $this->storage->getBucket()->object($this->storagePath . $photo->getValue()["file"])->delete();
        }
        $delData = $this->database->getReference($this->tableName . "/" . $id)->remove();
        if ($delData) {
            return response('Photo deleted successfully.', 200);
        } else {
            return response('Photo not deleted.', 400);
        }
    }
}
