@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        @if (session()->has('message'))
                            <div class="alert alert-primary">
                                <ul class="list">
                                    <li>{{ session()->get('message') }}</li>
                                </ul>
                            </div>
                        @endif
                        @if ($errors->all())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{route("printings.store")}}">
                            @csrf()
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Code" aria-label="Code" aria-describedby="basic-addon2" name="folder" value="{{date("Y/m/d")}}/">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
