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
        console.log('followed')
    } else if (targetClassList.contains('guest')) {
        console.log('log in first pop up')
    }
}

const titleSection = document.getElementById('titleSection')
titleSection.addEventListener('click', followUser)