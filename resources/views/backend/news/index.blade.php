@extends('backend._layout.master')

@section('content')
<a href="{{ route('backend.news.settings.create') }}" class="float-end btn btn-primary">{{ __('Добавить канал') }}</a>
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Новости /</span> Настройки</h4>

<div class="card">
    <h5 class="card-header">Новости</h5>

    <div class="card-body">
        @if(count($news))
            {{ $news->onEachSide(2)->links() }}
        <div class="table-responsive text-nowrap">
            <table class="table table-striped table-hover mb-5">
                <thead>
                    <tr>
                        <th></th>
                        <th>Статус</th>
                        <th>Обложка</th>
                        <th>Название</th>
                        <th>Дата</th>
                        <th>Контакт</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach ($news as $new)
                    <tr>
                        <td>
                            {{ $new->id }}
                        </td>
                        <td>
                            {{ Form::select('status', $newStatus, $new->status, ['data-news-id' => $new->id, 'class' => 'news_status']) }}
                        </td>
                        <td>
                            @if($new->cover)
                                <img src="{{ asset('storage/aparts/'. $new->chat_id .'/'. $new->msg_id .'/'. $new->cover) }}" style="width: 80px;" class="img-responsive" alt="{{ $new->title }}">
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('backend.news.list.edit', $new->id) }}">
                                {{ $new->title }}
                            </a>
                        </td>
                        <td>
                            {{ \Illuminate\Support\Carbon::createFromTimestamp($new->date) }}
                        </td>
                        <td>
                            {{ $new->announcement }}
                        </td>


                        <td><span class="badge bg-label-primary me-1">Active</span></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);"
                                    ><i class="bx bx-edit-alt me-1"></i> Edit</a
                                    >
                                    <a class="dropdown-item" href="javascript:void(0);"
                                    ><i class="bx bx-trash me-1"></i> Delete</a
                                    >
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
            {{ $news->onEachSide(2)->links() }}
        @else
            <p>Каналов нет</p>
        @endif
    </div>
</div>
@endsection



@section('script')
    @include('backend.news._js')
@endsection
