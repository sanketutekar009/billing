<div id="main">
    <div class="wrapper">
        <section id="content">
                <!--start container-->
                <div class="container-fluid">
                    <!--card stats start-->
                    <div id="card-stats">
                        <div class="row">
                            <?php if(empty($_GET["referrer"])){ ?>
                                <form class="col s12 mT20 create-customers">
                                    <div class="card">
                                        <div class="row">
                                            <div class="input-field col s12 m4">
                                                <input id="name" type="text" name="company_name" class="validate" value="<?php echo $edit_customer_details['0']['company_name']; ?>" autofocus />
                                                <label for="name">Name</label>
                                            </div>

                                            <div class="input-field col s12 m4">
                                                <input id="contact_number" type="text" name="company_number" class="validate" value="<?php echo $edit_customer_details['0']['company_number']; ?>" />
                                                <label for="contact_number">Contact Number</label>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input id="email_id" type="text" name="company_email" class="validate" value="<?php echo $edit_customer_details['0']['company_email']; ?>" />
                                                <label for="email_id">Email ID</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m4">
                                                <input id="address" type="text" name="company_address" class="validate" value="<?php echo $edit_customer_details['0']['company_address']; ?>" />
                                                <label for="address">Address</label>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input id="alternate_address" type="text" name="company_alternate_address" class="validate" value="<?php echo $edit_customer_details['0']['company_alternate_address']; ?>" />
                                                <label for="alternate_address">Alternate Address</label>
                                            </div>
                                            <div class="input-field col s12 m4">
                                                <input id="gst" type="text" name="gst_number" class="validate" value="<?php echo $edit_customer_details['0']['gst_number']; ?>" />
                                                <label for="gst">GST</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 m4">
                                                <input id="code" type="text" name="code" class="validate" value="<?php echo $edit_customer_details['0']['code']; ?>" />
                                                <label for="code">Code</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12 mB30">
                                                <?php if(empty($edit_customer_details)){ ?>
                                                    <a class="waves-effect waves-light btn save-company">Save</a>
                                                <?php }else{ ?>
                                                    <input type="hidden" name="id" value="<?php echo $edit_customer_details['0']['id']; ?>" />
                                                    <a class="waves-effect waves-light btn update-company">Update</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            <?php } ?>

                            <div class="col s12 mT20">
                                <div class="card">
                                    <table class="responsive-table">
                                        <thead>
                                            <tr>
                                                <th class="txt-left">Name</th>
                                                <th class="txt-left">Email ID</th>
                                                <th class="txt-right">Contact Number</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($customer_details)){ foreach($customer_details as $keys=>$values){ ?>
                                                <tr>
                                                    <td class="txt-left"><?php if(strlen($values["code"]) > 0){echo "[".$values["code"]."] ";}echo $values["company_name"]; ?></td>
                                                    <td class="txt-left"><?php echo (strlen($values["company_email"]) > 0 ? $values["company_email"] : "-"); ?></td>
                                                    <td class="txt-right"><?php echo (strlen($values["company_number"]) > 0 ? $values["company_number"] : "-"); ?></td>
                                                    <td>
                                                        <a class="btn-floating btn-small right mL10 delete-company red" lang="<?php echo $values['id']; ?>">
                                                                <i class="small material-icons">delete</i>
                                                        </a>
                                                        <a href="<?php echo base_url('create-customers/'.$values['id']); ?>" class="btn-floating btn-small right" lang="<?php echo $values['id']; ?>">
                                                                <i class="small material-icons">mode_edit</i>
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
        $(document).on("click",".save-company",function(){
            if($.trim($("input[name='company_name']").val()).length > 0){
                $("input[name='company_name']").css("border-bottom","1px solid #9e9e9e");
                $.ajax({
                    type:"post",
                    url:base_url+"Customers/insert_customer_details",
                    data:$(".create-customers").serialize(),
                    dataType:"json",
                    success:function(val){
                        if($.trim(val) == "success"){
                            $(".alert-text").text("Data successfully added");
                        }else{
                            $(".alert-text").text("Please try again");
                        }
                        $('#alert-model').modal('open');
                    }
                });
            }else{
                $("input[name='company_name']").css("border-bottom","1px solid red");
            }
        });

         $(document).on("click",".update-company",function(){
            $.ajax({
                type:"post",
                url:base_url+"Customers/update_customer_details",
                data:$(".create-customers").serialize(),
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
        
        $(document).on("click",".delete-company",function(){
            var id = $(this).attr("lang");
            $("#delete-model").modal("open");
            $(".delete-model-save").attr("lang", id);
        });
        /*$(document).on("click",".delete-company",function(){
            if(confirm("Do you really want to delete this entry?")){
                $.ajax({
                    type:"post",
                    url:base_url+"Customers/delete_customer_details",
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
        });*/
    });

    function delete_data(){
        $.ajax({
            type:"post",
            url:base_url+"Customers/delete_customer_details",
            data:{
                id:$(".delete-model-save").attr("lang")
            },
            dataType:"json",
            success:function(val){
                $("#delete-model").modal("close");
                if($.trim(val) == "success"){
                    $(".alert-text").text("Data successfully deleted");
                }else{
                    $(".alert-text").text("Please try again");
                }
                $('#alert-model').modal('open');
            }
        });
    }
</script>