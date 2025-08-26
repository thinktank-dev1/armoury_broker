<div>
    <style>
        ol {
            counter-reset: item;
            list-style: none; 
            /*padding-left: 1.5em;*/
        }
        ol li {
            display: block;
        }
        ol li::before {
            counter-increment: item;
            content: counters(item, ".") " ";
        }
        ul {
            list-style: disc;
            padding-left: 1.5em;
        }
        ul li {
            display: list-item;
        }
        ul li::before {
            content: none;
        }
    </style>
    <div class="section pt-5">
        <div class="container">
            <div class="row align-items-center mb-4">
                <div class="col-md-12 text-center">
                    <h2 class="page-title">Terms of Use and User Agreement</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {!! $printData !!}
                </div>
            </div>
        </div>
    </div>
</div>
