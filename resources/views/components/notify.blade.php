@auth
    <button id="dropdownNotificationButton" data-dropdown-toggle="dropdownNotification"
        class="inline-flex items-center relative top-0 text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none"
        type="button">
        <div class="p-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="text-gray-600 w-8 h-8" viewBox="0 0 16 16">
                <path
                    d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z" />
            </svg>
        </div>
        @if (auth()->user()->unreadNotifications())
            <span class="absolute bg-rose-500 rounded-full left-6 top-3 w-4 h-4">
                <span class="text-white font-bold absolute unread-notifications-count"
                    style="bottom:-1px; left:5px;font-size:12px;">
                </span>
            </span>
        @endif
    </button>
    <!-- Dropdown menu -->
    <div id="dropdownNotification" class="z-20 hidden w-full max-w-sm bg-white divide-y divide-gray-100 rounded-b-lg shadow"
        aria-labelledby="dropdownNotificationButton">
        <div class="block px-4 py-2 text-xl text-center font-bold text-cyan-400 bg-gray-900">
            Notificaciones
        </div>
        <div class="divide-y divide-gray-700 ">
            @if (count(auth()->user()->notifications) > 0)
                @if (count(auth()->user()->unreadNotifications) > 0)
                    <div id="createdProductUnread"></div>
                    <div id="authUserHasSentEmailsUnread"></div>
                    <div id="receiveEmailUnread"></div>
                    @if (count(auth()->user()->readNotifications) > 0)
                        <div class="block px-4 py-2 font-bold text-xl text-center text-cyan-400 bg-gray-900">
                            Notificaciones leídas
                        </div>
                        <div id="createdProductRead"></div>
                        <div id="authUserHasSentEmailsRead"></div>
                        <div id="receiveEmailRead"></div>
                    @endif
                @elseif(count(auth()->user()->readNotifications) > 0)
                    <div class="block px-4 font-medium py-2 text-sm bg-gray-800 text-center text-gray-400">
                        Sin nuevas notificaciones
                    </div>
                    <div class="block px-4 py-2 font-bold text-xl text-center text-cyan-400 bg-gray-900">
                        Notificaciones leídas
                    </div>
                    <div id="createdProductRead"></div>
                    <div id="authUserHasSentEmailsRead"></div>
                    <div id="receiveEmailRead"></div>
                @endif
            @else
                <div class="block px-4 font-medium py-2 text-sm bg-gray-800 text-center text-gray-400">
                    Sin notificaciones
                </div>
            @endif

        </div>
        <a href="{{ route('markAsRead') }}"
            class="block py-2 text-sm font-bold text-center text-gray-100 rounded-b-lg bg-gray-900 hover:text-cyan-400">
            <div class="inline-flex items-center mt-2">
                <svg class="w-4 h-4 mr-2 mt-1 text-cyan-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                    <path fill-rule="evenodd"
                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                        clip-rule="evenodd"></path>
                </svg>
                
                <p>Marcar como leídas</p>
            </div>
        </a>
    </div>
@endauth
