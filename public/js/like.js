function likePost(event) {
    const targetClassList = event.target.classList
    if (targetClassList.contains('like') &&
        !targetClassList.contains('guest')) {
        const url = '/like/' + event.target.id
        const csrfToken = document.querySelector('meta[name="_csrf"]').getAttribute('content')
        fetch(url, { method: 'POST', headers: { 'X-CSRF-Token': csrfToken } })
            .then(response => {
                const status = response.status
                const badge = event.target.nextElementSibling
                if (status === 201) {
                    event.target.classList.replace('far', 'fas')
                    badge.innerHTML = parseInt(badge.innerHTML) + 1
                } else if (status === 202) {
                    event.target.classList.replace('fas', 'far')
                    badge.innerHTML = parseInt(badge.innerHTML) - 1
                }
            })
    } else if (targetClassList.contains('guest')) {
        console.log('log in first pop up')
    }
}

const content = document.getElementsByClassName('content')[0]
content.addEventListener('click', likePost)