<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block; ">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<div>
  <img style='vertical-align: middle;' width="30px" src="https://lafeescobedo.com/logo_transparent.png"/>
<span  style='vertical-align: middle; display:inline;'>
  {{ $slot }}
</span>
</div>
@endif
</a>
</td>
</tr>
