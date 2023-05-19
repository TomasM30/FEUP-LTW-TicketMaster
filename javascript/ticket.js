import { encodeForAjax } from "../utils/ajax.js";

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
            statusName.style.color = 'green';
            agentButton.style.display = 'none';
            if(agentForm.style.display === 'block'){
                agentForm.style.display = 'none';
            }
            const response2 = await fetch('../actions/action_change_agent.php?ticket_id=' + document.getElementsByName('ticket_id')[0].value  + '&agent=None');
            const res2 = await response2.json();
            if(res2 === ''){
                agentName.textContent = 'Agent: ';
            }
        } else {
            agentButton.style.display = 'block';
            if(document.getElementById('status').value === 'Closed'){
                statusName.style.color = 'red';
            } else {
                statusName.style.color = '#be9801';
            }
        }

        updateLogs();
    }
});

agentForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    const response = await fetch('../actions/action_change_agent.php?ticket_id=' + document.getElementsByName('ticket_id')[0].value  + '&agent=' + document.getElementById('agent').value);
    const res = await response.json();
    if (res === '') {
        agentName.textContent = "Agent: " + document.getElementById('agent').value;
    }

    updateLogs();
});

departmentForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    const response = await fetch('../actions/action_change_department.php?ticket_id=' + document.getElementsByName('ticket_id')[0].value  + '&department=' + document.getElementById('department').value);
    const res = await response.json();
    console.log(res);
    if (res === '') {
        departmentName.textContent = (document.getElementById('department').value).length > 15 ?  (document.getElementById('department').value).substring(0, 15) + "..." : document.getElementById('department').value;
    }

    updateLogs();   
});

priorityForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    const response = await fetch('../actions/action_change_priority.php?ticket_id=' + document.getElementsByName('ticket_id')[0].value  + '&priority=' + document.getElementById('priority').value);
    const res = await response.json();
    console.log(res);
    if (res === '') {
        priorityName.textContent = 'Priority: ' + document.getElementById('priority').value;
    }
    updateLogs();
});

async function updateLogs() {
    const logs = document.querySelector(".log-list");

    const ticket_id = document.querySelector("#ticketId").value;

    const response = await fetch("../api/get_logs.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: encodeForAjax({
            id: ticket_id,
        }),
    }); 

    const data = await response.json();
    

    console.log(data);

    logs.innerHTML = "";

    for (const log of data) {;
        const logElement = document.createElement("li");
        
        const logDate = document.createElement("p");
        logDate.classList.add("log-date");

        logDate.innerHTML = log.date;

        const logContent = document.createElement("p");
        logContent.classList.add("log-content");

        logContent.innerHTML = log.content;

        logElement.appendChild(logDate);
        logElement.appendChild(logContent);

        logs.prepend(logElement);
    }
}

const responseForm = document.getElementById('comment');

responseForm.addEventListener('input', async () => {
    const content = responseForm.value;

    if (content.includes('#')) {
        const response = await fetch('../api/get_faq.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
        });

        const data = await response.json();

        const faq = document.getElementById('faq');

        faq.innerHTML = "";

        for (const qa of data) {
            const question = qa.question;
            const answer = qa.answer;

            const option = document.createElement('option');
            option.value = "#" + question;
            option.innerHTML = answer;

            faq.appendChild(option);
        }
    }
});
    
const editButton = document.querySelectorAll('.edit');

editButton.forEach(button => {
    button.addEventListener('click', async () => {
        const editForm = button.parentElement.querySelector('.editForm');

        if (editForm.style.display == 'none') {
            editForm.style.display = 'block';
        }
        else {
            editForm.style.display = 'none';
        }
    });
});