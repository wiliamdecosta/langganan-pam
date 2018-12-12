<?php $this->load->view('template_elite/header.php');?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Aduan Pelanggan</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Aduan Pelanggan</a></li>
                    <li class="breadcrumb-item active">Daftar Aduan</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <div class="form-group">
                        <div class="input-group">
                            <button type="button" onclick="downloadAduan();" class="btn btn-success"><i class="mdi mdi-file-excel"></i> Download Excel</button>
                            <input class="form-control col-md-5 offset-md-5" id="i_search" placeholder="Pencarian..." aria-label="" aria-describedby="basic-addon1" type="text">
                            <div class="input-group-append">
                                <button id="btn-search" class="btn btn-info" type="button"><i class="fas fa-search"></i> Search</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-t-0">
                    <div class="row">
                        <div class="col-12">
                            <h3>Lokasi : <?php echo getCurrentLocation(); ?></h3>
                        </div>
                    </div>
                    <div class="card b-all shadow-none">
                        <div class="inbox-center table-responsive">

                            <table class="table table-hover no-wrap">
                                <thead>
                                    <tr>
                                        <th>No Laporan</th>
                                        <th>Pelapor</th>
                                        <th class="text-center">Tgl Lapor</th>
                                        <th>Lokasi</th>
                                        <th>Subyek Keluhan</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Tgl Update</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="aduan-list-content">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-9">
                            <div id="aduan-list-pager"></div>
                        </div>
                        <div class="col-sm-3">
                            <span id="pageInfo">View x of n from y data</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

<script>

function downloadAduan() {

    var url = "<?php echo WS_JQGRID . "aduan.aduan_pelanggan_controller/download_excel_per_lokasi/?"; ?>";
    url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";

    Swal({
        title: 'Konfirmasi',
        text: "Anda yakin ingin melakukan download data?",
        type: 'info',
        showCancelButton: true,
        confirmButtonColor: '#538cf6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Yakin'
        }).then((result) => {
        if (result.value) {
            window.location = url;
        }
    });
}

</script>

<script>
    var pager_selector = '#aduan-list-pager';
    var pager_items_on_page = 10;

    $(function() {

        $(pager_selector).pagination({
            items: 0, /* total data */
            itemsOnPage: pager_items_on_page, /* data pada suatu halaman default 10*/
            cssStyle: 'light-theme',
            onPageClick:function(pageNumber, ev) {
                openAduanList();
            }
        });

        function updatePager(total_data) {
            $(pager_selector).pagination('updateItems', total_data);
            var currentPage = $(pager_selector).pagination('getCurrentPage');
            var totalPages = $(pager_selector).pagination('getPagesCount');

            if(currentPage > totalPages) {
                currentPage = 1;
                $(pager_selector).pagination('selectPage', 1);
            }

            $('#pageInfo').html('<strong>Page ' + currentPage + ' of ' + totalPages + ' ( Total : ' + total_data + ' data ) </strong>');
        }

        function openAduanList(page_number) {
            var params = {};

            if( typeof page_number == 'undefined' ) {
                params.page = $(pager_selector).pagination('getCurrentPage');
            }else {
                params.page = page_number;
                $(pager_selector).pagination('selectPage', page_number);
                window.location.replace("#");
            }

            params.limit = pager_items_on_page;
            params.searchPhrase = $('#i_search').val();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: '<?php echo WS_JQGRID."aduan.aduan_pelanggan_controller/admin_aduan_list"; ?>',
                data: params,
                timeout: 10000,
                success: function(data) {
                    /* update right content */
                    $("#aduan-list-content").html(data.contents);
                    /* update pager */
                    updatePager(data.total);
                },
                error: function(xhr, textStatus, errorThrown){
                    swal("Perhatian", "Summary Error", "warning");
                }
            });
        }

        openAduanList(1);

        $( "#i_search" ).on( "keydown", function(event) {
            event.stopPropagation();
            if(event.which == 13)
                openAduanList(1);
        });

        $("#btn-search").on( "click", function(event) {
            openAduanList(1);
        });

    });

</script>

<script>
    function deleteAduan(laporan_id, laporan_no) {
        var url = "<?php echo WS_JQGRID . "aduan.aduan_pelanggan_controller/delete_aduan_admin/?"; ?>";
        url += "<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>";
        url += "&laporan_id="+laporan_id;

        Swal({
            title: 'Konfirmasi',
            text: "Anda yakin ingin menghapus laporan "+laporan_no+" ?",
            type: 'info',
            showCancelButton: true,
            confirmButtonColor: '#538cf6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Yakin'
            }).then((result) => {
            if (result.value) {
                window.location = url;
            }
        });
    }

</script>

<?php if($this->session->flashdata('success_message') != ""): ?>
    <script>
        Swal(
            'Berhasil',
            <?php echo "'".$this->session->flashdata('success_message')."'"; ?>,
            'success'
        )
    </script>
<?php endif; ?>

<?php if($this->session->flashdata('error_message') != ""): ?>
    <script>
        Swal(
            'Error',
            <?php echo "'".$this->session->flashdata('error_message')."'"; ?>,
            'warning'
        )
    </script>
<?php endif; ?>

<?php $this->load->view('template_elite/footer.php');?>