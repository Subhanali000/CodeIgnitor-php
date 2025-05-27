<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class UserController extends Controller
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->orderBy('name', 'ASC')->paginate(10);
        $data['pager'] = $model->pager;

        // Convert status to Active/Inactive and id_proof to readable name
        foreach ($data['users'] as &$user) {
            $user['status'] = $model->getStatusLabel($user['status']);
            $user['id_proof'] = $model->getIdProofLabel($user['id_proof']);
        }

        echo view('templates/header');
        echo view('users/index', $data);
        echo view('templates/footer');
    }

    public function create()
    {
        echo view('templates/header');
        echo view('users/create');
        echo view('templates/footer');
    }

    public function store()
{
    helper(['form', 'url']);
    $model = new UserModel();
    $validation = \Config\Services::validation();

    // Validation rules
    $validation->setRules([
        'name'            => 'required|min_length[3]',
        'email'           => 'required|valid_email|is_unique[users.email]',
        'password'        => 'required|min_length[8]|regex_match[/(?=.*\d)(?=.*[@#$%^&+=])/]',
        'gender'          => 'required|in_list[Male,Female,Other]',
        'id_proof'        => 'required|in_list[Aadhar,PAN,Passport,Voter ID,Drivers License]',
        'qualifications'  => 'required',
        'subjects'        => 'required',
        'status' => 'in_list[Active,Inactive]',
        'profile_picture' => 'uploaded[profile_picture]|max_size[profile_picture,2048]|is_image[profile_picture]',
    ]);

    // If validation fails, redirect back with error messages
    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    // Handle profile picture
    $img = $this->request->getFile('profile_picture');
    $imgName = '';
    if ($img && $img->isValid()) {
        $imgName = $img->getRandomName();
        $img->move(FCPATH . 'uploads', $imgName);
    }

    // Handle post data safely
    $qualifications = (array) $this->request->getPost('qualifications');
    $subjects = (array) $this->request->getPost('subjects');

    $data = [
        'name'            => $this->request->getPost('name'),
        'age'             => $this->request->getPost('age'),
        'email'           => $this->request->getPost('email'),
        'password'        => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        'gender'          => $this->request->getPost('gender'),
        'id_proof'        => $this->request->getPost('id_proof'),
        'qualifications'  => implode(',', $qualifications),
        'subjects'        => implode(',', $subjects),
        'status' => $this->request->getPost('status') === 'Active' ? 'Active' : 'Inactive',
        'profile_picture' => $imgName,
    ];

    $model->insert($data);

    return redirect()->to('/users')->with('success', 'User added successfully.');
}


    public function edit($id)
    {
        $model = new UserModel();
        $data['user'] = $model->find($id);

        echo view('templates/header');
        echo view('users/create', $data); // Reuse the form for editing
        echo view('templates/footer');
    }

    public function update($id)
    {
        helper(['form', 'url']);
        $model = new UserModel();

        // Prepare the data for updating
        $data = [
            'name' => $this->request->getPost('name'),
            'age' => $this->request->getPost('age'),
            'email' => $this->request->getPost('email'),
            'gender' => $this->request->getPost('gender'),
            'id_proof' => $this->request->getPost('id_proof'),
            'qualifications' => implode(',', $this->request->getPost('qualifications') ?? []),
            'subjects' => implode(',', $this->request->getPost('subjects') ?? []),
            'status' => $this->request->getPost('status') === 'on' ? 'Active' : 'Inactive',
        ];

        // Handle optional password update
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        // Handle optional new image upload
        $img = $this->request->getFile('profile_picture');
        if ($img && $img->isValid()) {
            $imgName = $img->getRandomName();
            $img->move(FCPATH . 'uploads', $imgName);
            $data['profile_picture'] = $imgName;
        }

        $model->update($id, $data);
        return redirect()->to('/users')->with('success', 'User updated successfully.');
    }

    public function delete($id)
    {
        $model = new UserModel();
        $model->delete($id);
        return redirect()->to('/users')->with('success', 'User deleted successfully.');
    }
}
