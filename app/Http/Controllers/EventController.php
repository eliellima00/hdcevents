<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Event;
use App\Models\User;

class EventController extends Controller
{
    public function index()
    {
        $search = request('search');

        if ($search) {

            $events = Event::where(
                'title', 'like', '%'.$search.'%'
            )->get();

        } else {
            $events = Event::all();
        }

        return view('Welcome', ['events' => $events, 'search' => $search]);
    }

    public function create()
    {
        return view('events.create');
    }

    //Request é do laravel e ja tras todas as informações dos formularios
    public function store(Request $request)
    {

        $event = new Event;

        $event->title = $request->title;
        $event->date = $request->date;
        $event->city = $request->city;
        $event->private = $request->private;
        $event->description = $request->description;
        $event->items = $request->items; // no model eu digo que items é do tipo array

        //Image Upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/events'), $imageName);

            $event->image = $imageName;
        }

        $user = auth()->user() ; //Metodo Auth-> acessa o user(), que é o usuario logado
        $event->user_id = $user->id ; // Acesso a propriedade id do usuario que esta logado

        $event->save();

        return redirect('/')->with('msg', 'Evento criado com sucesso!');
    }

    public function show($id) {

        $event = Event::findOrFail($id);

        $eventOwner = User::where('id', $event->user_id)->first()->toArray();

        return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner]);

    }

    public function dashboard() {

        $user = auth()->user();

        $events = $user->events;

        return view ('events.dashboard', ['events' => $events ]);
    }

    public function destroy($id) {
        Event::findOrFail($id)->delete();

        return redirect('/dashboard')->with('msg', 'Evento excluído com sucesso!');
    }

    public function edit($id) {
        $event = Event::findOrFail($id);

        return view('events.edit', ['event' => $event]);
    }

    //pega a requisição que veio do update com todas as alterações
    public function update(Request $request) {

        $data = $request->all();

        //Image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            $requestImage = $request->image;

            $extension = $requestImage->extension();

            $imageName = md5($requestImage->getClientOriginalName() . strtotime("now")) . "." . $extension;

            $requestImage->move(public_path('img/events'), $imageName);

            $data['image'] = $imageName;
        }

        Event::findOrFail($request->id)->update($data);   // Procura em todos os dados que vieram da requisição e realiza as alterações com base no id informado

        return redirect('/dashboard')->with('msg', 'Evento editado com sucesso!');
    }
}
