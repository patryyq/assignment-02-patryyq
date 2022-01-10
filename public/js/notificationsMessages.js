var timeout
var firstNewMessage = true
var newMsgCount = 0

function displayNotification(data) {
    if (data[0] === 'store') {
        let exist = document.getElementById('notificationBox')
        if (exist != undefined) {
            exist.remove()
            clearTimeout(timeout)
        }

        changeUnreadMessageCount()
        appendOtherMessage(data)
        if (isNewMessageFromCurrentConversation(data[1][1])) return

        const body = document.getElementsByTagName('body')[0]
        const alertBox = renderAlertBox(data);
        body.appendChild(alertBox)

        timeout = setTimeout(closeNotification, 6000)
    } else if (data[0] === 'read') {
        const ticks = document.getElementsByClassName('fas fa-check')
        for (let i = 0; i < ticks.length; ++i) ticks[i].attributes.class.value = 'fas fa-check-double fas fa-check'
    }
}

function closeNotification() {
    const closeNotification = document.getElementById('notificationBox')
    closeNotification.remove()
    clearTimeout(timeout)
}

function isNewMessageFromCurrentConversation(currentUser) {
    const titleSection = document.getElementById('titleSection')
    const title = titleSection.firstElementChild.firstElementChild.innerText.split(': @')[1]

    return (title != undefined && title == currentUser) ? true : false
}

function removeNewMessageLine() {
    const titleSection = document.getElementById('titleSection')
    const username = titleSection.firstElementChild.firstElementChild.innerText.split(': @')[1]
    const newMsgLine = document.getElementById('hrNewMsg')

    if (newMsgLine != undefined) {
        const newMessages = document.getElementsByClassName('new-msg')
        for (let i = 0; i < newMessages.length; ++i) newMessages[i].attributes.class.value = 'bg-light p-3 rounded new-msg'
        newMsgLine.remove()
        firstNewMessage = true
        changeUnreadMessageCount(newMsgCount)
        sendRequestToMarkAsRead(username)
        newMsgCount = 0
    }
}

async function sendRequestToMarkAsRead(username) {
    const url = '/msg-read/' + username
    const csrfToken = document.querySelector('meta[name="_csrf"]').getAttribute('content')
    await fetch(url, { method: 'POST', headers: { 'X-CSRF-Token': csrfToken } })
}

function changeUnreadMessageCount(decrease = false) {
    unreadMsgPill = document.getElementById('msgCount')
    unreadMsgPill.innerText = decrease ? parseInt(unreadMsgPill.innerText) - decrease : parseInt(unreadMsgPill.innerText) + 1
}

function appendOtherMessage(data) {
    if (!isNewMessageFromCurrentConversation(data[1][1])) return

    const msgBox = document.getElementById('msg-box')
    if (firstNewMessage) displayLineAboveNewMsgs(msgBox)

    const message = renderMessage(data)
    msgBox.appendChild(message)
    msgBox.scrollTop = msgBox.scrollHeight
    ++newMsgCount
}

function renderMessage(data) {
    const a = document.createElement('a')
    const b = document.createElement('b')
    const divOuter = document.createElement('div')
    const div = document.createElement('div')
    const divText = document.createElement('div')

    a.setAttribute('href', '/messages/' + data[1][1])
    a.innerText = data[1][1]
    divOuter.setAttribute('class', 'm-3 col-8 float_left')
    divText.setAttribute('class', 'bg-light p-3 rounded border border-4 new-msg')
    divText.innerText = data[1][0]

    b.appendChild(a)
    div.appendChild(b)
    div.innerHTML += ', just now'
    div.appendChild(divText)
    divOuter.appendChild(div)
    return divOuter
}

function renderAlertBox(data) {
    const div = document.createElement('div')
    const button = document.createElement('button')
    const a = document.createElement('a')
    const b = document.createElement('a')

    a.setAttribute('href', '/messages/' + data[1][1])
    a.setAttribute('class', 'alert-link')
    b.setAttribute('href', '/messages/' + data[1][1])
    b.setAttribute('class', 'alert-link')
    b.setAttribute('style', 'text-decoration: underline;font-size:1.1rem')
    a.innerText = data[1][0].length > 30 ? data[1][0].substring(0, 30) + '...' : data[1][0]
    b.innerText = data[1][1]
    div.setAttribute('class', 'alert alert-info alert-dismissible border')
    div.setAttribute('style', 'margin: 0 auto; bottom: 30px;width: fit-content;position:fixed;left:0;right:0;padding:1rem 5rem 1rem 3rem')
    div.setAttribute('role', 'alert')
    div.setAttribute('id', 'notificationBox')
    button.setAttribute('type', 'button')
    button.setAttribute('id', 'closeNotification')
    button.setAttribute('class', 'btn-close')
    button.setAttribute('data-bs-dismiss', 'alert')
    button.setAttribute('aria-label', 'Close')
    div.innerText = 'You got a new message from '
    div.appendChild(b)
    div.innerHTML += ':'
    div.innerHTML += '<br>"'
    div.append(a, button)
    div.innerHTML += '"'
    return div
}

function displayLineAboveNewMsgs(msgBox) {
    const hr = document.createElement('hr')
    const divText = document.createElement('h6')
    const hrTextDiv = document.createElement('div')
    hrTextDiv.setAttribute('style', 'margin: 1.3rem auto 0 auto; width:80%;padding:1rem 1rem 0 1rem')
    divText.setAttribute('style', 'margin: 1.3rem auto 0 auto; width: fit-content;')
    divText.innerText = "New messages"
    hrTextDiv.setAttribute('id', 'hrNewMsg')
    hr.setAttribute('style', 'margin: 0.3rem auto 0.7rem auto; border: 0; border-top: 4px solid #005e71; width: 100%;')
    hrTextDiv.append(divText, hr)
    msgBox.appendChild(hrTextDiv)
    firstNewMessage = false
}

window.addEventListener('click', removeNewMessageLine)
const msgInput = document.getElementById('message_content')
if (msgInput != undefined) msgInput.focus()