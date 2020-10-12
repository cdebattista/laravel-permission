<?php
namespace Cdebattista\LaravelPermission\Http\Controllers\Inertia;

use App\Models\Permission;
use Cdebattista\LaravelPermission\Contracts\CreatesPermission;
use Cdebattista\LaravelPermission\Contracts\DeletesPermission;
use Cdebattista\LaravelPermission\Contracts\UpdatesPermission;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Schema;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PermissionController extends Controller
{
    use AuthorizesRequests;

    /**
     * @param Request $request
     *
     * @return \Inertia\Response
     */
    public function index(Request $request){

        $this->authorize('viewAny', Permission::class);

        $permissions = new Permission();
        $columns = Schema::getColumnListing($permissions->getTable());
        $permissions = $permissions->filter($request->only('search'), $columns)
                                   ->order($request->input('orderColumn') ?? 'id', $request->input('orderDirection'))
                                   ->get();
        return Inertia::render('Permission/Index', [
            'permissions' => $permissions,
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
        $this->authorize('create', Permission::class);
        return Inertia::render('Permission/Create');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->authorize('create', Permission::class);
        app(CreatesPermission::class)->create($request->all());
        return redirect(route('permissions.index'));
    }

    /**
     * @param Permission $permission
     *
     * @return \Inertia\Response
     */
    public function edit(Permission $permission){
        $this->authorize('update', $permission);
        return Inertia::render('Permission/Edit', ['permission' => $permission]);
    }

    /**
     * @param Permission $permission
     * @param Request    $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Permission $permission, Request $request){
        $this->authorize('update', $permission);
        app(UpdatesPermission::class)->update($permission, $request->all());
        return redirect(route('permissions.index'));
    }

    /**
     * @param Permission $permission
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Permission $permission){
        $this->authorize('delete', $permission);
        app(DeletesPermission::class)->delete($permission);
        return redirect(route('permissions.index'));
    }
}
