<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class OuathController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all users list
        $user = User::paginate(50);

        return view('oauth.create', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'user_name' => ['required', 'unique:users,user_name'],
            'password'  => ['required', Password::min(6)],
            'retype_password' => ['required', 'same:password', Password::min(6)]
        ]);

        $user = new User();
        $user->user_name = $request->get('user_name');

        //Encrypt user password
        $encrypt_password = Hash::make($request->get('password'));
        $user->password = $encrypt_password;

        $retype_password = $request->get('retype_password');
        $user->save();

        return redirect()->back()->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // fetch selected user records
        $user = User::find($id);

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Update seletced user name only
        $user = User::find($id);
        $user->user_name = $request->get('user_name');
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Delete selected users
        $user = User::find($id);
        $user->delete();
    }

    public function signInPage()
    {
        return view();
    }

    public function signIn(Request $request)
    {
        //Check user fill all feild
        if(!empty($request->get('user_name')) && !empty($request->get('password'))) {

            // Check user account exit or notDB
            $user = DB::table('users')->select('user_name')->where('user_name', '=', $request->get('user_name'))->first();

            if($user){

                //Check user password valid or not
                $save_password = DB::table('users')->select('password')->where('user_name', '=', $request->get('user_name'))->first();

                if(Hash::check($request->get('password'), $save_password->password)){

                    $user_id = DB::table('users')->select('id')->where('user_name', '=', $request->get('user_name'))->first();
                    session()->put('loggedin',$user_id->id);

                    //Redirect to dashboard
                    return redirect('/')->with('success', 'Loggedin successfully');

                }else{

                    return redirect()->back()->with('error', 'Password invalid');

                }
            }else{

                return redirect()->back()->with('error', 'User account not found');

            }

        }else{

            return redirect()->back()->with('error', 'All feild are required.');

        }
    }

    public function home()
    {
        if(session()->has('loggedin')){
            $user = DB::table('users')->select('*')->where('id', '=', session('loggedin'))->first();

            $user_data = [
                'user' => $user
            ];
        }
        return view('welcome', $user_data);
    }

    public function signOut()
    {
        if(session()->has('loggedin')){
            session()->pull('loggedin');

            return redirect('/oauth/sign-in')->with('success', 'Successfully loggedout');
        }
    }
}
