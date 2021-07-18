@extends('layouts.master')

@section('header')

    <style>
        .sticky {
            flex: 1;
            height: 100px;
            position: sticky;
            top: 1rem;
        }

        .list-group-item {
            display: flex;
            justify-content: space-between;
        }

        .chrome-extension-mutihighlight {
            padding: 0 !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            background-color: transparent !important;
            color: white !important;
        }

        .text-dark .chrome-extension-mutihighlight {
            padding: 0 !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            background-color: transparent !important;
            color: black !important;
        }

    </style>

@endsection

@section('content')
    <section>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a href="" class="navbar-brand order-md-last">شاپور</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a href="auth/logout" class="nav-link">خروج</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="mb-3" style="text-align: right;">
                <button v-on:click="reload" class="btn btn-outline-primary">بارگذاری مجدد لیست</button>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-4 col-6 sticky" id="list">
                    <div class="list-group">
                        @for($i = 0; $i < count($data); $i++)
                            <a class="list-group-item list-group-item-action"
                               :class="{active: {{$i}} == 0}"
                               data-toggle="list"
                               role="tab"
                               id="list-{{$i}}"
                               href="#{{$data[$i]->phone_number}}"
                               v-on:click="selectUser({{$i}}, {{$data[$i]}})">
                                <span>{% phoneNumberPattern({{($data[$i]->phone_number)}}) %}</span>
                                <span><small>{{$data[$i]->name}}</small></span>
								<span :class="{'text-danger': {{getSmartLastSeen($data[$i]->last_seen)}} == -1 }"><small>{% calLastSeen({{getSmartLastSeen($data[$i]->last_seen)}}) %}</small></span>
                            </a>
                        @endfor
                    </div>
                </div>
                <div class="col-lg-10 col-md-8 col-6">
                    <div :class="{fb: userIndex >= 0 && messages.length > 10}">
                        <div class="tap-content">

                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-3" v-for="(message, index) in messages">
                                    <div class="card bg-active text-light mb-3"
                                         :class="{'bg-light': index != 0, 'text-dark': index != 0}">
                                        <div class="card-header">{% message.phone_number %}</div>
                                        <div class="card-body">
                                            <p class="card-text text-right" dir="rtl">{% message.text %}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script>
        new Vue({
            el: '#app',
            delimiters: ['{%', '%}'],
            data: {
                userIndex: -1,
                messages: []
            },
            mounted: function () {
                document.getElementById('list-0').click();
            },
            mixins: [mixin],
            methods: {
                selectUser: function (index, user) {
                    if (index !== this.userIndex) {
                        this.userIndex = index;
                        this.getData(user.id);
                    }
                },
                calLastSeen: function(state) {
					console.log(state);
                    switch (state){
						case 1:
                            return "on"
                        case 0:
                        case -1:
                            return "off";
                   
                    }
                },
                reload: function () {
                    var tempIndex = this.userIndex;
                    this.userIndex = -1;
                    this.messages = [];

                    document.getElementById('list-' + tempIndex).click();
                },
                getData: function (id) {
                    var self = this;
                    self.messages = [];

                    axios({
                        method: 'GET',
                        params: {user: id},
                        url: '/api/internal/v1/message'
                    })
                        .then(function (response) {
                            self.messages = response.data.data;
                        })
                        .catch(function (error) {

                        })
                }
            }
        });

    </script>
@endsection