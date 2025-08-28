<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h2>Messages</h2>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card-body p-t-0">
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