<template>
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="media">
                                <div class="mr-3">
                                    <img v-if="asset.image != undefined" :src="currentUrl+'/images/avatars/'+asset.image" alt="" class="avatar-md rounded-circle img-thumbnail">
                                </div>
                                <div class="media-body align-self-center">
                                    <div class="text-muted font-weight-bold">
                                        <p class="text-primary mb-2">{{asset.location}}</p>
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

                        <div class="col-lg-3 d-none d-lg-block">
                            <div class="ml-auto">
                                <div class="toolbar button-items text-right">
                                    <button @click="newtrack(asset.id,asset.quantity)" type="button" class="btn btn-light btn-sm">
                                        Register Tracker
                                    </button>
                                    <button type="button" class="btn btn-light btn-sm">
                                        Maintenance
                                    </button>
                                    
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
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <ul class="list-inline user-chat-nav float-right" style="margin-top: -10px;">
                        <li class="list-inline-item d-none d-sm-inline-block font-size-12">{{pagination.current_page}} out of {{pagination.last_page}}</li>
                        <li class="list-inline-item d-none d-sm-inline-block">
                            <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetchPurchases(pagination.prev_page_url)">
                                <i class='bx bxs-chevron-left font-size-16'></i>
                            </a>
                        </li>
                        <li class="list-inline-item d-none d-sm-inline-block">
                            <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetchPurchases(pagination.next_page_url)">
                                <i class='bx bxs-chevron-right font-size-16'></i>
                            </a>
                        </li>
                    </ul>
                  
                    <h4 class="card-title mb-5">Asset Lists</h4>

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
                                        <a class="mr-2 text-warning font-size-16" @click="newtrack(list.id,index,list.status)"><i class='bx bx-edit-alt'></i></a>
                                        <a v-if="list.coordinates == 'n/a' && list.tracker == 'n/a'" class="mr-2 text-danger font-size-16" @click="newtrack(list.id,index,'newtrack')"><i class='bx bxs-location-plus'></i></a>
                                        <a v-else class="mr-2 text-danger font-size-16" @click="newtrack(list.id,list.tracker,'edit')"><i class='bx bxs-edit-location' ></i></a>
                                        <a @click="track(list.id,list.coordinates)" v-bind:class="[(list.coordinates != 'n/a' ? 'text-danger' : 'text-secondary')]" class="font-size-16"><i class='bx bx-current-location'></i></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Asset Tracker/'s</h4>
                    <div class="table-responsive"  data-simplebar style="max-height: 278px; min-height: 278px;">
                        
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
                        <div v-if="type == 'newtrack' || type == 'edit'">
                            <div class="form-group ">
                                <label for="formrow-firstname-input">Tracker Code: <span v-if="errors.trackercode" class="haveerror">({{ errors.trackercode[0] }})</span></label>
                                <input type="text" class="form-control" id="formrow-firstname-input" v-model="trackercode" style="text-transform: capitalize;">
                            </div>
                        </div>
                        <div v-else>
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
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
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
            asset: {},
            lists: [],
            statuses: [],
            trackercode: '',
            location_id: '',
            qnty: '',
            count: '',
            code: '',
            type: '',
            status: ''
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
            let vm = this; 
            page_url = page_url || this.currentUrl + '/request/member/lists/'+this.assetid;
            axios.get(page_url)
            .then(response => {
                this.lists = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        fetchStatus(){
            axios.get(this.currentUrl + '/request/dropdown/2')
            .then(response => {
                this.statuses = response.data.data;;
            })
            .catch(err => console.log(err));
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
            }else if(this.type == 'edit'){
                this.trackercode = code;
            }else{
                this.status = type;
            }
            if(this.status.id != 5){
                $("#newtrack").modal('show');
            }
        },

        createtracker(){
            if(this.type == 'newtrack' || this.type == 'edit'){
                axios.post(this.currentUrl + '/request/member/tracker/store', {
                    id: this.location_id,
                    trackercode: this.trackercode
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
        }
    }, components: { Multiselect}
}
</script>