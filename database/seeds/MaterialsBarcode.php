<?php

use Illuminate\Database\Seeder;
use App\Models\Materials\Material;
class MaterialsBarcode extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $materials = Material::whereNull('barcode')->get();
        foreach($materials as $material)
        {
            $material->barcode = $this->generateBarcode();
            $material->save();
        }
    }

    public function generateBarcode()
    {
        $code = rand(0, 6000000000000);
        $check = Material::where('barcode', $code)->exists();
        if ($check) {
            $this->generateBarcode();
        } else {
            return $code;
        }
    }
}
