<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('favicon.ico'); ?>">
    <title>Register</title>

    <!-- page css -->
    <link href="<?php echo base_url('assets/css/pages/register-lock.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>


    <![endif]-->
</head>

<body class="skin-default card-no-border">
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label">TIRTAWENING</p>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<section id="wrapper">
    <div class="login-register" style="background-image:url(<?php echo base_url('assets/images/humas.jpg'); ?>);">
        <div class="login-box card">
            <div class="card-body">
                <?php echo form_open('auth/register', array('id' => 'registerForm', 'class' => 'form-horizontal form-material')); ?>
                <div class="text-center">
                    <h4 class="text-primary">PENDAFTARAN</h4>
                </div>
                <!--                        <h3 class="box-title m-t-40 m-b-0">Register Now</h3><small>Create your account and enjoy</small>-->
                <?php if($this->session->flashdata('error_message') != ""): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                        <strong><?php echo $this->session->flashdata('error_message'); ?></strong>
                    </div>
                <?php endif; ?>
                <?php if($this->session->flashdata('success_message') != ""): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span></button>
                        <strong><?php echo $this->session->flashdata('success_message'); ?>Pendafataran Sukses</strong>
                    </div>
                <?php endif; ?>
                <div class="form-group m-t-30">
                    <div class="col-xs-12">
                        <input name="nolang" class="form-control" type="text" required="" placeholder="Nomor Langganan *">
                    </div>
                </div>
                <div class="form-group error">
                    <div class="col-xs-12">
                        <input name="email" class="form-control" type="text" required="" placeholder="Email *">
                    </div>
                </div>
                <div class="form-group error required">
                    <div class="col-xs-12">
                        <input name="first_name" class="form-control" type="text" required=""
                               placeholder="Nama Lengkap *">
                    </div>
                </div>
                <div class="form-group required">
                    <div class="col-xs-12">
                        <input name="address" class="form-control" type="text" placeholder="Alamat *" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12">
                        <input name="phone" class="form-control" type="text" placeholder="No HP">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group error">
                            <div class="col-xs-12">
                                <input class="form-control" name="password" id="password" type="password" required=""
                                       placeholder="Kata Sandi *">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group error">
                            <div class="col-xs-12">
                                <input class="form-control" name="password_confirm" id="password_confirm"
                                       type="password" required="" placeholder="Ulang Kata Sandi*">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group error">
                    <div class="col-md-12">
                        <div class="custom-control custom-checkbox">
                            <!--                                    <input type="checkbox" class="custom-control-input" id="term" name="term">-->
                            <input type="checkbox" class="custom-control-input"
                                   id="customCheck1" name="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Saya setuju dengan <a
                                        href="javascript:void(0)" id="tos">Syarat dan Ketentuan</a></label>
                        </div>
                    </div>
                </div>
                <div class="form-group text-center p-b-20">
                    <div class="col-xs-12">
                        <button id="register"
                                class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light"
                                type="submit">Daftar
                        </button>
                    </div>
                </div>
                <?php echo $message; ?>
                <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        Sudah punya akun ? <a href="<?php echo site_url('auth/login'); ?>"
                                                    class="text-info m-l-5"><b>Login</b></a>
                    </div>
                </div>
               <!-- <div align="center" class="g-recaptcha" data-callback="enableBtn"
                     data-sitekey="6LcytW0UAAAAAEKtjony7L21HxZaLsrci3dcRm4l" style="margin: auto;"></div>-->

                <?php echo form_close(); ?>

            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Term of Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $tos;?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('assets/node_modules/jquery/jquery-3.2.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.validate.js'); ?>" type="text/javascript"></script>

<!-- Bootstrap tether Core JavaScript -->
<script src="<?php echo base_url(); ?>assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

<script src='https://www.google.com/recaptcha/api.js'></script>
<!--Custom JavaScript -->

<script type="text/javascript">
    $(document).ready(function () {
       // document.getElementById("register").disabled = true;
        $("#registerForm").validate({
            rules: {
                identity: {
                    required: true,
                    lettersonly: true,
                    minlength: 5

                },
                first_name: "required",
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 5
                },
                password_confirm: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                customCheck1: "required"
            },
            messages: {
                identity: {
                    required: "Username harus diisi",
                    minlength: "Username minimal 5 karakter"
                },
                first_name: {
                    required: "Nama harus diisi"
                },
                email: {
                    required: "Email harus diisi"
                },
                newpassword1: {
                    required: "Kata sandi harus diisi !",
                    minlength: "Kata sandi minimal 5 huruf"
                },
                newpassword2: {
                    required: "Kata sandi harus diisi !",
                    minlength: "Kata sandi minimal 5 huruf",
                    equalTo: "Kata sandi baru tidak sesuai"
                },
                customCheck1: {
                    required: "Anda harus setuju dengan ketentuan dan persyaratan untuk melanjutkan."
                }
            },
            errorElement: "div>",
            errorPlacement: function (error, element) {
                // Add the `help-block` class to the error element
                error.addClass("help-block");

                if (element.prop("type") === "checkbox") {
                    error.insertAfter(element.parent(""));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".col-sm-12").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".col-sm-12").addClass("has-success").removeClass("has-error");
            }
        });


    });

    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z0-9]+$/i.test(value);
    }, "Character not allowed");


    function enableBtn() {
        document.getElementById("register").disabled = false;
    }
    $('#tos').click(function () {
        $('#exampleModalLong').modal('show');
    });

</script>
<script type="text/javascript">
    $(function () {
        $(".preloader").fadeOut();
    });
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>

</body>

</html>