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
    <div style="page-break-after: always;margin:0;" class = "page">
        <div> 
            <span class = "span-style">{{$product->size->name}}</span>
            <span class = "span-style">{{$product->material->mq_r_code}}</span>
            <span class = "span-style">{{Str::limit($product->productType->name,50)}}</span>
        </div>

        <div>
            {{--<img src = "{{asset(DNS1D::getBarcodePNGPath($product->prod_code, 'C39+' , 0.7 , 40 , array(0 , 0 , 0) , true))}}">--}}
            {{--DNS1D::getBarcodeHTML('2003456123493', 'EAN13' , 0.7 , 40 , 'black', true)--}}
            {{-- DNS1D::getBarcodeSVG($product->prod_code, 'C39+',0.7,50,'black', true) --}}
            {{-- DNS1D::getBarcodeHTML('9780691147727', 'EAN13' , 0.7 , 40 , 'black', true)--}}
            {{--<img src = "{{asset(DNS1D::getBarcodePNGPath('2016177069120', 'EAN13' , 2 , 50 , array(0 , 0 , 0) , true))}}">--}}
            {!! DNS1D::getBarcodeSVG($product->prod_code, 'EAN13',2.1,100,'black', true) !!}
            {{-- DNS1D::getBarcodeHTML('9780691147727', 'C39+')--}}

        </div>
    </div>
    @endforeach
@endsection

@push('scripts')
<script>
    window.print()
</script>
@endpush