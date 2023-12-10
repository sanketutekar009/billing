<div id="main">
    <div class="wrapper">
        <section id="content">
                <!--start container-->
                <div class="container-fluid">
                    <!--card stats start-->
                    <div id="card-stats">
                        <div class="row">
                            <form class="col s12 m4 mT20 create-users">
                                <div class="card">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="name" type="text" name="name" class="validate" value="" autofocus />
                                            <label for="name">Name</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="username" type="text" name="username" class="validate" value="" />
                                            <label for="username">Username</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="password" type="password" name="password" class="validate" value="" />
                                            <label for="password">Password</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="email_id" type="text" name="email_id" class="validate" value="" />
                                            <label for="email_id">Email ID</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="contact_number" type="text" name="contact_number" class="validate" value="" />
                                            <label for="contact_number">Contact Number</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 mB30">
                                            <a class="waves-effect waves-light btn save-user">Save</a>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="col s12 m8 mT20">
                                <div class="card">
                                    <table class="responsive-table">
                                        <thead>
                                            <tr>
                                                <th class="txt-left">Name</th>
                                                <th class="txt-left">Username</th>
                                                <th class="txt-left">Email ID</th>
                                                <th class="txt-right">Contact Number</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($internal_users)){ foreach($internal_users as $keys=>$values){ ?>
                                                <tr>
                                                    <td class="txt-left"><?php echo $values["name"]; ?></td>
                                                    <td class="txt-left"><?php echo $values["username"]; ?></td>
                                                    <td class="txt-left"><?php echo $values["email_id"]; ?></td>
                                                    <td class="txt-right"><?php echo $values["contact_number"]; ?></td>
                                                    <td>
                                                        <a class="btn-floating btn-small" lang="<?php echo $values["id"]; ?>">
                                                                <i class="small material-icons">mode_edit</i>
                                                        </a>
                                                        <a class="btn-floating btn-small delete-user red" lang="<?php echo $values["id"]; ?>">
                                                                <i class="small material-icons">delete</i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php }} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
        $(document).on("click",".save-user",function(){
            var err_array = new Array();
            $('.validate').each(function(){
                var current_name = $(this).attr('name');
                switch(current_name){
                    case 'name':
                    case 'username':
                    case 'password':
                        if ($.trim($(this).val()).length == 0){
                            $(this).css('border-bottom','1px solid red'); 
                            err_array.push(current_name);
                        }else{
                            $(this).css('border-bottom','1px solid #9e9e9e'); 
                        }
                    break;
                }
            });

            if(err_array.length == 0){
                $.ajax({
                    type:"post",
                    url:base_url+"Users/insert_user_details",
                    data:$(".create-users").serialize(),
                    dataType:"json",
                    success:function(val){
                        if($.trim(val) == "success"){
                            $(".alert-text").text("Data successfully added");
                        }else{
                            $(".alert-text").text("Please try again");
                        }
                        $('#alert-model').modal('open');
                    }
                })
            }
        });

        $(document).on("click",".delete-user",function(){
            if(confirm("Do you really want to delete this entry?")){
                $.ajax({
                    type:"post",
                    url:base_url+"Users/delete_user_details",
                    data:{
                        id:$(this).attr("lang")
                    },
                    dataType:"json",
                    success:function(val){
                        if($.trim(val) == "success"){
                            $(".alert-text").text("Data successfully deleted");
                        }else{
                            $(".alert-text").text("Please try again");
                        }
                        $('#alert-model').modal('open');
                    }
                });
            }
        });
    });
</script>