function likePost(event) {
    if (event.target.classList.contains('like')) {
        const url = '/post/' + event.target.id + '/like'
        fetch(url)
            .then(response => {
                const status = response.status
                const badge = event.target.parentElement.children[0].children[0]
                if (status === 201) {
                    event.target.classList.replace('far', 'fas')
                    badge.innerText = parseInt(badge.innerText) + 1
                } else if (status === 202) {
                    event.target.classList.replace('fas', 'far')
                    badge.innerText = parseInt(badge.innerText) - 1
                }
            })
    }
}

const content = document.getElementsByClassName('content')[0]
content.addEventListener('click', likePost)