<!-- products [barcode , size , product type , material code] -->
@extends('index')

@push('styles')
<link rel="stylesheet" href="{{asset('print.min.css')}}" type="text/css">
    <style>
        @media print  {
            * 
            {
                margin: 0;
            }
            @page {
                /* size: 35mm 25mm;  */
                /* margin: 25mm 25mm 25mm 25mm;   */
                /* margin: 0;*/
                size: A4 landscape;
                /* size: auto;    */

                /* this affects the margin in the printer settings */ 
                margin: 0mm 0mm 0mm 0mm;  
            } 

            }
            body 
            {
                margin: 0;
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
<div id = "content_here" style = "display:inline-block;text-align:center" >
    @foreach($products as $product)
    <div style="page-break-after: always;margin:0;" class = "page">
        <div> 
            <span class = "span-style">{{$product->size->name}}</span>
            <span class = "span-style">{{$product->material->mq_r_code}}</span>
            
        </div>

        <div style = "">
            {{--<img src = "{{asset(DNS1D::getBarcodePNGPath($product->prod_code, 'C39+' , 0.7 , 40 , array(0 , 0 , 0) , true))}}">--}}
            {{--DNS1D::getBarcodeHTML('2003456123493', 'EAN13' , 0.7 , 40 , 'black', true)--}}
            {{-- DNS1D::getBarcodeSVG($product->prod_code, 'C39+',0.7,50,'black', true) --}}
            {{-- DNS1D::getBarcodeHTML('9780691147727', 'EAN13' , 0.7 , 40 , 'black', true)--}}
            {{--<img src = "{{asset(DNS1D::getBarcodePNGPath('2016177069120', 'EAN13' , 2 , 50 , array(0 , 0 , 0) , true))}}">--}}
            {{-- {!! DNS1D::getBarcodeSVG($product->prod_code, 'EAN13',2.1,100,'black', true) !!} --}}
            {!! DNS1D::getBarcodeSVG($product->prod_code, 'EAN13',2.8,100,'black', true) !!}
            {{-- DNS1D::getBarcodeHTML('9780691147727', 'C39+')--}}

            

        </div>

        <span class = "" style = "display:inline-block;margin-right:50px;">M.O.M Brand</span>
    </div>
</div>
    @endforeach
@endsection

@push('scripts')
<script src = "{{asset('print.min.js')}}"></script>
<script>
    function printDiv() {
            var divContents = document.getElementById("content_here").innerHTML;
            var a = window.open('', '', 'height=100, width=100');
            a.document.write('<html>');
            a.document.write('<body>');
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            a.print();
        }
    // window.print()
    //printDiv();
    //printJS('content_here', 'html')
    printJS({printable: 'content_here',
             type: 'html',
             maxWidth: '500',
              
              })
</script>
@endpush