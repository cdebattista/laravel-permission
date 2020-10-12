<?php
namespace Cdebattista\LaravelPermission\Http\Controllers\Inertia;

use App\Models\Group;
use App\Models\User;
use App\Models\Permission;
use Cdebattista\LaravelPermission\Contracts\CreatesUser;
use Cdebattista\LaravelPermission\Contracts\DeletesUser;
use Cdebattista\LaravelPermission\Contracts\UpdatesUser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;

class UserController extends Controller
{
    use AuthorizesRequests;
    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function index(Request $request){
        $this->authorize('viewAny', User::class);
        $users = new User();
        $columns = Schema::getColumnListing($users->getTable());
        $users = $users->filter($request->only('search'), $columns)
                                   ->order($request->input('orderColumn') ?? 'id', $request->input('orderDirection'))
                                   ->get();
        return Inertia::render('User/Index', [
            'users' => $users,
            'filters' => $request->all('search'),
            'order' => $request->all('orderColumn', 'orderDirection'),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', User::class);
        $permissions = new Permission();
        $permissions = $permissions->optGroup();
        $groups = new Group();
        $groups = $groups->optGroup();

        return Inertia::render('User/Create', [
            'permissions' => $permissions,
            'groups' => $groups
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        app(CreatesUser::class)->create($request->all());
        return redirect(route('users.index'));
    }

    /**
     * @param User $user
     *
     * @return \Inertia\Response
     */
    public function edit(User $user){
        $this->authorize('update', $user);
        $permissions = new Permission();
        $permissions = $permissions->optGroup();
        $groups = new Group();
        $groups = $groups->optGroup();
        $user_permissions = $user->optGroupPermissions();
        $user_groups = $user->optGroupGroups();

        /**
         * 'userSelected' => $user,
         *  cause
         *  'user' => $user,
         *  will throw an error on vuejs
         */
        return Inertia::render('User/Edit', [
            'userSelected' => $user,
            'permissions' => $permissions,
            'groups' => $groups,
            'user_permissions' => $user_permissions,
            'user_groups' => $user_groups
        ]);
    }

    /**
     * @param User   $user
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $user, Request $request){
        $this->authorize('update', $user);
        app(UpdatesUser::class)->update($user, $request->all());
        return redirect(route('users.index'));
    }

    /**
     * @param User $user
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(User $user){
        $this->authorize('delete', $user);
        app(DeletesUser::class)->delete($user);
        return redirect(route('users.index'));
    }
}