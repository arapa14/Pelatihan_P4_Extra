@php
    $appName = DB::table('settings')->where('key', 'app_name')->value('value');
@endphp
<footer class="p-4 border-t border-slate-700 glass text-center text-sm text-slate-400">
    © {{ now()->year }} {{ $appName }} • Copyright
</footer>