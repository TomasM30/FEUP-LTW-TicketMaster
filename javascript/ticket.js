const form = document.getElementById('responseForm');
const ticketResponses = document.getElementById('responseDiv');
form.addEventListener('submit', async function (e) {
    e.preventDefault();
    const response = await fetch('../actions/action_add_response.php?content=' + document.getElementById('comment').value + '&ticket_id=' + document.getElementsByName('ticket_id')[0].value);
    const res = await response.json();
    if (res === '') {
        const responseDiv = document.createElement('div');
        responseDiv.classList.add('response');

        const authorParagraph = document.createElement('p');
        authorParagraph.textContent = "User: " + document.getElementsByName('author_username')[0].value;

        const dateParagraph = document.createElement('p');
        dateParagraph.textContent = new Date().toISOString().slice(0, 19).replace('T', ' ');

        const responseParagraph = document.createElement('p');
        responseParagraph.textContent = "Answer: " + document.getElementById('comment').value;

        responseDiv.appendChild(authorParagraph);
        responseDiv.appendChild(dateParagraph);
        responseDiv.appendChild(responseParagraph);

        ticketResponses.appendChild(responseDiv);
        document.getElementById('comment').value = '';
    } else {
        alert(res);
    }
});

const statusForm = document.getElementById('statusChangeForm');
const statusName = document.getElementById('ticketStatus');
const agentForm = document.getElementById('agentChangeForm');
const agentName = document.getElementById('ticketAgent');
const departmentForm = document.getElementById('departmentChangeForm');
const departmentName = document.getElementById('ticketDepartment');
const priorityForm = document.getElementById('priorityChangeForm');
const priorityName = document.getElementById('ticketPriority');


statusForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    const response = await fetch('../actions/action_change_status.php?ticket_id=' + document.getElementsByName('ticket_id')[0].value  + '&ticket_status=' + document.getElementById('status').value);
    const res = await response.json();
    if (res === '') {
        const agentButton = document.getElementById('agentEdit');
        const agentForm = document.getElementById('agentChangeForm');
        statusName.textContent = document.getElementById('status').value;
        if(document.getElementById('status').value === 'Open'){
            agentButton.style.display = 'none';
            if(agentForm.style.display === 'block'){
                agentForm.style.display = 'none';
            }
            const response2 = await fetch('../actions/action_change_agent.php?ticket_id=' + document.getElementsByName('ticket_id')[0].value  + '&agent=None');
            const res2 = await response2.json();
            if(res2 === ''){
                agentName.textContent = 'Assigned agent: ';
            }
        } else {
            agentButton.style.display = 'block';
        }
        openStatusMenu();
    }
});

agentForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    const response = await fetch('../actions/action_change_agent.php?ticket_id=' + document.getElementsByName('ticket_id')[0].value  + '&agent=' + document.getElementById('agent').value);
    const res = await response.json();
    if (res === '') {
        agentName.textContent = 'Assigned agent: ' + document.getElementById('agent').value;
    }
    openAgentsMenu();
});

departmentForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    const response = await fetch('../actions/action_change_department.php?ticket_id=' + document.getElementsByName('ticket_id')[0].value  + '&department=' + document.getElementById('department').value);
    const res = await response.json();
    console.log(res);
    if (res === '') {
        departmentName.textContent = 'Department: ' + document.getElementById('department').value;
    }
    openDepartmentMenu();
});

priorityForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    const response = await fetch('../actions/action_change_priority.php?ticket_id=' + document.getElementsByName('ticket_id')[0].value  + '&priority=' + document.getElementById('priority').value);
    const res = await response.json();
    console.log(res);
    if (res === '') {
        priorityName.textContent = 'Priority: ' + document.getElementById('priority').value;
    }
    openPriorityMenu();
});