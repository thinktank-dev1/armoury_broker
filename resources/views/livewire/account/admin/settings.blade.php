<div class="container-fluid">
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"> 
                            <a class="nav-link active" data-bs-toggle="tab" href="#categories" role="tab" aria-selected="true">
                                <span class="hidden-sm-up">
                                    <i class="icons-Bulleted-List"></i>
                                </span> 
                                <span class="hidden-xs-down">Categories</span>
                            </a> 
                        </li>
                        <li class="nav-item"> 
                            <a class="nav-link" data-bs-toggle="tab" href="#delivery_options" role="tab" aria-selected="false">
                                <span class="hidden-sm-up">
                                    <i class="ti-truck"></i>
                                </span> 
                                <span class="hidden-xs-down">Shipping Options</span>
                            </a> 
                        </li>
                        <li class="nav-item"> <a class="nav-link" data-bs-toggle="tab" href="#profile" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Profile</span></a> </li>
                    </ul>
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane active" id="categories">
                            <livewire:account.admin.categories />
                        </div>
                        <div class="tab-pane" id="delivery_options"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
