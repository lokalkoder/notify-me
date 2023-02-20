<x-mail::message>
# {{ $content->subject }}

<x-mail::panel>
    {!! $content->message !!}
</x-mail::panel>

<x-mail::subcopy>
    Visit your application by clicking this [link]({{ $url['link'] }})
</x-mail::subcopy>

Thanks,<br>
{{ $signature }}
</x-mail::message>
