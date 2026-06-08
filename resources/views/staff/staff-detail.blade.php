@extends('layouts.dashboard')

@section('breadcrumb')
    <x-breadcrumb
        page_title="Menambahkan Staff"
        :items="[
            ['label' => 'Home', 'url' => route('dashboard')],
            ['label' => 'Staff', 'url' => route('staff')],
            ['label' => 'Detail', 'url' => '']
        ]"
    />
@endsection

@section('content')
    <div>
        <div class="flex flex-col gap-4">
            <div>
                <label class="input-label" for="username">Username</label>
                <input
                    name="username"
                    id="username"
                    type="text"
                    disabled
                    class="input-field"
                    value="{{ $staff->username }}"
                />
            </div>
            <div>
                <label class="input-label" for="name">Nama</label>
                <input
                    name="name"
                    id="name"
                    type="text"
                    disabled
                    class="input-field"
                    value="{{ $staff->name }}"
                />
            </div>
            <div class="flex justify-end gap-4">
                <a href="{{route('staff.change-pass', $staff->id)}}">
                    <button class="btn-secondary">Ganti Password</button>
                </a>
                <a href="{{route('staff.edit', $staff->id)}}">
                    <button class="btn-secondary">Edit</button>
                </a>
            </div>
        </div>
    </div>

@endsection
