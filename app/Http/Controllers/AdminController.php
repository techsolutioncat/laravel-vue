<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\AdminRequest;
use App\User;
use App\UserRole;
use Dotenv\Exception\ValidationException;
use App\Exceptions\UserUpdateException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Session;
use JavaScript;
use Emerge;
use DB;
class AdminController extends Controller
{
    use RegistersUsers;

    public function index()
    {
        // add orWhere branch to this query
        // $users = User::query()->whereHas('userRole', function ($q){$q->where('role', 'admin')->orWhere('role', 'branch');})->orderBy('created_at', 'desc')->get();
        
        if(Session::get('role') >= 5){
            $users = DB::table('users')
            ->join('user_roles', 'users.user_role_id', '=', 'user_roles.id')
            ->where('user_roles.auth', '>=', 3)
            ->where('users.deleted_at', '=', NULL)
            ->select('users.*', 'user_roles.role_name')
            ->get();        
        }else if(Session::get('role') == 3){
            $users = DB::table('users')
            ->join('user_roles', 'users.user_role_id', '=', 'user_roles.id')
            ->where('user_roles.auth', '<', Session::get('role'))
            ->where('user_roles.auth', '>', 0)
            ->where('users.deleted_at', '=', NULL)
            ->select('users.*', 'user_roles.role_name')
            ->get();
        }else {
            $users = DB::table('users')
            ->join('user_roles', 'users.user_role_id', '=', 'user_roles.id')
            ->where('user_roles.auth', '<', Session::get('role'))            
            ->where('users.deleted_at', '=', NULL)
            ->select('users.*', 'user_roles.role_name')
            ->get();
        }        

        $users = Emerge::customPaginate($users, 20);        

        JavaScript::put([
            'users' => $users,
            'auth_role' => Session::get('role')            
        ]);
        ///delete other page's session for search;
        if (session('company_device_history_history')) {
            session(['company_device_history_history' =>
                [
                    'date' => '',
                    'rtc_time' => '',
                    'emergency_buzzer' => true,
                    'emergency_call' => true,
                    'call_received' => true,
                    'power_off' => true,
                    'power_on' => true,
                    'battery_low' => true,
                    'location_inquiry' => true,
                    'connection_error' => true,
                    'connection_restore' => true,
                    'device_model' => '',
                    'sb_billing_number' => '',
                    'group_name' => '',
                    'imei_number' => '',
                    'command_center' => '',
                    'msn' => '',
                    'receiver_number' => '',
                    'positioning_with_at_true' => true,
                    'positioning_with_at_false' => true,
                ]
            ]);
        }
        if (session("company_device_history_history_page")){
            session(['company_device_history_history_page' => 1]);
        }
        if(session('company_history')){
            session(['company_history' => [
                'registered_at' => '',
                'sb_payment_no' => '',
                'company_name' => '',
                'phone_number' => ''
            ]]);
        }

        if (session('company_device_assignment_history')) {
            session(['company_device_assignment_history' => [
                'started_at' => null,
                'mount_no' => null,
                'device_model' => null,
                'sb_billing_number' => null,
                'group_name' => null,
                'imei_number' => null,
                'command_center' => null,
                'msn' => null,
                'receiver_number' => null,
                'name' => null,
                'company_name' => null,
                'version' => null
            ]]);
        }

        if(session('notice_history')){
            session(['notice_history' => [
                'emergency_buzzer' => true,
                'emergency_call' => true,
                'battery_low' => true,
                'power_off' => true
            ]]);
        }

        if(session('history_setting_history')){
            session(['history_setting_history' => [
            'report_date_start' => null,
            'report_date_end' => null,
            'mount_no' => null,
            'imei' => null,
            'msn' => null
            ]]);
        }        

        return view('admin');
    }

    public function detail($user_id)
    {
        $data['row_auth'] = -1;
        $data = array();
        if($user_id != 0) {
            $user = User::select('users.id', 'users.login_id', 'users.name', 'users.user_role_id', 'user_roles.auth', 'user_roles.role_name')
                    ->leftJoin('user_roles', 'user_roles.id', '=', 'users.user_role_id')
                    ->where('users.id', '=', $user_id)
                    ->get();
            $data['row_auth'] = $user[0]['auth'];  
            $data['user'] = array(
                'id' => $user[0]['id'],
                'login_id' => $user[0]['login_id'],
                'name' => $user[0]['name'],
                'auth' => $user[0]['auth'],
                'user_role_id' => $user[0]['user_role_id'],
                'role_name' => $user[0]['role_name']
            );

            $data['user_list'] =  User::select('users.id', 'users.login_id', 'users.name', 'users.user_role_id')
                ->leftJoin('user_roles', 'user_roles.id', '=', 'users.user_role_id')
                ->where('user_roles.auth', '<', $user[0]['auth'])
                ->where('users.enabled', '=', 1)
                ->get();
        }
        $data['user_list'] = Emerge::customPaginate($data['user_list'], 20);        
        //var_dump(compact(userlist_data));exit;
        $data['role'] = UserRole::where('auth', '<', Session::get('role'))->orderBy('auth', 'desc')->get();
        $data['user_id'] = $user_id;
        $data['auth'] = Session::get('role');
        //$data['row_auth'] = $user[0]['auth'];

        return view('admin.detail', $data);
    }

