@extends('backend._layout.master')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Tables /</span> Basic Tables</h4>

<div class="card">
    <h5 class="card-header">Striped rows</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped table-hover mb-5">
            <thead>
            <tr>
                <th></th>
                <th>ID чата</th>
                <th>Название чата</th>
                <th>Username</th>
                <th>Контакт</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody class="table-border-bottom-0">
            @foreach ($telegramChats as $telegramChat)
                <tr>
                    <td>
                        <img src="../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle"/>
                    </td>
                    <td>
                        <a href="{{ route('backend.news.settings.show', $telegramChat->id) }}">
                            <i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ $telegramChat->chat_id }}</strong>
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('backend.news.settings.show', $telegramChat->id) }}">
                            {{ $telegramChat->title }}
                        </a>
                    </td>
                    <td>{{ $telegramChat->username }}</td>
                    <td>{{ $telegramChat->contact }}</td>

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
</div>
@endsection
