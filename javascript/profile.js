emailForm = document.getElementById('emailForm');
userEmail = document.getElementById('userEmail');
nameForm = document.getElementById('nameForm');
nameUser = document.getElementById('user_name');

emailForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    const response = await fetch('../actions/action_change_email.php?email=' + document.getElementById('email').value);
    const res = await response.json();
    if (res === '') {
        userEmail.textContent = document.getElementById('email').value;
        document.getElementById('email').value = '';
        closeForm();
    }
    else {
        alert(res);
    }
});

nameForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    const response = await fetch('../actions/action_change_name.php?name=' + document.getElementById('name').value);
    const res = await response.json();
    if (res === '') {
        nameUser.textContent = document.getElementById('name').value;
        document.getElementById('name').value = '';
        closeForm();
    } else {
        alert(res);
    }
});