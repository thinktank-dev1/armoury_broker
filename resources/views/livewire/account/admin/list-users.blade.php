<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-12 d-flex">
            <div class="">
                <h2>USERS</h2>
            </div>
            <div class="ms-auto">
                <a href="#" class="btn btn-primary" wire:click.prevent="showEdit">Add User</a>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8"></div>
                        <div class="col-md-4">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="search-addon"><i class="icon-magnifier"></i></span>
                                <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="search-addon" wire:model.live="search_key">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Vendor</th>
                                        <th>Dealer</th>
                                        <th>Mobile Number</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users AS $user)
                                    <tr>
                                        <td>{{ $user->name.' '.$user->surname }}</td>
                                        <td>
                                            @if($user->vendor)
                                                <a href="{{ url('admin/vendors/'.$user->vendor->id) }}">
                                                    {{ $user->vendor->name }}
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->dealer)
                                                <a href="{{ url('admin/dealers/view/'.$user->dealer->id) }}">
                                                    {{ $user->dealer->business_name }}
                                                </a>
                                            @endif
                                        </td>
                                        <td>{{ $user->mobile_number }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if($user->status)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Disabled</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if($user->status)
                                                <a href="#" class="text-danger" wire:click.prevent="changeUserStatus({{ $user->id }},0)">Disable</a>
                                            @else
                                                <a href="#" class="text-success" wire:click.prevent="changeUserStatus({{ $user->id }},1)">Enable</a>
                                            @endif
                                            &nbsp;|&nbsp;
                                            <a href="#" wire:click.prevent="showEdit({{ $user->id }})">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="users-modal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Users</h5>
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
                    <form wire:submit.prevent="saveUser">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" wire:model.defer="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Surname</label>
                                    <input type="text" class="form-control" name="surname" wire:model.defer="surname">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="text" class="form-control" name="mobile_number" wire:model.defer="mobile_number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="text" class="form-control" name="email" wire:model.defer="email">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" wire:model.defer="password">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" wire:click.prevent="saveUser">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', () => {
            @this.on('show-form', () => {
                $('#users-modal').modal('show');
            });
            @this.on('close-modal', () => {
                $('.modal').modal('hide');
            })
        })
    </script>
    @endpush
</div>