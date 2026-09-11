<?php

namespace App\Imports;

use App\Helpers\Utility;
use App\model\TempUsers;
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

class TempUsersImport implements 
ToModel, 
WithHeadingRow, 
WithBatchInserts, 
WithChunkReading, 
SkipsOnError, 
WithValidation,
SkipsOnFailure
{

    use Importable, SkipsErrors;

    protected $department;
    protected $role;
    protected $token;

    public function __construct($department, $role, $token){
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
       
            //Log::info($row);      
            $email = isset($row['email']) ? $row['email'] : '';
            $firstname = isset($row['firstname']) ? $row['firstname'] : '';
            $lastname = isset($row['lastname']) ? $row['lastname'] : '';
            $password = isset($row['lastname']) ? $row['lastname'] : 'password';
            $othername = isset($row['othername']) ? $row['othername'] : '';
            $gender = isset($row['gender']) ? $row['gender'] : '';
            $birthdate = isset($row['birthdate']) ? $row['birthdate'] : '01-01-1980';
            $phone = isset($row['phone']) ? $row['phone'] : '';
            $home_address = isset($row['home_address']) ? $row['home_address'] : '';
            $nationality = isset($row['nationality']) ? $row['nationality'] : '';
            $title = isset($row['title']) ? $row['title'] : '';
            $qualification = isset($row['qualification']) ? $row['qualification'] : '';

            $dbDATA = [
                'uid' =>  Utility::generateUID('temp_users'),
                'email' => $email,
                'password' => Hash::make($password),
                'role' => $this->role,
                'firstname' =>  $firstname,
                'lastname' => $lastname,
                'othername' => $othername,
                'sex' => $gender,
                'dob' => Utility::standardDate($birthdate),
                'phone' => $phone,
                'address' => $home_address,
                'dept_id' => $this->department,
                'nationality' => $nationality,
                'photo' => $photo,
                'title' => $title,
                'qualification' => $qualification,
                'created_by' => Auth::user()->firstname.' '.Auth::user()->lastname,
                'remember_token' => $this->token,
                'active_status' => Utility::STATUS_ACTIVE,
                'status' => Utility::STATUS_ACTIVE
            ];
            return new TempUsers($dbDATA);
        
    }

    public function rules(): array
    {
        return [
             // Above is alias for as it always validates in batches
             '*.email' => ['email', 'unique:temp_users,email'],
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
