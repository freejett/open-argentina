@extends('backend._layout.master')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Новости / Настройки / </span> Настройки телеграм-канала</h4>

    <div class="card card-default">
        <div class="card-header">
            <span class="card-title">{{ __('Добавить') }} Телеграм канал</span>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('backend.news.settings.store') }}"  role="form" enctype="multipart/form-data">
                @csrf
                @include('backend.news.settings._from')
            </form>
        </div>
    </div>
@endsection
