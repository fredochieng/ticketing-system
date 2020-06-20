<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assets')->insert([
            ['asset_status' => '3', 'asset_type' => 'CPU + DESKTOP', 'model_no' => 'Compaq/HP', 'serial_no' => '3CB926221G', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3', 'asset_type' => 'CPU + DESKTOP', 'model_no' => 'HP', 'serial_no' => 'TRF1182M70', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'Compaq/HP', 'serial_no' => '3CB92621QX', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'Acer', 'serial_no' => 'Acer M265', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'LAPTOP', 'model_no' => 'Lenovo', 'serial_no' => 'YB07855809', 'processor' => 'Intel Core i7', 'country' => 'KENYA'],
            ['asset_status' => '3', 'asset_type' => 'LAPTOP', 'model_no' => 'Lenovo', 'serial_no' => 'PF06YQGD', 'processor' => 'Intel Core i7', 'country' => 'KENYA'],
            ['asset_status' => '3', 'asset_type' => 'CPU + DESKTOP', 'model_no' => '', 'serial_no' => '3CB926213Q', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'DESKTOP', 'model_no' => '', 'serial_no' => '3CB025267O', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'Acer', 'serial_no' => 'Acer M261', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'HP', 'serial_no' => 'TRF3520V5G', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3', 'asset_type' => 'CPU + DESKTOP', 'model_no' => 'HP', 'serial_no' => 'TRF2410HVM', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3', 'asset_type' => 'PRINTER', 'model_no' => 'HP Laser Jet ', 'serial_no' => 'CN153226G4', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'PRINTER', 'model_no' => 'HP LASERJET- 100 COLOURMFP  M175A  ', 'serial_no' => 'IH97EFICHA', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'PRINTER', 'model_no' => 'HP Laser Jet ', 'serial_no' => 'MFP M175A', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'LAPTOP', 'model_no' => 'HP Compaq', 'serial_no' => 'IH97EFICHA ', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3', 'asset_type' => 'LAPTOP', 'model_no' => 'HP 550', 'serial_no' => 'CNU9066NJP', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3', 'asset_type' => 'LAPTOP', 'model_no' => 'Macbook Pro', 'serial_no' => 'CNU9066NJP', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'LAPTOP', 'model_no' => 'Compaq 500b-MT', 'serial_no' => '3CB01527LF', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'Acer/HP', 'serial_no' => '3CB01527LF', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'LAPTOP', 'model_no' => 'Toshiba', 'serial_no' => '1c106519k', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3', 'asset_type' => 'PRINTER', 'model_no' => 'HP Officejet Printer', 'serial_no' => '1HC8EEHCKA', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3', 'asset_type' => 'CPU + DESKTOP', 'model_no' => 'HP Compaq', 'serial_no' => 'TRF35219L4', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'Acer/HP', 'serial_no' => 'M265', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'DESKTOP', 'model_no' => 'HP', 'serial_no' => 'TRF 4010LVC', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'PRINTER', 'model_no' => 'HP Officejet Printer', 'serial_no' => 'CN3CEFXGMW', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3', 'asset_type' => 'PROJECTOR', 'model_no' => 'Panasonic Projector', 'serial_no' => 'DB3620016', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3', 'asset_type' => 'CPU + DESKTOP', 'model_no' => 'IMAC 27"', 'serial_no' => 'C02K92Z3DNCW', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'IMAC 27"', 'serial_no' => 'C02KD24B4UDNCW', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'IMAC 27"', 'serial_no' => 'C02KC2TZDNCW', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'IMAC 27"', 'serial_no' => 'C02KC2TZDNCW', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3', 'asset_type' => 'CPU + DESKTOP', 'model_no' => 'IMAC 21"', 'serial_no' => 'W8740C69X85', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'IMAC 27"', 'serial_no' => 'C02K518PDNCW', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'IMAC 27"', 'serial_no' => 'CO2KC2U2DNCW', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'IMAC 27"', 'serial_no' => 'C02KC5RLDNCW', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'DELL/HP"', 'serial_no' => 'HODLS4J', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'DELL/DELL"', 'serial_no' => '8M7RVQ1', 'processor' => '', 'country' => 'KENYA'],
            ['asset_status' => '3',  'asset_type' => 'CPU + DESKTOP', 'model_no' => 'DELL/DELL"', 'serial_no' => '5XBMVQ1', 'processor' => '', 'country' => 'KENYA'],
        ]);
    }
}
