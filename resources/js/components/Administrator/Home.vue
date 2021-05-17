<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Latest Asset Location</h4>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Asset Code</th>
                                    <th>Coordinates</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(list,index) in lists" v-bind:key="index">
                                    <td><a class="text-body font-weight-bold">{{list.id}}</a> </td>
                                    <td>{{list.value}}</td>
                                    <td>07 Oct, 2019</td>
                                    <td>{{list.created_at}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            lists: []
        }
    },

    created(){
        this.listenForNewEvent();
    },

    methods : {

        listenForNewEvent(){
            Echo.join('public-channel')
            .listen('AssetLocation', (data) => {
                this.lists.push(data);
            });
        },

    }
}
</script>