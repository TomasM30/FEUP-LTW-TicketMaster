const departmentChangeForm = document.getElementById('modifyDeps');
const showBtn = document.getElementById('showDepForm');
const addToggleBtn = document.getElementById('add-rm');

showBtn.addEventListener('click', function(e){
    e.preventDefault();
    if(departmentChangeForm.style.display === 'none'){
        departmentChangeForm.style.display = 'block';
        showBtn.textContent = 'Hide form';
    } else {
        departmentChangeForm.style.display = 'none';
        showBtn.textContent = 'Add/Remove Departments';
    }
});

addToggleBtn.addEventListener('click', function(e){
    e.preventDefault();
    if(document.getElementById('add-rmLabel').textContent === 'Add'){
        document.getElementById('add-rmLabel').textContent = 'Remove';
        document.getElementById('action_input').value ='remove';
    }
    else {
        document.getElementById('add-rmLabel').textContent = 'Add';
        document.getElementById('action_input').value = 'add';
    }
});