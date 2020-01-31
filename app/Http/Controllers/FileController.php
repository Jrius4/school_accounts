<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Input;

class FileController extends Controller
{
    protected $uploadFilePath;
    protected $uploadImagePath;

    public function __construct()
    {
        $this->uploadImagePath = public_path(config('cms.image.directory'));
        $this->uploadFilePath = public_path(config('cms.file.directory'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $files = File::get();
        return view('manage-files.index',compact('files'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(File $file)
    {
        return view('manage-files.create',compact('file'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{

    $this->validate($request,[
        'name' => 'required',
        'author' => 'required',
        'file' => 'required',
        'image'=>'required|image'
    ]);

    // $imageInput = Input::file('image');
    // $image= Image::make(Input::file('image'));
    // $path= $this->uploadImagePath;

    // $image->save($path.$imageInput->getClientOriginalName());
    // $image->resize(100,100);
    // $image->save($path.$request->input('name').'_'.'thumb_'.$imageInput->getClientOriginalName());



    $files= new File();


    $files->name  = $request->input('name');
    $files->author  = $request->input('author');

    $extensionImage = Input::file('image')->getClientOriginalExtension();
    $imageName = $files->name.'_'.rand(11111111, 99999999). '.' . $extensionImage;
    $fullImagePath = $imageName;
    $request->file('image')->move(
        $this->uploadImagePath, $imageName
    );

    $files->image = $fullImagePath;

    $extension = Input::file('file')->getClientOriginalExtension();
    $filename = $files->name.'_'.rand(11111111, 99999999). '.' . $extension;
    $fullFilePath = $filename;

    $request->file('file')->move(
        $this->uploadFilePath, $filename
    );
    $files->file = $fullFilePath;

    if ($files->save())
    {
        return redirect()->back()->with('message','Your file has been uploaded');
    }
    return redirect()->back()->withErrors($validate);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        return view('manage-files.show', compact('file'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        return view('manage-files.edit', compact('file'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        $this->validate($request,[
            'name' => 'required',
            'author' => 'required',
        ]);
        $OldImage = $file->image;
        $OldFile = $file->file;

        $file->name  = $request->input('name');
        $file->author  = $request->input('author');

        if($request->hasFile('image'))
        {    $extensionImage = Input::file('image')->getClientOriginalExtension();
            $imageName = $request->input('name').'_'.rand(11111111, 99999999). '.' . $extensionImage;
            $fullImagePath = $imageName;
            $request->file('image')->move(
                $this->uploadImagePath, $imageName
            );

            $request->image = $fullImagePath;
        }
        else{
            $request->image = $OldImage;
        }


        if($request->hasFile('file'))
        {     $extension = Input::file('file')->getClientOriginalExtension();
            $filename =$request->input('name').'_'.rand(11111111, 99999999). '.' . $extension;
            $fullFilePath = $filename;

            $request->file('file')->move(
                $this->uploadFilePath, $filename
            );
            $request->file = $fullFilePath;
        }
        else{
            $request->image = $OldImage;
        }

        if ($file->update($request->all()))
        {
            return redirect()->back()->with('message','Your file has been update');
        }
        return redirect()->back()->withErrors($validate);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {

    }

    private function handleRequest($request)
    {
        $data = $request->all();

        if ($request->hasFile('image'))
        {
            $image       = $request->file('image');
            $imageName    = $image->getClientOriginalName();
            $destination = $this->uploadImagePath;

            $successUploaded = $image->move($destination, $imageName);

            if ($successUploaded)
            {
                $width     = config('cms.image.thumbnail.width');
                $height    = config('cms.image.thumbnail.height');
                $extension = $image->getClientOriginalExtension();
                $thumbnail = str_replace(".{$extension}", "_thumb.{$extension}", $imageName);

                Image::make($destination . '/' . $imageName)
                    ->resize($width, $height)
                    ->save($destination . '/' . $thumbnail);
            }

            $data['image'] = $imageName;
        }
        if($request->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $destination = $this->uploadFilePath;
            $successUploaded = $file->move($destination,$fileName);


            $data['file'] = $fileName;
        }


        return $data;
    }

}
