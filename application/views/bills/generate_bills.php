<div id="main">
    <div class="wrapper">
        <section id="content">
                <!--start container-->
                <div class="container-fluid">
                    <!--card stats start-->
                    <div class="row">
                        <div class="input-field col s12 m3 mT40">
                        <label for="" class="">Company</label>
                            <input type="text" name="company_id" class="" value="<?php echo $bill_details['0']["coporate_id"]; ?>" />
                            <!-- <select name="company_id">
                                <option value="" disabled selected>Choose Company</option>
                                <?php // if(!empty($customer_details)){ foreach($customer_details as $keys=>$values){ ?>
                                    <option value="<?php echo $values["id"]; ?>" <?php if($values["id"] == $bill_details['0']["coporate_id"]){ ?>selected<?php } ?>><?php if(strlen($values["code"]) > 0){echo "[".$values["code"]."] ";} echo $values["company_name"]; ?></option>
                                <?php // }} ?>
                            </select> -->
                        </div>
                        <div class="input-field col s6 m1 mT40">
                            <label for="" class="">Bill Number</label>
                            <input type="text" name="bill_number" class="" value="<?php if($bill_number != ""){echo $bill_number; }else{ echo $bill_details['0']['invoice_number']; } ?>" />
                        </div>
                        <div class="col s6 m2 mT20">
                            <label for="" class="">Bill Date</label>
                            <input type="text" name="bill_date" class="datepicker" value="<?php if(!empty($bill_details) && $bill_details['0']['invoice_date'] != "0000-00-00"){ echo date("d F, Y", strtotime($bill_details['0']['invoice_date']));}else{ echo date('d F, Y'); } ?>" />
                        </div>
                        <div class="input-field col s4 m1 mT40">
                            <label for="" class="">Discount</label>
                                <input type="text" name="bill_discount" value="<?php echo $bill_details['0']['bill_discount']; ?>" />
                        </div>
                        <div class="input-field col s4 m1 mT40">
                            <label for="" class="">Contact Person</label>
                            <input type="text" name="bill_contact_person" value="<?php echo $bill_details['0']['bill_contact_person']; ?>" />
                        </div>
                        <div class="col s4 m1 mT40">
                            <select class="browser-default" name="print_details">
                                <option value="" disabled selected>Print Details</option>
                                <option value="no">No</option>
                                <option value="yes">Yes</option>
                            </select>
                        </div>
                        <div class="input-field col s12 m2 mT40">
                            <?php if(empty($bill_details)){ ?>
                                <button class="btn-floating btn-small waves-effect waves-light save-bill" type="button" name="save-bill">
                                    <i class="material-icons right small">save</i>
                                </button>
                            <?php }else{ ?>
                                <input type="hidden" name="id" value="<?php echo $bill_details['0']['main_id']; ?>" /> 
                                <button class="btn-floating btn-small waves-effect waves-light update-bill" type="button" name="save-bill">
                                    <i class="material-icons right">save</i>
                                </button>
                                <a class="btn-floating btn-small remove_more mL10" href="<?php echo base_url('print-bill/'.$bill_details['0']['main_id']); ?>">
                                    <i class="small material-icons">print</i>
                                </a>
                            <?php } ?>
                        </div>
                        <div class="col s12 ">
                            <div class="card">
                                <table id="editable-table" class="bordered">
                                    <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Products</th>
                                            <th style="display: none;">HSN</th>
                                            <th>MRP</th>
                                            <th style="display: none;">GST%</th>
                                            <th style="display: none;">CESS</th>
                                            <th style="width:8%;">&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(!empty($bill_details)){ foreach($bill_details as $keys=>$values){ ?>
                                            <tr>
                                                <td><?php echo $values["qty"]; ?></td>
                                                <td class="autocomplete"><?php echo $values["item_name"]; ?></td>
                                                <td style="display: none;"><?php echo $values["hsn"]; ?></td>
                                                <td mrp="<?php echo $values["actual_mrp"]; ?>"><?php echo $values["mrp"]; ?></td>
                                                <td style="display: none;"><?php echo $values["cgst"]+$values["sgst"]; ?></td>
                                                <td style="display: none;"><?php echo $values["cess"]; ?></td>
                                                <td class="edit-disabled" lang="<?php echo $values['item_id']; ?>">
                                                    <a class="btn-floating btn-small add_more" href="javascript:;">
                                                        <i class="small material-icons">add</i>
                                                    </a>
                                                    <a class="btn-floating btn-small remove_more red" href="javascript:;">
                                                        <i class="small material-icons">delete</i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php }} ?>
                                        <!-- Add blank rows by default -->
                                        <?php for($i=0;$i<10;$i++){ ?>
                                            <tr>
                                                <td></td>
                                                <td class="autocomplete"></td>
                                                <td style="display: none;"></td>
                                                <td mrp=""></td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td class="edit-disabled">
                                                    <a class="btn-floating btn-small add_more" href="javascript:;">
                                                        <i class="small material-icons">add</i>
                                                    </a>
                                                    <a class="btn-floating btn-small remove_more red" href="javascript:;">
                                                        <i class="small material-icons">delete</i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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
        $('select[name="print_details"]').material_select();
        $('#editable-table').editableTableWidget({
            disableClass: "edit-disabled",
            editor: $('<textarea style="background:#f9f9f9;">'),
            cloneProperties: ['height','width','class']
        });

        $("html, body").on("click",function(){
            $(".autocomplete-content").remove();
        });

        $(document).on("focus","td",function(e){
            $(".autocomplete-content").remove();
        });

        $(document).on("keyup",".autocomplete-textarea",function(e){
            if(e.keyCode == "40"){
                next_index = parseInt(parseInt($(".focus").index())+parseInt(1));
                //console.log("40 "+next_index);
                $(".autocomplete-content li:eq('"+next_index+"')").focus();                             
                $(".focus").removeClass("focus");                   
                $(".autocomplete-content li:eq('"+next_index+"')").addClass("focus");
                $(this).focus();
            }else if(e.keyCode == "38"){
                prev_index = parseInt(parseInt($(".focus").index())-parseInt(1));
                //console.log("38 "+prev_index);
                $(".autocomplete-content li:eq('"+prev_index+"')").focus();                             
                $(".focus").removeClass("focus");                   
                $(".autocomplete-content li:eq('"+prev_index+"')").addClass("focus");
                $(this).focus();
            }else{
                var search_value = $.trim($(this).val());
                if (search_value.length > 2) {
                    delay(function(){
                        $.ajax({
                            type:'post',
                            url:base_url+"Products/search_products",
                            data:{
                                product_name:search_value
                            },
                            dataType:'json',
                            success:function(val){
                                var auto_suggest = '<ul class="autocomplete-content dropdown-content" style="position:absolute;">';
                                    $.each(val.product_array, function(i, values){
                                        auto_suggest += '<li id="'+values.id+'" hsn="'+values.hsn_code+'" gst="'+values.gst+'" rate="'+values.product_rate+'">'+values.product_name+'</li>';
                                    });
                                    auto_suggest += '</ul>';
                                $(".autocomplete-content").remove();
                                $("body").after(auto_suggest);
                                var eq = $(".autocomplete-textarea").attr("position");
                                var position = $(".autocomplete:eq('"+eq+"')").offset();
                                var width = $(".autocomplete:eq('"+eq+"')").outerWidth();
                                var height = $(".autocomplete-textarea").outerHeight();
                                $(".autocomplete-content").css({
                                    top:position.top+height+20,
                                    left:position.left,
                                    width:width
                                });

                                if(val.action_type == "barcode"){
                                    $(".autocomplete-content li:first").trigger("click");
                                }
                            }
                        });
                    }, 500 );
                }else{
                    $(".autocomplete-content").remove();
                }
            }
        });

        $(document).on("click",".focus, .autocomplete-content li",function(){
            var eq = $(".autocomplete-textarea").attr("position");  
            var product_selected = $(this).text();   
            if(product_selected != "No Result Found"){
                var hsn = $(this).attr("hsn");  
                var mrp = $(this).attr("rate");  
                var gst = $(this).attr("gst");  
                var Obj = $(".autocomplete:eq('"+eq+"')").parent();
                $("td:eq('2')", Obj).text(hsn);
                $("td:eq('3')", Obj).text(mrp);
                $("td:eq('3')", Obj).attr('mrp', mrp);
                $("td:eq('4')", Obj).text(gst);
                $(".autocomplete:eq('"+eq+"')").text(product_selected);
            }   
        });

        $(document).on("click",".add_more",function(){
            var add_more = '<tr><td></td><td class="autocomplete"></td><td style="display:none;"></td><td mrp=""></td><td style="display:none;"></td><td style="display:none;"></td><td class="edit-disabled"><a class="btn-floating btn-small add_more" href="javascript:;"><i class="small material-icons">add</i></a><a class="btn-floating btn-small remove_more mR10 mL10 red" href="javascript:;"><i class="small material-icons">delete</i></a></td></tr>';
            $("tr:last").after(add_more);
            $('#editable-table').editableTableWidget({
                disableClass: "edit-disabled",
                editor: $('<textarea style="background:#f9f9f9;">'),
                cloneProperties: ['height','width']
            });
        }); 
        
        $(document).on("click",".remove_more",function(){
            var id = $(this).closest(".edit-disabled").attr("lang");
            if(id != undefined){
                $(this).closest("tr").hide();
                $(this).closest(".edit-disabled").attr("element_removed","yes");
            }else{
                $(this).closest("tr").remove();
            }
        }); 

        $(document).on("click",".save-bill",function(){
            post_data("add");
        });

        $(document).on("click",".update-bill",function(){
            post_data("update");
        }); 

        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: true, // Creates a dropdown of 15 years to control year,
            today: false,
            clear: false,
            close: false,
            closeOnSelect: true // Close upon selecting a date,
        });
        
        $('.datepicker').on('mousedown',function(event){
          event.preventDefault();
        });

        function post_data($flag){
            var hsn = new Array();
            var products = new Array();
            var qty = new Array();
            var mrp = new Array();
            var actual_mrp = new Array();
            var gst = new Array();
            var cess = new Array();
            var ids = new Array();
            var is_deleted = new Array();

            $("#editable-table tbody tr").each(function(){
                var qty_value = $.trim($("td:eq('0')",this).text());
                var products_value = $.trim($("td:eq('1')",this).text());
                var hsn_value = $.trim($("td:eq('2')",this).text());
                var mrp_value = $.trim($("td:eq('3')",this).text());
                var actual_mrp_value = $.trim($("td:eq('3')",this).attr('mrp'));
                var gst_value = $.trim($("td:eq('4')",this).text());
                var cess_value = $.trim($("td:eq('5')",this).text());
                var ids_value = $.trim($(".edit-disabled",this).attr("lang"));
                var is_deleted_value = $.trim($(".edit-disabled",this).attr("element_removed"));

                if(products_value.length > 0){
                    hsn.push(hsn_value);
                    products.push(products_value);
                    qty.push(qty_value);
                    mrp.push(mrp_value);
                    actual_mrp.push(actual_mrp_value)
                    gst.push(gst_value);
                    cess.push(cess_value);
                    ids.push(ids_value);
                    is_deleted.push(is_deleted_value);
                }
            });

            if(products.length > 0){
                if($flag == "add"){
                    $.ajax({
                        type:"post",
                        url:base_url+"Bills/insert_bill",
                        dataType:"json",
                        data:{
                            company_id:$("input[name='company_id']").val(),
                            bill_number:$("input[name='bill_number']").val(),
                            purchase_order_number:$("input[name='purchase_order_number']").val(),
                            bill_date:$("input[name='bill_date']").val(),
                            bill_discount:$("input[name='bill_discount']").val(),
                            bill_contact_person:$("input[name='bill_contact_person']").val(),
                            hsn:hsn,
                            products:products,
                            qty:qty,
                            mrp:mrp,
                            actual_mrp:actual_mrp,
                            gst:gst,
                            cess:cess
                        },
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
                    $.ajax({
                        type:"post",
                        url:base_url+"Bills/update_bill",
                        dataType:"json",
                        data:{
                            company_id:$("input[name='company_id']").val(),
                            bill_number:$("input[name='bill_number']").val(),
                            purchase_order_number:$("input[name='purchase_order_number']").val(),
                            bill_date:$("input[name='bill_date']").val(),
                            bill_discount:$("input[name='bill_discount']").val(),
                            bill_contact_person:$("input[name='bill_contact_person']").val(),
                            hsn:hsn,
                            products:products,
                            qty:qty,
                            mrp:mrp,
                            actual_mrp:actual_mrp,
                            gst:gst,
                            cess:cess,
                            id:ids,
                            is_deleted:is_deleted,
                            main_id:$("input[name='id']").val()
                        },
                        success:function(val){
                            if($.trim(val) == "success"){
                                $(".alert-text").text("Data successfully updated");
                            }else{
                                $(".alert-text").text("Please try again");
                            }
                            $('#alert-model').modal('open');
                        }
                    });
                }
            }
        }
    });
</script>