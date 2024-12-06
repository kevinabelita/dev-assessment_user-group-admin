<div class="row">
    <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Add User</h4>
        <a href="/"><i class="bi bi-arrow-left"></i> Go back</a>
        <form class="form" id="js-add-form">
            <div class="row g-3">
                <div class="col-sm-12">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                    <div class="invalid-feedback">Valid name is required.</div>
                </div>
                <div class="col-sm-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                    <div class="invalid-feedback">Valid email is required.</div>
                </div>
                <div class="col-sm-12">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="number" name="phone" class="form-control" id="phone" required>
                    <div class="invalid-feedback">Valid phone is required.</div>
                </div>
                <div class="col-sm-12">
                    <h6 class="mb-3">User Group</h6>
                    <?php foreach ($groups as $i => $group) { ?>
                    <div class="form-check">
                        <input type="checkbox" name="usergroup[]" class="form-check-input js-user-group-checkbox" id="user-group-<?= $i + 1; ?>" value="<?= $group['groupid']; ?>">
                        <label class="form-check-label" for="user-group-<?= $i + 1; ?>"><?= $group['groupname']; ?></label>
                    </div>
                    <?php } ?>
                </div>  
            </div>
            <hr class="my-4">
            <button type="button" class="w-100 btn btn-success btn-lg js-add-user">Add</button>
        </form>
    </div>
</div>
<script>
const addUser = () => {
    const addForm = document.getElementById('js-add-form');
    const addFormButton = document.querySelector('.js-add-user');
    addFormButton.addEventListener('click', (event) => {
        if (!validateCheckbox()) {
            let firstCheckbox = document.querySelector('.js-user-group-checkbox');
            firstCheckbox.setCustomValidity('At least one checkbox must be selected.');
            addForm.reportValidity();
            return false;
        }

        let formEntries = {
            name: document.querySelector('input[name="name"]').value,
            email: document.querySelector('input[name="email"]').value,
            phone: document.querySelector('input[name="phone"]').value,
            usergroups: Array.from(document.querySelectorAll('.form-check-input:checked')).map((elem) => elem.value),
        };

        fetch('/api/users', {
            method: 'POST',
            body: JSON.stringify(formEntries),
            headers: {'Content-Type': 'application/json', 'Accept': 'application/json', },
        }).then(response => response.json()).then(data => {
            if (data.userid > 0) {
                alert('User created');
                window.location.href = '/';
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
    addUser();
});
</script>