<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(RolePeremissionsSeeder::class);
        $this->call(RoleUsersSeeder::class);
        $this->call(FactoryTypeSeeder::class);
        $this->call(FactorySeeder::class);
        $this->call(MaterialTypeSeeder::class);
        $this->call(ProductTypeSeeder::class);
        $this->call(ShippingCompanySeeder::class);
        $this->call(SizeSeeder::class);
        $this->call(SupplierSeeder::class);
    }
}
