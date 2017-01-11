<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\User;
use App\Mail\UserInvite;

class UserController extends Controller
{
    protected $rules = [
        'name' => 'required',
        'username' => 'required|max:8|unique:users,username',
        'email' => 'required|email|unique:users,email',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('valid_until', 'desc')
            ->get();

        return view('user.index', [
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        $data = $request->all();

        $password = str_random(12);
        $data['password'] = Hash::make($password);
        if ($request->input('admin', 0) == 1)
            $data['password'] = true;

        // Create user
        $user = User::create($data);
        if ($user === null)
            abort(500, 'Der Benutzer konnte nicht erstellt werden!');

        // Send invitation mail to user
        if ($request->input('invite', 0) == 1) {
            Mail::to($user)->send(new UserInvite($user, $password));
            flash('Benutzer erfolgreich angelegt. Das Passwort wurde dem Benutzer per E-Mail geschickt.', 'success');
        } else {
            flash(sprintf('Benutzer erfolgreich angelegt. Das Passwort lautet: %s', $password), 'success');
        }

        return [
            'model' => $user,
            'redirect' => route('user.index'),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
