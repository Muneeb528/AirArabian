<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            [
                'bank_name'      => 'HBL',
                'account_title'  => 'Travel Portal (Pvt) Ltd',
                'account_number' => '1234-5678-9012-3456',
                'iban'           => 'PK36HABB0000001123456702',
                'branch'         => 'Main Branch, Karachi',
                'is_active'      => true,
                'sort_order'     => 1,
            ],
            [
                'bank_name'      => 'BAFL',
                'account_title'  => 'Travel Portal (Pvt) Ltd',
                'account_number' => '0101-2345-6789-0123',
                'iban'           => 'PK29ALFH0000000012345678',
                'branch'         => 'Gulshan Branch, Karachi',
                'is_active'      => true,
                'sort_order'     => 2,
            ],
            [
                'bank_name'      => 'Meezan',
                'account_title'  => 'Travel Portal (Pvt) Ltd',
                'account_number' => '0200-1234567-01',
                'iban'           => 'PK70MEZN0001020012345701',
                'branch'         => 'DHA Branch, Lahore',
                'is_active'      => true,
                'sort_order'     => 3,
            ],
            [
                'bank_name'      => 'FBL',
                'account_title'  => 'Travel Portal (Pvt) Ltd',
                'account_number' => '0311-12345678',
                'iban'           => 'PK02FAYS0000000031112345',
                'branch'         => 'Blue Area, Islamabad',
                'is_active'      => true,
                'sort_order'     => 4,
            ],
            [
                'bank_name'      => 'UBL',
                'account_title'  => 'Travel Portal (Pvt) Ltd',
                'account_number' => '1234567890',
                'iban'           => 'PK61UNIL0109000012345678',
                'branch'         => 'Clifton Branch, Karachi',
                'is_active'      => true,
                'sort_order'     => 5,
            ],
        ];

        foreach ($banks as $bank) {
            BankAccount::firstOrCreate(
                ['bank_name' => $bank['bank_name']],
                $bank
            );
        }

        $this->command->info('✅ Bank accounts seeded: HBL, BAFL, Meezan, FBL, UBL');
    }
}
