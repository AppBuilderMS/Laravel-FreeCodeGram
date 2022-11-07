@component('mail::message')
    # Welcome to freeCodeGram

    This is a community of fellow developers and we love that you have joind us.

    {{-- @component('mail::button', ['url' => ''])
    Button Text
    @endcomponent --}}

    All th best,<br>
    {{ config('app.name') }}
@endcomponent
