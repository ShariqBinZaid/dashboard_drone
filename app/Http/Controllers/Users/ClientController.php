<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Helper\Helper;
use App\Models\Clients;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\ClientsResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;
use App\Http\Resources\Users\UserClientResource;

class ClientController extends Controller
{
    public function index()
    {
        return view('client.index');
    }

    public function list(Request $req)
    {
        $req = $req->input();
        $client = Clients::get();
        return new ClientsResource($client);
    }

    // public function list(Request $req)
    // {
    //     $req = $req->input();
    //     $users = User::where('user_type', '=', 'client')->get();
    //     return new UserClientResource($users);
    // }

    public function store(Request $req)
    {
        $input = $req->all();

        $validator = Validator::make($input, [
            'image' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'country' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->errors()]);
        }

        if ($req->file('image')) {
            unset($input['image']);
            $input += ['image' => $this->updateprofile($req, 'image')];
        }

        unset($input['_token']);

        if (@$input['id']) {
            $cardswip = Clients::where("id", $input['id'])->update($input);
            return response()->json(['success' => true, 'msg' => 'Client Updated Successfully.']);
        } else {
            $cardswip = Clients::create($input);
            return response()->json(['success' => true, 'msg' => 'Client Created Successfully']);
        }
    }
    // public function store(Request $req)
    // {
    //     $input = $req->all();
    //     unset($input['_token']);
    //     $validator = Validator::make($input, [
    //         'email' => 'required',
    //         'first_name' => 'required',
    //         'last_name' => 'required',
    //         'email' => 'email|required|unique:users,email,' . $input['id'],
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json(['success' => false, 'error' => $validator->errors()]);
    //     }

    //     if (@$input['password']) {
    //         $input['password'] = Hash::make($input['password']);
    //     } else {
    //         unset($input['password']);
    //     }
    //     if ($req->file('display_picture')) {
    //         unset($input['display_picture']);
    //         $input += ['display_picture' => $this->updateprofile($req, 'display_picture')];
    //     }

    //     if (@$input['id']) {
    //         if (@$input['c_password']) {
    //             $user = Clients::find($input['id']);
    //             if (!Hash::check($input['c_password'], $user->password)) {
    //                 return response()->json(['success' => false, 'msg' => 'Incorrent Password']);
    //             }
    //         }
    //         unset($input['c_password']);
    //         // if (Helper::permission('Clients.update')) {
    //         $user = User::where("id", $input['id'])->update($input);
    //         if (!empty($input['role_id'])) {
    //             UserRole::where('user_id', $input['id'])->delete();
    //             foreach ($input['role_id'] as $role) {
    //                 $data = ['user_id' => $input['id'], 'role_id' => $role];
    //                 $userrole = UserRole::create($data);
    //             }
    //         }
    //         return response()->json(['success' => true, 'msg' => 'User Updated']);
    //         // }
    //         return response()->json(['success' => false, 'msg' => 'Access Denied']);
    //     } else {
    //         // if (Helper::permission('Clients.create')) {
    //         $input += ['user_type' => 'admin'];
    //         $user = User::create($input);
    //         if (!empty($input['role_id'])) {
    //             foreach ($input['role_id'] as $role) {
    //                 $data = ['user_id' => $user->id, 'role_id' => $role];
    //                 $userrole = UserRole::create($data);
    //             }
    //         }
    //         return response()->json(['success' => true, 'msg' => 'User Created']);
    //         // }
    //         return response()->json(['success' => false, 'msg' => 'Access Denied']);
    //     }
    // }

    public function show($id)
    {
        if ($id ==  "all") {
            $client = Clients::all();
            return new ClientsResource($client);
        } else {
            $client = Clients::where('id', $id)->first();
            return response()->json(['success' => true, 'data' => $client]);
        }
    }

    public function destroy(Request $req, $id)
    {
        Clients::where('id', $id)->forcedelete();
        echo json_encode(['success' => true, 'msg' => 'Clients Deleted Successfully']);
    }
}
