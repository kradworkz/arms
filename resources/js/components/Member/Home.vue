<template>
    <div>
        <div class="row">
            <div class="col-xl-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mini-stats-wid" v-for="(list,index) in reports" v-bind:key="list.id" style="margin-bottom: 5px;">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p :class="'text-'+list.color+' mb-2'">{{ list.name }}</p>
                                        <h5 class="mb-0">{{ list.counts }}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-9">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card" style="min-height: 365px;">
                                    <div class="card-body">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-left: -10px;">
                                <div class="card" style="min-height: 175px; margin-bottom: 10px;">
                                  <div class="card-body">
                                        <h6 class="card-title mb-4 text-danger font-size-12">For Maintenance</h6>
                                        <div class="table-responsive" data-simplebar style="max-height: 95px; min-height: 90px; ">
                                            <table class="table table-nowrap table-centered mb-0">
                                                <tbody>
                                                    <tr  v-for="(m,index) in maintenance" v-bind:key="index+m.id">
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0"><a href="#" class="text-dark">{{m.code}}</a></h5>
                                                            <p class="text-muted mb-0">{{m.name}}</p>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                {{m.maintenance}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" style="min-height: 177px;">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4 text-warning font-size-12">For Expiration</h4>
                                        <div class="table-responsive" data-simplebar style="max-height: 95px; min-height: 90px; ">
                                            <table class="table table-nowrap table-centered mb-0">
                                                <tbody>
                                                    <tr  v-for="(e,index) in expiration" v-bind:key="index+e.id">
                                                        <td>
                                                            <h5 class="text-truncate font-size-14 m-0"><a href="#" class="text-dark">{{e.code}}</a></h5>
                                                            <p class="text-muted mb-0">{{e.name}}</p>
                                                        </td>
                                                        <td>
                                                            <div class="text-center">
                                                                {{e.expiration}}
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
</template>

<script>
import Multiselect from 'vue-multiselect';
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            keyword: '',
            maintenance: [],
            expiration: [],
            year: new Date().getFullYear(),
            month: 'All', /* ("0" + ((new Date()).getMonth() + 1)).slice(-2) */
            months : ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            todate: '',
            reports: [],
            asset_id: '',
            index: ''
        }
    },

    created(){
        this.fetchExpiration();
        this.fetchMaintenance();
        this.fetchReports();
    },

    methods : {
 
        fetch(){
            let key;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';

            axios.get(this.currentUrl + '/request/member/assets/search/'+key)
            .then(response => {
                this.results = response.data.data;
            })
            .catch(err => console.log(err));
        },

        fetchMaintenance(){
              axios.get(this.currentUrl + '/request/member/foraction/M')
            .then(response => {
                this.maintenance = response.data.data;
            })
            .catch(err => console.log(err));
        },

        fetchExpiration(){
              axios.get(this.currentUrl + '/request/member/foraction/E')
            .then(response => {
                this.expiration = response.data.data;
            })
            .catch(err => console.log(err));
        },


        fetchReports(){
            axios.get(this.currentUrl + '/request/dropdowncount/status/asset')
            .then(response => {
                this.reports = response.data.data;
            })
            .catch(err => console.log(err));
        },

    }, components: { Multiselect}
}
</script>