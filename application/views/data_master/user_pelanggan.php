    <?php $this->load->view('template_elite/header.php');?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Data Master</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Data Master</a></li>
                    <li class="breadcrumb-item active">Admin</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <form action="">
                    <div class="form-body">
                        <h3 class="card-title">Data User Pelanggan</h3>

                            <div class="input-group mb-3">
                                <input class="form-control" id="i_search" placeholder="Cari No Pelanggan/Nama" aria-label="" aria-describedby="basic-addon1" type="text">
                                <div class="input-group-append">
                                    <button class="btn btn-success" type="button" onClick="loadDataTable();">Cari</button>
                                </div>
                            </div>


                        <table id="grid-table"></table>
                        <div id="grid-pager"></div>
                    </div>
                    </form>
                </div>
            </div>

        </div>
    </div>



<script>
    $( "#i_search" ).on( "keydown", function(event) {
      event.stopPropagation();
      if(event.which == 13)
        loadDataTable();
    });

    function loadDataTable() {
        var grid_table = jQuery("#grid-table");
        var i_search = $('#i_search').val();

        grid_table.jqGrid('setGridParam', {
            url: "<?php echo WS_JQGRID."data_master.user_pelanggan_controller/crud"; ?>",
            postData: {i_search: i_search}
        });
        $("#grid-table").trigger("reloadGrid");

    }
</script>

