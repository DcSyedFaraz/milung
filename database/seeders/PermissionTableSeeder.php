<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'addNewSupplierEntry',
            'editSupplierEntry',
            'setEditSupplierIDCode',
            'addNewBuyerEntry',
            'editBuyerEntry',
            'addProductEntry',
            'editProductEntry',
            'accessImportExportCertificateTestingReport',
            'createProductGroup',
            'accessNotifyImportExportFunctionForMinorEKPrice',
            'createPriceInquiry',
            'orderGeneralSinglePage',
            'createNewOrder',
            'editOrderDetails',
            'voidOrder',
            'miLungOrderPriceEnquiry',
            'printviewConfirmRejectButton',
            'massCargoPhotoApproval',
            'createSONumber',
            'shipmentOverview',
            'editShipmentOverview',
            'exportShippingDocuments',
            'priceInquiry',
            'supplierOrderPriceQuote',
            'supplierOrderConfirmationNotification',
            'supplierOrderGeneralSinglePage',
            'uploadPrintview',
            'cargoReadyConfirmation',
            'uploadMassCargoPhoto',
            'createReceiptNote',
            'inputPackingList',
            'supplierAccountsReceivable',
            'createBuyerPriceInquiry',
            'editBuyerPriceInquiry',
            'createNewBuyerOrder',
            'editBuyerOrder',
            'confirmRejectPrintview',
            'buyerShipmentOverview',
            'addATCNumber',
            'buyerAccountPayable',
            'accessToUSBChipPrice',
            'transactionOverview',
            'accountPayable',
            'accountReceivable',
            'issueNewLoginIdPassword',
            'setAccessAuthority',
            'userManagement',
            'bestSales',
            'bestPurchase',
            'salesRevenue',
            'purchaseRevenue',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $roles = [
            'Admin',
            'Internal',
            'Buyer',
            'Supplier',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }


        $user = [
            'userid' => 'Milung01',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => date('Y-m-d h:i:s'),
        ];

        $userd = User::create($user);
        $userd->assignRole('Admin');
        $userd->syncPermissions($permissions);

        $buy = [
            'userid' => 'Buyer01',
            'name' => 'buyer',
            'email' => 'buyer@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => date('Y-m-d h:i:s'),
        ];

        $buyr = User::create($buy);
        $buyr->assignRole('Buyer');
        $buyr->syncPermissions($permissions);

        $supp = [
            'userid' => 'Supplier01',
            'name' => 'supplier',
            'email' => 'supplier@gmail.com',
            'password' => Hash::make('12345678'),
            'email_verified_at' => date('Y-m-d h:i:s'),
        ];

        $suppl = User::create($supp);
        $suppl->assignRole('Supplier');
        $suppl->syncPermissions($permissions);



        // permission assig
        $rolepermission =
            [
                ['permission_id' => 1, 'role_id' => 1],
                ['permission_id' => 2, 'role_id' => 1],
                ['permission_id' => 3, 'role_id' => 1],
                ['permission_id' => 4, 'role_id' => 1],
                ['permission_id' => 5, 'role_id' => 1],
                ['permission_id' => 6, 'role_id' => 1],
                ['permission_id' => 7, 'role_id' => 1],
                ['permission_id' => 8, 'role_id' => 1],
                ['permission_id' => 9, 'role_id' => 1],
                ['permission_id' => 10, 'role_id' => 1],
                ['permission_id' => 11, 'role_id' => 1],
                ['permission_id' => 12, 'role_id' => 1],
                ['permission_id' => 13, 'role_id' => 1],
                ['permission_id' => 14, 'role_id' => 1],
                ['permission_id' => 15, 'role_id' => 1],
                ['permission_id' => 16, 'role_id' => 1],
                ['permission_id' => 17, 'role_id' => 1],
                ['permission_id' => 18, 'role_id' => 1],
                ['permission_id' => 19, 'role_id' => 1],
                ['permission_id' => 20, 'role_id' => 1],
                ['permission_id' => 21, 'role_id' => 1],
                ['permission_id' => 22, 'role_id' => 1],
                ['permission_id' => 23, 'role_id' => 1],
                ['permission_id' => 24, 'role_id' => 1],
                ['permission_id' => 25, 'role_id' => 1],
                ['permission_id' => 26, 'role_id' => 1],
                ['permission_id' => 27, 'role_id' => 1],
                ['permission_id' => 28, 'role_id' => 1],
                ['permission_id' => 29, 'role_id' => 1],
            ];
        foreach ($rolepermission as $role) {
            \DB::table('role_has_permissions')->insert($role);
        }
    }
}
