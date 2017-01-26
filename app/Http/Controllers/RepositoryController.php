<?php

namespace App\Http\Controllers;

use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use VisualAppeal\Gitolite\Config as Repository;
use VisualAppeal\Gitolite\User as RepositoryUser;
use VisualAppeal\Gitolite\Permission as RepositoryPermission;

class RepositoryController extends Controller
{
    /**
     * Rules to validate a new key.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required',
    ];

    public function index()
    {
        $config = new Repository(Config::get('services.gitolite.path'), false);

        $repositories = $config->getRepositories();

        return view('repository.index', [
            'repositories' => $repositories,
        ]);
    }

    /**
     * Destroy repository.
     *
     * @param string $name
     * @return Response
     */
    public function destroy($name)
    {
        if (!Auth::user()->admin)
            abort(403, 'Du darfst kein Repository löschen!');

        $config = new Repository(Config::get('services.gitolite.path'), false);
        $user = new RepositoryUser($username, Config::get('services.gitolite.path'));

        if (!$config->deleteRepository($name))
            abort(500, 'Das Repository konnte nicht gelöscht werden!');

        $config->save();

        flash('Das Repository wurde gelöscht.', 'info');

        return redirect()->back();
    }

    /**
     * Create new repository for user.
     *
     * @param Request $request
     * @param string $username
     * @return Response
     */
    public function store(Request $request, $username)
    {
        if (!Auth::user()->admin)
            abort(403, 'Du darfst kein Repository erstellen!');

        $this->validate($request, $this->rules);

        $config = new Repository(Config::get('services.gitolite.path'), false);
        $user = new RepositoryUser($username, Config::get('services.gitolite.path'));
        $name = $request->input('name');

        $repository = $config->createOrFindRepository($name);
        $permission = new RepositoryPermission;
        $permission->setPermission(RepositoryPermission::PERMISSION_READ_WRITE);
        $permission->addUser($user);
        $repository->addPermission($permission);
        $config->save();

        flash('Das Repository wurde erfolgreich erstellt.', 'success');

        return redirect()->back();
    }
}
