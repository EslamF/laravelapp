<?php
use App\Models\Products\Product;
use App\Models\Orders\SaveOrder;
use App\Models\Materials\Material;
use App\Models\Materials\Vestment;
use App\Models\Orders\BuyOrder;

function generate_product_code_not_in_array($array)
{
    $number = rand(0, 900000000);
    $code = generateEAN($number);

    $check = Product::where('prod_code', $code)->exists();

    if ($check) 
    {
        generate_product_code_not_in_array($array);
    } else 
    {
        if(in_array($code , $array))
        {
            generate_product_code_not_in_array($array);
        }
        else 
        {
            return $code;
        }
    }

    return $code;
}

function generate_product_code()
{
    $number = rand(0, 900000000);
    $code = generateEAN($number);

    $check = Product::where('prod_code', $code)->exists();

    if ($check) 
    {
        generate_product_code();
    } 
    else 
    {
        return $code;
    }

    return $code;
}


function generate_save_order_code()
{
    $code = rand(0, 6000000000000);
    $check = SaveOrder::where('code', $code)->exists();
    if ($check) {
        generateSaveOrderCode();
    } else {
        return $code;
    }
}

function generate_product_produce_code()
{
    $code = rand(0, 6000000000000);
    $check = Product::where('produce_code', $code)->exists();
    if ($check) {
        generate_product_produce_code();
    } else {
        return $code;
    }
}

function generate_product_material_code()
{
    $code = rand(0, 6000000000000);
    $check = Product::where('produce_code', $code)->exists();
    if ($check) {
        generate_product_material_code();
    } else {
        return $code;
    }
}

function generate_material_barcode()
{
    $number = rand(0, 900000000);
    $code = generateEAN($number);

    $check = Material::where('barcode', $code)->exists();

    if ($check) 
    {
        generate_material_barcode();
    } 
    else 
    {
        return $code;
    }

    return $code;
}

function generate_vestment_barcode()
{
    $number = rand(0, 900000000);
    $code = generateEAN($number);

    $check = Vestment::where('barcode', $code)->exists();

    if ($check) 
    {
        generate_vestment_barcode();
    } 
    else 
    {
        return $code;
    }

    return $code;
}

function generate_buy_order_barcode()
{
    $number = rand(0, 900000000);
    $code = generateEAN($number);

    $check = BuyOrder::where('bar_code', $code)->exists();

    if ($check) 
    {
        generate_buy_order_barcode();
    } 
    else 
    {
        return $code;
    }

    return $code;
}


function generateEAN($number)
{
  $code = '200' . str_pad($number, 9, '0');
  $weightflag = true;
  $sum = 0;
  // Weight for a digit in the checksum is 3, 1, 3.. starting from the last digit. 
  // loop backwards to make the loop length-agnostic. The same basic functionality 
  // will work for codes of different lengths.
  for ($i = strlen($code) - 1; $i >= 0; $i--)
  {
    $sum += (int)$code[$i] * ($weightflag?3:1);
    $weightflag = !$weightflag;
  }
  $code .= (10 - ($sum % 10)) % 10;
  return $code;
}
