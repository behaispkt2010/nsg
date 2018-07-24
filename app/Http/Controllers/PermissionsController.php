<?php namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

class PermissionsController extends Controller {

	private $role;
	private $permission;

	public function __construct(Permission $permission, Role $role)
	{
		$this->permission = $permission;
		$this->role       = $role;
	}

	public function index()
	{
		$permissions = $this->permission->where('deleted', 0)->get();
		$data = [
			'permissions' => $permissions,
			'type'        =>'permission'
		];
		return view('admin.permissions.index',$data);
	}

	public function create()
	{
		return view('admin.permissions.edit');
	}

	public function store(PermissionRequest $request)
	{
		$permission = $this->permission->create($request->all());
		$role = $this->role->where('name','admin')->first();
		$role->attachPermission($permission->id);
		return redirect('admin/permission/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);

	}

	public function edit($id)
	{
		$permission = $this->permission->find($id);
		$data = [
			'permission'=>$permission,
			'id'=>$id
		];

		return view('admin.permissions.edit', $data);
	}


	public function update(PermissionRequest $request, $id)
	{

		$permission = $this->permission->find($id);
		$permission->update($request->all());

		return redirect('admin/permission/')->with(['flash_level' => 'success', 'flash_message' => 'Lưu thành công']);

	}

	public function destroy($id)
	{
		$res =  Permission::destroy($id);
		if(!empty($res)) {
			return redirect('admin/permission/')->with(['flash_level' => 'success', 'flash_message' => 'Xóa thành công']);
		}
		else{
			return redirect('admin/permission/')->with(['flash_level' => 'success', 'flash_message' => 'Chưa thể xóa']);

		}
	}

	/**
	 * Show a list of all the languages posts formatted for Datatables.
	 *
	 * @return Datatables JSON
	 */
	public function data()
	{
		$permission = Permission::get()
			->map(function ($permission) {
				return [
					'id' => $permission->id,
					'display_name' => $permission->display_name,
					'name' => $permission->route,
					'description' => $permission->description,
				];
			});

		return Datatables::of($permission)
			->add_column('actions',
				'<a class = "btn-xs btn-info" href="{{route(\'permission.edit\',[\'id\' => $id])}}" style="margin-right: 5px;display: inline"><i class="fa fa-pencil"  aria-hidden="true"></i></a>
                            <form action="{{route(\'permission.destroy\',[\'id\' => $id])}}" method="post" class="form-delete" style="display: inline">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="text" class="hidden" value="{{$id}}">
                                 {{method_field("DELETE")}}
                           <a type="submit" class = "btn-xs btn-danger" name ="delete_modal" style="display: inline-block"><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </form>')
			->remove_column('id')
			->make();
	}
}