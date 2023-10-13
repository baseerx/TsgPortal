<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Model\TraineesModel;
class HrisInstructor extends Model
{
    public function HrisEmployees()
    {
        $users = DB::connection('mysql2')->table('personal')
                ->join('designation', 'designation.MyId', '=', 'personal.DesignationId')
                ->join('designationdetail', 'designationdetail.MyId', '=', 'personal.designationdetailId')
                ->join('departments', 'departments.DeptId', '=', 'personal.DepartmentId')
                ->select('personal.MyId', 'personal.Name', 'personal.Grade', 'personal.DesignationId', 'personal.designationdetailId', 'designationdetail.designationdetail', 'designation.Designation', 'personal.DepartmentId', 'departments.DeptName', 'personal.EmpStatus')
                ->orderBy('personal.Grade', 'desc')
                ->get();
      return $users;
    }

    public function EmployeeRecord($id)
    {
        $user = DB::connection('mysql2')->table('personal')
            ->join('designation', 'designation.MyId', '=', 'personal.DesignationId')
            ->where('personal.MyId', '=', $id)
            ->select('personal.MyId', 'personal.Name as name', 'designation.designation as title', 'personal.PhMobile as mobile', 'personal.PhOffice as phone', 'personal.Email as email', 'personal.DOBirth as dob')
            ->get();
//        Log::info(DB::connection('mysql2')->select("select Name as name,Designation as title from personal,designation where MyId='$id'"));
//        $user['dob']=date("d-m-Y", strtotime($user['dob']));
        return $user;
    }

  public function StoreTrainee($id)
    {
        $vals=explode('-',$id);
        $user = DB::connection('mysql2')->table('personal')
            ->join('designation', 'designation.MyId', '=', 'personal.DesignationId')
            ->where('personal.MyId', '=', $vals[0])
            ->select('personal.MyId', 'personal.OfficialAddress as address','personal.Name as name', 'designation.Designation as title', 'personal.PhMobile as mobile','personal.PhOffice as phone','personal.Email as email','personal.DOBirth as dob')
            ->get();
            // Log::info($user);
        $user=json_decode($user,true);
            TraineesModel::create([
                'letterid'=>$vals[1],
                'name'=>$user[0]['name'],
                'address'=>$user[0]['address'],
                'phone'=>$user[0]['phone'],
                'email'=>$user[0]['email']
            ]);
    }

    Public function InternalList()
    {
        $data=DB::table('create_letter')
            ->join('trainees','trainees.letterid','=','create_letter.letterid')
            ->where('create_letter.checkparticipent','=','internal')
            ->paginate(20);
        return $data;
    }
    Public function ExternalList()
    {
        $data = DB::table('create_letter')
            ->join('trainees', 'trainees.letterid', '=', 'create_letter.letterid')
            ->join('course_schedules', 'course_schedules.course', '=', 'create_letter.course')
            ->where('create_letter.checkparticipent', '=', 'external')
            ->paginate(100);
        return $data;
    }
}
