function setMaxAvaiableHeight() {
    const box = document.getElementById('msg-box')
    const sendMsg = document.getElementById('send-msg')

    const availableHeight = window.innerHeight - box.offsetTop - sendMsg.offsetHeight - 20
    console.log(availableHeight)
    box.style.height = availableHeight + 'px'
    box.scrollTop = box.scrollHeight
}

setMaxAvaiableHeight()
window.addEventListener('resize', setMaxAvaiableHeight)