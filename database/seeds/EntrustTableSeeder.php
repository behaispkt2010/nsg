<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;
use App\User;

class EntrustTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('role_user')->truncate();
        DB::table('permission_role')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();

        $admin = new Role(); // 1
        $admin->name = 'admin';
        $admin->display_name = "Administrator";

        $admin->save();

        $editor = new Role(); // 2
        $editor->name = 'editor';
        $editor->display_name = "Quản trị";

        $editor->save();

        $userRole = new Role(); // 3
        $userRole->name = 'user';
        $userRole->display_name = "Khách hàng";
        $userRole->save();

        $userRole = new Role(); // 4
        $userRole->name = 'kho';
        $userRole->display_name = "Chủ kho";
        $userRole->save();

        $userRole = new Role(); // 5
        $userRole->name = 'staff';
        $userRole->display_name = "Nhân viên";
        $userRole->save();

        $user = User::where('email', '=', 'admin@gmail.com')->first();
        $user->attachRole($admin);
        //$user->roles()->attach($admin->id); Eloquent basic

        $user1 = User::where('email', '=', 'editor@gmail.com')->first();
        $user1->attachRole($editor);

        $user2 = User::where('email', '=', 'user@gmail.com')->first();
        $user2->attachRole($userRole);

        $user3 = User::where('email', '=', 'kho@gmail.com')->first();
        $user3->attachRole($userRole);

        $perm0 = new Permission();
        $perm0->name = 'dashboard-admin';
        $perm0->display_name = "Thống kê admin";
        $perm0->description = "";
        $perm0->route = "admin/dashboard/";
        $perm0->save();

        $perm0 = new Permission();
        $perm0->name = 'dashboard';
        $perm0->display_name = "Thống kê";
        $perm0->description = "";
        $perm0->route = "admin/dashboard/";
        $perm0->save();


        $perm1 = new Permission();
        $perm1->name = 'news';
        $perm1->display_name = "Quản trị tin tức";
        $perm1->description = "";
        $perm1->route = "admin/news";
        $perm1->save();

        $perm1c = new Permission();
        $perm1c->name = 'news-create';
        $perm1c->display_name = "Tạo mới tin tức";
        $perm1c->description = "";
        $perm1c->route = "admin/news/create";
        $perm1c->save();

        $perm1e = new Permission();
        $perm1e->name = 'news-edit';
        $perm1e->display_name = "Chỉnh sửa tin tức";
        $perm1e->description = "";
        $perm1e->route = "admin/news/{news}/edit";
        $perm1e->save();


        $perm2 = new Permission();
        $perm2->name = 'category';
        $perm2->display_name = "Quản trị nhóm tin tức";
        $perm2->description = "";
        $perm2->route = "admin/category";
        $perm2->save();

        $perm2c = new Permission();
        $perm2c->name = 'category-create';
        $perm2c->display_name = "Tạo mới nhóm";
        $perm2c->description = "";
        $perm2c->route = "admin/category/create";
        $perm2c->save();

        $perm2e = new Permission();
        $perm2e->name = 'category-edit';
        $perm2e->display_name = "Chỉnh sửa nhóm";
        $perm2e->description = "";
        $perm2e->route = "admin/category/{category}/edit";
        $perm2e->save();

        $perm3 = new Permission();
        $perm3->name = 'Quản trị role';
        $perm3->display_name = "Role";
        $perm3->description = "";
        $perm3->route = "admin/role";
        $perm3->save();

        $perm3c = new Permission();
        $perm3c->name = 'role-create';
        $perm3c->display_name = "Tạo mới role";
        $perm3c->description = "";
        $perm3c->route = "admin/role/create";
        $perm3c->save();

        $perm3e = new Permission();
        $perm3e->name = 'role-edit';
        $perm3e->display_name = "Chỉnh sửa role";
        $perm3e->description = "";
        $perm3e->route = "admin/role/{role}/edit";
        $perm3e->save();


        $perm4 = new Permission();
        $perm4->name = 'permission';
        $perm4->display_name = "Quản trị permission";
        $perm4->description = "";
        $perm4->route = "admin/permission";
        $perm4->save();

        $perm4c = new Permission();
        $perm4c->name = 'permission-create';
        $perm4c->display_name = "Tạo mới permission";
        $perm4c->description = "";
        $perm4c->route = "admin/permission/create";
        $perm4c->save();

        $perm4e = new Permission();
        $perm4e->name = 'permission-edit';
        $perm4e->display_name = "Chỉnh sửa permission";
        $perm4e->description = "";
        $perm4e->route = "admin/permission/{permission}/edit";
        $perm4e->save();

        $perm5 = new Permission();
        $perm5->name = 'pages';
        $perm5->display_name = "Quản trị pages";
        $perm5->description = "";
        $perm5->route = "admin/pages";
        $perm5->save();

        $perm5c = new Permission();
        $perm5c->name = 'page-create';
        $perm5c->display_name = "Tạo mới page";
        $perm5c->description = "";
        $perm5c->route = "admin/permission/create";
        $perm5c->save();

        $perm5e = new Permission();
        $perm5e->name = 'page-edit';
        $perm5e->display_name = "Chỉnh sửa page";
        $perm5e->description = "";
        $perm5e->route = "admin/pages/{page}/edit";
        $perm5e->save();


        $perm6 = new Permission();
        $perm6->name = 'products';
        $perm6->display_name = "Sản phẩm";
        $perm6->description = "";
        $perm6->route = "admin/products";
        $perm6->save();

        $perm6c = new Permission();
        $perm6c->name = 'products-create';
        $perm6c->display_name = "Tạo mới product";
        $perm6c->description = "";
        $perm6c->route = "admin/products/create";
        $perm6c->save();

        $perm6e = new Permission();
        $perm6e->name = 'products-edit';
        $perm6e->display_name = "Chỉnh sửa product";
        $perm6e->description = "";
        $perm6e->route = "admin/products/{products}/edit";
        $perm6e->save();

        $perm7 = new Permission();
        $perm7->name = 'categoryProducts';
        $perm7->display_name = "Nhóm sản phẩm";
        $perm7->description = "";
        $perm7->route = "admin/categoryProducts*";
        $perm7->save();



        $perm8 = new Permission();
        $perm8->name = 'orders';
        $perm8->display_name = "Đơn hàng";
        $perm8->description = "";
        $perm8->route = "admin/orders";
        $perm8->save();

        $perm8c = new Permission();
        $perm8c->name = 'orders-create';
        $perm8c->display_name = "Tạo mới orders";
        $perm8c->description = "";
        $perm8c->route = "admin/orders/create";
        $perm8c->save();

        $perm8e = new Permission();
        $perm8e->name = 'orders-edit';
        $perm8e->display_name = "Chỉnh sửa orders";
        $perm8e->description = "";
        $perm8e->route = "admin/orders/{orders}/edit";
        $perm8e->save();

        $perm9 = new Permission();
        $perm9->name = 'money';
        $perm9->display_name = "Sỗ quỹ";
        $perm9->description = "";
        $perm9->route = "admin/money";
        $perm9->save();


        $perm10 = new Permission();
        $perm10->name = 'historyInput';
        $perm10->display_name = "Lịch sữ giao dịch";
        $perm10->description = "";
        $perm10->route = "admin/historyInput*";
        $perm10->save();

        $perm11 = new Permission();
        $perm11->name = 'inventory';
        $perm11->display_name = "inventory";
        $perm11->description = "";
        $perm11->route = "admin/inventory";
        $perm11->save();

        $perm12 = new Permission();
        $perm12->name = 'customers';
        $perm12->display_name = "Khách hàng";
        $perm12->description = "";
        $perm12->route = "admin/customers";
        $perm12->save();

        $perm13 = new Permission();
        $perm13->name = 'users';
        $perm13->display_name = "users";
        $perm13->description = "";
        $perm13->route = "admin/users";
        $perm13->save();


        $perm13c = new Permission();
        $perm13c->name = 'users-create';
        $perm13c->display_name = "Tạo mới users";
        $perm13c->description = "";
        $perm13c->route = "admin/users/create";
        $perm13c->save();

        $perm13e = new Permission();
        $perm13e->name = 'users-edit';
        $perm13e->display_name = "Chỉnh sửa users";
        $perm13e->description = "";
        $perm13e->route = "admin/users/{users}/edit";
        $perm13e->save();

        $perm14 = new Permission();
        $perm14->name = 'setting';
        $perm14->display_name = "Cài đặt";
        $perm14->description = "";
        $perm14->route = "admin/setting";
        $perm14->save();

        $perm15 = new Permission();
        $perm15->name = 'warehouse';
        $perm15->display_name = "Thông tin chủ kho";
        $perm15->description = "";
        $perm15->route = "admin/warehouse";
        $perm15->save();

        $perm16 = new Permission();
        $perm16->name = 'staffs';
        $perm16->display_name = "Thông tin nhân sự";
        $perm16->description = "";
        $perm16->route = "admin/staffs";
        $perm16->save();

        $perm17 = new Permission();
        $perm17->name = 'menu';
        $perm17->display_name = "menu";
        $perm17->description = "";
        $perm17->route = "admin/menu";
        $perm17->save();


        $admin->attachPermissions([$perm16,$perm17,$perm15,$perm2c,$perm2e,$perm1c,$perm1e,$perm3c,$perm3e,$perm4c,$perm4e,$perm5e,$perm5c,$perm6c,$perm6e,$perm8e,$perm8c,$perm13e,$perm13c,$perm0, $perm1, $perm2, $perm3, $perm4, $perm5, $perm6, $perm7, $perm8, $perm9, $perm10, $perm11,$perm12,$perm13,$perm14]);
        //$admin->perms()->sync([$manageRoles->id, $manageUsers->id, $managePerms->id]); Eloquent basic

//        $editor->attachPermissions([$managePerms, $createPerms, $updatePerms, $destroyPerms]);
    }
}
