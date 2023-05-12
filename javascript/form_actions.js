function openEmailForm() {
    var elements = document.querySelectorAll('footer, header, .profileContainer');
    for (var i = 0; i < elements.length; i++) {
        elements[i].style.pointerEvents = 'none';
        elements[i].style.opacity = '0.5';
    }
    document.getElementById('popupEmail').style.display = 'block';
}

function openPswForm() {
    var elements = document.querySelectorAll('footer, header, .profileContainer');
    for (var i = 0; i < elements.length; i++) {
        elements[i].style.pointerEvents = 'none';
        elements[i].style.opacity = '0.5';
    }
    document.getElementById('popupPsw').style.display = 'block';
}

function closeForm() {
    var elements = document.querySelectorAll('footer, header, .profileContainer');
    for (var i = 0; i < elements.length; i++) {
        elements[i].style.pointerEvents = '';
        elements[i].style.opacity = '';
    }
    document.getElementById('popupEmail').style.display = 'none';
    document.getElementById('popupPsw').style.display = 'none';

}
