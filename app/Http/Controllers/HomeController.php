<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect()->route('incomes');
    }

    public function reload(){
        $oldTransportType = \DB::connection('pgsql2')->table('transport_types')->get();
        $oldTransport= \DB::connection('pgsql2')->table('transports')->get();
        $oldRoles = \DB::connection('pgsql2')->table('roles')->get();
        $oldUsers = \DB::connection('pgsql2')->table('users')->get();
        $oldRelationShip= \DB::connection('pgsql2')->table('role_users')->get();
        $i = 1;
        ini_set('max_execution_time', 1000000);

        /*foreach ($oldTransportType as $type) {
            $transport = new \App\TransportType;
            $transport->id = $type->id;
            $transport->title = $type->title;
            $transport->save();
        }*/
        foreach ($oldTransport as $transportType) {
            try{
            $transport = new \App\Transport;
            $transport->title = $transportType->title;
            $transport->creationDate = Carbon::parse($transportType->creationDate);
            $transport->commissioningDate = Carbon::parse($transportType->commissioningDate);
            $transport->detailsUpdateDate = Carbon::parse($transportType->detailsUpdateDate);
            $transport->number = $transportType->number;
            $transport->brand = $transportType->brand;
            $transport->model = $transportType->model;
            $transport->chassis_engine_number = $transportType->chassis_engine_number;
            $transport->engine_volume = $transportType->engine_volume;
            $transport->weight = $transportType->weight;
            $transport->color = $transportType->color;
            $transport->certificate = $transportType->certificate;
            $transport->factory_number = $transportType->factory_number;
            $transport->rent = $transportType->rent;
            if($transportType->typeId == 0){
                $transportType->typeId=15;
            }
            $transport->typeId = $transportType->typeId;
            $transport->save();
            $i++;
        }
        catch(QueryException $e){

        }
        }
        foreach ($oldRoles as $oldrole) {
            $role = new \App\Role;
            $role->title = $oldrole->title;
            $role->permissions = $oldrole->permissions;
            $role->slug = $oldrole->slug;
            $role->id = $oldrole->id;
            $role->save();
        }
        foreach ($oldUsers as $olduser) {
            $user = new \App\Models\User;
            $user->id = $olduser->id;
            $user->login = $olduser->login;
            $user->email = $olduser->email;
            $user->password = $olduser->password;
            $user->name = $olduser->name;
            $user->surname = $olduser->surname;
            $user->middlename = $olduser->middlename;
            $user->company = $olduser->company;
            $user->save();
        }
    }
}
