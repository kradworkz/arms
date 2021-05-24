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
                                    <select v-model="laboratory" class="custom-select custom-select-sm" style="width: 200px;">
                                        <option :value="lab" v-for="lab in laboratories" v-bind:key="lab.id">{{lab.name}}</option>
                                    </select>
                                    <div class="input-group-append">
                                        <label class="input-group-text">Services</label>
                                    </div>
                                </div>
                            </div>
                            <div class="float-right">
                                <div class="apex-charts" >
                                    <div class="toolbar button-items text-center">
                                        <button @click="show = 'bar'" type="button" class="btn btn-light btn-sm">
                                            <i class="bx bx-grid-alt"></i>
                                        </button>
                                        <button @click="show = 'lists'" type="button" class="btn btn-light btn-sm">
                                            <i class="bx bx-list-ul"></i>
                                        </button>
                                        <button @click="print" class="btn btn-sm btn-primary" type="button">
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
            <div class="col-xl-5">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <div>
                                <div class="text-muted">
                                    <h5>asdada</h5>
                                    <p class="mb-1">henrywells@abc.com</p>
                                    <p class="mb-0">Id no: #SK0234</p>
                                </div>
                            </div>
                            <div class="dropdown ml-2">
                                <a class="text-muted dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body border-top mt-2">
                        <div class="row">
                            <div class="col-md-12">
                                <form>
                                    <div class="search-box">
                                        <div class="position-relative">
                                            <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                                        <i class='bx bx-search-alt search-icon'></i>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-body border-top mb-4 mt-2">
                        <div class="text-center">
                            <div class="row">
                                <div class="col-md-12 align-center" style="margin-top: 20px;" v-if="results.length < 1">
                                    <center>
                                    <i class='bx bxs-file' style="font-size: 100px; opacity: 0.5;"></i>
                                    </center>
                                </div>
                                <div class="col-md-12" v-else>
                                    <table class="table table-centered table-nowrap mb-0">
                                    <tbody>
                                        <!-- :class="{'table-success':list.coordinates != 'n/a'} -->
                                            <tr v-for="(list,index) in lists" v-bind:key="list.id">
                                                <td>{{index +1}}</td>
                                                <td class="text-center font-weight-bold">{{list.asset}}</td>
                                                <td class="text-center">{{list.tracker}}</td>
                                                <td class="text-center">
                                                    <span :class="'badge badge-'+list.status.color">{{list.status.name}}</span>
                                                </td>
                                                <td class="text-center">
                                                    <a class="mr-2 text-warning font-size-16" @click="editstatus(list.id,index,list.status)"><i class='bx bx-edit-alt'></i></a>
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
            
            <div class="col-xl-7">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-success mb-2">Operational</p>
                                        <h5 class="mb-0">123131</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-warning mb-2">Under Maintenance</p>
                                        <h5 class="mb-0">123131</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card mini-stats-wid">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body">
                                        <p class="text-danger mb-2">Disposed</p>
                                        <h5 class="mb-0">1231</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Overview</h4>
                        <div>
                            <div id="chart">
                                <!-- <apexchart height="240" :options="chartOptions" :series="series"></apexchart> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade exampleModal" id="newtrack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-if="type == 'newtrack' || type == 'edit'">Asset Code: {{code}} </h5>
                            <h5 class="modal-title" v-else>Update Status</h5>
                        </div>
                        <form  @submit.prevent="createtracker">
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
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            year: new Date().getFullYear(),
            month: 'All', /* ("0" + ((new Date()).getMonth() + 1)).slice(-2) */
            months : ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            todate: '',
            results: []
        }
    },

    methods : {
        editStatus(){

        },

        updateStatus(){
            axios.post(this.currentUrl + '/request/member/status/update', {
                id: this.location_id,
                status: this.status.id
            })
            .then(response => {
                this.lists[this.code] = response.data.data;
                $("#newtrack").modal("hide");
                Vue.$toast.success('<strong>Successfully Updated</strong>', {
                    position: 'bottom-right'
                });
                this.clear();
            })
            .catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        }
    }
}
</script>