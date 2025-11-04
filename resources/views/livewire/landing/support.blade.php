<div>
    <div class="section breadcrumb_section bg_gray page-title-mini support-bg" wire:ignore.self>
        <div class="head-back">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-title text-center">
                            <h3 class="text-white mt-3">SUPPORT</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section suppor-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 pt-3">
                    <h3 class="page-title">Frequently asked questions</h3>
                    <ul class="nav nav-tabs flex-column faq_nav mt-4" id="myTab" role="tablist">
                        @foreach($data AS $k => $v)
                            @php
                            $string = strtolower($k);
                            $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
                            $string = preg_replace('/[^a-z0-9]+/', '-', $string);
                            $string = trim($string, '-');
                            $url = $string;

                            $active = "";
                            $selected = "false";
                            if($loop->index == 0){
                                $active = 'active';
                                $selected = "true";
                            }
                            @endphp
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $active }} bold-500" id="{{ $url }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $url }}" type="button" role="tab" aria-controls="{{ $url }}" aria-selected="{{ $selected }}">{{ $k }}</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-9">
                    <div class="tab-content" id="myTabContent">
                        @foreach($data AS $k => $dt)
                            @php
                            $string = strtolower($k);
                            $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
                            $string = preg_replace('/[^a-z0-9]+/', '-', $string);
                            $string = trim($string, '-');
                            $url = $string;

                            $active = "";
                            if($loop->index == 0){
                                $active = 'show active';
                            }
                            @endphp
                            <div class="tab-pane fade {{ $active }}" id="{{ $url }}" role="tabpanel" aria-labelledby="{{ $url }}-tab">
                                <div class="accordion" id="accordion_{{ $url}}">
                                    @foreach($dt AS $title => $vals)
                                        @php
                                        $i = $loop->index;
                                        $xpanded = "false";
                                        $collapsed = "collapsed";
                                        $show = "";
                                        /*
                                        if($i == 0){
                                            $xpanded = "true";
                                            $show = "show";
                                            $collapsed = "";
                                        }
                                        */
                                        @endphp
                                        <div class="accordion-item mb-2">
                                            <h2 class="accordion-header" id="heading_{{ $url.$i }}">
                                                <button class="accordion-button {{ $collapsed }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $url.$i }}" aria-expanded="{{ $xpanded }}" aria-controls="collapse_{{ $url.$i }}">
                                                    {{ $title }}
                                                </button>
                                            </h2>
                                            <div id="collapse_{{ $url.$i }}" class="faq accordion-collapse collapse {{ $show }}" aria-labelledby="heading_{{ $url.$i }}" data-bs-parent="#accordion_{{ $url}}">
                                                <div class="accordion-body">
                                                    @if(is_array($vals))
                                                        @foreach($vals AS $sub_title => $val)
                                                            @if(!is_numeric($sub_title))
                                                                {{ $sub_title }}
                                                            @endif
                                                            {!! $val !!}
                                                            <br />
                                                        @endforeach
                                                    @else
                                                        {{ $vals }}
                                                        <br />
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section" id="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="">
                        <h4 class="page-title">Need Support?</h4>
                        <h5 class="bold-600 font-21 text-upper">Get in touch</h5>
                        <div class="mt-3">
                            <p>For support, get in touch via email or fill in and submit the contact form and we we will get in touch with you.</p>
                        </div>
                    </div>
                    <div class="">
                        <div class="">
                            <i class="linearicons-envelope"></i>
                            <b>support@armourybroker.co.za</b>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    @if($errors->any())
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        </div>
                    </div>
                    @endif
                    @if (session('status'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        </div>
                    </div>
                    @endif
                    <form wire:submit.prevent="sendContact">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="text" class="form-control line_form-control" placeholder="Name" name="name" wire:model.defer="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="text" class="form-control line_form-control" placeholder="Surname" name="surname" wire:model.defer="surname">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="email" class="form-control line_form-control" placeholder="Email" name="email" wire:model.defer="email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <input type="email" class="form-control line_form-control" placeholder="Contact Number" name="contact_number" wire:model.defer="contact_number">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <textarea class="form-control line_form-control" placeholder="Message" name="message" wire:model.defer="message"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 text-end">
                                <a href="#" class="btn btn-primary-outline" wire:click.prevent="sendContact">Submit Form</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
