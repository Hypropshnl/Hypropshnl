<?php

namespace App\Console\Commands;

use App\Helpers\Utility;
use App\model\TempUsers;
use App\model\VendorCustomer;
use App\model\VendorJobCategory;
use App\model\VendorsPool;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Hash;

class VendorApprovedTransfer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:VendorApprovedTransfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move approved vendors to VendorCustomer table and delete data from VendorsPool table';

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
    public function handle()
    {
        //
        $vendorPool = VendorsPool::specialColumns2('approval_status',Utility::APPROVED,'transfer_status',Utility::ZERO);
        DB::transaction(function() use($vendorPool){

            //LOOP THROUGH EACH APPROVED VENDORS
            if($vendorPool->count()){
                foreach($vendorPool as $vendor){
                    $dbData = [
                        'email1' => $vendor->email,
                        'email2' => $vendor->address2,
                        'name' => $vendor->company_name,
                        'address' => $vendor->address1,
                        'city' => $vendor->city,
                        'country_id' => $vendor->country_id,
                        'contact_name' => $vendor->contact_name,
                        'annual_turnover' => $vendor->annual_turnover,
                        'phone' => $vendor->phone,
                        'website' => $vendor->website,
                        'company_no' => $vendor->company_no,
                        'vat_no' => $vendor->vat_no,
                        'tax_id_no' => $vendor->tax_no,
                        'bank_name' => $vendor->bank_name,
                        'account_no' => $vendor->bank_account_no,
                        'account_name' => $vendor->bank_account_name,
                        'currency_id' => $vendor->currency,
                        'company_type' => Utility::VENDOR,
                        'memo' => $vendor->memo,
                        'bank_branch' => $vendor->bank_branch,
                        'bank_sort_code' => $vendor->bank_sort_code,
                        'hse_policy' => $vendor->hse_policy,
                        'qa_cert' => $vendor->qa_cert,
                        'active_status' => Utility::STATUS_ACTIVE,
                        'status' => Utility::STATUS_ACTIVE
                    ];

                    //STORE VENDOR JOB CATEGORIES
                    $categories = json_decode($vendor->job_category);
                    foreach($categories as $cat){
                        $jobCatData = [
                            'vendor_id' => $vendor->id,
                            'category_id' => $cat,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        VendorJobCategory::create($jobCatData);
                    }
    
                    //CREATE VENDOR IN THE VENDOR TABLE
                    $create = VendorCustomer::create($dbData);
                    
                    if($create){
                        //DELETE VENDOR FROM TEMPORARY TABLE OF VENDORS WHERE APPROVAL OCCURS
                        VendorsPool::defaultUpdate('id', $vendor->id,['transfer_status' => Utility::STATUS_ACTIVE]);
                    }
    
                }
            }
    

        });

    }
}
