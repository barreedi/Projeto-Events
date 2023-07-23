@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1> Meus eventos</h1>

</div>

 <div class="col-md-10 offset-md-1 dashboard-events-container">
    @if(count($events) > 0)
  <table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Nome</th>
            <th scope="col">Participantes</th>
            <th scope="col">Ações</th >
        </tr>
    </thead>

  <tbody>
    @foreach($events as $event)
    <tr>
        <th scropt="row">{{ $loop->index + 1 }}</th>
        <td><a href="/events/{{ $event->id }}">{{ $event->title }}</a></td>
        <td>{{count($event->users)}}</td><!--para mostrar os participantes-->

        <td>
        <a href="/events/edit/{{$event->id}}" class="btn btn-info edit-btn"><ion-icon name="create-outline">
            </ion-icon> Editar </a>
               <form action="/events/{{ $event->id }}" method="POST">
                  @csrf    <!--para enviar para o banco-->
                 @method('DELETE')
               <button type="submit" class="btn btn-danger delete-btn"><ion-icon
             name="trash-outline"></ion-icon> Delete </button>

           </form>
        </td>
    </tr>
    @endforeach
  </tbody>
  </table>
    @else
    <p>Voce ainda nao tem eventos, <a href="/events/create"> criar evento </a></p>
    @endif
 </div>
 <div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1> Eventos que estou participando</h1>
</div>
<div class="col-md-10 offset-md-1 dashboard-title-container">
    @if(count($eventsasparticipant) > 0)
  <table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Nome</th>
            <th scope="col">Participantes</th>
            <th scope="col">Ações</th >
        </tr>
    </thead>
  <tbody>
    @foreach($eventsasparticipant as $event)
    <tr>
        <th scropt="row">{{ $loop->index + 1 }}</th>
        <td><a href="/events/{{ $event->id }}">{{ $event->title }}</a></td>
        <td>{{count($event->users)}}</td><!--para mostrar os participantes-->
        <td>
        <form action="/events/leave/{{ $event->id}}" method="POST">
            @csrf
            @method("DELETE")
            <button type="submit" class="btn btn-danger delete-btn">
            <ion-icon name="trash-outline"></ion-icon> Sair do Evento
            </button>
        </form>
        </td>
    </tr>
    @endforeach
  </tbody>
  </table>
        @else
        <p>Voce ainda nao esta participando de nenhum evento, <a href="/">Veja todos os eventos</a></p>
        @endif

</div>
@endsection
