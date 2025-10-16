import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '2f781955a5e3c4f265c4',
    cluster: 'mt1',
    forceTLS: true
});




console.log('hello echo js');

// window.Echo.join(`room_online`)
//     .here((users) => {
//       console.log('Here : ');
//       console.log(users);
//     })
//     .joining((user) => {
//         console.log('joining');
//         console.log(user);
//     })
//     .leaving((user) => {
//         console.log('leaving');
//         console.log(user);
//     })
//     .error((error) => {
//         console.log('error');
//         console.error(error);
//     });



window.Echo.join(`room_online`)
    .here((users) => {
        console.log('Here:', users);
        updateOnlineUsers(users);
    })
    .joining((user) => {
        console.log('Joining:', user);
        addOnlineUser(user);
    })
    .leaving((user) => {
        console.log('Leaving:', user);
        removeOnlineUser(user.id);
    })
    .error((error) => {
        console.log('Error:', error);
    });

function updateOnlineUsers(users) {
    let container = $(".admin-online");
    container.empty();
    users.forEach(user => {
        addOnlineUser(user);
    });
}

function addOnlineUser(user) {
    const baseUrl = window.location.origin;
    let image=`${baseUrl}/uploads/${user.image}`;
    let userHTML = `
        <div class="box-online" id="user-${user.id}">
            <div class="user-holder">
                <div class="img-holder">
                    <img src="${  image ? image: 'https://hosp.const-tech.in/admin-asset/img/no-image.jpeg'}" alt="">
                </div>
                <h6 class="title">${user.name}</h6>
            </div>
               <div class="icon-holder">
                    <svg class="svg-inline--fa fa-circle fa-beat-fade" aria-hidden="true"
                            focusable="false" data-prefix="fas" data-icon="circle" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                            <path fill="currentColor"
                                d="M512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256z">
                            </path>
                    </svg>
                </div>
        </div>
    `;
    $(".admin-online").append(userHTML);
}

function removeOnlineUser(userId) {
    $(`#user-${userId}`).remove();
}
