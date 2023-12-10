<div id="main">
    <div class="wrapper">
        <section id="content">
            <!--start container-->
            <div class="container-fluid">
                <div class="row">
                    <form class="col s12">
                        <div class="col s4 m2">
                            <label for="" class="">Filter By</label>
                            <select name="filter_by" class="browser-default">
                                <option value="">All</option>
                                <option value="company-name" <?php if($_GET["filter_by"] == "company-name"){ ?>selected<?php } ?>>Company Name</option>
                                <option value="date" <?php if($_GET["filter_by"] == "date"){ ?>selected<?php } ?>>Date</option>
                                <option value="bill-number" <?php if($_GET["filter_by"] == "bill-number"){ ?>selected<?php } ?>>Bill Number</option>
                            </select>
                        </div>
                        <div class="input-field col s12 m4 mT20">
                            <i class="material-icons prefix mT10">search</i>
                            <input type="text" id="autocomplete-input" class="autocomplete autocomplete-input" value="<?php if($_GET['query'] != ""){ echo $_GET['query']; } ?>" lang="<?php if($_GET['company_id'] != ""){ echo $_GET['company_id']; } ?>">
                            <label for="autocomplete-input">Search Bill</label>
                        </div>
                        <div class="col s3 m2">
                            <label for="" class="">From Date</label>
                            <input type="text" name="from_date" class="datepicker" value="<?php echo $from_date; ?>" />
                        </div>
                        <div class="col s3 m2">
                            <label for="" class="">To Date</label>
                            <input type="text" name="to_date" class="datepicker" value="<?php echo $to_date; ?>" />
                        </div>
                        <div class="col s6 m2">
                            <button class="btn-floating btn-small waves-effect waves-light search-bill mT20" type="button" name="save-bill">
                                <i class="material-icons right small">search</i>
                            </button>
                            <a href="<?php echo base_url('search-bills'); ?>" class="btn-floating btn-small waves-effect waves-light search-bill mT20 red" type="button" name="save-bill">
                                <i class="material-icons right small">clear</i>
                            </a>
                            <!-- <button class="btn-floating btn-small waves-effect waves-light download-bill mT20 green" type="button" name="save-bill">
                                <i class="material-icons right small">file_download</i>
                            </button> -->
                        </div>
                    </form>

                    <div class="col s12">
                        <table class="bordered">
                            <thead>
                                <tr>
                                    <th class="txt-left">Company Name</th>
                                    <th class="txt-right">Invoice Number</th>
                                    <th class="txt-center">Month</th>
                                    <th class="txt-right">Amount</th>
                                    <th class="txt-center">Status</th>
                                    <th class="txt-center" style="width:15%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($bill_details)){ foreach($bill_details as $keys=>$values){ ?>
                                    <tr>
                                        <td class="txt-left"><?php if(strlen($values["code"]) > 0){echo "[".$values["code"]."] ";} echo $values["company_name"]; ?></td>
                                        <td class="txt-right"><?php echo $values["invoice_number"]; ?></td>
                                        <td class="txt-center"><?php echo date("M-Y", strtotime($values["invoice_date"])); ?></td>
                                        <td class="txt-right">&#8377;<?php echo convert_indian_currency($values["invoice_amount"]); ?></td>
                                        <td class="txt-center"><?php echo $values["bill_status"]; ?></td>
                                        <td class="edit-disabled txt-right">
                                            <a class="btn-floating btn-small add_more grey" href="<?php echo base_url('generate-bill/'.$values['id']); ?>">
                                                <i class="small material-icons">edit</i>
                                            </a>
                                            <a class="btn-floating btn-small remove_more" href="<?php echo base_url('print-bill/'.$values['id']); ?>">
                                                <i class="small material-icons">print</i>
                                            </a>
                                            <a class="btn-floating btn-small remove_more red delete-bill" href="javascript:;" lang="<?php echo $values["id"]; ?>">
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
        </section>
    </div>        
</div>
<!-- Modal Structure -->
<div id="add-comment-modal" class="modal">
    <div class="modal-content">
        <h4><span id="company_name"></span> <span id="bill_month" style="font-size:18px;"></span></h4>
        <div class="row">
            <div class="col s6 m4">
                <h6 id="bill_no">Bill No: <span></span></h6>
            </div>
            <div class="col s6 m4">
                <h6 id="bill_amount">Bill Amount: <span></span></h6>
            </div>
            <div class="col s6 m4">
                <h6 id="created_by">Created By: <span></span></h6>
            </div>
            <div class="col s12">
                <h6>Status: </h6>
                <select id="status" class="browser-default" style="width:200px">
                    <option value="">Choose your option</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
            <div class="col s12">
                <h6 id="created_by">Comment: </h6>
                <textarea id="comments" class="materialize-textarea"></textarea>
                <input type="hidden" id="bill_id" />
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:;" class="save-comment waves-effect waves-light waves-teal btn-flat">Save</a>
        <a href="javascript:;" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
    </div>
</div>

