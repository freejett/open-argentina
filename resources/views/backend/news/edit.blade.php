@extends('backend._layout.master')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Новости / </span> {{ $news->title ?: 'Заголовок новости' }}</h4>

<div class="card card-default">
    <div class="card-header">
        <span class="card-title">{{ __('Update') }} {{ $news->title }}</span>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('backend.news.list.update', $news->id) }}"  role="form" enctype="multipart/form-data">
            {{ method_field('PATCH') }}
            @csrf
            @include('backend.news._from')
        </form>
    </div>
</div>
@endsection
