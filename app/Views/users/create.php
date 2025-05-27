<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>

    <div class="container mt-5">
        <h2>Create User</h2>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/users/store" method="post" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" value="<?= old('name') ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Age:</label>
                <input type="number" name="age" value="<?= old('age') ?>" class="form-control">
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?= old('email') ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Gender:</label><br>
                <label><input type="radio" name="gender" value="Male" <?= old('gender') == 'Male' ? 'checked' : '' ?>> Male</label>
                <label><input type="radio" name="gender" value="Female" <?= old('gender') == 'Female' ? 'checked' : '' ?>> Female</label>
                <label><input type="radio" name="gender" value="Other" <?= old('gender') == 'Other' ? 'checked' : '' ?>> Other</label>
            </div>

            <div class="form-group">
                <label>ID Proof:</label>
                <select name="id_proof" class="form-control" required>
                    <option value="Aadhar" <?= old('id_proof') == 'Aadhar' ? 'selected' : '' ?>>Aadhar</option>
                    <option value="PAN" <?= old('id_proof') == 'PAN' ? 'selected' : '' ?>>PAN</option>
                    <option value="Passport" <?= old('id_proof') == 'Passport' ? 'selected' : '' ?>>Passport</option>
                    <option value="Voter ID" <?= old('id_proof') == 'Voter ID' ? 'selected' : '' ?>>Voter ID</option>
                    <option value="Drivers License" <?= old('id_proof') == "Drivers License" ? 'selected' : '' ?>>Driver's License</option>
                </select>
            </div>

            <div class="form-group">
                <label>Qualifications:</label><br>
                <?php $qualifications = (array) old('qualifications'); ?>

                <label><input type="checkbox" name="qualifications[]" value="10th" <?= in_array('10th', $qualifications) ? 'checked' : '' ?>> 10th</label>
                <label><input type="checkbox" name="qualifications[]" value="12th" <?= in_array('12th', $qualifications) ? 'checked' : '' ?>> 12th</label>
                <label><input type="checkbox" name="qualifications[]" value="UG" <?= in_array('UG', $qualifications) ? 'checked' : '' ?>> UG</label>
                <label><input type="checkbox" name="qualifications[]" value="PG" <?= in_array('PG', $qualifications) ? 'checked' : '' ?>> PG</label>
                <label><input type="checkbox" name="qualifications[]" value="PhD" <?= in_array('PhD', $qualifications) ? 'checked' : '' ?>> PhD</label>
            </div>

            <div class="form-group">
                <label>Subjects:</label>
                <?php $subjects = (array) old('subjects'); ?>

                <select id="subjects" name="subjects[]" class="form-control" multiple required>
                    <option value="Tamil" <?= in_array('Tamil', $subjects) ? 'selected' : '' ?>>Tamil</option>
                    <option value="English" <?= in_array('English', $subjects) ? 'selected' : '' ?>>English</option>
                    <option value="Mathematics" <?= in_array('Mathematics', $subjects) ? 'selected' : '' ?>>Mathematics</option>
                    <option value="Physics" <?= in_array('Physics', $subjects) ? 'selected' : '' ?>>Physics</option>
                    <option value="Chemistry" <?= in_array('Chemistry', $subjects) ? 'selected' : '' ?>>Chemistry</option>
                    <option value="Botany" <?= in_array('Botany', $subjects) ? 'selected' : '' ?>>Botany</option>
                    <option value="Zoology" <?= in_array('Zoology', $subjects) ? 'selected' : '' ?>>Zoology</option>
                    <option value="Computer Science" <?= in_array('Computer Science', $subjects) ? 'selected' : '' ?>>Computer Science</option>
                </select>
                <small class="form-text text-muted">Select at least 3 subjects.</small>
            </div>

            <div class="form-group">
                <label>Status:</label><br>
                <input type="checkbox" name="status" id="statusToggle" value="Active" <?= old('status') == 'Active' ? 'checked' : '' ?>>
                <span id="statusText"><?= old('status') == 'Active' ? 'Active' : 'Inactive' ?></span>
            </div>

            <div class="form-group">
                <label>Profile Picture:</label>
                <input type="file" name="profile_picture" class="form-control-file">
            </div>

            <button type="submit" class="btn btn-primary">Create</button>
            <a href="/users" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusToggle = document.getElementById('statusToggle');
            const statusText = document.getElementById('statusText');
            const subjectSelect = document.getElementById('subjects');
            const maxSelections = 3;

            function updateStatusText() {
                if (statusToggle.checked) {
                    statusText.textContent = 'Active';
                } else {
                    statusText.textContent = 'Inactive';
                }
            }

            updateStatusText();
            statusToggle.addEventListener('change', updateStatusText);

            subjectSelect.addEventListener('change', function () {
                const selected = Array.from(subjectSelect.selectedOptions);
                if (selected.length > maxSelections) {
                    alert(`You can select a maximum of ${maxSelections} subjects.`);
                    selected[selected.length - 1].selected = false;
                }
            });
        });
    </script>

</body>

</html>
