const depOrAg = document.getElementById('showDepForm') != null;
const currentForm = depOrAg ? document.getElementById('modifyDeps') : document.getElementById('modifyUsers');
const showBtn = depOrAg ? document.getElementById('showDepForm') : document.getElementById('showAgForm');
const toggleBtn = depOrAg ? document.getElementById('add-rm') : document.getElementById('promote-demote');
const toggleLabel = depOrAg ? toggleLabel : document.getElementById('promote-demoteLabel');
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
    if(toggleLabel.textContent === 'Add'){
        toggleLabel.textContent = 'Remove';
        actionInput.value ='remove';
    }
    else if(toggleLabel.textContent === 'Remove'){
        toggleLabel.textContent = 'Add';
        actionInput.value = 'add';
    }
    else if(toggleLabel.textContent === 'Promote'){
        toggleLabel.textContent = 'Demote';
        actionInput.value ='demote';
    }
    else if(toggleLabel.textContent === 'Demote'){
        toggleLabel.textContent = 'Promote';
        actionInput.value = 'promote';
    }
});
