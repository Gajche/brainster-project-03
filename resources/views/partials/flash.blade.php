{{-- resources/views/partials/flash.blade.php --}}

{{-- Flash: success --}}
@if(session('success'))
<div class="absolute left-0 right-0 z-60 m-4 ">
	<div class="max-w-7xl mx-auto px-4">
		<div class="flex items-center justify-between bg-green-50 border border-green-200 text-green-800 rounded-lg px-4 py-3 text-sm" role="alert">
			<span>{{ session('success') }}</span>
			<button onclick="this.parentElement.remove()" class="ml-4 text-green-600 hover:text-green-900 font-bold">✕</button>
		</div>
	</div>
</div>
@endif

{{-- Flash: general error --}}
@if($errors->has('general'))
<div class="absolute left-0 right-0 z-60 m-4 ">
	<div class="max-w-7xl mx-auto px-4">
		<div class="flex items-center justify-between bg-red-50 border border-red-200 text-red-800 rounded-lg px-4 py-3 text-sm" role="alert">
			<span>{{ $errors->first('general') }}</span>
			<button onclick="this.parentElement.remove()" class="ml-4 text-red-600 hover:text-red-900 font-bold">✕</button>
		</div>
	</div>
</div>
@endif