    <?php $this->load->view('template_elite/header.php');?>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Profile User</h4>
        </div>
        <div class="col-md-7 align-self-center text-right">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Authentication</a></li>
                    <li class="breadcrumb-item active">Profile User</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-12">

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Profile User</h4>
                    <form id="form-profile" class="form" action="">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Email</label>
                            <div class="col-10">
                                <input class="form-control" name="email" disabled="" value="<?php echo $this->session->userdata('user_email'); ?>" id="profile-email" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Nama</label>
                            <div class="col-10">
                                <input class="form-control" name="nama" disabled="" value="<?php echo $this->session->userdata('user_name'); ?>" id="profile-nama" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">New Password</label>
                            <div class="col-10">
                                <input class="form-control" placeholder="Min. 6 Karakter" name="password" value="" id="profile-new-password" type="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-form-label">Confirm Password</label>
                            <div class="col-10">
                                <input class="form-control" placeholder="Ketik ulang password" name="password_confirmation" value="" id="profile-confirm-password" type="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Change Password</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>


<script>

$("#form-profile").on('submit', (function (e) {

    e.preventDefault();

    var data = $(this).serializeArray();
    $.ajax({
        url: "<?php echo WS_JQGRID."data_master.user_admin_controller/updateProfile"; ?>",
        type: "POST",
        data: data,
        dataType: "json",
        success: function (data) {
            if (data.success == true) {
                swal("Sukses",data.message,"success");
            } else {
                swal("Perhatian",data.message,"warning");
            }
        },
        error: function (xhr, status, error) {
            swal({title: "Error!", text: xhr.responseText, html: true, type: "error"});
        }
    });

    return false;
}));

</script>

<?php $this->load->view('template_elite/footer.php');?>