<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block; ">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<div>
  <img style='vertical-align: middle;' width="30px" src="https://dev.d2ax9tya2rkwv4.amplifyapp.com/rc_desarrolladora_logo.jpg"/> 
<span  style='vertical-align: middle; display:inline;'>
  {{ $slot }}
</span>
</div>
@endif
</a>
</td>
</tr>
