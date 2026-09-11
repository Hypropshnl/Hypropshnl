<?php

namespace App\Imports;

use App\Helpers\Utility;
use App\User;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class UsersImport implements 
ToModel, 
WithHeadingRow, 
WithBatchInserts, 
WithChunkReading, 
SkipsOnError, 
WithValidation,
SkipsOnFailure
{

    use Importable, SkipsErrors;

    protected $employType;
    protected $department;
    protected $role;
    protected $token;

    public function __construct($employType, $department, $role, $token){
        $this->employType = $employType;
        $this->department = $department;
        $this->role = $role;
        $this->token = $token;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $photo = 'user.png';
        $sign = '';
       
            //Log::info($row);
            $email = isset($row['email']) ? $row['email'] : '';            
            //$uid = Utility::generateUID('users');                        
            
            $email = isset($row['email']) ? $row['email'] : '';
            $other_email = isset($row['other_email']) ? $row['other_email'] : '';
            $firstname = isset($row['firstname']) ? $row['firstname'] : '';
            $lastname = isset($row['lastname']) ? $row['lastname'] : '';
            $password = isset($row['lastname']) ? $row['lastname'] : 'password';
            $othername = isset($row['othername']) ? $row['othername'] : '';
            $gender = isset($row['gender']) ? $row['gender'] : '';
            $birthdate = isset($row['birthdate']) ? $row['birthdate'] : '01-01-1980';
            $phone = isset($row['phone']) ? $row['phone'] : '';
            $job_role = isset($row['job_role']) ? $row['job_role']: '';
            $home_address = isset($row['home_address']) ? $row['home_address'] : '';
            $religion = isset($row['religion']) ? $row['religion'] : '';
            $nationality = isset($row['nationality']) ? $row['nationality'] : '';
            $marital_status = isset($row['marital_status']) ? $row['marital_status'] : '';
            $blood_group = isset($row['blood_group']) ? $row['blood_group'] : '';
            $next_of_kin = isset($row['next_of_kin']) ? $row['next_of_kin'] : '';
            $next_of_kin_phone = isset($row['next_of_kin_phone']) ? $row['next_of_kin_phone'] : '';
            $state = isset($row['state']) ? $row['state'] : '';
            $local_govt = isset($row['local_govt']) ? $row['local_govt'] : '';
            $emergency = isset($row['emergency']) ? $row['emergency'] : '';
            $emergency_contact = isset($row['emergency_contact']) ? $row['emergency_contact'] : '';
            $emergency_phone = isset($row['emergency_phone']) ? $row['emergency_phone'] : '';
            $title = isset($row['title']) ? $row['title'] : '';
            $qualification = isset($row['qualification']) ? $row['qualification'] : '';
            $employ_date = isset($row['employ_date']) ? $row['employ_date'] : '';

            $dbDATA = [
                'uid' =>  Utility::generateUID('users'),
                'email' => $email,
                'password' => Hash::make($password),
                'other_email' => $other_email,
                'role' => $this->role,
                'firstname' =>  $firstname,
                'lastname' => $lastname,
                'othername' => $othername,
                'sex' => $gender,
                'dob' => Utility::standardDate($birthdate),
                'phone' => $phone,
                'job_role' => $job_role,
                'address' => $home_address,
                'employ_type' => $this->employType,
                'dept_id' => $this->department,
                'religion' => $religion,
                'nationality' => $nationality,
                'marital' => $marital_status,
                'blood_group' => $blood_group,
                'next_kin' => $next_of_kin,
                'next_kin_phone' => $next_of_kin_phone,
                'state' => $state,
                'local_govt' => $local_govt,
                'emergency_name' => $emergency,
                'emergency_contact' => $emergency_contact,
                'emergency_phone' => $emergency_phone,
                'photo' => $photo,
                'sign' => $sign,
                'title' => $title,
                'qualification' => $qualification,
                'employ_date' => $employ_date,
                'created_by' => Auth::user()->firstname.' '.Auth::user()->lastname,
                'remember_token' => $this->token,
                'active_status' => Utility::STATUS_ACTIVE,
                'status' => Utility::STATUS_ACTIVE
            ];
            return new User($dbDATA);
        
    }

    public function rules(): array
    {
        return [
             // Above is alias for as it always validates in batches
             '*.email' => ['email', 'unique:users,email'],
             '*.firstname' => ['required', 'string'],
             '*.lastname' => ['required', 'string'],
        ];
    }

    public function onError(Throwable $e)
    {
        // Handle the exception how you'd like.
    }

    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }

    public function batchSize(): int
    {
        return 20;
    }

    public function chunkSize(): int
    {
        return 50;
    }

}
