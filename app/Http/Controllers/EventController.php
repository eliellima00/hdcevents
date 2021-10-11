<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;

class EventController extends Controller
{
    public function index() {

        $events = Event::all();

        return view('Welcome',['events' => $events ]);
    }

    public function create () {
        return view('events.create');
    }

    //Request é do laravel e ja tras todas as informações dos formularios
    public function store(Request $request) {

        $event = new Event;

        $event->title = $request->title;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;

        //Image Upload
        if($request->hasFile('image') ** request->file('image')->isValid()) {

        }

        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');

    }
}
