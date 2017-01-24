<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use VisualAppeal\Gitolite\Config as Repository;
use VisualAppeal\Gitolite\User as RepositoryUser;

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
     * Display a listing of the resource.
     *
     * @param string $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        $user = User::findByUsername($username);

        $config = new Repository(Config::get('services.gitolite.path'), false);
        $gitUser = new RepositoryUser($username, Config::get('services.gitolite.path'));

        $pathToKeydir = dirname(dirname(Config::get('services.gitolite.path'))) . DIRECTORY_SEPARATOR . 'keydir' . DIRECTORY_SEPARATOR;
        $keys = array_map(function($path) use ($pathToKeydir, $user) {
            $name = str_replace($pathToKeydir, '', $path);
            $nameParts = explode('/', $name);
            if (count($nameParts) !== 3)
                throw new \Exception(sprintf('Could not parse key path %s', $name));

            return [
                'name' => $nameParts[1],
                'content' => file_get_contents($path)
            ];
        }, $gitUser->getKeys());

        return view('user.show', [
            'user' => $user,
            'repositories' => $config->getRepositoriesForUser($gitUser),
            'keys' => $keys,
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
     * @param string $name
     * @return \Illuminate\Http\Response
     */
    public function edit($username)
    {
        $user = User::findByUsername($username);

        return view('user.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request  $request
     * @param string $username
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $username)
    {
        $user = User::findByUsername($username);

        $rules = $this->rules;
        $rules['username'] = $rules['username'] . ',' . $user->id;
        $rules['email'] = $rules['email'] . ',' . $user->id;
        $this->validate($request, $rules);

        $data = $request->all();
        $data['admin'] = $request->has('admin');

        $user->fill($data);
        if (!$user->save())
            abort(500, 'Der Benutzer konnte nicht gespeichert werden!');

        flash('Der Benutzer wurde erfolgreich gespeichert.', 'success');

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $username
     * @return \Illuminate\Http\Response
     */
    public function destroy($username)
    {
        $user = User::findByUsername($username);
        $user->delete();

        flash('Der Benutzer wurde erfolgreich gelöscht.', 'info');

        return redirect()->route('user.index');
    }
}
