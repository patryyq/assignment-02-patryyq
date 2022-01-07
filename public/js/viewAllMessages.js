const newMsg = document.getElementById('new-msg')
const titleSection = document.getElementById('titleSection')
newMsg.style = 'right:0;top:-' + (parseInt(titleSection.offsetTop) - 5) + 'px'

async function findUsername(event) {
    const targetId = event.target.id
    if (targetId === 'needle' && event.target.value.length > 0) {
        const url = '/username/' + event.target.value
        const csrfToken = document.querySelector('meta[name="_csrf"]').getAttribute('content')

        const response = await fetch(url, { headers: { 'X-CSRF-Token': csrfToken } })
        const data = await response.json();
        displayUsernames(data)
    } else {
        displayUsernames([])
    }
}

function displayUsernames(usernames) {
    const usernamesDiv = document.getElementById('usernamesResp')
    usernamesDiv.innerHTML = '';

    for (let i = 0; i < usernames.length; ++i) {
        usernamesDiv.innerHTML = usernamesDiv.innerHTML + '<a href="/messages/' + usernames[i].username + '"><div class="hoverUsername form-control mt-1">' + usernames[i].username + '</div></a>'
    }
}

const usernameInputField = document.getElementById('needle')
usernameInputField.addEventListener('keyup', findUsername)