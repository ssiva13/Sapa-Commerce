<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $sliders = Slider::orderBy('created_at', 'DESC')->paginate(10);

        // return \json_encode($sliders);
        return \view('admin.sliders.show')->with('sliders', $sliders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sliders = Slider::all();
        return \view('admin.sliders.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'title' => 'required | max:225',
            'slider' => 'required | image | max:1999',
            'active-slide' => 'nullable',
        ));


        $slider = new Slider();

        $slider->title = $request->input('title');

        if (($slider->active = $request->input('active-slide')) != "") {
            $slider->active = "active";
        }

        if ($request->hasFile('slider')) {


            $slider_image = $request->file('slider');
            $filename = $slider->title . '-' . time() . '-' . $slider_image->getClientOriginalName();
            
            $slider_image->move('zoom/slides/', $filename);

            $slider->photo = $filename;
        } else {
            $filename = 'no_image.jpg';
            $slider->photo = $filename;
        }
        $slider->save();
        return redirect()->route('sliders.index')->with('success', 'Slider Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {


        $slider->title = $request->input('title');

        if (($slider->active = $request->input('active-slide')) != "") {
            $slider->active = "active";
        }

        if ($request->hasFile('slider')) {


            $slider_image = $request->file('slider');
            $filename = $slider->title . '-' . time() . '-' . $slider_image->getClientOriginalName();
            
            $slider_image->move('zoom/slides/', $filename);

            $oldFilename = $slider->photo;
            $slider->photo = $filename;
            if (!empty($slider->photo)) {
                File::delete('zoom/slides/'. $oldFilename);
            }

            $slider->photo = $filename;
        }

        $slider->save();

        return redirect()->route('sliders.index')->with('success', 'Slider Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {


        $slider->delete();

        return redirect('/admin/sliders')->with('success', 'Category Deleted Successfully!!');
    }
}