    public function getOne(Request $request)
    {
        $user_id = $request->get('id');
        $data = array();
        if($user_id != 0) {
            $user = User::select('users.id', 'users.login_id', 'users.name', 'users.user_role_id', 'user_roles.auth')
                    ->leftJoin('user_roles', 'user_roles.id', '=', 'users.user_role_id')
                    ->where('users.id', '=', $user_id)
                    ->get();
            
            $data['user'] = array(
                'id' => $user[0]['id'],
                'login_id' => $user[0]['login_id'],
                'name' => $user[0]['name'],
                'auth' => $user[0]['auth'],
                'user_role_id' => $user[0]['user_role_id']
            );
            
            $data['user_list'] =  User::select('users.id', 'users.login_id', 'users.name', 'users.user_role_id')
                ->leftJoin('user_roles', 'user_roles.id', '=', 'users.user_role_id')
                ->where('user_roles.auth', '<', $user[0]['auth'])
                ->where('users.enabled', '=', 1)
                ->get();
        }

        $data['role'] = UserRole::where('auth', '<', Session::get('role'))->orderBy('auth', 'desc')->get();
        $data['user_id'] = $user_id;
        $data['auth'] = Session::get('role');
        
        echo json_encode($data);
    }

    // 管理者情報のリストを取得
    public function list(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $roleAdmin = UserRole::where('role', 'admin')
            ->first();

        $roleBranch = UserRole::where('role', 'branch')
            ->first();            

        $query = User::query();

        $query->where('user_role_id', $roleAdmin->id)->orWhere('user_role_id', $roleBranch->id)->orderBy('created_at', 'desc');

        $users = $query->paginate($perPage);

        return response()->json($users);
    }

    // レコードの登録
    public function register(Request $request)
    {
        // $data['id'] = $request->post('id', '');
        $data['login_id'] = $request->post('login_id', '');
        $data['name'] = $request->post('name', '');
        $data['password'] = $request->post('password', '');
        // $data['password_confirmation'] = $request->post('password_confirmation', '');
        $data['enabled'] = 1;
        $data['company_id'] = 1;
        $data['user_role_id'] = $request->post('user_role_id', 3);

        try {
            $admin = $this->create($data);
        } catch (\InvalidArgumentException $exception) {
            // return back()->with('error', '管理者情報の新規作成に失敗しました');
            echo false;
        }
        echo true;
        // return back()->with('success', '管理者情報を新規作成しました');
    }

    // レコードの更新
    public function update(Request $request)
    {
        $roleAdminID = UserRole::where('role', 'admin')->first()->id;
        $roleBranchID = UserRole::where('role', 'branch')->first()->id;

        $data['id'] = $request->post('id', null);
        $data['login_id'] = $request->post('login_id', null);
        $data['name'] = $request->post('name', null);

        $password = $request->post('password', null);
        if ($password != null) $data['password'] = Hash::make($password);

        $data['company_id'] = null;
//        $data['password_confirmation'] = $request->post('password_confirmation', null);
        $data['enabled'] = $request->post('enabled', true);
        $data['user_role_id'] = $request->post('user_role_id', $roleBranchID);

        // Check the ability to change the admin user's admin role if he is the last admin
        $numberAdmin = User::query()->where('user_role_id', $roleAdminID)->get()->count();
        if ($numberAdmin == 1 && $data['user_role_id'] != $roleAdminID) {
            $oldUserRoleID = User::query()->where('id', $data['id'])->first()->user_role_id;
            if ($oldUserRoleID == $roleAdminID) {
                throw new UserUpdateException("管理者権限の変更をすることができません。");    
            }
        }

        try {
//            $validate =  Validator::make($data, [
//                'login_id' => ['required', 'string', 'max:255'],
//                'name' => ['required', 'string', 'max:255'],
////                'password' => ['required', 'string', 'min:4'],
//            ]);
//
//            if (!$validate->fails())
//            {
            User::find($data['id'])->fill($data)->save();
//            }
        } catch (\InvalidArgumentException $exception) {
            // return back()->with('error', '管理者情報の更新に失敗しました');
            echo false;
        }

        // return back()->with('success', '管理者情報を更新しました');
        echo true;
    }

    // レコードの削除
    public function delete(Request $request)
    {
        $id = $request->post('id', null);

        // Check the ability to delete the requested user if he is the last admin
        $roleAdminID = UserRole::where('role', 'admin')->first()->id;
        $numberAdmin = User::query()->where('user_role_id', $roleAdminID)->get()->count();
        if ($numberAdmin == 1 && $request['user_role_id'] == $roleAdminID) {
            throw new UserUpdateException("管理者の削除をすることができません。");            
        }

        // ユーザーの削除
        try {
            $user = User::find($id);
            $user->delete();
        } catch (\PDOException $exception) {
            return back()->with('error', '管理者情報の更新に失敗しました');
        }

        // レスポンスの返却
        return back()->with('success', '管理者情報を更新しました');;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        try {
            return Validator::make($data, [
                'login_id' => ['required', 'string', 'max:255'],
                'name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:4', 'confirmed'],
            ]);
        } catch (\InvalidArgumentException $e) {
            throw $e;
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create($data)
    {
        try {
            return User::create([
                'name' => $data['name'],
                'login_id' => $data['login_id'],
                'company_id' => null,
                'password' => Hash::make($data['password']),
                'user_role_id' => $data['user_role_id'],
                'enabled' => $data['enabled'],
            ]);
        } catch (\PDOException $e) {
            throw $e;
        }
    }
}
