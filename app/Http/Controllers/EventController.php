<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index(){
        $data = array(
            'events' => Event::all()
        );

        return view('home', $data);
    }

    public function create(Request $request){
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'pembicara' => 'required',
                'start' => 'required',
                'end' => 'required',
                'poster' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $event = new Event();

            $file = $request->file('poster');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
            $event->poster = $fileName;

            $event->create(array_merge(
                $validator->validated(),
                ['poster' => $fileName]
            ));

            return redirect('/')->with('success', 'Event berhasil ditambahkan');
        }

        return view('addEvents');
    }

    public function show($id){
        $data = array(
            'event' => Event::find($id)
        );

        return view('detailEvents', $data);
    }

    public function update(Request $request, $id){
        $event = Event::find($id);

        if($request->method('PUT')){
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'pembicara' => 'required',
                'start' => 'required',
                'end' => 'required',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if($request->hasFile('poster')){
                $file = $request->file('poster');
                $fileName = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $fileName);

                if($event->poster){
                    if(file_exists(public_path('uploads/'.$event->poster))){
                        unlink(public_path('uploads/'.$event->poster));
                    }
                }
                $event->poster = $fileName;
            }

            $event->update(array_merge(
                $validator->validated(),
                isset($fileName) ? ['poster' => $fileName] : []
            ));

            return redirect()->back()->with('success', 'Event bverhasil diupdate');
        }

        $data = array(
            'event' => $event
        );

        return view('detailEvents', $data);
    }

    public function delete($id){
        $event = Event::find($id);
        $event->delete();

        if($event->poster){
            if(file_exists(public_path('uploads/'.$event->poster))){
                unlink(public_path('uploads/'.$event->poster));
            }
        }

        return redirect('/')->with('success', 'Event berhasil dihapus');
    }
}