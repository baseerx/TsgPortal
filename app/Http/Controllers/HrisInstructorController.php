<?php

namespace App\Http\Controllers;

use App\HrisInstructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Model\TraineesModel;

class HrisInstructorController extends Controller
{
    public function HrisEmployees()
    {
       $modelObj=new HrisInstructor();
       $data=$modelObj->HrisEmployees();
      return $data;
    }

    public function EmployeeRecord($id)
    {
       $employeRec=new HrisInstructor();
       $record=$employeRec->EmployeeRecord($id);
        return $record;
    }
    public function StoreTrainee($id)
    {

        $employeRec=new HrisInstructor();
        $record=$employeRec->StoreTrainee($id);
        return $record;
    }
    public function InternalList()
    {
        $employeRec=new HrisInstructor();
        $record=$employeRec->InternalList();
        return $record;
    }
    public function ExternalList()
    {
        $employeRec=new HrisInstructor();
        $record=$employeRec->ExternalList();
        return $record;
    }

}