<script>
jQuery(function($) {

        var grid_selector = "#grid-table";
        var pager_selector = "#grid-pager";

        jQuery("#grid-table").jqGrid({
            url: '<?php echo WS_JQGRID."data_master.user_pelanggan_controller/crud"; ?>',
            datatype: "json",
            mtype: "POST",
            colModel: [
                {label: 'ID', name: 'user_id', key: true, width: 5, sorttype: 'number', editable: true, hidden: true},
                {label: 'No Pelanggan',name: 'no_pelanggan',width: 120, align: "left",editable: true,
                    editoptions: {
                        size: 30,
                        maxlength:11
                    },
                    editrules: {required: true}
                },
                {label: 'Nama',name: 'nama',width: 250, align: "left",editable: true,
                    editoptions: {
                        size: 30,
                        maxlength:100
                    },
                    editrules: {required: true}
                },
                {label: 'Email',name: 'email',width: 250, hidden:false, align: "left",editable: true,
                    edittype: 'text',
                    editoptions: {
                        size: 30,
                        maxlength:60
                    },
                    editrules: {email:true, required: true}
                },
                {label: 'Alamat',name: 'alamat',width: 200, align: "left",editable: true,
                    edittype:'textarea',
                    editoptions: {
                        rows: 2,
                        cols:50
                    }
                },
                {label: 'HP',name: 'hp',width: 120, hidden:false, align: "left",editable: true,
                    edittype: 'text',
                    editoptions: {
                        size: 30,
                        maxlength:20
                    },
                    editrules: {required: true}
                },

                {label: 'Password',name: 'password',width: 150, hidden:true, align: "left",editable: true,
                    edittype: 'password',
                    editoptions: {
                        size: 30,
                        maxlength:15,
                        defaultValue: ''
                    },
                    editrules: {edithidden: true, required: false},
                    formoptions: {
                        elmsuffix:'<i data-placement="left" class="orange"> Min.6 Characters</i>'
                    }
                },

                {label: 'Password', name: 'password_visible', width: 120, align: "left", editable: false},
                {label: 'Status Aktif',name: 'status_aktif',width: 120, align: "left",editable: true, edittype: 'select', hidden:true,
                    editrules: {edithidden: true, required: false},
                    editoptions: {
                    value: "1:AKTIF;2:TIDAK AKTIF",
                    dataInit: function(elem) {
                        $(elem).width(150);  // set the width which you need
                    }
                }},
                {label: 'Status Aktif', name: 'status_aktif_display', width: 120, align: "center", editable: false},
            ],
            height: '100%',
            autowidth: true,
            viewrecords: true,
            rowNum: 10,
            rowList: [10, 20, 50],
            rownumbers: true, // show row numbers
            rownumWidth: 35, // the width of the row numbers columns
            altRows: true,
            shrinkToFit: false,
            multiboxonly: true,
            onSelectRow: function (rowid) {
                /*do something when selected*/

            },
            sortorder:'',
            pager: '#grid-pager',
            jsonReader: {
                root: 'rows',
                id: 'id',
                repeatitems: false
            },
            loadComplete: function (response) {
                if(response.success == false) {
                    swal({title: 'Attention', text: response.message, html: true, type: "warning"});
                }
            },
            //memanggil controller jqgrid yang ada di controller crud
            editurl: '<?php echo WS_JQGRID."data_master.user_pelanggan_controller/crud"; ?>',
            caption: "User Pelanggan"

        });

        jQuery('#grid-table').jqGrid('navGrid', '#grid-pager',
            {   //navbar options
                edit: true,
                editicon: 'fas fa-pencil-alt blue bigger-120',
                add: false,
                addicon: 'fas fa-plus-circle purple bigger-120',
                del: true,
                delicon: 'far fa-trash-alt red bigger-120',
                search: true,
                searchicon: 'fas fa-search orange bigger-120',
                refresh: true,
                afterRefresh: function () {
                    // some code here

                },

                refreshicon: 'fa fa-redo green bigger-120',
                view: false,
                viewicon: 'fas fa-search-plus grey bigger-120'
            },

            {
                // options for the Edit Dialog
                closeAfterEdit: true,
                closeOnEscape:true,
                recreateForm: true,
                serializeEditData: serializeJSON,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);
                    /*form.css({"height": 0.50*screen.height+"px"});
                    form.css({"width": 0.60*screen.width+"px"});*/
                    $("#password").removeClass( "jqgrid-required" );
                    $("#password").val('');
                    $('#no_pelanggan').prop("readonly",true);

                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //new record form
                closeAfterAdd: false,
                clearAfterAdd : true,
                closeOnEscape:true,
                recreateForm: true,
                width: 'auto',
                errorTextFormat: function (data) {
                    return 'Error: ' + data.responseText
                },
                serializeEditData: serializeJSON,
                viewPagerButtons: false,
                beforeShowForm: function (e, form) {
                    var form = $(e[0]);
                    style_edit_form(form);
                    /*form.css({"height": 0.50*screen.height+"px"});
                    form.css({"width": 0.60*screen.width+"px"});*/
                    $('#no_pelanggan').prop("readonly",true);
                    $("#password").addClass( "jqgrid-required" );
                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }

                    $(".tinfo").html('<div class="ui-state-success">' + response.message + '</div>');
                    var tinfoel = $(".tinfo").show();
                    tinfoel.delay(3000).fadeOut();

                    return [true,"",response.responseText];
                }
            },
            {
                //delete record form
                serializeDelData: serializeJSON,
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);
                    style_delete_form(form);

                },
                afterShowForm: function(form) {
                    form.closest('.ui-jqdialog').center();
                },
                onClick: function (e) {
                    //alert(1);
                },
                afterSubmit:function(response,postdata) {
                    var response = jQuery.parseJSON(response.responseText);
                    if(response.success == false) {
                        return [false,response.message,response.responseText];
                    }
                    return [true,"",response.responseText];
                }
            },
            {
                //search form
                closeAfterSearch: false,
                recreateForm: true,
                afterShowSearch: function (e) {
                    var form = $(e[0]);
                    style_search_form(form);

                    form.closest('.ui-jqdialog').center();
                },
                afterRedraw: function () {
                    style_search_filters($(this));
                }
            },
            {
                //view record form
                recreateForm: true,
                beforeShowForm: function (e) {
                    var form = $(e[0]);

                }
            }
        );
    });

    function responsive_jqgrid(grid_selector, pager_selector) {

        var parent_column = $(grid_selector).closest('[class*="col-"]');
        $(grid_selector).jqGrid( 'setGridWidth', $(".form-body").width() );
        $(pager_selector).jqGrid( 'setGridWidth', parent_column.width() );

    }

</script>

<?php $this->load->view('template_elite/footer.php');?>