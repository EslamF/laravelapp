<!-- products [barcode , size , product type , material code] -->
@extends('index')

@push('styles')
    <style>
        @media print  {
            * 
            {
                margin: 0;
            }
            @page {
                size: 38mm 25mm;
               
                /*size: A4 landscape;*/

            }
        }

        .span-style 
        {
            margin-left: 5px;
            font-size: 12pt;
            font-family: 'Times New Roman', Times, serif;
        }

        footer 
        {
            display: none;
        }


    
    </style>
@endpush
@section('content')
    @foreach($products as $product)
    <div style="page-break-after: always;margin-bottom:10px;" class = "page">
        <div> 
            <span class = "span-style">{{$product->size->name}}</span>
            <span class = "span-style">{{$product->material->mq_r_code}}</span>
            <span class = "span-style">{{$product->productType->name}}</span>
        </div>

        <div>
            {{--<img src = "{{asset(DNS1D::getBarcodePNGPath($product->prod_code, 'C39+' , 0.7 , 40 , array(0 , 0 , 0) , true))}}">--}}
            {!! DNS1D::getBarcodeSVG($product->prod_code, 'C39+',0.7,40,'black', true) !!}
        </div>
    </div>
    @endforeach
@endsection

@push('scripts')
<script>
    window.print()
</script>
@endpush