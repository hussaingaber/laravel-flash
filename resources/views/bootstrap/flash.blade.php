@if(session()->has('flash_messages'))
    @php
        $message = session('flash_messages');
        $alertClass = match($message['type']) {
            'success' => 'alert-success',
            'error' => 'alert-danger',
            'warning' => 'alert-warning',
            'info' => 'alert-info',
            default => 'alert-info'
        };
        $iconClass = match($message['type']) {
            'success' => 'bi bi-check-circle-fill',
            'error' => 'bi bi-exclamation-triangle-fill',
            'warning' => 'bi bi-exclamation-circle-fill',
            'info' => 'bi bi-info-circle-fill',
            default => 'bi bi-info-circle-fill'
        };
        $dismissible = config('flash-notifications.dismissible', true);
        $duration = config('flash-notifications.animation_duration', 5000);
    @endphp

    @if(isset($message['overlay']) && $message['overlay'])
        {{-- Modal Overlay --}}
        <div class="modal fade" id="flashModal" tabindex="-1" aria-labelledby="flashModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="flashModalLabel">
                            <i class="{{ $iconClass }} me-2"></i>
                            {{ $message['title'] ?? 'Notice' }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{ $message['message'] }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var flashModal = new bootstrap.Modal(document.getElementById('flashModal'));
                flashModal.show();
            });
        </script>
    @else
        {{-- Regular Alert --}}
        <div class="alert {{ $alertClass }} {{ $dismissible ? 'alert-dismissible' : '' }} fade show flash-alert"
             role="alert"
             @if(isset($message['important']) && $message['important']) data-important="true" @endif>

            <div class="d-flex align-items-start">
                <i class="{{ $iconClass }} me-2 flex-shrink-0" style="margin-top: 2px;"></i>
                <div class="flex-grow-1">
                    @if($message['title'])
                        <h6 class="alert-heading mb-1">{{ $message['title'] }}</h6>
                    @endif
                    <div>{{ $message['message'] }}</div>
                </div>
            </div>

            @if($dismissible)
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            @endif
        </div>

        @if(!isset($message['important']) || !$message['important'])
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(function() {
                        var alert = document.querySelector('.flash-alert');
                        if (alert) {
                            var bsAlert = new bootstrap.Alert(alert);
                            bsAlert.close();
                        }
                    }, {{ $duration }});
                });
            </script>
        @endif
    @endif
@endif

<style>
    .flash-alert {
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        border: none;
        border-left: 4px solid;
    }

    .alert-success {
        border-left-color: #198754;
    }

    .alert-danger {
        border-left-color: #dc3545;
    }

    .alert-warning {
        border-left-color: #ffc107;
    }

    .alert-info {
        border-left-color: #0dcaf0;
    }

    .flash-alert .alert-heading {
        color: inherit;
        font-weight: 600;
    }

    @keyframes slideInDown {
        from {
            transform: translate3d(0, -100%, 0);
            visibility: visible;
        }
        to {
            transform: translate3d(0, 0, 0);
        }
    }

    .flash-alert.show {
        animation: slideInDown 0.3s ease-out;
    }
</style>
