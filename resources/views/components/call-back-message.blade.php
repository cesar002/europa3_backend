@if (session()->has('CALL_BACK_MESSAGE'))
	@if (session('CALL_BACK_MESSAGE')['status'] == 'SUCCESS')
		<x-alert-success-message message="{{ session('CALL_BACK_MESSAGE')['message'] }}" />
	@else
		<x-alert-error-message message="{{ session('CALL_BACK_MESSAGE')['message'] }}" />
	@endif
@endif
