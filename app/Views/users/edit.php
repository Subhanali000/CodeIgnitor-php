<div class="container mt-5">
    <h2>Edit User</h2>

    <form action="/users/update/<?= $user['id'] ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Name:</label>
            <input type="text" name="name" value="<?= esc($user['name']) ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Age:</label>
            <input type="number" name="age" value="<?= esc($user['age']) ?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?= esc($user['email']) ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Password: <small>(Leave blank to keep existing)</small></label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label>Gender:</label>
            <select name="gender" class="form-control">
                <option value="Male" <?= $user['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $user['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
                <option value="Other" <?= $user['gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
            </select>
        </div>

        <div class="form-group">
            <label>ID Proof:</label>
            <select name="id_proof" class="form-control">
                <option value="Aadhar" <?= $user['id_proof'] == 'Aadhar' ? 'selected' : '' ?>>Aadhar</option>
                <option value="PAN" <?= $user['id_proof'] == 'PAN' ? 'selected' : '' ?>>PAN</option>
            </select>
        </div>

        <div class="form-group">
            <label>Qualifications:</label><br>
            <?php $quals = explode(',', $user['qualifications']); ?>
            <label><input type="checkbox" name="qualifications[]" value="BCA" <?= in_array('BCA', $quals) ? 'checked' : '' ?>> BCA</label>
            <label><input type="checkbox" name="qualifications[]" value="MCA" <?= in_array('MCA', $quals) ? 'checked' : '' ?>> MCA</label>
            <label><input type="checkbox" name="qualifications[]" value="BTech" <?= in_array('BTech', $quals) ? 'checked' : '' ?>> BTech</label>
        </div>

        <div class="form-group">
            <label>Subjects:</label><br>
            <?php $subs = explode(',', $user['subjects']); ?>
            <label><input type="checkbox" name="subjects[]" value="Math" <?= in_array('Math', $subs) ? 'checked' : '' ?>> Math</label>
            <label><input type="checkbox" name="subjects[]" value="Science" <?= in_array('Science', $subs) ? 'checked' : '' ?>> Science</label>
            <label><input type="checkbox" name="subjects[]" value="English" <?= in_array('English', $subs) ? 'checked' : '' ?>> English</label>
        </div>

        <div class="form-group">
            <label>Status:</label>
            <input type="checkbox" name="status" value="1" <?= $user['status'] == 'Active' ? 'checked' : '' ?>> Active
        </div>

        <div class="form-group">
            <label>Profile Picture:</label>
            <input type="file" name="profile_picture" class="form-control-file">
            <br>
            <?php if($user['profile_picture']): ?>
                <img src="/uploads/<?= esc($user['profile_picture']) ?>" width="100">
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="/users" class="btn btn-secondary">Cancel</a>
    </form>
</div>
