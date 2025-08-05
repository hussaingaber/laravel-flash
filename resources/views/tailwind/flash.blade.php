@if(session()->has('flash_messages'))
    @php
        $message = session('flash_messages');
        $alertClasses = match($message['type']) {
            'success' => 'bg-green-50 text-green-800 border-green-200',
            'error' => 'bg-red-50 text-red-800 border-red-200',
            'warning' => 'bg-yellow-50 text-yellow-800 border-yellow-200',
            'info' => 'bg-blue-50 text-blue-800 border-blue-200',
            default => 'bg-blue-50 text-blue-800 border-blue-200'
        };
        $iconClasses = match($message['type']) {
            'success' => 'text-green-400',
            'error' => 'text-red-400',
            'warning' => 'text-yellow-400',
            'info' => 'text-blue-400',
            default => 'text-blue-400'
        };
        $dismissible = config('flash-notifications.dismissible', true);
        $duration = config('flash-notifications.animation_duration', 5000);
    @endphp

    @if(isset($message['overlay']) && $message['overlay'])
        {{-- Modal Overlay --}}
        <div id="flashModal" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full {{ str_replace('text-', 'bg-', $iconClasses) }} bg-opacity-20 sm:mx-0 sm:h-10 sm:w-10">
                                @if($message['type'] === 'success')
                                    <svg class="h-6 w-6 {{ $iconClasses }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                @elseif($message['type'] === 'error')
                                    <svg class="h-6 w-6 {{ $iconClasses }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @elseif($message['type'] === 'warning')
                                    <svg class="h-6 w-6 {{ $iconClasses }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                @else
                                    <svg class="h-6 w-6 {{ $iconClasses }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    {{ $message['title'] ?? 'Notice' }}
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">{{ $message['message'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" onclick="closeFlashModal()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-600 text-base font-medium text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function closeFlashModal() {
                document.getElementById('flashModal').style.display = 'none';
            }

            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('flashModal').style.display = 'block';
            });
        </script>
    @else
        {{-- Regular Alert --}}
        <div class="flash-alert rounded-md border-l-4 p-4 {{ $alertClasses }} shadow-sm transition-all duration-300 transform"
             @if(isset($message['important']) && $message['important']) data-important="true" @endif>
            <div class="flex">
                <div class="flex-shrink-0">
                    @if($message['type'] === 'success')
                        <svg class="h-5 w-5 {{ $iconClasses }}" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    @elseif($message['type'] === 'error')
                        <svg class="h-5 w-5 {{ $iconClasses }}" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    @elseif($message['type'] === 'warning')
                        <svg class="h-5 w-5 {{ $iconClasses }}" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    @else
                        <svg class="h-5 w-5 {{ $iconClasses }}" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>
                <div class="ml-3 flex-1">
                    @if($message['title'])
                        <h3 class="text-sm font-medium">{{ $message['title'] }}</h3>
                        <div class="mt-1 text-sm">{{ $message['message'] }}</div>
                    @else
                        <p class="text-sm">{{ $message['message'] }}</p>
                    @endif
                </div>
                @if($dismissible)
                    <div class="ml-auto pl-3">
                        <div class="-mx-1.5 -my-1.5">
                            <button type="button" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()" class="inline-flex rounded-md p-1.5 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-green-50 focus:ring-green-600">
                                <span class="sr-only">Dismiss</span>
                                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if(!isset($message['important']) || !$message['important'])
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    setTimeout(function() {
                        var alert = document.querySelector('.flash-alert');
                        if (alert) {
                            alert.style.transform = 'translateX(100%)';
                            alert.style.opacity = '0';
                            setTimeout(function() {
                                alert.remove();
                            }, 300);
                        }
                    }, {{ $duration }});
                });
            </script>
        @endif
    @endif
@endif

<style>
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    .flash-alert {
        animation: slideInRight 0.3s ease-out;
    }
</style>
