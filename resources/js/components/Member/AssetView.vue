<template>
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="media">
                                <div class="mr-3">
                                    <img v-if="asset.image != undefined" :src="currentUrl+'/images/avatars/'+asset.image" alt="" class="avatar-md rounded-circle img-thumbnail">
                                </div>
                                <div class="media-body align-self-center">
                                    <div class="text-muted font-weight-bold">
                                        <p class="text-primary mb-2">{{asset.location.name}}</p>
                                        <h5 class="text-success mb-1">{{asset.name}}</h5>
                                        <p class="mb-0">{{asset.category}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 align-self-center">
                            <div class="text-lg-center mt-4 mt-lg-0">
                                <div class="row">
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Quantity</p>
                                            <h5 class="mb-0">{{asset.quantity}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Available</p>
                                            <h5 class="mb-0">{{asset.available}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">With Tracker</p>
                                            <h5 class="mb-0">{{asset.tracker}}</h5>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>
                
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-xl-8 form-inline">
                            <button @click="newtrack(asset.id,asset.quantity,'quantity')" type="button" class="btn btn-info mr-2"><span class="d-none d-sm-inline-block "> <i class='bx bx-plus'></i></span></button>      
                            <form class="float-sm-right form-inline">
                                <div class="search-box">
                                    <div class="position-relative">
                                        <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetchLists()">
                                    <i class='bx bx-search-alt search-icon'></i>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-xl-4">
                            <ul class="list-inline user-chat-nav text-right mb-0 dropdown">
                                <li class="list-inline-item d-none d-sm-inline-block font-size-12">{{pagination.current_page}} out of {{pagination.last_page}}</li>
                                <li class="list-inline-item d-none d-sm-inline-block">
                                    <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetchLists(pagination.prev_page_url)">
                                        <i class='bx bxs-chevron-left font-size-16'></i>
                                    </a>
                                </li>
                                <li class="list-inline-item d-none d-sm-inline-block">
                                    <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetchLists(pagination.next_page_url)">
                                        <i class='bx bxs-chevron-right font-size-16'></i>
                                    </a>
                                </li>
                                <li class="list-inline-item d-non d-sm-inline-block">
                                    <button @click="fetchLists()" type="button" class="btn btn-light"><span class="d-none d-sm-inline-block "> <i class='bx bx-refresh'></i></span></button>                                 
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="table-responsive"  data-simplebar style="max-height: 278px; min-height: 278px;">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Asset Code</th>
                                    <th class="text-center">Tracker Code</th>
                                    <th class="text-center">Status</th>
                                     <th class="text-center">Action</th>
                                </tr>
                            </thead>
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
                                        <a v-if="list.status.name != 'Borrowed'" class="mr-2 text-warning font-size-16" @click="newtrack(list.id,index,list.status)"><i class='bx bx-edit-alt'></i></a>
                                        <a v-else class="mr-2 text-warning font-size-16" @click="newtrack(list.id,list.borrowed,list.status)"><i class='bx bxs-show'></i></a>
                                        <a v-if="list.coordinates == 'n/a' && list.tracker == 'n/a'" class="mr-2 text-danger font-size-16" @click="newtrack(list.id,list,'newtrack')"><i class='bx bxs-location-plus'></i></a>
                                        <a v-else class="mr-2 text-danger font-size-16" @click="newtrack(list.id,list,'edit')"><i class='bx bxs-edit-location' ></i></a>
                                        <a @click="track(list.id,list.coordinates)" v-bind:class="[(list.coordinates != 'n/a' ? 'text-danger' : 'text-secondary')]" class="font-size-16"><i class='bx bx-current-location'></i></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade exampleModal" id="newtrack" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-if="type == 'newtrack' || type == 'edit'">Update Assetcode</h5>
                    <h5 class="modal-title" v-else-if="type == 'quantity'">Add Quantity </h5>
                    <h5 class="modal-title" v-else>
                        <span v-if="currentStatus != 'Borrowed'">Update Status</span>
                        <span v-else>View</span>
                    </h5>
                </div>
                <form  @submit.prevent="createtracker">
                    <div class="modal-body customerform">
                        <div v-if="type == 'newtrack' || type == 'edit'">
                            <div class="form-group ">
                                <label for="formrow-firstname-input">Tracker Code: <span v-if="errors.trackercode" class="haveerror">({{ errors.trackercode[0] }})</span></label>
                                <input type="text" class="form-control" v-model="trackercode" style="text-transform: capitalize;">
                            </div>
                            <div class="form-group ">
                                <label for="formrow-firstname-input">Asset Code: <span v-if="errors.assetcode" class="haveerror">({{ errors.assetcode[0] }})</span></label>
                                <input type="text" class="form-control" v-model="assetcode" style="text-transform: capitalize;">
                            </div>
                        </div>
                        <div v-else-if="type == 'quantity'">
                            <div class="col-md-12">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="mdi mdi-alert-outline mr-2"></i>
                                    <div class="form-group" style="margin-top:-20px; margin-bottom: 2px;">         
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" v-model="trackable" class="custom-control-input" id="formrow-customCheck">
                                            <label class="custom-control-label font-size-12" for="formrow-customCheck">Is trackable via <b>GPS</b>? (<b>Yes</b>?, It will automatically generate a code for each Asset quantity)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>Quantity <span v-if="errors['quantity']" class="haveerror"> {{( errors['quantity'])}}</span></label>
                                <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected"><input type="text" v-model="quantity" class="form-control"><span class="input-group-btn-vertical">
                                    <button @click="addup('add')" class="btn btn-primary bootstrap-touchspin-up " type="button">+</button>
                                    <button @click="addup('minus')" class="btn btn-primary bootstrap-touchspin-down " type="button">-</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div v-if="currentStatus != 'Borrowed'">
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
                                <div class="form-group" v-if="status.name == 'Borrowed'">
                                    <label class="float-label">Agencies<span v-if="errors.agency" class="haveerror"> {{( errors.agency )}}</span></label>
                                    <multiselect v-model="agency" id="ajax" label="name" track-by="name"
                                        placeholder="Search Agency" open-direction="bottom" :options="agencies"
                                        :searchable="true" 
                                        @search-change="asyncFind">
                                    </multiselect> 
                                </div>
                            </div>
                            <div v-else>
                                <div class="text-muted">
                                    <h5 class="mb-1"><span class="text-secondary font-size-11">Borrowed By:</span> {{code.name }}</h5>
                                    <p class="mb-0"><span class="text-secondary font-size-11">Date Borrowed:</span> {{code.created_at}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button v-if="currentStatus != 'Borrowed'" type="submit" class="btn btn-primary">Save</button>
                        <button @click="clear" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
   
    <div class="modal fade exampleModal" id="track" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <asset-track :selectedasset="assetid" ref="tracks"></asset-track>
    </div>
</div>
</template>

<script>
import Multiselect from 'vue-multiselect';
export default {
    props: ['assetid'],
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            keyword: '',
            asset: { location: {}},
            lists: [],
            agencies: [],
            statuses: [],
            agency: '',
            trackercode: '',
            assetcode: '',
            location_id: '',
            qnty: '',
            count: '',
            code: '',
            type: '',
            status: '',
            quantity : 1,
            trackable: false,
            currentStatus: ''
        }
    },

    created(){
        this.fetch();
        this.fetchLists();
        this.fetchStatus();
    },

    methods : {
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            };
            this.pagination = pagination;
        },

        fetch(){
            axios.get(this.currentUrl + '/request/member/asset/'+this.assetid)
            .then(response => {
                this.asset = response.data.data;
            })
            .catch(err => console.log(err));
        },

        fetchLists(page_url){
            let vm = this; let key;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            page_url = page_url || this.currentUrl + '/request/member/lists/'+this.assetid+'/'+key;
            axios.get(page_url)
            .then(response => {
                this.lists = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
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

        asyncFind(value) {
            if(value.length > 0){
                axios.post(this.currentUrl + '/request/agency/search', {
                    keyword: value,
                })
                .then(response => {
                    this.agencies = response.data.data;
                })
                .catch(err => console.log(err));
            }else{
                this.agencies = [];
            }
        },

        track(id,coor){
            if(coor != 'n/a'){
                this.$refs.tracks.test(id);
                $("#track").modal('show');
            }
        },

        newtrack(id,code,type){
            this.location_id = id;
            this.code = code;
            this.type = type;
            if(this.type == 'newtrack'){
                this.type = type;
                this.trackercode = ''
                this.assetcode = code.asset;
            }else if(this.type == 'edit'){
                this.trackercode = code.tracker;
                this.assetcode = code.asset;
            }else{
                this.currentStatus = type.name;
                this.code = code[0];
                this.status = type;
            }
            if(this.status.id != 9){
                $("#newtrack").modal('show');
            }
        },

        createtracker(){
            if(this.type == 'newtrack' || this.type == 'edit'){
                axios.post(this.currentUrl + '/request/member/tracker/store', {
                    id: this.location_id,
                    trackercode: this.trackercode,
                    assetcode: this.assetcode
                })
                .then(response => {
                    var index = this.lists.map(x => {
                        return x.id;
                    }).indexOf(this.location_id);
    
                    this.lists[index].tracker = response.data.data.tracker_code;
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
            }else if(this.type == 'quantity'){
                axios.post(this.currentUrl + '/request/member/quantity/update', {
                    id: this.asset.id,
                    quantity: this.quantity,
                    trackable: this.trackable
                })
                .then(response => {
                    var index = this.lists.map(x => {
                        return x.id;
                    }).indexOf(this.location_id);
    
                    this.lists[index].tracker = response.data.data.tracker_code;
                    $("#newtrack").modal("hide");
                    Vue.$toast.success('<strong>Successfully Created</strong>', {
                        position: 'bottom-right'
                    });
                    this.clear();
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            }else{
                axios.post(this.currentUrl + '/request/member/status/update', {
                    id: this.location_id,
                    status: this.status.id,
                    agency: this.agency.id
                })
                .then(response => {
                    this.lists[this.code] = response.data.data;
                    $("#newtrack").modal("hide");
                    this.agency = '';
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
        },

        clear(){
            this.status= '';
            this.trackercode = '';
            this.code = '';
            this.errors = [];
        },

        newquantity(id){
            this.location_id = id;
            $("#newquantity").modal('show');
        },

        addup(val){
            if(val == 'add'){
                this.quantity += 1;
            }else{
                if(this.quantity > 1){
                this.quantity -= 1;
                }
            }
        },
    }, components: { Multiselect}
}

 var lastDate = 0;
  var data = []
  var TICKINTERVAL = 86400000
  let XAXISRANGE = 777600000
  function getDayWiseTimeSeries(baseval, count, yrange) {
    var i = 0;
    while (i < count) {
      var x = baseval;
      var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
  
      data.push({
        x, y
      });
      lastDate = baseval
      baseval += TICKINTERVAL;
      i++;
    }
  }
  
  getDayWiseTimeSeries(new Date('11 Feb 2017 GMT').getTime(), 10, {
    min: 10,
    max: 90
  })
  
  function getNewSeries(baseval, yrange) {
    var newDate = baseval + TICKINTERVAL;
    lastDate = newDate
  
    for(var i = 0; i< data.length - 10; i++) {
      // IMPORTANT
      // we reset the x and y of the data which is out of drawing area
      // to prevent memory leaks
      data[i].x = newDate - XAXISRANGE - TICKINTERVAL
      data[i].y = 0
    }
  
    data.push({
      x: newDate,
      y: Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min
    })
  }
  
  function resetData(){
    // Alternatively, you can also reset the data at certain intervals to prevent creating a huge series 
    data = data.slice(data.length - 10, data.length);
  }
</script>