<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
class EventController extends Controller
{

   public function index() {
      $search = request('search');
        if($search){
         $events = Event::where([
            ['title','like','%'.$search.'%']
              ])->get();
        }else{
                   $events = Event::all();
    }
    return view('welcome',['events'=> $events, 'search'=> $search]);
  }

public function create(){
    return view('events.create');

}
public function store(Request $request){
    $event = new Event;
    $event->title = $request->title;
    $event->date = $request->date;
    $event->city = $request->city;
    $event->private = $request->private;
    $event->description = $request->description;
    $event->items = $request->items;

    //image upload para colocar imagem no banco
    if($request->hasFile('image') && $request->file('image')->isValid()) {
        $requestImage = $request->image;
        $extension = $requestImage->extension();
        $imageName = md5($requestImage->getClientOriginalName()
        . strtotime('now')) . "." . $extension;
        $requestImage->move(public_path('img/events'), $imageName);
        $event->image = $imageName;
    }
  $user =auth()->user();
      $event->user_id = $user->id;
         $event->save();
            return redirect('/')->with('msg', 'Evento criado com sucesso!');

}
public function show($id) {
    $event = Event::findOrFail($id);
      $user = auth()->user();//codigo se participar de um evento nao repetir
        $hasUserJoined = false;
         if($user){
           $userEvents = $user->eventsAsParticipant->toArray();
             foreach($userEvents as $userEvent){
              if($userEvent['id'] == $id){//id participante do evento comparando com id request
                $hasUserJoined = true;

            }
        }
    }
    $eventOwner = User::where('id', $event->user_id)->first()->toArray();
    return view('events.show', ['event' => $event, 'eventOwner' => $eventOwner, 'hasUserJoined' => $hasUserJoined]);

}

    public function dashboard() {
        $user =auth()->user();
        $events = Event::all();
        $eventsAsParticipant = $user->eventsAsParticipant;
        return view('events.dashboard', ['events' => $events,'eventsasparticipant'=> $eventsAsParticipant]);
    }

    public function destroy($id){//funcao para deletar evento
        $listaEventos = auth()->user()->events;
        //dd($listaEventos);
        //TODO Alteramos aqui
        foreach ($listaEventos as $evento) {
            if($evento->id == $id){
                return back()->with('msg',"Você possui eventos relacionados com seu usuário.");

            }
        }
        Event::findOrFail($id)->delete();
        return redirect('/dashboard')->with('msg','Evento excluido com sucesso !');
    }

    public function edit($id){//para mostrar  o evento e editar
        $user = auth()->user();
          $event = Event::findOrFail($id);
           if($user->id != $event->user_id){//para nao deixar editar evento q nao sao do usuario
              return redirect('/dashboard');
    }
    return view('events.edit', ['event' => $event]);

}

        public function update(Request $request){//para acrescentar um dado do evento
            $data = $request->all();
            if($request->hasFile('image') && $request->file('image')->isValid()) {
                $requestImage = $request->image;
                $extension = $requestImage->extension();
                $imageName = md5($requestImage->getClientOriginalName()
                . strtotime('now')) . "." . $extension;
                $requestImage->move(public_path('img/events'), $imageName);
                $data['image'] = $imageName;
            }
             Event::findOrFail($request->id)->update($data);
             return redirect('/dashboard')->with('msg','Evento editado com sucesso !');

        }

        public function joinEvent($id) {
               $user = auth()->user();
                  $user->eventsAsParticipant()->attach($id);
                      $event = Event::findOrFail($id);
                        return redirect('/dashboard')->with('msg','Sua presença esta confirmada no evento !'
                            .$event->title);

         }
        public function leaveEvent($id) {
                $user = auth()->user();
                   $user->eventsAsParticipant()->detach($id);
                      $event = Event::findOrFail($id);
                         return redirect('/dashboard')->with
                         ('msg','Voce saiu do evento que estava participando: !'
                            .$event->title);
         }


        }

