@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><a class="btn btn-secondary btn-sm" href="{{route("printings.index")}}">Back</a> (#{{count($documents)}}) - <span>{{$printing->folder}}</span></div>
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
                        <form method="POST" action="{{route("printings.update", $printing->id)}}">
                            @method("PUT")
                            @csrf()
                            <div class="input-group mb-3">
                                <input type="text" class="form-control typeahead" placeholder="Code" aria-label="Code" aria-describedby="basic-addon2" data-provide="typeahead" name="document"  autocomplete="off">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Copy</button>
                                </div>
                            </div>
                        </form>
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-files-tab" data-toggle="tab" href="#nav-files" role="tab" aria-controls="nav-files" aria-selected="true">Files</a>
                                <a class="nav-item nav-link" id="nav-logs-tab" data-toggle="tab" href="#nav-logs" role="tab" aria-controls="nav-logs" aria-selected="false">Logs</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-files" role="tabpanel" aria-labelledby="nav-files-tab">
                                <table class="table table-hover table-sm">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">File</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($documents as $key => $document)
                                        <tr>
                                            <th scope="row">{{$key+1}}</th>
                                            <td>{{basename($document)}}</td>
                                            <td><a class="btn btn-primary btn-sm" href="{{asset("storage/".$document)}}" target="_blank">Show</a></td>
                                            <td>
                                                <form method="POST" action="{{route("printings.deletefile", $printing->id)}}">
                                                    @csrf()
                                                    <input name="file" value="{{$document}}" type="hidden">
                                                    <button onclick="return confirm('Delete file?')" type="submit" class="btn btn-danger btn-sm" href="{{route("printings.edit", $printing->id)}}">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                                <div class="tab-pane fade" id="nav-logs" role="tabpanel" aria-labelledby="nav-logs-tab">
                                    <form method="POST" action="{{route("printings.addlog", $printing->id)}}">
                                        @csrf()
                                        <textarea class="form-control" name="logs" rows="15">{{$logs}}</textarea>
                                        <div class="dropdown-divider"></div>
                                        <button class="btn btn-secondary" type="submit" >Save logs</button>
                                    </form>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $( document ).ready(function() {

            $(".typeahead").on('keypress', function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault()
                    return false;
                }
            });



            $('.typeahead').typeahead({
                items: 100,
                selectOnBlur: false,
                changeInputOnSelect: true,
                source: [
                    @foreach($files as $file)
                    "{{$file}}",
                    @endforeach
                ]
            });




            $(".form-control").on("keyup", function (e) {
                $(this).val($(this).val().replace(/\//g,''))
            })
        });
    </script>
@endsection