<!-- Download data -->
<div id="download-modal" class="modal">
    <div class="modal-content">
        <h4>Download data by</h4>
        <div class="row">
            <select id="status" class="browser-default" style="width:200px">
                <option value="">Choose your option</option>
                <option value="company">Company</option>
                <option value="bills">Bills</option>
                <option value="filters">Download by filters</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <a href="javascript:;" class="waves-effect waves-light waves-teal btn-flat">Download</a>
        <a href="javascript:;" class="modal-action modal-close waves-effect waves-green btn-flat">Cancel</a>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        // the "href" attribute of the modal trigger must specify the modal ID that wants to be triggered
        $('.modal').modal();
        
        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: true, // Creates a dropdown of 15 years to control year,
            today: false,
            clear: false,
            close: false,
            closeOnSelect: true, // Close upon selecting a date,
            format:'dd-mm-yyyy',
        });
        
        $('.datepicker').on('mousedown',function(event){
          event.preventDefault();
        });

        $(document).on("click",".search-bill", function(){
            filter_data();
        });

        $(document).on("click","#content .modal-trigger",function(){
            $("#add-comment-modal #company_name").text("");
            $("#bill_month").text("");
            $("#bill_no span").text("");
            $("#bill_amount span").text("");
            $("#created_by span").text("");
            $("#status").val("");
            $("#bill_id").val("");
            $("#comments").val("");
        });

        $(document).on("click",".add-comment",function(){
            var Obj = $(this);
            $.ajax({
                type:"post",
                    url:base_url+"Bills/get_bill_details_comments",
                    data:{
                        id:Obj.attr("lang")
                    },
                    dataType:"json",
                    success:function(val){
                        if($.trim(val) != "error"){
                            $("#add-comment-modal #company_name").text(Obj.closest("tr").find("td:first").text());
                            $("#bill_month").text(val.invoice_date);
                            $("#bill_no span").text(val.invoice_number);
                            $("#bill_amount span").text("₹"+val.invoice_amount);
                            $("#created_by span").text(val.name);
                            $("#status").val(val.bill_status);
                            $("#bill_id").val(val.id);
                            $("#comments").val(val.invoice_comment);
                            $("#add-comment-modal").modal("open");
                        }else{
                            $(".alert-text").text("Please try again");
                            $('#alert-model').modal('open');
                        }
                    }
            });
        });

        $(document).on("click",".save-comment",function(){
            $.ajax({
                    type:"post",
                    url:base_url+"Bills/save_bill_comments",
                    data:{
                        id:$("#bill_id").val(),
                        bill_status:$("#status").val(),
                        invoice_comment:$("#comments").val(),
                    },
                    dataType:"json",
                    success:function(val){
                        if($.trim(val) == "success"){
                            $("#add-comment-modal").modal("close");
                            $(".alert-text").text("Data successfully updated");
                        }else{
                            $(".alert-text").text("Please try again");
                        }
                        $('#alert-model').modal('open');
                    }
                });
        });

        $(document).on("click",".delete-bill",function(){
            var id = $(this).attr("lang");
            $("#delete-model").modal("open");
            $(".delete-model-save").attr("lang", id);
        });

        $(document).on("click",".download-bill",function(){
            $("#download-modal").modal("open");
        });
        /*$(document).on("click",".delete-bill",function(){
            if(confirm("Do you really want to delete this bill?")){
                var Obj = $(this);
                $.ajax({
                    type:"post",
                    url:base_url+"Bills/delete_bill",
                    data:{
                        id:Obj.attr("lang")
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

        /** Auto Suggest **/
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
                    var company_selected = $(".focus").text();  
                    var id = $(".focus").attr("id"); 
                    $(".autocomplete-input").attr("lang",id); 
                    $(".autocomplete-input").val(company_selected);
                    $(".autocomplete-content").remove();
                    filter_data();
                }else{
                    $(".autocomplete-content").remove();
                }
            }else{
                var search_value = $.trim($(this).val());
                if (search_value.length > 2) {
                    delay(function(){
                        $.ajax({
                            type:'post',
                            url:base_url+"Customers/search_customers",
                            data:{
                                customer_name:search_value
                            },
                            dataType:'json',
                            success:function(val){
                                var auto_suggest = '<ul class="autocomplete-content dropdown-content" style="position:absolute;">';
                                    $.each(val, function(i, values){
                                        auto_suggest += '<li id="'+values.id+'">'+(values.code.length > 0 ? "["+values.code+"] " : "")+values.company_name+'</li>';
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
            var company_selected = $(this).text();  
            var id = $(this).attr("id"); 
            $(".autocomplete-input").val(company_selected);
            $(".autocomplete-input").attr("lang",id);
            filter_data()
        });


    });

    function delete_data(){
        $.ajax({
            type:"post",
            url:base_url+"Bills/delete_bill",
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

    function filter_data(){
        var get_params = "";
        var filter_by = $("select[name='filter_by']").val();
        switch(filter_by){
            case "company-name":
                get_params = "query="+$("#autocomplete-input").val()+"&company_id="+$("#autocomplete-input").attr("lang")+"&filter_by=company-name"; 
            break;

            case "date":
                var from_array = $("input[name='from_date']").val().split("-");
                var from_date = from_array["2"]+"-"+from_array["1"]+"-"+from_array["0"];

                var to_array = $("input[name='to_date']").val().split("-");
                var to_date = to_array["2"]+"-"+to_array["1"]+"-"+to_array["0"];
                get_params = "from_date="+from_date+"&to_date="+to_date+"&filter_by=date"; 
            break;

            case "bill-number":
                get_params = "query="+$("#autocomplete-input").val()+"&filter_by=bill-number";
            break;

            default:
                // Search By input data
                get_params = "query="+$("#autocomplete-input").val()+"&company_id="+$("#autocomplete-input").attr("lang")+"&filter_by=company-name"; 
                
                // Date Pickers data
                var from_array = $("input[name='from_date']").val().split("-");
                var from_date = from_array["2"]+"-"+from_array["1"]+"-"+from_array["0"];

                var to_array = $("input[name='to_date']").val().split("-");
                var to_date = to_array["2"]+"-"+to_array["1"]+"-"+to_array["0"];
                get_params += "&from_date="+from_date+"&to_date="+to_date+"&filter_by=all";
            break;
        }

        location.href = base_url+"search-bills?"+get_params;  
    }
</script>