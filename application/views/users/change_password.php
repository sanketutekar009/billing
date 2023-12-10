<div id="main">
    <div class="wrapper">
        <section id="content">
                <!--start container-->
                <div class="container-fluid">
                    <!--card stats start-->
                    <div id="card-stats">
                          <div class="row">
                            <form class="col s12 m4 mT20 update-users">
                                <div class="card">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="name" name="name" type="text" class="validate" value="<?php echo $internal_users['name']; ?>" readonly />
                                            <label for="name">Name</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="contact_number" name="contact_number" type="text" class="validate" value="<?php echo $internal_users['contact_number']; ?>" readonly />
                                            <label for="contact_number">Contact Number</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="username" name="username" type="text" class="validate" value="<?php echo $internal_users['username']; ?>" />
                                            <label for="username">Username</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="email_id" name="email_id" type="text" class="validate" value="<?php echo $internal_users['email_id']; ?>" />
                                            <label for="email_id">Email ID</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="password" name="password" type="password" class="validate" value="" />
                                            <label for="password">Password</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <input name="id" type="hidden" class="validate" value="<?php echo $internal_users['id']; ?>" />
                                        <div class="input-field col s12 mB30">
                                            <a class="waves-effect waves-light btn update-user">Update</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--card stats end-->
                </div>
                <!--end container-->
        </section>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click",".update-user",function(){
            $.ajax({
                type:"post",
                url:base_url+"Users/update_user_details",
                data:$(".update-users").serialize(),
                dataType:"json",
                success:function(val){
                    if($.trim(val) == "success"){
                        $(".alert-text").text("Data successfully updated");
                    }else{
                        $(".alert-text").text("Please try again");
                    }
                    $('#alert-model').modal('open');
                }
            })
        });
    });
</script>