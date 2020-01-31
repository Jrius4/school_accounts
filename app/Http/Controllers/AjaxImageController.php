<?php

namespace App\Http\Controllers;

use App\AjaxImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class AjaxImageController extends Controller
{
    public function ajaxImageUpload()
    {
        return view('ajaxImageUpload');
    }
    // public function ajaxImageUploadPost(Request $request)
    // {
    //     $validator = Validator::make($request->all(),[
    //         'title' => 'required',
    //         'image' => 'required|image|max:2048',
    //     ]);
    //     if($validator->passes())
    //     {
    //         $input = $request->all();
    //         $input['image'] = time().'.'.$request->image->extension();

    //         $request->image->move(public_path('images'), $input['image']);


    //         AjaxImage::create($input);


    //         return response()->json(['success'=>'done']);

    //       }


    //       return response()->json(['error'=>$validator->errors()->all()]);



    // }

    public function save (Request $request)
    {

        request()->validate([
            'image'=>'required|image|max:3048',
        ]);

        if ($files = $request->file('image')) {

            $files = new AjaxImage();
            $files->title = "diles";
            $extensionImage = $request->file("image")->getClientOriginalExtension();
            $imageName = $request->file("image")->getClientOriginalName();
            $fullImagePath = $imageName;
            $uploadImagePath = public_path('images/');
            $request->file('image')->move(
                $uploadImagePath, $imageName
            );

            $files->image = $fullImagePath;
            $files->save();


          }

          $image = AjaxImage::latest()->first(['image']);
          return Response()->json($image);
    }
}
