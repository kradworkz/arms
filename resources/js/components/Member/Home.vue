<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-left">
                                <div class="input-group input-group-sm">
                                    
                                    <select v-model="month" class="custom-select custom-select-sm ml-2" style=" width: 100px;">
                                        <option value="All">All</option>
                                        <option value="Daily">Daily</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                    <input type="date" v-model="todate" class="custom-select custom-select-sm"  v-if="month == 'Daily'" style="margin-right: 10px; margin-left: 10px;width: 100px;">
                                    <select v-else v-model="year" class="custom-select custom-select-sm ml-2" style="margin-right: 10px; width: 100px;">
                                        <option value="2021" selected>2021</option>
                                        <option value="2020">2020</option>
                                        <option value="2019">2019</option>
                                        <option value="2018">2018</option>
                                    </select>
                                    <select class="custom-select custom-select-sm" style="width: 200px;">
                                        <!-- <option :value="lab" v-for="lab in laboratories" v-bind:key="lab.id">{{lab.name}}</option> -->
                                    </select>
                                    <div class="input-group-append">
                                        <label class="input-group-text">Services</label>
                                    </div>
                                </div>
                            </div>
                            <div class="float-right">
                                <div class="apex-charts" >
                                    <div class="toolbar button-items text-center">
                                        <button  type="button" class="btn btn-light btn-sm">
                                            <i class="bx bx-grid-alt"></i>
                                        </button>
                                        <button  type="button" class="btn btn-light btn-sm">
                                            <i class="bx bx-list-ul"></i>
                                        </button>
                                        <button  class="btn btn-sm btn-primary" type="button">
                                            <i class="bx bxs-printer align-middle mr-1"></i> Print
                                        </button>
                                    </div>
                                    <div id="overview-chart-timeline"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


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
            
            <div class="col-xl-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" style="min-height: 365px;">
                            <div class="card-body">
                                <form>
                                    <div class="search-box">
                                        <div class="position-relative">
                                            <input type="text" class="form-control bg-light border-light rounded" style="text-transform: capitalize;" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                                        <i class='bx bx-search-alt search-icon'></i>
                                        </div>
                                    </div>
                                </form>

                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-md-12 align-center" style="margin-top: 95px;" v-if="results.length < 1">
                                            <center style="opacity: 0.5;">
                                            <i class='bx bxs-file' style="font-size: 100px;"></i>
                                            <p>Nothing on lists, search assets now.</p>
                                            </center>
                                        </div>
                                        <div class="col-md-12" v-else>
                                        <table class="table table-nowrap table-centered table-hover mt-4 mb-0">
                                                <tbody>
                                                    <tr v-for="(list,index) in results" v-bind:key="list.id" @click="editStatus(list.id,list.status,index)">
                                                        <td width="50px;">
                                                            <img class="rounded-circle avatar-xs" :src="currentUrl+'/images/avatars/'+list.image" alt="">
                                                        </td>
                                                        <td class="text-left">
                                                            <h5 class="text-truncate font-size-14 mb-1"><a href="#" class="text-dark">{{ list.asset_code }}</a></h5>
                                                            <p class="text-muted mb-0">{{ list.name}}</p>
                                                        </td>
                                                        <td class="text-right font-size-14">
                                                            <span :class="'badge badge-'+list.status.color">{{list.status.name}}</span>
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

            <div class="col-xl-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card" style="min-height: 365px;">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Requests</h4>
                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-md-12 align-center" style="margin-top: 95px;" v-if="requests.length < 1">
                                            <center style="opacity: 0.3;">
                                            <i class='bx bx-add-to-queue ' style="font-size: 50px;"></i>
                                            <p>No Requests.</p>
                                            </center>
                                        </div>
                                        <div class="col-md-12" v-else>
                                            <table class="table table-nowrap table-centered table-hover mt-4 mb-0">
                                                <tbody>
                                                    <!-- <tr v-for="(list,index) in results" v-bind:key="list.id" @click="editStatus(list.id,list.status,index)">
                                                        <td width="50px;">
                                                            <img class="rounded-circle avatar-xs" :src="currentUrl+'/images/avatars/'+list.image" alt="">
                                                        </td>
                                                        <td class="text-left">
                                                            <h5 class="text-truncate font-size-14 mb-1"><a href="#" class="text-dark">{{ list.asset_code }}</a></h5>
                                                            <p class="text-muted mb-0">{{ list.name}}</p>
                                                        </td>
                                                        <td class="text-right font-size-14">
                                                            <span :class="'badge badge-'+list.status.color">{{list.status.name}}</span>
                                                        </td>
                                                    </tr> -->
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

            <div class="modal fade exampleModal" id="updatestatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Status</h5>
                        </div>
                        <form  @submit.prevent="updateStatus">
                            <div class="modal-body customerform">
                                <div class="form-group">
                                    <label class="float-label">Status  <span v-if="errors.status" class="haveerror"> {{( errors.status )}}</span></label>
                                    <multiselect v-model="status" 
                                    :allow-empty="false"
                                    deselect-label="Can't remove"
                                    :options="statuses" 
                                    placeholder="Select Status" 
                                    label="name" track-by="id">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
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
            year: new Date().getFullYear(),
            month: 'All', /* ("0" + ((new Date()).getMonth() + 1)).slice(-2) */
            months : ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            todate: '',
            results: [],
            reports: [],
            statuses: [],
            requests: [],
            status: '',
            asset_id: '',
            index: ''
        }
    },

    created(){
        this.fetchStatus();
        this.fetchReports();
    },

    methods : {
 
        fetch(){
            if(this.keyword.length > 4){
                let key;
                (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';

                axios.get(this.currentUrl + '/request/member/assets/search/'+key)
                .then(response => {
                    this.results = response.data.data;
                })
                .catch(err => console.log(err));
            }
        },

        fetchReports(){
            axios.get(this.currentUrl + '/request/dropdown/count/status/asset')
            .then(response => {
                this.reports = response.data.data;
            })
            .catch(err => console.log(err));
        },

        fetchStatus(){
            axios.get(this.currentUrl + '/request/dropdown/lists/status/asset')
            .then(response => {
                this.statuses = response.data.data;;
            })
            .catch(err => console.log(err));
        },

        editStatus(asset,status,index){
            this.status = status;
            this.asset_id = asset;
            this.index = index;
            $("#updatestatus").modal('show');
        },

        updateStatus(){
            axios.post(this.currentUrl + '/request/member/status/up', {
                id: this.asset_id,
                status: this.status.id
            })
            .then(response => {
                this.results[this.index].status = response.data.data.status;
                $("#updatestatus").modal("hide");
                Vue.$toast.success('<strong>Successfully Updated</strong>', {
                    position: 'bottom-right'
                });
            })
            .catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        }
    }, components: { Multiselect}
}
</script>