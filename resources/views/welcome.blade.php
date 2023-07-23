@extends('layouts.main')

@section('title','HDC Events')

@section('content')

<div id="search-container" class="col-md-12">
    <h1>Busque um evento</h1>
    <form action = "/" method="GET"><!--usando get para buscar no banco-->
    <input type="text" id="search" name="search" class="form-control" placeholder="Procurar.."> <!--fica dentro da barra de pesquisa-->
    </form>
</div>

<div id="events-container" class="col-md-12">
    @if($search)
    <h2>Resultado da Busca : {{ $search }}</h2>
    @else
    <h2>Próximos Eventos</h2>
    <p class="subtitle"> Veja os eventos dos próximos dias</p>
    @endif
    <div id="cards-container" class="row">
        @foreach ($events as $event )
            <div class="card col-md-3"> <!--aqui para acionar imagem na tela principal nos eventos-->
                <img src="/img/events/{{ $event->image }}" alt="{{ $event->title }}"><!--alt seria atributo php-->
                <div class="card-body">
                    <p class="card-date">{{date('d/m/y', strtotime($event->date))}}</p>
                    <h5 class="card-title">{{ $event->title }}</h5>
                    <p class="card-participants">{{count($event->users)}} Participantes</p>
                    <a href="/events/{{ $event->id }}" class="btn btn-primary">Saber mais</a>

                </div>
            </div>
        @endforeach
           @if(count($events) == 0 && $search) <!--codigo para aparecer nao a eventos -->
              <p>Nao foi possivel encontrar nenhum evento com {{ $search}}!<!--search seria o q digita na pesquisa -->
                <a href="/"> Ver todos! </a></p><!--este para voltar na home barra para home -->
                  @elseif(count($events) == 0)
                   <p>Nao ha eventos disponíveis</p>
          @endif
    </div>
</div>
@endsection
