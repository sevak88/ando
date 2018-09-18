
    @foreach($documents as $documant)
        @php
            $img = \Intervention\Image\ImageManagerStatic::make($documant->getPathname());
            $img->resize($width, $height);
        @endphp
        <img src="{{$img->encode("data-url")}}" style="margin: 2px">
    @endforeach