<?php

namespace App\Http\Controllers;

use App\Category;
use App\Asset;
use Auth;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
            $categories = Category::orderBy('created_at', 'desc')->paginate(8);
            return view('categories.index')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Category::class);
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Category::class);

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'image' => 'image'
        ]);

        $name = htmlspecialchars($request->input('name'));
        $description = htmlspecialchars($request->input('description'));
        $image = $request->file('image');

        if($image){ //if there is an image uploaded
            $category = new Category;
            $category->name = $name;
            $category->description = $description;
            //handle the file image upload
            //set the file name of the uploaded image to be the time of upload, retaining the original file type
            $file_name = time() . "." . $image->getClientOriginalExtension();
            //set target destination where the file will be saved in
            $destination = "images/";
            //call the move() method of the $image object to save the uploaded file in the target destination under the specified file name
            $image->move($destination, $file_name);
            //set the path of the saved image as the value for the column img_path of this record
            $category->img_path = $destination.$file_name;
            //save the new product object as a new record in the products table via its save() method
            $category->save();
            return redirect('/categories')->with('success', 'Successfully added a new product line.');
        }else{
            //if no image is uploaded
            return back()->with('warning', 'Please insert an image');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {   
        $available = 0;
        $unavailable = 0;
        $total = 0;
        foreach($category->assets as $asset){
            if($asset->isAvailable == 1){
                $available++;
            }else{
                $unavailable++;
            }
            $total++;
        }
        $asset_count = [
            'available' => $available,
            'unavailable' => $unavailable,
            'total' => $total
        ];
        return view('categories.show')->with('category', $category)->with('asset_count', $asset_count);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $this->authorize('update', Category::class);
       /* $categories = Category::all();*/
        return view('categories.edit')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', Category::class);
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string', 
            'image' => 'image'
        ]);
        $name = htmlspecialchars($request->input('name'));
        $description = htmlspecialchars($request->input('description'));
        $category->name = $name;
        $category->description = $description;
        $image = $request->file('image');
        //if an image file upload is found, replace the current image of the product with the new upload
        if($request->file('image') != null){
            //handle the file image upload
            //set the file name of the uploaded image to be the time of upload, retaining the original file type
            $file_name = time() . "." . $image->getClientOriginalExtension();
            //set target destination where the file will be saved in
            $destination = "images/";
            //call the move() method of the $image object to save the uploaded file in the target destination under the specified file name
            $image->move($destination, $file_name);
            //set the path of the saved image as the value for the column img_path of this record
            $category->img_path = $destination.$file_name;
        }
        $category->save();
        return redirect('/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
       if($category->isActive == 1){
            $category->isActive = 0;
            foreach($category->assets as $asset){
                $asset->isAvailable = 0;
                $asset->save();
            }
       }else{
            $category->isActive = 1;

            foreach($category->assets as $asset){
                $asset->isAvailable = 1;
                $asset->save();
            }
        }
       $category->save();
       return redirect('/categories');
    }
}
