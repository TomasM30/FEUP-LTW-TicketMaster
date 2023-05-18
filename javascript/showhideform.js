const depOrAg = document.getElementById('showDepForm') != null;
const currentForm = depOrAg ? document.getElementById('modifyDeps') : document.getElementById('modifyUsers');
const showBtn = depOrAg ? document.getElementById('showDepForm') : document.getElementById('showAgForm');
const toggleBtn = depOrAg ? document.getElementById('add-rm') : document.getElementById('promote-demote');
const actionInput = document.getElementById('action_input');

showBtn.addEventListener('click', function(e){
    e.preventDefault();
    if(currentForm.style.display === 'none'){
        currentForm.style.display = 'block';
        showBtn.textContent = 'Hide form';
    } else {
        currentForm.style.display = 'none';
        showBtn.textContent = depOrAg ? 'Add/Remove Departments' : 'Promote/Demote Users';
    }
});

toggleBtn.addEventListener('click', function(e){
    e.preventDefault();
    if(toggleBtn.textContent === 'Add'){
        toggleBtn.textContent = 'Remove';
        actionInput.value ='remove';
    }
    else if(toggleBtn.textContent === 'Remove'){
        toggleBtn.textContent = 'Add';
        actionInput.value = 'add';
    }
    else if(toggleBtn.textContent === 'Promote'){
        toggleBtn.textContent = 'Demote';
        actionInput.value ='demote';
    }
    else if(toggleBtn.textContent === 'Demote'){
        toggleBtn.textContent = 'Promote';
        actionInput.value = 'promote';
    }
});
