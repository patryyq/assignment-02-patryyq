var timeout
var firstNewMessage = true
var newMsgCount = 0

function displayNotification(data) {
    let exist = document.getElementById('notificationBox')
    if (exist != undefined) {
        exist.remove()
        clearTimeout(timeout)
    }

    changeUnreadMessageCount()
    appendOtherMessage(data)
    if (isNewMessageFromCurrentConversation(data[1])) return

    const body = document.getElementsByTagName('body')[0]
    const div = document.createElement('div')
    const button = document.createElement('button')
    const a = document.createElement('a')
    const b = document.createElement('a')

    a.setAttribute('href', '/messages/' + data[1])
    a.setAttribute('class', 'alert-link')
    b.setAttribute('href', '/messages/' + data[1])
    b.setAttribute('class', 'alert-link')
    b.setAttribute('style', 'text-decoration: underline;font-size:1.1rem')
    a.innerText = data[0].length > 30 ? data[0].substring(0, 30) + '...' : data[0]
    b.innerText = data[1]
    div.setAttribute('class', 'alert alert-warning alert-dismissible border')
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
    body.appendChild(div)

    timeout = setTimeout(closeNotification, 5000)
}

function closeNotification() {
    const closeNotification = document.getElementById('notificationBox')
    closeNotification.remove()
    clearTimeout(timeout)
}

function changeUnreadMessageCount(decrease = false) {
    unreadMsgPill = document.getElementById('msgCount')
    unreadMsgPill.innerText = decrease ? parseInt(unreadMsgPill.innerText) - decrease : parseInt(unreadMsgPill.innerText) + 1
}

function appendOtherMessage(data) {
    if (!isNewMessageFromCurrentConversation(data[1])) return
    const msgBox = document.getElementById('msg-box')
    if (firstNewMessage) displayLineAboveNewMsgs(msgBox)

    const a = document.createElement('a')
    const b = document.createElement('b')
    const divOuter = document.createElement('div')
    const div = document.createElement('div')
    const divText = document.createElement('div')

    a.setAttribute('href', '/messages/' + data[1])
    a.innerText = data[1]
    divOuter.setAttribute('class', 'm-3 col-8 float_left')
    divText.setAttribute('class', 'bg-light p-3 rounded')
    divText.innerText = data[0]

    b.appendChild(a)
    div.appendChild(b)
    div.innerHTML += ', just now'
    div.appendChild(divText)
    divOuter.appendChild(div)
    msgBox.appendChild(divOuter)
    msgBox.scrollTop = msgBox.scrollHeight

    ++newMsgCount
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
    console.log('ad')
    firstNewMessage = false
}

function isNewMessageFromCurrentConversation(currentUser) {
    const titleSection = document.getElementById('titleSection')
    const title = titleSection.firstElementChild.firstElementChild.innerText.split(': ')[1]
    console.log(title)
    return (title != undefined && title == currentUser) ? true : false
}

function removeNewMessageLine() {
    const titleSection = document.getElementById('titleSection')
    const username = titleSection.firstElementChild.firstElementChild.innerText.split(': ')[1]
    const newMsgLine = document.getElementById('hrNewMsg')
    if (newMsgLine != undefined) {
        newMsgLine.remove()
        firstNewMessage = true
        changeUnreadMessageCount(newMsgCount)
        newMsgCount = 0;
        sendRequestToMarkAsRead(username)
    }
}

async function sendRequestToMarkAsRead(username) {
    const url = '/msg-read/' + username
    const csrfToken = document.querySelector('meta[name="_csrf"]').getAttribute('content')

    const response = await fetch(url, { method: 'POST', headers: { 'X-CSRF-Token': csrfToken } })
    const data = await response.text();
    console.log(data)
}

window.addEventListener('click', removeNewMessageLine)

//     // Example 1 - Event Channel
//     Echo.channel('events')
//         .listen('RealTimeMessage', (e) => console.log('RealTimeMessage: ' + e.message));

//   //  Example 2 - Private Event Channel
//     Echo.private('events')
//         .listen('RealTimeMessage', (e) => console.log('Private RealTimeMessage: ' + e.message));

//  Example 3 - Notification
Echo.private('App.Models.User.{{Auth::id()}}')
    .notification((notification) => {
        console.log(notification.message, notification.user);
        let data = [notification.message, notification.user];
        displayNotification(data)
        return data;
    });