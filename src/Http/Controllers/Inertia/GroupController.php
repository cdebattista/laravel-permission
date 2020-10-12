<?php
namespace Cdebattista\LaravelPermission\Http\Controllers\Inertia;

use App\Models\Group;
use App\Models\Permission;
use Cdebattista\LaravelPermission\Contracts\CreatesGroup;
use Cdebattista\LaravelPermission\Contracts\DeletesGroup;
use Cdebattista\LaravelPermission\Contracts\UpdatesGroup;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;

class GroupController extends Controller
{
    use AuthorizesRequests;

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function index(Request $request){
        $this->authorize('viewAny', Group::class);
        $groups = new Group();
        $columns = Schema::getColumnListing($groups->getTable());
        $groups = $groups->filter($request->only('search'), $columns)
                                   ->order($request->input('orderColumn') ?? 'id', $request->input('orderDirection'))
                                   ->get();
        return Inertia::render('Group/Index', [
            'groups' => $groups,
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
        $this->authorize('create', Group::class);
        $permissions = new Permission();
        $permissions = $permissions->optGroup();

        return Inertia::render('Group/Create', [
            'permissions' => $permissions
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', Group::class);
        app(CreatesGroup::class)->create($request->all());
        return redirect(route('groups.index'));
    }

    /**
     * @param Group $group
     *
     * @return \Inertia\Response
     */
    public function edit(Group $group){
        $this->authorize('update', $group);
        $permissions = new Permission();
        $permissions = $permissions->optGroup();
        $group_permissions = $group->optGroupPermissions();

        return Inertia::render('Group/Edit', [
            'group' => $group,
            'permissions' => $permissions,
            'group_permissions' => $group_permissions
        ]);
    }

    /**
     * @param Group   $group
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Group $group, Request $request){
        $this->authorize('update', $group);
        app(UpdatesGroup::class)->update($group, $request->all());
        return redirect(route('groups.index'));
    }

    /**
     * @param Group $group
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Group $group){
        $this->authorize('delete', $group);
        app(DeletesGroup::class)->delete($group);
        return redirect(route('groups.index'));
    }
}