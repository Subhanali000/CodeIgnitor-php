
<div class="container mt-5">
    <h2>User Management</h2>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <form method="get" class="mb-3">
        <div class="row">
            <div class="col">
                <label>Filter by Gender:</label><br>
                <label><input type="checkbox" name="gender[]" value="Male" <?= in_array('Male', $_GET['gender'] ?? []) ? 'checked' : '' ?>> Male</label>
                <label><input type="checkbox" name="gender[]" value="Female" <?= in_array('Female', $_GET['gender'] ?? []) ? 'checked' : '' ?>> Female</label>
            </div>

            <div class="col">
                <label>Filter by ID Proof:</label><br>
                <label><input type="checkbox" name="id_proof[]" value="Aadhar" <?= in_array('Aadhar', $_GET['id_proof'] ?? []) ? 'checked' : '' ?>> Aadhar</label>
                <label><input type="checkbox" name="id_proof[]" value="PAN" <?= in_array('PAN', $_GET['id_proof'] ?? []) ? 'checked' : '' ?>> PAN</label>
            </div>

            <div class="col">
                <label>Sort By:</label>
                <select name="sort_by" class="form-control">
                    <option value="name" <?= ($_GET['sort_by'] ?? '') === 'name' ? 'selected' : '' ?>>Name</option>
                    <option value="age" <?= ($_GET['sort_by'] ?? '') === 'age' ? 'selected' : '' ?>>Age</option>
                    <option value="email" <?= ($_GET['sort_by'] ?? '') === 'email' ? 'selected' : '' ?>>Email</option>
                </select>
            </div>

            <div class="col">
                <label>Sort Direction:</label>
                <select name="sort_dir" class="form-control">
                    <option value="asc" <?= ($_GET['sort_dir'] ?? '') === 'asc' ? 'selected' : '' ?>>Ascending</option>
                    <option value="desc" <?= ($_GET['sort_dir'] ?? '') === 'desc' ? 'selected' : '' ?>>Descending</option>
                </select>
            </div>

            <div class="col mt-4">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="/users" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <a href="/users/create" class="btn btn-success mb-3">Add New User</a>

    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Serial No.</th> <!-- Profile Picture Column -->
            <th>Profile</th> <!-- Profile Picture Column -->
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Gender</th>
            <th>ID Proof</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $serialNo = 1; ?> <!-- Initialize Serial Number -->
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $serialNo++ ?></td> <!-- Display Serial Number -->
                <td>
                    <?php if (!empty($user['profile_picture'])): ?>
                        <img src="<?= base_url('uploads/' . esc($user['profile_picture'])) ?>" alt="Profile Pic" style="width:60px; height:60px; object-fit:cover; border-radius:50%;">
                    <?php else: ?>
                        <span class="text-muted">No Image</span>
                    <?php endif; ?>
                </td>
                <td><?= esc($user['name']) ?></td>
                <td><?= esc($user['email']) ?></td>
                <td><?= esc($user['age']) ?></td>
                <td><?= esc($user['gender']) ?></td>
                <td><?= esc($user['id_proof']) ?></td>
                <td><?= esc($user['status']) ?></td>
                <td>
                    <a href="/users/edit/<?= $user['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="/users/delete/<?= $user['id'] ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    <?= $pager->links() ?>
</div>
