@props([
    'type' => session('message_type', 'success'),
    'message' => session('message', ''),
    'colors' => [
        'success' => ['bg' => '#07f070', 'text' => '#ffffff', 'icon' => 'check-circle'],
        'danger' => ['bg' => '#f51853', 'text' => '#ffffff', 'icon' => 'x-circle'],
        'warning' => ['bg' => '#ffc107', 'text' => '#212529', 'icon' => 'alert-circle'],
        'info' => ['bg' => '#17a2b8', 'text' => '#ffffff', 'icon' => 'info']
    ]
])

@if($message)
@php
    $config = $colors[$type] ?? $colors['success'];
@endphp

<div class="alert alert-{{ $type }} position-fixed top-0 end-0 m-3 d-flex align-items-center fade show"
     style="z-index: 9999; font-size:18px;
            background-color: {{ $config['bg'] }};
            color: {{ $config['text'] }};"
     role="alert">
  <div class="d-flex align-items-center">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-{{ $config['icon'] }} me-2">
      @if($type === 'success')
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
        <polyline points="22 4 12 14.01 9 11.01"></polyline>
      @elseif($type === 'danger')
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="15" y1="9" x2="9" y2="15"></line>
        <line x1="9" y1="9" x2="15" y2="15"></line>
      @elseif($type === 'warning')
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" y1="8" x2="12" y2="12"></line>
        <line x1="12" y1="16" x2="12.01" y2="16"></line>
      @else
        <circle cx="12" cy="12" r="10"></circle>
        <line x1="12" y1="16" x2="12" y2="12"></line>
        <line x1="12" y1="8" x2="12.01" y2="8"></line>
      @endif
    </svg>
    <span>{{ $message }}</span>
  </div>
  <button type="button" class="btn-close ms-auto" style="filter: brightness(0) invert(1);" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const alert = document.querySelector('.alert');
  if(alert) {
    setTimeout(() => {
      alert.classList.add('fade');
      setTimeout(() => alert.remove(), 150);
    }, 2000);
  }
});
</script>
@endif
