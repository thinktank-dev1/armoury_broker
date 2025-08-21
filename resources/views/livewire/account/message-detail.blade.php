<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12">
            <h2>Messages</h2>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card b-all shadow-none">
                @foreach($messages AS $msg)
                <div class="card-body">
                    <div class="m-b-40">
                        <div class="p-l-10">
                            <h4 class="m-b-0">
                                @if($msg->fromUser)
                                    {{ $msg->fromUser->name.' '.$msg->fromUser->surname }}
                                @else
                                    {{ $msg->name.' '.$msg->surname }}
                                @endif
                            </h4>
                            <small class="text-muted">
                                From: 
                                @if($msg->fromUser)
                                    {{ $msg->fromUser->email }}
                                @else
                                    {{ $msg->email }}
                                @endif
                            </small>
                            @if($msg->contact_number)
                            <br />
                            <small class="text-muted">
                                Contact: {{ $msg->contact_number }}
                            </small>
                            @endif
                        </div>
                    </div>
                    {{ $msg->message }}
                </div>
                @if(($loop->index + 1) != $messages->count())
                <div>
                    <hr class="m-t-0">
                </div>
                @endif
                @endforeach
                <div>
                    <hr class="m-t-0">
                </div>
                <div class="card-body">
                    @if($errors->any())
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        </div>
                    </div>
                    @endif
                    @if (session('status'))
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="b-all">
                        <div class="mb-3">
                            <label class="form-label">Reply</label>
                            <textarea rows="5" class="form-control" name="message" wire:model.defer="message"></textarea>
                        </div>
                        <div class="mt-3">
                            <a href="#" class="btn btn-primary" wire:click.prevent="sendMessage">Send</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
