<div id="main">
    <div class="wrapper">
        <section id="content">
                <!--start container-->
                <div class="container-fluid">
                    <!--card stats start-->
                    <div id="card-stats">
                        <div class="row">
                            <form class="col s12 m6 mT20 invoice_settings">
                                <div class="card">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="name" type="text" name="invoice_title" class="validate" value="<?php echo $billDetails_array['invoice_title']; ?>" />
                                            <label for="name">Name</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="contact_number" type="text" name="invoice_contact_number" class="validate" value="<?php echo $billDetails_array['invoice_contact_number']; ?>" />
                                            <label for="contact_number">Contact Number</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="email_id" type="text" name="invoice_email_id" class="validate" value="<?php echo $billDetails_array['invoice_email_id']; ?>" />
                                            <label for="email_id">Email ID</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="address" type="text" name="invoice_address" class="validate" value="<?php echo $billDetails_array['invoice_address']; ?>" />
                                            <label for="address">Address</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="pancard_number" type="text" name="pancard_number" class="validate" value="<?php echo $billDetails_array['pancard_number']; ?>" />
                                            <label for="pancard_number">Pancard Number</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="gst" type="text" name="gst_number" class="validate" value="<?php echo $billDetails_array['gst_number']; ?>" />
                                            <label for="gst">GST</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="invoice_prefix" type="text" name="invoice_prefix" class="validate" value="<?php echo $billDetails_array['invoice_prefix']; ?>" />
                                            <label for="invoice_prefix">Invoice Prefix</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <label for="invoice_prefix">Challan Print</label>
                                            <select name="challan_print" class="browser-default">
                                                <option value="0" <?php if($billDetails_array['challan_print'] == "0"){ ?>selected<?php } ?>>Single Per Page</option>
                                                <option value="1" <?php if($billDetails_array['challan_print'] == "1"){ ?>selected<?php } ?>>Double Per Page</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12 mB30">
                                            <input type="hidden" name="id" value="<?php echo $billDetails_array['id']; ?>" />
                                            <a class="waves-effect waves-light btn update-bill-setting">Save</a>
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
        $(document).on("click",".update-bill-setting",function(){
            $.ajax({
                type:"post",
                url:base_url+"Bills/update_bill_setting",
                dataType:"json",
                data:$(".invoice_settings").serialize(),
                success:function(val){
                    if($.trim(val) == "success"){
                        $(".alert-text").text("Data successfully updated");
                    }else{
                        $(".alert-text").text("Please try again");
                    }
                    $('#alert-model').modal('open');
                }
            });
        });
    });
    
</script>
