<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'age',
        'email',
        'password',
        'gender',
        'id_proof',
        'qualifications',
        'subjects',
        'status',
        'profile_picture'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[3]',
        'email' => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password' => 'permit_empty|min_length[8]|regex_match[/(?=.*[0-9])(?=.*[\W])/]',
        'gender' => 'required|in_list[Male,Female,Other]',
        'id_proof' => 'required',
        'qualifications' => 'required',
        'subjects' => 'required',
        'status' => 'in_list[Active,Inactive]',
        'profile_picture' => 'permit_empty'
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email is already registered.',
            'valid_email' => 'Enter a valid email address.'
        ],
        'password' => [
            'regex_match' => 'Password must contain at least one number and one special character.'
        ]
    ];

    // Convert status to human-readable form
    public function getStatusLabel($status)
    {
        return $status === 'Active' ? 'Active' : 'Inactive';
    }

    // Convert id_proof value to readable label
    public function getIdProofLabel($idProof)
    {
        $proofs = [
            'Aadhar' => 'Aadhar',
            'PAN' => 'PAN',
            'Passport' => 'Passport',
            'Voter ID' => 'Voter ID',
            "Drivers License" => "Drivers License"
        ];
        return $proofs[$idProof] ?? 'Unknown';
    }
}
