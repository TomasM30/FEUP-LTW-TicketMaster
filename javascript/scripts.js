function opacityPointerA(){
    const elements = document.querySelectorAll('footer, header, .profileContainer');
    for (let i = 0; i < elements.length; i++) {
        elements[i].style.pointerEvents = 'none';
        elements[i].style.opacity = '0.5';
    }
}
function opacityPointerD(){
    const elements = document.querySelectorAll('footer, header, .profileContainer');
    for (let i = 0; i < elements.length; i++) {
        elements[i].style.pointerEvents = '';
        elements[i].style.opacity = '';
    }
}

function openEmailForm() {
    opacityPointerA();
    document.getElementById('popupEmail').style.display = 'block';
}

function openPswForm() {
    opacityPointerA();
    document.getElementById('popupPsw').style.display = 'block';
}

function openInfoForm(){
    opacityPointerA();
    document.getElementById('popupName').style.display = 'block';
}
function openUserNameForm(){
    opacityPointerA();
    document.getElementById('popupUserName').style.display = 'block';
}

function closeForm() {
    opacityPointerD();
    document.getElementById('popupEmail').style.display = 'none';
    document.getElementById('popupPsw').style.display = 'none';
    document.getElementById('popupName').style.display = 'none';
    document.getElementById('popupUserName').style.display = 'none';
}

function scrollHContainer(scrollAmount,direction,container) {
    if(direction === 'left')
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    else
    container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
}

function openStatusMenu(){
    const form = document.getElementById('statusChangeForm');
    if (form.style.display === 'block') {
        form.style.display = 'none';
    } else {
        form.style.display = 'block';
    }
}
function openAgentsMenu(){
    const form = document.getElementById('agentChangeForm');
    if (form.style.display === 'block') {
        form.style.display = 'none';
    } else {
        form.style.display = 'block';
    }
}
function openDepartmentMenu(){
    const form = document.getElementById('departmentChangeForm');
    if (form.style.display === 'block') {
        form.style.display = 'none';
    } else {
        form.style.display = 'block';
    }
}
function openPriorityMenu(){
    const form = document.getElementById('priorityChangeForm');
    if (form.style.display === 'block') {
        form.style.display = 'none';
    } else {
        form.style.display = 'block';
    }
}


