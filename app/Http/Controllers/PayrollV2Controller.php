<?php

namespace App\Http\Controllers;

use App\Helpers\Utility;
use App\model\Department;
use App\model\Payroll;
use App\model\Company;
use App\model\Tax;
use App\model\SalaryStructure;
use App\User;
use App\Helpers\Notify;
use Auth;
use View;
use Validator;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Log;

class PayrollV2Controller extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $dept = Department::getAllData();
        $mainData = (in_array(Auth::user()->role,Utility::HR_MANAGEMENT)) ? Payroll::paginateAllData() :Payroll::specialColumnsPage('payroll_status',Utility::APPROVED) ;
        $salarySum = Utility::sumColumnDataCondition('payroll','payroll_status',Utility::PROCESSING,'total_amount');

        if ($request->ajax()) {
            return \Response::json(view::make('payroll_v2.reload',array('mainData' => $mainData,'salarySum' => $salarySum,'dept' => $dept))->render());

        }else{
            return view::make('payroll_v2.main_view')->with('mainData',$mainData)->with('salarySum',$salarySum)
            ->with('dept',$dept);
        }

    }

    public function payslipItem(Request $request)
    {
        //
        $companyInfo = Company::firstRow('active_status',Utility::STATUS_ACTIVE);
        //print_r($companyInfo); exit();
        $payslip = Payroll::firstRow('id',$request->input('dataId'));
        $user = User::firstRow('id',$payslip->user_id);
        $tax = Tax::firstRow('id',$user->salary->tax_id);
        $loan = $payslip->loan_deduct;
        $advance = $payslip->sal_advance_deduct;
        $taxAmount = $payslip->tax_amount;
        $payrollDeduct = ($payslip->bonus_deduc_type == Utility::PAYROLL_DEDUCTION) ? $payslip->bonus_deduc : 0;
        $totalSalaryDeduction = $this->primarySalaryDeduction($payslip->component,$loan,$advance,$payrollDeduct);

        return view::make('payroll_v2.edit_form')->with('edit',$payslip)->with('companyInfo',$companyInfo)
            ->with('user',$user)->with('tax',$tax)->with('taxAmount',$taxAmount)->with('totalDeduction',$totalSalaryDeduction);

    }

    public function primarySalaryDeduction($jsonData,$loan,$salAdv,$payrollDeduct){
        $array = json_decode($jsonData,true);
        $holdArray = [];
        foreach($array as $data){
            if($data['component_type'] == Utility::COMPONENT_TYPE[2]){
                $holdArray[] = $data['amount'];
            }

        }
        $sum = array_sum($holdArray);
        $totalDeduct = $sum+$loan+$salAdv+$payrollDeduct;
        return $totalDeduct;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function process(Request $request)
    {
        //

        $validator = Validator::make($request->all(),[]);
        if($validator->passes()){

            $rate = $request->input('rate');
            $daysEngage = $request->input('days_engage');
            $extendedHoursAmount = $request->input('extended_hours_amount');
            $gross = $request->input('gross');
            $basic = $request->input('basic');
            $pension = $request->input('pension');
            $paye = $request->input('paye');
            $net = $request->input('net_pay');
            $salaryId = $request->input('salary_id');
            $userId = $request->input('user_id');
            $checkbox = $request->input('checkbox');
            $processDate = Utility::standardDate($request->input('date'));

            $month = Utility::getMonthFromDate($processDate);;
            $year = date('Y', strtotime($processDate));
            
            Utility::checkCurrencyActiveStatus();
                
                $defaultCurr = session('currency')['id'];
                foreach($rate as $key => $val){
                    $user = User::firstRow('id',$userId[$key]);
                    if(isset($checkbox[$key]) && isset($daysEngage[$key])){
                        $bonusDeduc = ($extendedHoursAmount[$key] == '') ? Utility::ZERO : Utility::STATUS_ACTIVE;
                        $extraAmount = ($extendedHoursAmount[$key] == '') ? Utility::ZERO : $extendedHoursAmount[$key];
                        $bonusDeducDesc = ($extendedHoursAmount[$key] == '') ? '' : 'Extended Hours/Days';
                        
                        $compArray = [];
                        $holdArray = [];
                        $holdArray['component'] = 'Basic';
                        $holdArray['amount'] = $basic[$key];
                        $holdArray['component_type'] = 'Earnings';
                        $compArray[] = $holdArray;

                        $holdArray = [];
                        $holdArray['component'] = 'Pension';
                        $holdArray['amount'] = $pension[$key];
                        $holdArray['component_type'] = 'Deduction';
                        $compArray[] = $holdArray;

                        $holdArray = [];
                        $holdArray['component'] = 'Paye';
                        $holdArray['amount'] = $paye[$key];
                        $holdArray['component_type'] = 'Deduction';
                        $compArray[] = $holdArray;

                        $dbData = [
                            'user_id' => $userId[$key],
                            'bonus_deduc' => $extraAmount,
                            'bonus_deduc_type' => $bonusDeduc,
                            'bonus_deduc_desc' => $bonusDeducDesc,
                            'salary_id' => $salaryId[$key],
                            'component' => json_encode($compArray),
                            'dept_id' => $user->dept_id,
                            'position_id' => $user->position_id,
                            'gross_pay' => $gross[$key],
                            'total_amount' => $net[$key],
                            'tax_amount' => $paye[$key],
                            'curr_id' => $defaultCurr,
                            'process_date' => $processDate,
                            'payroll_status' => Utility::PROCESSING,
                            'pay_year' => $year,
                            'pay_date' => '',
                            'month' => $month,
                            'days_hours_engage' => $daysEngage[$key],
                            'created_by' => Auth::user()->id,
                            'status' => Utility::STATUS_ACTIVE
                        ];
                        $userCount = Payroll::countData3('user_id',$userId[$key], 'month', $month, 'pay_year', $year);
                        if($userCount > 0){
                            Payroll::defaultUpdate('user_id',$userId[$key],$dbData);
                        }else{
                            Payroll::create($dbData);
                        }
                        

                    }

                }

                return response()->json([
                'message2' => 'saved',
                'message' => 'saved successfully'
                ]);
                    $mailContentApproved = new \stdClass();
                    $mailContentApproved->type = 'process_request';
                    $mailContentApproved->desc = 'Payroll for '.$month.' '.$year. 'has been processed by HR, please visit the portal to action request';
                    $mailContentApproved->sender = Auth::user()->firstname . ' ' . Auth::user()->lastname;

                    $accountants = User::specialColumns('role',Utility::ACCOUNTANTS);
                    if(count($accountants) >0){ //SEND MAIL TO ALL IN ACCOUNTS DEPARTMENT ABOUT THIS APPROVAL
                        foreach($accountants as $data) {
                            Notify::payrollMail('mail_views.payroll', $mailContentApproved, $data->email, Auth::user()->firstname, 'Process Request');
                        }
                    }


                return response()->json([
                    'message2' => 'saved',
                    'message' => 'Data(s) has been sent to accounts for processing '
                ]);

            /////////////////////////////////////////////////


        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

     //PAYROLL REPORT SEARCH REQUEST AND QUERY
     public function searchPayrollLite(Request $request)
     {
         //
 
         $from = Utility::standardDate($request->input('from_date'));
         $to = Utility::standardDate($request->input('to_date'));
         $dept = $request->input('department');
         $dateArray = [$from,$to];
         $mainData = [];
 
         //PROCESS SEARCH REQUEST
 
        if ($dept != '')  {
            $mainData = Payroll::specialColumnsDate('dept_id', $dept,'process_date',$dateArray);
        }
        if ($dept == '')  {
            $mainData = Payroll::getByDate('process_date',$dateArray);
        }

        return view::make('payroll_v2.payroll_search')->with('mainData', $mainData);

 
 
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve(Request $request)
    {
        //
        $all_id = json_decode($request->input('all_data'));
        $journalValid = $request->input('ledger_valid');
        $status = $request->input('input');
        $payDate = $request->input('date');

        $dbData = [
            'payroll_status' => Utility::APPROVED,
            'pay_date' => Utility::standardDate($payDate),
            'updated_by' => Auth::user()->id
        ];


        $mailContentApproved = new \stdClass();
        $mailContentApproved->type = 'request_approval';
        $mailContentApproved->desc = count($all_id).' users in the payroll have received payment';
        $mailContentApproved->sender = Auth::user()->firstname . ' ' . Auth::user()->lastname;

        $updateApproval = Payroll::massUpdate('id',$all_id,$dbData);


        if($status == 1) {
            $hr = User::specialColumns('role', Utility::HR);
            if (count($hr) > 0) { //SEND MAIL TO ALL IN ACCOUNTS DEPARTMENT ABOUT THIS APPROVAL
                foreach ($hr as $data) {
                    Notify::payrollMail('mail_views.payroll', $mailContentApproved, $data->email, Auth::user()->firstname, 'Request Approval');
                }
            }
        }

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Payment was made to '.count($all_id).' entry(ies)'
        ]);



    }

    /**
     * Search the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function searchUser(Request $request)
    {
        //
        //$search = User::searchUser($request->input('searchVar'));
        $search = User::searchEnabledUserAll($_GET['searchVar']);
        $obtain_array = [];

        foreach($search as $data){

            $obtain_array[] = $data->uid;
        }
        /*for($i=0;$i<count($search);$i++){
            $obtain_array[] = $search[$i]->id;
        }*/

        $user_ids = array_unique($obtain_array);
        $mainData =  (Auth::user()->role == Utility::ADMIN) ? User::massDataMassCondition('uid',$user_ids,'role',Utility::USER_ROLES_ARRAY)
            :User::massDataPaginate('uid', $user_ids);
        //print_r($obtain_array); die();
        if(!empty($search)){
            if (count($user_ids) > 0) {

                return view::make('payroll_v2.search_user')->with('mainData',$mainData);
            }else{
                return 'No match found, please search again with sensitive words';
            }

        }else{
            $mainData = User::specialColumns('active_status',Utility::STATUS_ACTIVE);
            return view::make('payroll_v2.search_user')->with('mainData',$mainData);
        }

    }

    public function searchUserStrict(Request $request)
    {
        //
       
        
            $dept = $request->input('department');

            $mainData = User::specialColumns2('dept_id', $dept,'active_status',Utility::STATUS_ACTIVE);

            if ($mainData->count() > 0) {

                return view::make('payroll_v2.search_user')->with('mainData',$mainData);
            }else{
                return 'No match found, please search again with sensitive words';
            }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $all_id = json_decode($request->input('all_data'));
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];

            $delete = Payroll::massUpdate('id',$all_id,$dbData);

            return response()->json([
                'message2' => 'deleted',
                'message' => count($all_id).' data(s) has been deleted'
            ]);

    }

    public function refineData($data){
        $holdArray = [];
        if(count($data) >0){
            foreach($data as $value){
                if($value->payroll_status == Utility::PROCESSING){
                    $holdArray[] = $value->total_amount;
                }
            }
            $data->salary_sum = array_sum($holdArray);
        }


    }

}
