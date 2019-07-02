@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
			'modalClass' => 'flash-modal',
			'title'      => $message['title'],
			'body'       => $message['message']
		])
    @else

    <!-- 
    <div class="toast
        " role="alert" aria-live="assertive" aria-atomic="true">
    </div>
    -->
        <div class="alert
                alert-{{ $message['level'] }}
                {{ $message['important'] ? 'alert-important' : '' }}"
                role="alert"
        >
            @if ($message['important'])
                <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-hidden="true"
                >&times;</button>
            @endif
            
            {!! $message['message'] !!}
        </div>
    @endif
@endforeach

<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

<!-- 
<script>
    $('div.alert').not('.alert-important').delay(4000).fadeOut(1000);
    $('.h-spacer').delay(4000).fadeOut(1000);
</script>
-->

{{ session()->forget('flash_notification') }}
