import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


function sendPlaylistRequest(animeId, status) {
    const token = document.head.querySelector('meta[name="csrf-token"]').getAttribute('content');
    fetch('/playlist', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify({status: status, animeId: animeId})
        }
    ).then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        console.log(response);
    })
        .catch(error => {
            console.error('There was a problem with the request:', error);
        });
}

window.sendPlaylistRequest = sendPlaylistRequest;

