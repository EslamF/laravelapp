<?php

use Illuminate\Database\Seeder;
use App\Models\Products\Product;
use App\Models\Materials\Material;

class barcode_edit extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::get();
        foreach($products as $product)
        {
            $product->prod_code = $this->generateEANCode() ?? $this->generateEANCode();
            $product->save();
        }

        $materials = Material::get();
        foreach($materials as $material)
        {
            $material->barcode	 = $this->generateEANBarcode() ?? $this->generateEANBarcode();
            $material->save();
        }
    }

    public function generateEANCode()
    {
        $date = new DateTime();
        $time = $date->getTimestamp();
        $code = '20' . str_pad($time, 10, '0');
        $weightflag = true;
        $sum = 0;
        for ($i = strlen($code) - 1; $i >= 0; $i--) {
            $sum += (int)$code[$i] * ($weightflag ? 3 : 1);
            $weightflag = !$weightflag;
        }
        $code .= (10 - ($sum % 10)) % 10;

        $check = Product::where('prod_code', $code)->exists();
        if ($check) {
            $this->generateEANCode();
        } else {
            return $code;
        }
    }

    public function generateEANBarcode()
    {
        $date = new DateTime();
        $time = $date->getTimestamp();
        $code = '20' . str_pad($time, 10, '0');
        $weightflag = true;
        $sum = 0;
        for ($i = strlen($code) - 1; $i >= 0; $i--) {
            $sum += (int)$code[$i] * ($weightflag ? 3 : 1);
            $weightflag = !$weightflag;
        }
        $code .= (10 - ($sum % 10)) % 10;

        $check = Material::where('barcode', $code)->exists();
        if ($check || !$code) {
            $this->generateEANCode();
        } else {
            return $code;
        }
    }
}
