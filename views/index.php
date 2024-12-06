<h1>User Management</h1>
<a href="/add" class="btn btn-success">Add User</a>
<table class="table">
    <thead>
        <tr>
            <th scope="col">User ID</th>
            <th scope="col">Email</th>
            <th scope="col">Name</th>
            <th scope="col">Phone</th>
            <th scope="col">Group</th>
            <th scope="col"><small>Actions</small></th>
        </tr>
    </thead>
    <tbody id="table-data">
        <tr class="loader">
            <td colspan="6">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </td>
        </tr>
    </tbody>
    <template id="table-rows">
        <tr class="table-row" scope="row">
            <td class="user-id"></td>
            <td class="email"></td>
            <td class="name"></td>
            <td class="phone"></td>
            <td class="user-group"></td>
            <td class="actions">
                <a href="#" class="btn btn-sm btn-primary update-user" title="Update">Update</a>
                <button href="#" class="btn btn-sm btn-danger js-delete-user">Delete</button>
            </td>
        </tr>
    </template>
</table>
<script>
const loadUsers = async () => {
    let dataContainer = document.getElementById('table-data');
    let spinner = document.querySelector('.loader')
    spinner.classList.remove('d-none');
    [...dataContainer.children].forEach(child => child !== spinner ? dataContainer.removeChild(child) : null);

    await fetch('/api/users', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    }).then(response => response.json()).then(data => {
        
        let rowContainer = document.getElementById('table-rows');
        data.forEach(rowData => {
            let rowItem = rowContainer.content.firstElementChild.cloneNode(true);
            rowItem.querySelector('.user-id').innerHTML = rowData.userid;
            rowItem.querySelector('.email').innerHTML = rowData.email;
            rowItem.querySelector('.name').innerHTML = rowData.name;
            rowItem.querySelector('.phone').innerHTML = rowData.phone;
            rowItem.querySelector('.user-group').innerHTML = rowData.usergroups;
            rowItem.querySelector('.actions .update-user').setAttribute('href', '/update/' + rowData.userid);
            rowItem.querySelector('.actions .js-delete-user').setAttribute('data-userid', rowData.userid);
            dataContainer.appendChild(rowItem);
        });
        spinner.classList.add('d-none');
    });
};

const deleteUser = () => {
    document.body.addEventListener('click', (event) => {
        if (event.target.classList.contains('js-delete-user')) {
            let id = event.target.dataset.userid;
            if (confirm('Are you sure you want to delete this user?')) {
                fetch('/api/users/' + id, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                }).then(response => response.json()).then(data => {
                    loadUsers();
                });
            }
        }
    });
};

window.addEventListener('DOMContentLoaded', () => {
    loadUsers();
    deleteUser();
});
</script>