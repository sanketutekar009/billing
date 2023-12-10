<div id="main">
    <div class="wrapper">
        <section id="content">
            <!--start container-->
            <div class="container-fluid">
                <div class="row">
                        <div class="input-field col s12 m9">
                            <i class="material-icons prefix mT10">search</i>
                            <input id="icon_prefix" type="text" class="validate autocomplete-input" autocomplete="off" lang="" />
                            <label for="icon_prefix">Search Product</label>
                        </div>
                        <div class="col s12 m3">
                            <a class="waves-effect waves-light btn mT20 search-product">Search</a>
                            <a class="waves-effect waves-light btn mT20 grey darken-4 modal-trigger" href="#create-product-modal">Add New</a>
                        </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <div class="card">
                            <table class="responsive-table">
                                <thead>
                                    <tr>
                                        <th class="txt-left">Product Name</th>
                                        <th class="txt-right">HSN</th>
                                        <th class="txt-right">GST</th>
                                        <th class="txt-right">Amount</th>
                                        <th width="200" class="txt-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($products)){ foreach($products as $keys=>$values){ ?>
                                        <tr>
                                            <td class="txt-left"><?php echo $values["product_name"]; ?></td>
                                            <td class="txt-right"><?php echo $values["hsn_code"]; ?></td>
                                            <td class="txt-right"><?php echo $values["gst"]; ?>%</td>
                                            <td class="txt-right">&#8377;<?php echo $values["product_rate"]; ?></td>
                                            <td class="txt-right">
                                                <a class="btn-floating btn-small remove_more right mR10 red delete-product" href="javascript:;" id="<?php echo $values['id']; ?>">
                                                        <i class="small material-icons">delete</i>
                                                </a>
                                                <a class="btn-floating btn-small add_more right mR10 mL10 edit-product" href="javascript:;" id="<?php echo $values['id']; ?>">
                                                        <i class="small material-icons">edit</i>
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
        </section>
    </div>        
</div>
<!-- Modal Structure -->
<div id="create-product-modal" class="modal">
    <div class="modal-content">
        <h4>Create new product</h4>
        <div class="row">
            <form class="col s12 product-details">
                <div class="row">
                    <div class="input-field col s6">
                        <input name="product_name" id="product_name" type="text" class="validate" autofocus />
                        <label for="product_name">Product Name</label>
                    </div>
                    <div class="input-field col s6">
                        <input name="hsn_code" id="hsn_code" type="text" class="validate">
                        <label for="hsn_code">HSN Code</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s3">
                        <input name="gst" id="gst" type="text" class="validate">
                        <label for="gst">GST</label>
                    </div>
                    <div class="input-field col s3">
                        <input name="rate" id="rate" type="text" class="validate">
                        <label for="rate">Rate</label>
                    </div>
                    <div class="input-field col s6">
                        <input name="product_barcode" id="product_barcode" type="text" class="validate">
                        <label for="product_barcode">Barcode</label>
                    </div>
                    <input type="hidden" name="id" id="id" />
                </div>
            </form>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:;" class="save-product waves-effect waves-light waves-teal btn-flat">Save</a>
        <a href="javascript:;" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
    </div>
