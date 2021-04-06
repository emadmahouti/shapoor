@extends('layouts.master')

@section('header')

    <style>

        .card.card-signin {
            border-radius: 0.7rem;
        }

        .card-title.title-center {
            text-align: center;
        }

        .form-group.rtl {
            direction: rtl;
            text-align: right;
        }

    </style>

@endsection

@section('content')
    <!-- Header -->

    <div class="container">
        <div class="row justify-content-around">
            <div class="col-lg-5 col-10 col-md-7  mt-5">
                <div class="card card-signin ">
                    <div class="card-body">
                        <h5 class="card-title title-center">
                            شاپور
                        </h5>

                        <div class="form-group rtl mt-5">
                            <input type="email" class="form-control" id="username" placeholder="نام کاربری"
                                   v-model:value="form.username">
                        </div>

                        <div class="form-group rtl mt-3">
                            <input type="password" class="form-control" id="code" placeholder="کد فعال‌سازی"
                                   v-model:value="form.code">
                        </div>

                        <div class="form-group rtl" >
                            <a href="https://cafebazaar.slack.com/archives/G016CFY954N/p1610891777005900" target="_blank">اطلاعات ورود</a>
                        </div>

                        <div class="mt-5">
                            <hr>
                            <button type="button" class="btn btn-primary form-control" @click="submit">ورود</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>
        new Vue({
            el: '#app',
            delimiter: ['{$ ', ' $}'],
            data: {
                form: {
                    username: '',
                    code: ''
                }
            },
            methods: {
                submit: function (e) {
                    var self = this;

                    axios({
                        method: 'post',
                        url: '/api/internal/v1/auth/verify',
                        data: {
                            'user': self.form.username,
                            'code': self.form.code
                        }
                    })
                        .then(function (response) {
                            console.log(response.data);
                            var status = response.data.status;
                            if (status === 'ok')
                                window.location.replace("../dashboard")
                        })
                        .catch(function (error) {
                            console.log(error.response);
                            $.notify(error.response.data.status, {
                                style: 'notif',
                                className: 'error'
                            });
                        })
                }
            }
        })
    </script>
@endsection