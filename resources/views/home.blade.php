@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a class="btn btn-success" href="{{route("printings.create")}}">Create folder</a>
                    <a class="btn btn-primary" href="{{route("printings.index")}}">All foldersr</a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
