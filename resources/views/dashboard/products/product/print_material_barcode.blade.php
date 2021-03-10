<!-- products [barcode , size , product type , material code] -->
@extends('index')

@push('styles')
    <style>
        @media print  {
            @page {
                /*size: 5mm 15mm;*/
                margin: auto;
            }
        }
        .span-style 
        {
            margin-left: 5px;
            font-size: 0.5em;
        }

        footer 
        {
            display: none;
        }
    
    </style>
@endpush
@section('content')
    @foreach($products as $product)
    <div style="page-break-after: always;margin:0;" class = "page">
        <img src = "{{asset(DNS1D::getBarcodePNGPath($product->material->barcode, 'C128' , 1.4 , 22 , array(0 , 0 , 0) , true))}}">
        {{--{!! DNS1D::getBarcodeHTML($product->prod_code, 'C39',1,50,'black', true) !!}--}}
    </div>
    @endforeach
@endsection

@push('scripts')
<script>
    window.print()
</script>
@endpush