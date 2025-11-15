@props([
    'url' => config('app.url'),
])

<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">

            <img src="{{ asset('img/aepapa-logo.jpg') }}" alt="{{ config('app.name') }} Logo" style="width: auto; max-height: 75px; border: 0;">

        </a>
    </td>
</tr>
