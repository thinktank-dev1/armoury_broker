<div>
    <div class="container-fluid">
        <div class="row mt-3">
            <div class="col-md-12">
                <h3 class="page-title bold" wire:ignore>
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
                                        <a href="#" class="btn @if($read_type == 'unread') btn-primary @else btn-secondary @endif" wire:click.prevent="changeType('unread')">Unread</a>
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
                                                    @if($msg->user->vendor)
                                                        @if($msg->user->vendor->avatar)
                                                            <img src="{{ asset('storage/'.$msg->user->vendor->avatar) }}" alt="user-img" class="avatar"> 
                                                        @else
                                                            <img src="{{ asset('img/PROFILE PIC.png') }}" alt="user-img" class="avatar"> 
                                                        @endif
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
                                                                @if($msg->user->vendor)
                                                                {{ $msg->user->vendor->name }}
                                                                @else
                                                                {{ $msg->user->name.' '.$msg->user->surname }}
                                                                @endif
                                                            @else
                                                                {{ $msg->name.' '.$msg->surname }}
                                                            @endif
                                                            @if($msg->product)
                                                                - {{ $msg->product->item_name }}
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
                                                @if($cur_msg->user->vendor)
                                                    @if($cur_msg->user->vendor->avatar)
                                                        <img src="{{ asset('storage/'.$cur_msg->user->vendor->avatar) }}" alt="user-img" class="avatar"> 
                                                    @else
                                                        <img src="{{ asset('img/PROFILE PIC.png') }}" alt="user-img" class="avatar"> 
                                                    @endif
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
                                                            @if($cur_msg->user->vendor)
                                                                {{ $cur_msg->user->vendor->name }}
                                                            @else
                                                                {{ $cur_msg->user->name.' '.$cur_msg->user->surname }}
                                                            @endif
                                                        @else
                                                            {{ $cur_msg->name.' '.$cur_msg->surname }}
                                                        @endif
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <small>
                                                <strong>Safety Reminder</strong>
                                                <ul>
                                                    <li>Always use the "Buy" button when making purchases</li>
                                                    <li>Payments outside Armoury Broker violate our Terms and Conditions and are not protected</li>
                                                    <li>Never open external links or scan QR codes sent through platform messaging. Keep all communication on the platform</li>
                                                    <li>Armoury Broker will never ask you to change your login information, banking details, or social media account information</li>
                                                    <li>All firearm transactions must comply with the Firearms Control Act of South Africa 60 of 2000</li>
                                                    <li>Legal liability for correct firearm transfer procedures rests with the license holder and not Armoury Broker (Pty) Ltd or any of its members</li>
                                                </ul>
                                            </small>
                                        </div>
                                        <div class="chat-container" wire:poll.15s>
                                            <div class="chat-body" id="chat-body">
                                                @foreach($cur_msg->messages as $message)
                                                <div x-data x-intersect.once="$wire.markAsViewed({{ $message->id }})">
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
                                                                        @if($message->action == "countered")
                                                                            You Counter offered.
                                                                        @elseif($message->action == "reject")
                                                                            You rejected the offer.
                                                                        @elseif($message->action == "accept")
                                                                            You've accepted the offer.
                                                                        @elseif($message->action == "cancelled")
                                                                            Offer was cancelled.
                                                                        @elseif($message->action == "product changed")
                                                                            Product Changed
                                                                        @else
                                                                            <p>What would you like to do?</p>
                                                                            <div class="text-center">
                                                                                <a href="#" class="btn btn-secondary px-3 py-1" wire:click.prevent="changeActionStatus({{ $message->id }}, 'accept')">Accept</a>
                                                                                <a href="#" class="btn btn-secondary px-3 py-1" wire:click.prevent="changeActionStatus({{ $message->id }}, 'reject')">Reject</a>
                                                                                <a href="#" class="btn btn-secondary px-3 py-1" wire:click.prevent="showCounterModal({{ $message->id }})">Counter</a>
                                                                            </div>
                                                                        @endif
                                                                    @else
                                                                    <p>You made an offer.</p>
                                                                    <div class="text-center">
                                                                        @if($message->action == "countered")
                                                                            Offer was countered.
                                                                        @elseif($message->action == "reject")
                                                                            Offer was rejected.
                                                                        @elseif($message->action == "accept")
                                                                            Offer was accepted. <a href="{{ url('shop/product/'.$cur_msg->product->id) }}">Click here to go to product</a>
                                                                        @elseif($message->action == "cancelled")
                                                                            Offer was cancelled.
                                                                        @elseif($message->action == "product changed")
                                                                            Product Changed
                                                                        @else
                                                                            <a href="#" class="btn btn-secondary px-3 py-1" wire:click.prevent="cancelOffer({{ $message->id }})">Cancel Offer</a>
                                                                        @endif
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @elseif($message->message == "You have a new counter offer")
                                                    <span style="font-size: 12px"><b>{{ $message->user->vendor->name }}</b> has made a counter offer.</span>
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
                                                                        @if($message->action == "countered")
                                                                            You Counter offered.
                                                                        @elseif($message->action == "reject")
                                                                            You rejected the offer.
                                                                        @elseif($message->action == "accept")
                                                                            You accepted the offer.
                                                                        @elseif($message->action == "product changed")
                                                                            Product Changed
                                                                        @else
                                                                            <p>What would you like to do?</p>
                                                                            <div class="text-center">
                                                                                <a href="#" class="btn btn-secondary px-3 py-1" wire:click.prevent="changeActionStatus({{ $message->id }}, 'accept')">Accept</a>
                                                                                <a href="#" class="btn btn-secondary px-3 py-1" wire:click.prevent="changeActionStatus({{ $message->id }}, 'reject')">Reject</a>
                                                                                <a href="#" class="btn btn-secondary px-3 py-1" wire:click.prevent="showCounterModal({{ $message->id }})">Counter</a>
                                                                            </div>
                                                                        @endif
                                                                    @else
                                                                    <p>You made an offer.</p>
                                                                    <div class="text-center">
                                                                        @if($message->action == "countered")
                                                                            Offer was countered.
                                                                        @elseif($message->action == "reject")
                                                                            Offer was rejected.
                                                                        @elseif($message->action == "accept")
                                                                            Offer was accepted. <a href="{{ url('shop/product/'.$cur_msg->product->id) }}">Click here to go to product</a>
                                                                        @elseif($message->action == "product changed")
                                                                            Product Changed
                                                                        @else
                                                                            <a href="#" class="btn btn-secondary px-3 py-1" wire:click.prevent="cancelOffer({{ $message->id }})">Cancel Offer</a>
                                                                        @endif
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="chat-message {{ $message->user_id === auth()->id() ? 'sent' : 'received' }}">
                                                        <div class="message-bubble">
                                                            @php
                                                            $masked = preg_replace_callback(
                                                                '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/',
                                                                function ($m) {
                                                                    [$user, $domain] = explode('@', $m[0]);
                                                                    return strlen($user) <= 2
                                                                    ? str_repeat('*', strlen($user)) . '@' . $domain
                                                                    : $user[0] . str_repeat('*', strlen($user) - 2) . $user[-1] . '@' . $domain;
                                                                },
                                                                $message->message
                                                            );
                                                            $regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@";
                                                            $masked = preg_replace($regex, '*', $masked);
                                                            $masked = preg_replace('/\b((https?|ftp|file):\/\/|www\.)[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', ' ', $masked);

                                                            @endphp
                                                            {!! $masked !!}
                                                        </div>
                                                        <div class="message-time">
                                                            {{ $message->created_at->format('H:i') }}
                                                        </div>
                                                    </div>
                                                    @endif
                                                    @if($message->attachment)
                                                        @php
                                                        $file = storage_path('app/public/'.$message->attachment);
                                                        $is_image = false;
                                                        if (exif_imagetype($file)) {
                                                            $is_image = true;
                                                        } 
                                                        else {
                                                            $is_image = false;
                                                        }
                                                        @endphp
                                                        @if($is_image)
                                                        <img src="{{ asset('storage/'.$message->attachment) }}" style="width: 50%;">
                                                        @else
                                                        <a href="{{ url('storage/'.$message->attachment) }}" target="_blank">View attachment</a>
                                                        @endif
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @if($cur_msg->user->vendor->id != 1)
                                        <div class="">
                                            <div class="input-group">
                                                <input type="text" class="form-control border-right-none" placeholder="Reply..." name="message" wire:model.defer="message">
                                                <label class="input-group-text chat-file-link" for="fileInput" style="cursor:pointer;">
                                                    <i class="mdi mdi-paperclip"></i>
                                                </label>
                                                <input type="file" id="fileInput" hidden wire:model.live="message_attachment">
                                                <button class="btn btn-primary" type="button" id="button-addon1" wire:click.prevent="sendMessage">Send</button>
                                            </div>
                                            @if($message_attachment)
                                            <div class="form-text">
                                                @php
                                                $is_temp_image = str_starts_with($message_attachment->getMimeType(), 'image/');
                                                @endphp
                                                @if($is_temp_image)
                                                <a href="{{ $message_attachment->temporaryUrl() }}" target="_blank">View attachment</a>
                                                @endif
                                                <span class="ms-3"><a href="#" class="text-danger" wire:click.prevent="removeAttachment"><i class="ti-trash"></i></a></span>
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="counter-offer-modal" wire:ignore.self>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Counter Offer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if($errors->any())
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="alert alert-danger">
                                    {{ $errors->first() }}
                                </div>
                            </div>
                        </div>
                        @endif
                        <form wire:submit.prevent="saveCounterOffer">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label">Counter Offer Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">R</span>
                                            <input type="number" class="form-control" nae="counter_amount" wire:model.defer="counter_amount">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" wire:click.prevent="saveCounterOffer">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', () => {
                @this.on('close-modal', () => {
                    $('.modal').modal('hide');
                });
                @this.on('show-offer-modal', () => {
                    $('#counter-offer-modal').modal('show');
                });
            });
        </script>
        @endpush
    </div>
</div>