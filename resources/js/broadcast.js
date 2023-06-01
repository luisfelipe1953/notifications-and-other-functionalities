const getUrl = (notification, userId) => 'http://' + window.location.host + `${notification}/${userId}`;

function getNotificationElement(notificationType, read) {
    let suffix = read ? 'Read' : 'Unread';
    let element = '';
    switch (notificationType) {
        case 'App\\Notifications\\CreatedProductNotification':
            element = document.querySelector(`#createdProduct${suffix}`);
            break;
        case 'App\\Notifications\\AuthUserHasSentEmailsNotification':
            element = document.querySelector(`#authUserHasSentEmails${suffix}`);
            break;
        case 'App\\Notifications\\ReceiveEmailNotification':
            element = document.querySelector(`#receiveEmail${suffix}`);
            break;
        default:
            element = '';
    }
    return element;
}

// Función para obtener el mensaje de la notificación según su tipo
function getNotificationMessage(notificationType, data) {
    let message = '';
    switch (notificationType) {
        case 'App\\Notifications\\CreatedProductNotification':
            message = `<div class="text-gray-200 text-center text-sm mb-1.5">Se ha creado un nuevo producto: <span class="font-bold text-emerald-600">${data.product_name}</span>`;
            break;
        case 'App\\Notifications\\AuthUserHasSentEmailsNotification':
            message = `<div class="text-gray-200 text-center text-sm mb-1.5">Hola <span class="font-bold text-emerald-600">${data.user_name}, </span>has enviado un correo a todos los usuarios registrados`;
            break;
        case 'App\\Notifications\\ReceiveEmailNotification':
            message = `<div class="text-gray-200 text-center text-sm mb-1.5">Hola <span class="font-bold text-emerald-600">${data.user_name}, </span>has recibido un tipo de notificacion general por parte de <span class="font-bold text-emerald-600">${data.userAuthor_name}</span>`;
            break;
        default:
            message = '';
    }
    return message;
}

// Función para marcar una notificación como leída
function markNotificationAsRead(notificationId) {
    window.axios.post(getUrl('/read-notification', notificationId),
        { id: notificationId, user_id: userId })
        .then(response => {
            let notificationElements = document.querySelectorAll('.notification');
            notificationElements.forEach(function (element) {
                element.remove();
            });
            axiosInit();
        })
}

const userId = document.querySelector('#userId').value;
const toast = document.querySelector('#toast');
const responseNotification = await axios.get(getUrl('/api/notifications-unread', userId));
const notifications = responseNotification.data.data;
const notificationIds = notifications.map(notification => notification.id);

// Laravel Echo
window.Echo.channel('created-product-channel')
    .listen('.CreatedProduct', (data) => {
        toastNotify(toast, data.message);
        setTimeout(() => {
            toast.innerHTML = null;
        }, 5000);
        axiosInit();
    })

window.Echo.channel('email-submitted-channel')
    .listen('.EmailSubmitted', data => {
        toastNotify(toast, data.message);
        setTimeout(() => {
            toast.innerHTML = null;
        }, 5000);
        axiosInit();
    })

window.Echo.private(`file-upload-channel.${userId}`)
    .listen('.FileUpload', data => {
        toastNotify(toast, data.message);
        setTimeout(() => {
            toast.innerHTML = null;
        }, 5000);
        axiosInit();
    })

window.Echo.private(`restored-product-channel.${userId}`)
    .listen('.RestoredProduct', data => {
        toastNotify(toast, data.message);
        setTimeout(() => {
            toast.innerHTML = null;
        }, 5000);
        axiosInit();
    })

window.Echo.private(`softdeleted-product-channel.${userId}`)
    .listen('.SoftDeletedProduct', data => {
        toastNotify(toast, data.message);
        setTimeout(() => {
            toast.innerHTML = null;
        }, 5000);
        axiosInit();
    })



notificationIds.forEach(notificationId => {
    window.Echo.private(`notification-read-channel.${notificationId}`)
        .listen('.NotificationRead', data => {
            toastNotify(toast, data.message);
            setTimeout(() => {
                toast.innerHTML = null;
            }, 5000);
        })
})

function axiosInit() {
    window.axios.get(getUrl('/api/notifications-unread', userId))
        .then(response => {
            document.querySelector('.unread-notifications-count').innerHTML = `${response.data.data.length}`;

            response.data.data.forEach(notification => {

                let notificationType = notification.type;
                let notificationMessage = getNotificationMessage(notificationType, notification.data);

                let notificationElement = getNotificationElement(notificationType, false);

                let notificationId = `notification-${notification.id}`;
                if (document.querySelector(`#${notificationId}`) !== null) {
                    return;
                }

                notificationElement.innerHTML += `
                            <div id="${notificationId}" class="flex px-4 py-3 cursor-pointer bg-gray-800 hover:bg-gray-900 divide-y-3 border-red-900 notification" data-notification-id="${notification.id}">
                                <div class="w-full">
                                        ${notificationMessage}
                                        <div class="text-xs text-gray-400">
                                            ${notification.created_at}
                                        </div>
                                        <button class="text-xs text-cyan-900 hover:text-cyan-900 hover:underline mark-as-read" data-notification-id="${notification.id}">
                                            Marcar como leída
                                        </button>
                                    </div> 
                                </div> 
                            </div>
                        `;

                let markAsReadButtons = notificationElement.querySelectorAll('.mark-as-read');
                markAsReadButtons.forEach(function (button) {
                    button.addEventListener('click', function () {
                        let notificationId = this.dataset.notificationId;
                        markNotificationAsRead(notificationId);
                        this.disabled = true;
                    });
                });
            });
        })
    window.axios.get(getUrl('/api/notifications-read', userId))
        .then(response => {
            response.data.data.forEach(notification => {

                let notificationType = notification.type;
                let notificationMessage = getNotificationMessage(notificationType, notification.data);

                let notificationElement = getNotificationElement(notificationType, true);
                notificationElement.innerHTML += `
                            <div class="flex px-4 py-3 cursor-pointer bg-gray-800 hover:bg-gray-900 divide-y-3 border-red-900 notification">
                                <div class="w-full">
                                        ${notificationMessage}
                                        <div class="text-xs text-stone-400">
                                            ${notification.created_at}
                                        </div>
                                    </div> 
                                </div> 
                            </div>
                        `;
            });
        })
}

axiosInit()

function toastNotify(element, message) {
    element.innerHTML = `<div id="toast-success"
    class="flex absolute z-50 bottom-5 right-5 items-center w-full max-w-xs p-4 mb-4 text-gray-100 bg-gray-800 rounded-xl shadow"
    role="alert">
    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Check icon</span>
    </div>
    <div class="ml-3 text-sm font-normal">${message}</div>
    <button type="button"
        class="ml-auto -mx-1.5 -my-1.5 text-gray-400 hover:text-rose-500 focus:ring-2 focus:ring-gray-300 p-1.5 inline-flex h-8 w-8"
        data-dismiss-target="#toast-success" aria-label="Close">
        <span class="sr-only">Close</span>
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
    </button>
</div>
`;
}