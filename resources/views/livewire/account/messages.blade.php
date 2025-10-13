<div>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-12">
                <h3 class="page-title bold">MESSAGES</h3>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card bg-none">
                    <div class="card-header bg-dark">
                        <h3 class="card-title text-white">ARMOURY BROKER MESSAGING</h3>
                    </div>
                    <div class="card-body pt-3 px-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="#" class="btn @if($read_type == 'Unread') btn-primary @else btn-secondary @endif" wire:click.prevent="changeType('unread')">Unread</a>
                                        <a href="#" class="btn @if($read_type == 'read') btn-primary @else btn-secondary @endif" wire:click.prevent="changeType('read')">Read</a>
                                    </div>
                                </div>
                                <div class="card mt-3">
                                    <div class="card-body">
                                        <h3 class="bold">Chats</h3>
                                        <div class="">
                                            <ul class="chatonline style-none ps ps--theme_default" data-ps-id="da6c87b3-32a6-11fe-4009-985bbc2e3034">
                                                @foreach($mesages AS $msg)
                                                <li>
                                                    <a href="javascript:void(0)">
                                                        @if($msg->vendor_id != Auth::user()->vendor_id)
                                                        <img src="{{ asset('storage/'.$msg->vendor->avatar) }}" alt="user-img" class="img-circle"> 
                                                        @else
                                                        @endif
                                                        <span>Varun Dhavan</span>
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h3 class="page-title bold">MESSAGES</h3>
                        <div class="card b-all shadow-none">
                            <div class="inbox-center table-responsive">
                                <table class="table table-hover no-wrap">
                                    <tbody>
                                        @foreach($mesages AS $msg)
                                        <tr @if($msg->status == 0) class="unread" @endif>
                                            <td style="width:40px" class="hidden-xs-down">
                                                <i class="far fa-star"></i>
                                            </td>
                                            <td class="hidden-xs-down">
                                                @if($msg->user)
                                                    {{ $msg->user->name.' '.$msg->user->surname }}
                                                @else
                                                    {{ $msg->name.' '.$msg->surname }}
                                                @endif
                                            </td>
                                            <td class="max-texts"> 
                                                <a href="{{ url('messages/'.$msg->id) }}">
                                                    @if($msg->children->count() > 0)
                                                    <span class="label label-info m-r-10">{{ $msg->children->count() }}</span>
                                                    @endif 
                                                    @php
                                                    $string = $msg->message;
                                                    $maxLen = 100;
                                                    $str =  substr($string, 0, $maxLen); 
                                                    if(strlen($string) > $maxLen){}  $str = $str.' ...';
                                                    @endphp
                                                    {{ $str }}
                                                </a>
                                            </td>
                                            <td class="text-end"> {{ date('d M y H:i', strtotime($msg->created_at)) }} </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($mesages->count() == 0)
                                <div class="text-center mt-5">
                                    <h1 class="text-muted">Get started</h1>
                                    <p>Your messages will show here when buyers contact you.</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        --}}
    </div>
</div>