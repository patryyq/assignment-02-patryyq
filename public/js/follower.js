function followUser(event) {
    const targetClassList = event.target.classList
    if (targetClassList.contains('follow') &&
        !targetClassList.contains('guest')) {
        const url = '/follower/' + event.target.id
        const csrfToken = document.querySelector('meta[name="_csrf"]').getAttribute('content')
        fetch(url, { method: 'POST', headers: { 'X-CSRF-Token': csrfToken } })
            .then(response => {
                const status = response.status
                const badge = event.target.nextElementSibling
                if (status === 201) {
                    event.target.classList.replace('btn-outline-dark', 'btn-dark')
                    event.target.innerText = 'Following'
                    badge.innerHTML = parseInt(badge.innerHTML) + 1
                } else if (status === 202) {
                    event.target.classList.replace('btn-dark', 'btn-outline-dark')
                    event.target.innerText = 'Follow'
                    badge.innerHTML = parseInt(badge.innerHTML) - 1
                }
            })
    } else if (targetClassList.contains('guest')) {
        console.log('log in first pop up')
    }
}

const titleSection = document.getElementById('titleSection')
if (titleSection != null) titleSection.addEventListener('click', followUser)

const explore = document.getElementById('explore')
if (explore != null) explore.addEventListener('click', followUser)

const dmButton = document.getElementsByName('send_dm')[0]
function sendMessageRedirect(evnt) {
    const username = evnt.target.id
    window.location.href = '/messages/' + username
}

dmButton.addEventListener('click', sendMessageRedirect)