</div>

  <script type="text/javascript">
    $(document).ready(function(){
        // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
        $('.modal').modal();

        $(document).on("click","#content .modal-trigger",function(){
            $("#id").val("");
            $("#product_name").val("");
            $("#hsn_code").val("");
            $("#gst").val("");
            $("#rate").val("");
        });

        $(document).on("click",".save-product",function(){
            if($("#product_name").val() != ""){
                $.ajax({
                    type:"post",
                    url:base_url+"Products/insert_products",
                    data:$(".product-details").serialize(),
                    dataType:"json",
                    success:function(val){
                        if($.trim(val) == "success"){
                            if($("#id").val() == ""){
                                $(".alert-text").text("Product successfully created");
                            }else{
                                $(".alert-text").text("Product successfully updated");
                            }
                        }else{
                            $(".alert-text").text("Please try again");
                        }
                        $('#create-product-modal').modal('close');
                        $('#alert-model').modal("open");
                    }
                });
            }
        });

        $(document).on("click",".edit-product",function(){
            var id = $(this).attr("id");
            if(id > 0){
                $.ajax({
                    type:"post",
                    url:base_url+"Products/search_products/json",
                    data:{
                        id:id
                    },
                    dataType:"json",
                    success:function(val){
                        if($.trim(val) == "error"){
                            $(".alert-text").text("Please try again");
                            $('#alert-model').modal("open");
                        }else{
                            $.each(val.product_array, function(i, values){
                                $("#id").val(values.id);
                                $("#product_name").val(values.product_name);
                                $("#hsn_code").val(values.hsn_code);
                                $("#gst").val(values.gst);
                                $("#rate").val(values.product_rate);
                                $("#product_barcode").val(values.product_barcode);
                            });
                            $('#create-product-modal').modal('open');
                            Materialize.updateTextFields();   
                        }
                    }
                });
            }
        });

        $(document).on("click",".delete-product",function(){
            if(confirm("Do you really want to delete this entry?")){
                $.ajax({
                    type:"post",
                    url:base_url+"Products/delete_products",
                    data:{
                        id:$(this).attr("id")
                    },
                    dataType:"json",
                    success:function(val){
                        if($.trim(val) == "success"){
                            $(".alert-text").text("Product successfully deleted");
                        }else{
                            $(".alert-text").text("Please try again");
                        }
                        $('#alert-model').modal("open");
                    }
                });
            }
        });

        $("html, body").on("click",function(){
            $(".autocomplete-content").remove();
        });

        $(document).on("keyup",".autocomplete-input",function(e){
            $(".autocomplete-input").attr("lang", "");
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
            }else if(e.keyCode == "13"){
                if($(".focus").length > 0){
                    var product_selected = $(".focus").text();  
                    var id = $(".focus").attr("id"); 
                    $(".autocomplete-input").attr("lang",id); 
                    $(".autocomplete-input").val(product_selected);
                    $(".autocomplete-content").remove();
                }else{
                    $(".autocomplete-content").remove();
                    search_product();
                }
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
                                var eq = $(".autocomplete-input").attr("position");
                                var position = $(".autocomplete-input").offset();
                                var width = $(".autocomplete-input").outerWidth();
                                var height = $(".autocomplete-input").outerHeight();
                                $(".autocomplete-content").css({
                                    top:position.top+height+20,
                                    left:position.left,
                                    width:width
                                });
                            }
                        });
                    }, 500 );
                }else{
                    $(".autocomplete-content").remove();
                }
            }
        });

        $(document).on("click",".autocomplete-content li",function(){
            var product_selected = $(this).text();  
            var id = $(this).attr("id"); 
            $(".autocomplete-input").val(product_selected);
            $(".autocomplete-input").attr("lang",id);
            search_product();
        });

        $(document).on("click",".search-product",function(){
            search_product();
        });
    });

    function search_product(){
        var input_lang = $(".autocomplete-input").attr("lang");
        var input_value = $.trim($(".autocomplete-input").val());
        $.ajax({
            type:'post',
            url:base_url+"Products/search_products",
            data:(input_lang == "" ? "product_name="+ input_value : "id="+input_lang),
            dataType:'json',
            success:function(val){
                var table_rows = "";
                $.each(val.product_array, function(i, values){
                    table_rows += '<tr>';
                        table_rows += '<td class="txt-left">'+values.product_name+'</td>';
                        table_rows += '<td class="txt-right">'+values.hsn_code+'</td>';
                        table_rows += '<td class="txt-right">'+values.gst+'%</td>';
                        table_rows += '<td class="txt-right">₹'+values.product_rate+'</td>';
                        table_rows += '<td>';
                            table_rows += '<a class="btn-floating btn-small remove_more right mR10 red delete-product" href="javascript:;" id="'+values.id+'">';
                                table_rows += '<i class="small material-icons">delete</i>';
                            table_rows += '</a>';

                            table_rows += '<a class="btn-floating btn-small add_more right mR10 mL10 edit-product" href="javascript:;" id="'+values.id+'">';
                                table_rows += '<i class="small material-icons">edit</i>';
                            table_rows += '</a>';
                        table_rows += '</td>';
                    table_rows += '</tr>';
                });
                $(".responsive-table tbody tr").remove();
                $(".responsive-table tbody").append(table_rows);
            }
        });
    }
  </script>