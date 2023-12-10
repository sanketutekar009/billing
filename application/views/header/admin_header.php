<nav class="nav-extended">
        <div class="nav-wrapper">
                <a href="<?php echo base_url('generate-bill'); ?>" class="brand-logo"><?php echo CGS; ?></a>
                <a href="javascript:;" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                        <li class="<?php if($page == 'generate-bills'){ ?>active<?php } ?>"><a href="<?php echo base_url('generate-bill'); ?>">Generate Bill</a></li>
                        <li class="<?php if($page == 'search-bills'){ ?>active<?php } ?>"><a href="<?php echo base_url('search-bills'); ?>">Search Bills</a></li>
                        <li class="<?php if($page == 'product-list'){ ?>active<?php } ?>"><a href="<?php echo base_url('product-list'); ?>">Products</a></li>
                        <li class="<?php if($page == 'create-customers'){ ?>active<?php } ?>"><a href="<?php echo base_url('create-customers'); ?>">Create Customers</a></li>
                        <li class="<?php if($page == 'settings'){ ?>active<?php } ?>"><a class="dropdown-button" href="#!" data-activates="website-settings-dropdown">Settings<i class="material-icons right">arrow_drop_down</i></a></li>
                        <li><a href="<?php echo base_url('logout'); ?>">Logout</a></li>
                </ul>

                <!-- Challans Dropdown Mobile Structure -->
                <ul id="website-challan-dropdown" class="dropdown-content">
                        <li><a href="<?php echo base_url('generate-challan'); ?>">Generate Challan</a></li>
                        <li><a href="<?php echo base_url('search-challans'); ?>">Search Challans</a></li>
                </ul>
                
                <!-- Setting Dropdown Mobile Structure -->
                <ul id="settings-dropdown" class="dropdown-content">
                        <li><a href="<?php echo base_url('bill-setting'); ?>">Bills</a></li>
                        <li><a href="<?php echo base_url('change-password'); ?>">Change Password</a></li>
                        <li><a href="<?php echo base_url('create-users'); ?>">Create Users</a></li>
                </ul>

                <!-- Setting Dropdown Website Structure -->
                <ul id="website-settings-dropdown" class="dropdown-content">
                        <li><a href="<?php echo base_url('bill-setting'); ?>">Bills</a></li>
                        <li><a href="<?php echo base_url('change-password'); ?>">Change Password</a></li>
                        <li><a href="<?php echo base_url('create-users'); ?>">Create Users</a></li>
                </ul>

                <ul class="side-nav" id="mobile-demo">
                        <li class="<?php if($page == 'generate-bills'){ ?>active<?php } ?>"><a href="<?php echo base_url('generate-bill'); ?>">Generate Bill</a></li>
                        <li class="<?php if($page == 'search-bills'){ ?>active<?php } ?>"><a href="<?php echo base_url('search-bills'); ?>">Search Bills</a></li>
                        <li class="<?php if($page == 'product-list'){ ?>active<?php } ?>"><a href="<?php echo base_url('product-list'); ?>">Products</a></li>
                        <li class="<?php if($page == 'create-customers'){ ?>active<?php } ?>"><a href="<?php echo base_url('create-customers'); ?>">Create Customers</a></li>
                        <li class="<?php if($page == 'settings'){ ?>active<?php } ?>"><a class="dropdown-button" href="#!" data-activates="settings-dropdown">Settings<i class="material-icons right">arrow_drop_down</i></a></li>
                        <li><a href="<?php echo base_url('logout'); ?>">Logout</a></li>
                </ul>
        </div>
</nav>
<!-- Start Page Loading -->
<div id="loader-wrapper" style="display:none;">
        <div id="loader"></div>        
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
</div>

<!-- Alert Box -->
<!-- Modal Structure -->
<div id="alert-model" class="modal">
        <div class="modal-content">
                <h4><?php echo CGS; ?></h4>
                <p class="alert-text"></p>
        </div>
        <div class="modal-footer">
                <a href="javascript:;" class="modal-action modal-close waves-effect waves-green btn-flat alert-box-close">OK</a>
        </div>
</div>

<!-- Delete Box -->
<div id="delete-model" class="modal">
        <div class="modal-content">
                <h4><?php echo CGS; ?></h4>
                <div class="input-field col s6">
                        <label for="enter_password">Enter Password</label>
                        <input id="enter_password" name="enter_password" type="password" class="validate" />
                </div>
        </div>
        <div class="modal-footer">
                <a href="javascript:;" class="modal-action waves-effect waves-green btn-flat delete-model-save">OK</a>
                <a href="javascript:;" class="modal-action modal-close waves-effect waves-green btn-flat alert-box-close">Close</a>
        </div>
</div>

<script type="text/javascript">
        $(document).ready(function(){
                $('#alert-model, #delete-model').modal();
                $(".dropdown-button").dropdown();
                $(".button-collapse").sideNav();

                $(document).on("click",".alert-box-close",function(){
                       location.reload();
                });

                $(document).on("click",".delete-model-save",function(){
                        $.ajax({
                                type:"post",
                                url:base_url+"Users/verify_password",
                                data:{
                                        enter_password:$("#enter_password").val()
                                },
                                dataType:"json",
                                success:function(val){
                                        if($.trim(val) == "password_matched"){
                                                delete_data();
                                        }else{
                                                $("#delete-model").modal("close");
                                                $(".alert-text").text("Password doesn't match");
                                                $('#alert-model').modal('open');
                                        }
                                }
                        });
                });
        });

        var delay = (function(){
            var timer = 0;
            return function(callback, ms){
                clearTimeout (timer);
                timer = setTimeout(callback, ms);
            };
        })();
</script>