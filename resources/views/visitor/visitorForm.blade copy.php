<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request a Demo</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css">
    <style>
        body {
            color: #000;
            overflow-x: hidden;
            height: 100%;
            background-image: url("https://i.imgur.com/GMmCQHC.png");
            background-repeat: no-repeat;
            background-size: 100% 100%;
        }

        .card {
            padding: 30px 40px;
            margin-top: 60px;
            margin-bottom: 60px;
            border: none !important;
            box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.2);
        }

        .blue-text {
            color: #00BCD4;
        }

        .form-control-label {
            margin-bottom: 0;
        }

        input,
        textarea,
        button {
            padding: 8px 15px;
            border-radius: 5px !important;
            margin: 5px 0px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            font-size: 18px !important;
            font-weight: 300;
        }

        input:focus,
        textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #00BCD4;
            outline-width: 0;
            font-weight: 400;
        }

        .btn-block {
            text-transform: uppercase;
            font-size: 15px !important;
            font-weight: 400;
            height: 43px;
            cursor: pointer;
        }

        .btn-block:hover {
            color: #fff !important;
        }

        button:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            outline-width: 0;
        }
    </style>
</head>

<body>
    <div class="container-fluid px-1 py-5 mx-auto" style="background: url('{{ asset('ima/b2.jpg') }}'); background-size: cover; background-repeat: no-repeat; background-position: center top;">
    {{-- <div class="container-fluid px-1 py-5 mx-auto" style="background: linear-gradient(120deg, #00BCD4, #33691E);"> --}}
    {{-- <div class="container-fluid px-1 py-5 mx-auto"> --}}
        <div class="row d-flex justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                <h3>Request a Demo</h3>
                <p class="blue-text">Just answer a few questions<br> so that we can personalize the right experience for
                    you.</p>
                <div class="card">
                    <h5 class="text-center mb-4">Powering world-class companies</h5>
                    <form class="form-card" onsubmit="event.preventDefault()">
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">First name<span class="text-danger">
                                        *</span></label>
                                <input type="text" id="fname" name="fname" placeholder="Enter your first name"
                                    onblur="validate(1)">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Last name<span class="text-danger">
                                        *</span></label>
                                <input type="text" id="lname" name="lname" placeholder="Enter your last name"
                                    onblur="validate(2)">
                            </div>
                        </div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Business email<span class="text-danger">
                                        *</span></label>
                                <input type="text" id="email" name="email" placeholder="" onblur="validate(3)">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Phone number<span class="text-danger">
                                        *</span></label>
                                <input type="text" id="mob" name="mob" placeholder="" onblur="validate(4)">
                            </div>
                        </div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Job title<span class="text-danger">
                                        *</span></label>
                                <input type="text" id="job" name="job" placeholder="" onblur="validate(5)">
                            </div>
                        </div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-12 flex-column d-flex">
                                <label class="form-control-label px-3">What would you be using Flinks for?<span
                                        class="text-danger"> *</span></label>
                                <input type="text" id="ans" name="ans" placeholder="" onblur="validate(6)">
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="form-group col-sm-6">
                                <button type="submit" class="btn-block btn-primary">Request a demo</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script>
        function validate(val) {
            var v1 = document.getElementById("fname");
            var v2 = document.getElementById("lname");
            var v3 = document.getElementById("email");
            var v4 = document.getElementById("mob");
            var v5 = document.getElementById("job");
            var v6 = document.getElementById("ans");

            var flag1 = true;
            var flag2 = true;
            var flag3 = true;
            var flag4 = true;
            var flag5 = true;
            var flag6 = true;

            if (val >= 1 || val == 0) {
                if (v1.value == "") {
                    v1.style.borderColor = "red";
                    flag1 = false;
                } else {
                    v1.style.borderColor = "green";
                    flag1 = true;
                }
            }

            if (val >= 2 || val == 0) {
                if (v2.value == "") {
                    v2.style.borderColor = "red";
                    flag2 = false;
                } else {
                    v2.style.borderColor = "green";
                    flag2 = true;
                }
            }

            if (val >= 3 || val == 0) {
                if (v3.value == "") {
                    v3.style.borderColor = "red";
                    flag3 = false;
                } else {
                    v3.style.borderColor = "green";
                    flag3 = true;
                }
            }

            if (val >= 4 || val == 0) {
                if (v4.value == "") {
                    v4.style.borderColor = "red";
                    flag4 = false;
                } else {
                    v4.style.borderColor = "green";
                    flag4 = true;
                }
            }

            if (val >= 5 || val == 0) {
                if (v5.value == "") {
                    v5.style.borderColor = "red";
                    flag5 = false;
                } else {
                    v5.style.borderColor = "green";
                    flag5 = true;
                }
            }

            if (val >= 6 || val == 0) {
                if (v6.value == "") {
                    v6.style.borderColor = "red";
                    flag6 = false;
                } else {
                    v6.style.borderColor = "green";
                    flag6 = true;
                }
            }

            var flag = flag1 && flag2 && flag3 && flag4 && flag5 && flag6;

            return flag;
        }
    </script>
</body>

</html>

<style>
    body {
        color: #000;
        overflow-x: hidden;
        height: 100%;
        background-image:
            url("https://i.imgur.com/GMmCQHC.png");
        background-repeat: no-repeat;
        background-size: 100% 100%
    }

    .card {
        padding: 30px 40px;
        margin-top: 60px;
        margin-bottom: 60px;
        border: none !important;
        box-shadow: 0 6px 12px 0 rgba(0, 0, 0, 0.2)
    }

    .blue-text {
        color: #00BCD4
    }

    .form-control-label {
        margin-bottom: 0
    }

    input,
    textarea,
    button {
        padding: 8px 15px;
        border-radius: 5px !important;
        margin: 5px 0px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        font-size: 18px !important;
        font-weight: 300
    }

    input:focus,
    textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: 1px solid #00BCD4;
        outline-width: 0;
        font-weight:
            400
    }

    .btn-block {
        text-transform: uppercase;
        font-size: 15px !important;
        font-weight: 400;
        height: 43px;
        cursor:
            pointer
    }

    .btn-block:hover {
        color: #fff !important
    }

    button:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        outline-width: 0
    }
</style>