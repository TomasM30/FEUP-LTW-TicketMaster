function openForm() {
    var elements = document.querySelectorAll('footer, header, .profileContainer');
    for (var i = 0; i < elements.length; i++) {
        elements[i].style.pointerEvents = 'none';
        elements[i].style.opacity = '0.5';
    }
    document.getElementById('popup').style.display = 'block';
}

function closeForm() {
    var elements = document.querySelectorAll('footer, header, .profileContainer');
    for (var i = 0; i < elements.length; i++) {
        elements[i].style.pointerEvents = '';
        elements[i].style.opacity = '';
    }
    document.getElementById('popup').style.display = 'none';
}
