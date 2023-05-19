const form = document.getElementById('responseForm');
const ticketResponses = document.getElementById('responseDiv');
form.addEventListener('submit', async function (e) {
    e.preventDefault();
    const response = await fetch('../actions/action_add_response.php?content=' + document.getElementById('comment').value + '&ticket_id=' + document.getElementsByName('ticket_id')[0].value);
    const res = await response.json();
    if (res === '') {
        const responseDiv = document.createElement('div');

        const infoHeadingDiv = document.createElement('div');
        infoHeadingDiv.classList.add('infoHeading');

        const authorInfoDiv = document.createElement('div');
        authorInfoDiv.classList.add('authorInfo');

        const authorImage = document.createElement('img');
        authorImage.src = document.getElementsByName('imgPath')[0].value;
        authorImage.alt = 'User';
        authorImage.width = 50;
        authorImage.height = 50;
        authorInfoDiv.appendChild(authorImage);

        const authorHeading = document.createElement('h3');
        authorHeading.textContent = document.getElementsByName('author_username')[0].value;
        authorInfoDiv.appendChild(authorHeading);

        infoHeadingDiv.appendChild(authorInfoDiv);

        const dateParagraph = document.createElement('p');
        dateParagraph.textContent = new Date().toISOString().slice(0, 19).replace('T', ' ');
        infoHeadingDiv.appendChild(dateParagraph);

        responseDiv.appendChild(infoHeadingDiv);

        const contentBoxDiv = document.createElement('div');
        contentBoxDiv.classList.add('contentBox');

        const fieldset = document.createElement('fieldset');
        const legend = document.createElement('legend');
        legend.textContent = 'Answer';
        fieldset.appendChild(legend);

        const responseParagraph = document.createElement('p');
        responseParagraph.textContent = document.getElementById('comment').value;
        fieldset.appendChild(responseParagraph);

        contentBoxDiv.appendChild(fieldset);
        responseDiv.appendChild(contentBoxDiv);

        ticketResponses.appendChild(responseDiv);
        document.getElementById('comment').value = '';
        window.scrollTo({
            top: document.documentElement.scrollHeight,
            behavior: 'smooth'
        });
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
        openStatusMenu();
    }
});

agentForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    const response = await fetch('../actions/action_change_agent.php?ticket_id=' + document.getElementsByName('ticket_id')[0].value  + '&agent=' + document.getElementById('agent').value);
    const res = await response.json();
    if (res === '') {
        agentName.textContent = "Agent: " + document.getElementById('agent').value;
    }
    openAgentsMenu();
});

departmentForm.addEventListener('submit', async function (e) {
    e.preventDefault();
    const response = await fetch('../actions/action_change_department.php?ticket_id=' + document.getElementsByName('ticket_id')[0].value  + '&department=' + document.getElementById('department').value);
    const res = await response.json();
    console.log(res);
    if (res === '') {
        departmentName.textContent = (document.getElementById('department').value).length > 15 ?  (document.getElementById('department').value).substring(0, 15) + "..." : document.getElementById('department').value;
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

function openStatusMenu(){
    const form = document.getElementById('statusChangeForm');
    if (form.style.display === 'block') {
        form.style.display = 'none';
    } else {
        form.style.display = 'block';
    }
}

/*async function updateLogs() {
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
        const logElement = document.createElement("div  ");

        const logContent = document.createElement("p");
        logContent.classList.add("log-content");

        logContent.innerHTML = log.content;

        const logDate = document.createElement("p");
        logDate.classList.add("log-date");

        logDate.innerHTML = log.date;

        logElement.appendChild(logDate);
        logElement.appendChild(logContent);

        logs.appendChild(logElement);
    }

}

updateLogs();*/

