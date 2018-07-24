<?php namespace App\Http\Controllers;


use App\Http\Requests\RoleRequest;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;


class RolesController extends Controller {

	private $role;
	private $permission;

	public function __construct(Role $role, Permission $permission)
	{
		$this->role = $role;
		$this->permission = $permission;
	}

	public function index()
	{
		$roles = $this->role->where('deleted', 0)->get();
		$data = [
			'roles' => $roles,
			'type'  => 'role',
		];
		return view('admin.roles.index', $data);
	}

	public function create()
	{
		$permissions = $this->permission->all();
		return view('admin.roles.edit', compact('permissions'));
	}

	public function store(RoleRequest $request)
	{

		$role = $this->role->create($request->all());

		$role->savePermissions($request->get('perms'));
		return redirect('admin/role/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);


	}

	public function edit($id)
	{
		$role = $this->role->find($id);
		if($role->id == 1)
		{
			abort(403);
		}
		$permissions = $this->permission->all();
		$rolePerms   = $role->perms()->pluck('id')->all();

		$data = [
			'role'        => $role ,
			'permissions' => $permissions,
			'rolePerms'   => $rolePerms,
			'id'		  => $id
		];
		return view('admin.roles.edit', $data);
	}

	public function update(RoleRequest $request, $id)
	{
		$role = $this->role->find($id);
		$role->update($request->all());
		$role->savePermissions($request->get('perms'));
		return redirect('admin/role/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);
	}

	public function destroy($id)
	{
		if($id == 1)
		{
			abort(403);
		}

		$this->role->delete($id);

		return redirect('admin/role/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);

	}
	/**
	 * Show a list of all the languages posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function data()
	{
		$permission = Role::get()
			->map(function ($permission) {
				return [
					'id' 		   => $permission->id,
					'display_name' => $permission->display_name,
					'name' 		   => $permission->name,
					'description'  => $permission->description,
				];
			});

		return Datatables::of($permission)
			->add_column('actions',
				'<a class = "btn-xs btn-info" href="{{route(\'role.edit\',[\'id\' => $id])}}" style="margin-right: 5px;display: inline"><i class="fa fa-pencil"  aria-hidden="true"></i></a>
                            <form action="{{route(\'role.destroy\',[\'id\' => $id])}}" method="post" class="form-delete" style="display: inline">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="text" class="hidden" value="{{$id}}">
                                 {{method_field("DELETE")}}
                           <a type="submit" class = "btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </form>')
			->remove_column('id')
			->make();
	}

}