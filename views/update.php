<div class="row">
    <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Update User</h4>
        <a href="/"><i class="bi bi-arrow-left"></i> Go back</a>
        <form class="form" id="js-update-form">
            <div class="row g-3">
                <div class="col-sm-6">
                    <label for="userid" class="form-label">User ID</label>
                    <input type="text" class="form-control" id="userid" value="<?= $user['userid']; ?>" required disabled>
                </div>
                <div class="col-sm-12">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="<?= $user['name']; ?>" required>
                    <div class="invalid-feedback">Valid name is required.</div>
                </div>
                <div class="col-sm-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="<?= $user['email']; ?>" required>
                    <div class="invalid-feedback">Valid email is required.</div>
                </div>
                <div class="col-sm-12">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="number" name="phone" class="form-control" id="phone" value="<?= $user['phone']; ?>" required>
                    <div class="invalid-feedback">Valid phone is required.</div>
                </div>
                <div class="col-sm-12">
                    <h6 class="mb-3">User Group</h6>
                    <?php foreach ($groups as $i => $group) { ?>
                    <div class="form-check">
                        <input type="checkbox" name="usergroup[]" class="form-check-input js-user-group-checkbox" id="user-group-<?= $i + 1; ?>" value="<?= $group['groupid']; ?>" <?= in_array($group['groupid'], $user_groups) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="user-group-<?= $i + 1; ?>"><?= $group['groupname']; ?></label>
                    </div>
                    <?php } ?>
                </div>  
            </div>
            <hr class="my-4">
            <button type="button" class="w-100 btn btn-success btn-lg js-update-user" data-userid="<?= $user['userid']; ?>">Update</button>
        </form>
    </div>
</div>
<script>
const updateUser = () => {
    const updateForm = document.getElementById('js-update-form');
    const updateFormButton = document.querySelector('.js-update-user');
    updateFormButton.addEventListener('click', (event) => {
        if (!validateCheckbox()) {
            let firstCheckbox = document.querySelector('.js-user-group-checkbox');
            firstCheckbox.setCustomValidity('At least one checkbox must be selected.');
            updateForm.reportValidity();
            return false;
        }

        let userId = event.target.dataset.userid;
        let formEntries = {
            name: document.querySelector('input[name="name"]').value,
            email: document.querySelector('input[name="email"]').value,
            phone: document.querySelector('input[name="phone"]').value,
            usergroups: Array.from(document.querySelectorAll('.form-check-input:checked')).map((elem) => elem.value),
        };

        fetch('/api/users/' + userId, {
            method: 'PATCH',
            body: JSON.stringify(formEntries),
            headers: {'Content-Type': 'application/json', 'Accept': 'application/json', },
        }).then(response => response.json()).then(data => {
            if (data.rows > 0) {
                alert('User updated');
            }
        });
    });
};

const validateCheckbox = () => {
    let switches = [];
    let checkboxes = document.querySelectorAll('.js-user-group-checkbox');
    checkboxes.forEach(checkbox => {
        switches.push(+ checkbox.checked);
    });
    switches = switches.reduce((partialSum, a) => partialSum + a, 0);

    return switches > 0;
};



window.addEventListener('DOMContentLoaded', () => {
    updateUser();
});
</script>