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
                            <table class="table table-hover table-sm">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Path</th>
                                    <th scope="col">User</th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($printings as  $printing)
                                    <tr>
                                        <th scope="row">{{$printing->id}}</th>
                                        <td>{{$printing->folder}}</td>
                                        <td>{{$printing->user->name}}</td>
                                        <td><a class="btn btn-primary btn-sm" href="{{route("printings.edit", $printing->id)}}">Edit</a></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Print
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{route("print", [$printing->id, 175,175])}}">175x175</a>
                                                    <a class="dropdown-item" href="{{route("print", [$printing->id, 235,235])}}">235x235</a>
                                                    <a class="dropdown-item" href="{{route("print", [$printing->id, 350,310])}}">350x310</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <form method="POST" action="{{route("printings.destroy", $printing->id)}}">
                                                @csrf()
                                                @method("DELETE")
                                                <button onclick="return confirm('Delete files?')" type="submit" class="btn btn-danger btn-sm" href="{{route("printings.edit", $printing->id)}}">Delete</button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach

                            </table>
                            {{ $printings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
