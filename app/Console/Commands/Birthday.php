<?php

namespace App\Console\Commands;

use App\Helpers\Notify;
use App\Helpers\Utility;
use App\User;
use Illuminate\Console\Command;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;

class Birthday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:Birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends out email to users who have birthday, and notifies people of other peoples birthday';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function deleteAllFolderFiles(){
        
        // List of name of files inside
        // specified folder
        $files = glob(Utility::IMG_URL('birthday-frames').'/*');
           
        // Deleting all the files in the list
        foreach($files as $file) {
           
            if(is_file($file))
            
                // Delete the given file
                unlink($file);
        }
    }

    public function birthdayImageFrame($photoName,$id = ''){
        $previousBirthdayFrame = Utility::IMG_URL($photoName);
        //Log::info($previousBirthdayFrame);
        
        $img = Image::make(Utility::IMG_URL('11_aa_birthday_frame.jpeg'));
        $img->resize(400,600);
        
        //Resize user photo
        if(!empty($photoName) && file_exists($previousBirthdayFrame)){
            $resizePhoto = Image::make(Utility::IMG_URL($photoName));
            $resizePhoto->resize(200, 220);

            /* insert watermark at bottom-right corner with 10px offset */
            $img->insert($resizePhoto, 'center');
        }
        
        $img->save(Utility::IMG_URL('birthday-frames/'.$id.'_birthday.jpeg'));
        

    }

    public function handle()
    {
        //
        $today = date('Y-m-d');
        $month = date('m');
        $day = date('d');
        $birthdayUsersArr = [];
        $birthdayNames = [];
        $birthdayId = [];
        $birthdayUsers =  User::specialColumns('active_status',Utility::STATUS_ACTIVE);
        //Log::info('askfjalsdifasdfsadf');
        foreach ($birthdayUsers as $userData){

            $birthDate = strtotime($userData->dob);

            $birthDay = date('d', $birthDate);
            $birthMonth = date('m', $birthDate);
            $userEmail = $userData->email;
           

            $mailContent = [];
            $myBirthdayPhoto = [];
            $mailContent['subject'] = 'HAPPY BIRTHDAY NOTIFICATION (' . $userData->firstname.' '.$userData->lastname. ')';
            $messageBody = "Dear " . $userData->firstname . ",
            Congratulations on another wonderful birthday!
            We are proud to have you as a part of our team. We do hope that this birthday be the start of an amazing year where you accomplish every goal that you have set. May this day bring you joy and much happiness in abundance. Wishing you the very best of luck in all aspects of your life.
            Enjoy your special day! From all of us at ".Utility::companyInfo()->name;

            if(!empty($userData->dob) && $birthDay == $day && $birthMonth == $month){
                
                //birthday picture
                $this->birthdayImageFrame($userData->photo,$userData->id);
                
                $names = $userData->firstname.' '.$userData->lastname;
                $birthdayNames[] = $names;
                $birthdayPhotos[] = $userData->id.'_birthday.jpeg';
                $myBirthdayPhoto[] = $userData->id.'_birthday.jpeg';
                
                $birthdayUsersArr[] = $userData->id;
                $mailContent['message'] = $messageBody;
                 $mailContent['birthdayPhotos'] = $myBirthdayPhoto;
                 
                Notify::BirthdayMail('mail_views.birthday', $mailContent, $userEmail);
                
            }

        }

        if(count($birthdayUsersArr) > 0){
            $activeUsers = User::specialColumns('active_status',Utility::STATUS_ACTIVE);
            foreach($activeUsers as $userData){
                if(!in_array($userData->id,$birthdayUsersArr) && $userData->active_status == Utility::STATUS_ACTIVE){
                    
                    
                    $userEmail = $userData->email;

                    $mailContent = [];
                    $mailContent['subject'] = 'Employee Birthday Notification (' . implode(', ',$birthdayNames). ')';

                    $messageBody = "Dear " . $userData->firstname . ", ".implode(', ',$birthdayNames).
                    " have birthday today, please wish them well";

                    $mailContent['message'] = $messageBody;
                    $mailContent['birthdayPhotos'] = $birthdayPhotos;
                    Notify::BirthdayMail('mail_views.birthday', $mailContent, $userEmail);
                }
            }
        }
        
       


    }
    
    
    
}
