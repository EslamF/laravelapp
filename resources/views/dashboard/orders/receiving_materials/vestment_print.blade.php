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
    @foreach($vestments as $vestment)
    <div style="page-break-after: always;margin:0;" class = "page">
        <div> 
            <span class = "span-style">{{$vestment->name}} - </span>
            <span class = "span-style">وزن {{$vestment->weight}} - </span>
            <span class = "span-style">خامة {{$vestment->material->mq_r_code}}</span>
        </div>

        <div>
            {!! DNS1D::getBarcodeSVG($vestment->barcode, 'EAN13',2.1,100,'black', true) !!}

        </div>
    </div>
    @endforeach

    <a href="{{Route('order.receiving.material')}}" class="btn btn-info no-print float-left" style = "margin-top:10px">رجوع</a>
@endsection

@push('scripts')
<script>
    window.print()
</script>
@endpush