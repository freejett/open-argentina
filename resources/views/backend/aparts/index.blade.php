@extends('backend._layout.master')

@section('content')
<a href="{{ route('backend.news.settings.create') }}" class="float-end btn btn-primary">{{ __('Добавить канал') }}</a>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Новости /</span> Настройки</h4>

<div class="card">
    <h5 class="card-header">Квартиры</h5>

    <div class="card-body">
        @if(count($apartments))
            {{ $apartments->onEachSide(2)->links() }}
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="thead">
                        <tr>
                            <th>No</th>
                            <th>Photo</th>
{{--                            <th>Chat Id</th>--}}
                            <th>Title</th>
                            <th>Address</th>
                            <th>Full Address</th>
                            <th>Lat</th>
                            <th>Lng</th>
                            <th>Status</th>
                            <th>Price</th>
{{--                            <th>Full Price</th>--}}
{{--                            <th>Pets Allowed</th>--}}
{{--                            <th>Kids Allowed</th>--}}
{{--                            <th>Advantages</th>--}}
                            <th>Type</th>
                            <th>Number Of Rooms</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($apartments as $apartment)
                            <tr>
                                <td>{{ $apartment->id }}</td>
{{--                                <td>{{ $apartment->chat_id }}</td>--}}
                                <td>
                                    @if($apartment->photo)
                                        <a href="{{ route('backend.aparts.list.edit', $apartment->id) }}">
                                            <img src="{{ asset('storage/aparts/'. $apartment->chat_id .'/'. $apartment->msg_id .'/'. $apartment->photo) }}" style="width: 150px;" class="img-responsive" alt="{{ $apartment->title }}">
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('backend.aparts.list.edit', $apartment->id) }}">
                                        {{ $apartment->title }}
                                    </a>
                                </td>
                                <td>{{ $apartment->address }}</td>
                                <td>{{ $apartment->full_address }}</td>
                                <td>{{ $apartment->lat }}</td>
                                <td>{{ $apartment->lng }}</td>
                                <td>{{ $apartment->status }}</td>
                                <td>{{ $apartment->price }}</td>
{{--                                <td>{{ $apartment->full_price }}</td>--}}
{{--                                <td>{{ $apartment->pets_allowed }}</td>--}}
{{--                                <td>{{ $apartment->kids_allowed }}</td>--}}
{{--                                <td>{{ $apartment->advantages }}</td>--}}
                                <td>{{ $apartment->type }}</td>
                                <td>{{ $apartment->number_of_rooms }}</td>
                                <td>
                                    <form action="{{ route('backend.aparts.list.destroy',$apartment->id) }}" method="POST">
                                        <a class="btn btn-sm btn-primary " href="{{ route('backend.aparts.list.show',$apartment->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                        <a class="btn btn-sm btn-success" href="{{ route('backend.aparts.list.edit',$apartment->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $apartments->onEachSide(2)->links() }}
        @else
            <p>Новостей нет</p>
        @endif
    </div>
</div>
@endsection



@section('script')
    @include('backend.news._js')
@endsection
