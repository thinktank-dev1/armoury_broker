<div>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-12">
                <h3 class="page-title bold">
                    @if(url()->current() != URL::previous())
                    <a href="{{ URL::previous() }}" wire:ignore><i class="fas fa-angle-left"></i></a> 
                    @endif
                    MESSAGES
                </h3>
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
                            <div class="col-md-4">
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
                                            @foreach($mesages AS $msg)
                                            <div class="chat-item @if($active_id == $msg->id) active @endif" wire:click.prevent="changeCurMessage({{ $msg->id }})">
                                                @if($msg->user)
                                                    @if($msg->user->vendor->avatar)
                                                        <img src="{{ asset('storage/'.$msg->user->vendor->avatar) }}" alt="user-img" class="avatar"> 
                                                    @else
                                                        <img src="{{ asset('img/PROFILE PIC.png') }}" alt="user-img" class="avatar"> 
                                                    @endif
                                                @else
                                                    <img src="{{ asset('img/PROFILE PIC.png') }}" alt="user-img" class="avatar">
                                                @endif
                                                <div class="chat-info">
                                                    <div class="chat-header">
                                                        <span class="chat-name">
                                                            @if($msg->user)
                                                                {{ $msg->user->vendor->name }}
                                                            @else
                                                                {{ $msg->name.' '.$msg->surname }}
                                                            @endif
                                                        </span>
                                                        <span class="chat-time">{{ date('Y-m-d', strtotime($msg->created_at)) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                @if($cur_msg)
                                <div class="card">
                                    <div class="card-header d-flex bg-dark p-0">
                                        <div class="chat-item bb-none">
                                            @if($cur_msg->user)
                                                @if($cur_msg->user->vendor->avatar)
                                                    <img src="{{ asset('storage/'.$cur_msg->user->vendor->avatar) }}" alt="user-img" class="avatar"> 
                                                @else
                                                    <img src="{{ asset('img/PROFILE PIC.png') }}" alt="user-img" class="avatar"> 
                                                @endif
                                            @else
                                                <img src="{{ asset('img/PROFILE PIC.png') }}" alt="user-img" class="avatar">
                                            @endif
                                            <div class="chat-info">
                                                <div class="chat-header">
                                                    <h4 class="card-title text-white">
                                                        @if($cur_msg->user)
                                                            {{ $cur_msg->user->vendor->name }}
                                                        @else
                                                            {{ $cur_msg->name.' '.$cur_msg->surname }}
                                                        @endif
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="chat-container" wire:poll.15s>
                                            <div class="chat-body" id="chat-body">
                                                @foreach($cur_msg->messages as $message)
                                                    @if($message->message == "You have a new offer")
                                                    <span style="font-size: 12px"><b>{{ $message->user->vendor->name }}</b> has made an offer.</span>
                                                    <div class="card bordered">
                                                        <div class="card-header bg-dark">
                                                            <h5 class="card-title bold text-white">OFFER</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    @if($cur_msg->product->images->count() > 0)
                                                                    <img src="{{ asset('storage/'.$cur_msg->product->images->first()->image_url) }}" class="offer-product-img">
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <h5 class="bold">{{ $cur_msg->product->item_name }}</h5>
                                                                    <b class="bold"><s>R {{ number_format($cur_msg->product->item_price,2) }}</s></b><br />
                                                                    <b class="bold">R {{ number_format($message->offer_amount,2) }}</b><br />
                                                                </div>
                                                                <div class="col-md-7 text-center">
                                                                    @if($message->user_id != auth()->id())
                                                                    <p>What would you like to do?</p>
                                                                    <div class="text-center">
                                                                        <a href="#" class="btn btn-secondary px-3 py-1">Accept</a>
                                                                        <a href="#" class="btn btn-secondary px-3 py-1">Reject</a>
                                                                        <a href="#" class="btn btn-secondary px-3 py-1">Counter</a>
                                                                    </div>
                                                                    @else
                                                                    <p>You made an offer.</p>
                                                                    <div class="text-center">
                                                                        <a href="#" class="btn btn-secondary px-3 py-1">Cancel Offer</a>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="chat-message {{ $message->user_id === auth()->id() ? 'sent' : 'received' }}">
                                                        <div class="message-bubble">
                                                            {{ $message->message }}
                                                        </div>
                                                        <div class="message-time">
                                                            {{ $message->created_at->format('H:i') }}
                                                        </div>
                                                    </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Reply..." name="message" wire:model.defer="message">
                                                <button class="btn btn-primary" type="button" id="button-addon1" wire:click.prevent="sendMessage">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
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