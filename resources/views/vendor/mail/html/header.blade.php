@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('img/logo.png') }}" class="logo" alt="Armoury Broker">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
