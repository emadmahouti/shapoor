<?php $__env->startSection('header'); ?>

    <style>
        .sticky {
            flex: 1;
            height: 100px;
            margin: 10px;
            position: sticky;
            top: 1rem;
        }

    </style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-2 sticky" id="list">
                    <div class="list-group" role="tablist">
                        <a class="list-group-item list-group-item-action"
                           data-toggle="list"
                           role="tab"
                           aria-controls="'list-aria' + index"
                           :id="'list-label' + index" v-for="(item, index) in users"
                           :href="'#list-' + index"  >
                            {% item.phone_number %}
                        </a>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="tap-content">
                        <div class="tab-content">
                            <div v-for="(user, uIndex) in users" class="tab-pane fade" :id="'list-' + uIndex"
                                 role="tabpanel" :aria-labelledby="'list-label-' + uIndex">
                                <div class="row">
                                    <div class="col-md-3" v-for="(message, index) in user.message">
                                        <div class="card bg-info text-light mb-3"
                                             :class="{'bg-light': index != 0, 'text-dark': index != 0}">
                                            <div class="card-header">{% message.phone_number %}</div>
                                            <div class="card-body">
                                                <p class="card-text">{% message.text %}</p>
                                            </div>
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






<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        new Vue({
            el: '#app',
            delimiters: ['{%', '%}'],
            data: {
                users: [],
                messages: []
            },
            created: function () {
                var self = this;

                axios({
                    method: 'GET',
                    url: '/api/internal/v1/message'
                })
                    .then(function (response) {
                        self.users = response.data.data;
                    })
                    .catch(function (error) {

                    })
            }
        });

    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\htdocs\operation\app\views/message/dashboard.blade.php ENDPATH**/ ?>