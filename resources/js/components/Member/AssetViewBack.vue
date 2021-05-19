<template>
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="media">
                                <div class="mr-3">
                                    <img :src="currentUrl+'/images/avatars/'+asset.image" alt="" class="avatar-md rounded-circle img-thumbnail">
                                </div>
                                <div class="media-body align-self-center">
                                    <div class="text-muted">
                                        <h5 class="mb-1">{{asset.name}}</h5>
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
                                            <p class="text-muted text-truncate mb-2">Total Quantity</p>
                                            <h5 class="mb-0">{{asset.quantity}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Available</p>
                                            <h5 class="mb-0">40</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">w/ Tracker</p>
                                            <h5 class="mb-0">18</h5>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 d-none d-lg-block">
                        <div class="ml-auto">
                                <div class="toolbar button-items text-right">
                                    <button type="button" class="btn btn-light btn-sm">
                                        New Tracker
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
        <div class="col-xl-6">
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
                        <li class="list-inline-item d-none d-sm-inline-block">
                            <button type="button" class="btn btn-light btn-sm">
                                New Location
                            </button>
                        </li>
                    </ul>
                  
                    <h4 class="card-title mb-5">Location/'s</h4>

                    <div class="table-responsive"  data-simplebar style="max-height: 278px; min-height: 278px;">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th>Location</th>
                                    <th class="text-center">Qnty</th>
                                    <th class="text-right">Action</th>
                                </tr>
                            </thead>
                           <tbody>
                                <tr v-for="location in locations" v-bind:key="location.id">
                                    <td>
                                        <h5 class="font-size-13 text-truncate mb-1"><a class="text-dark">{{location.storage}}</a></h5>
                                    </td>
                                    <td class="text-center">{{location.quantity}}</td>
                                    <td class="text-right">
                                        <a class="mr-3 text-warning" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class='bx bx-edit-alt' ></i></a>
                                        <a class="text-danger" @click="newtrack(location.id,location.quantity)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class='bx bxs-location-plus'></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <ul class="list-inline user-chat-nav float-right" style="margin-top: -10px;">
                        <li class="list-inline-item d-none d-sm-inline-block font-size-12">{{pagination.current_page}} out of {{pagination.last_page}}</li>
                        <li class="list-inline-item d-none d-sm-inline-block">
                            <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetchTrackers(pagination.prev_page_url)">
                                <i class='bx bxs-chevron-left font-size-16'></i>
                            </a>
                        </li>
                        <li class="list-inline-item d-none d-sm-inline-block">
                            <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetchTrackers(pagination.next_page_url)">
                                <i class='bx bxs-chevron-right font-size-16'></i>
                            </a>
                        </li>
                    </ul>
                    <h4 class="card-title mb-5">Asset Tracker/'s</h4>

                    <div class="table-responsive"  data-simplebar style="max-height: 278px; min-height: 278px;">
                        <table class="table table-centered table-nowrap mb-0">
                           <tbody>
                                
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Tracker</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body customerform">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class='bx bx-error mr-2'></i>
                        <b>{{ count }}</b> tracked asset out of <b>{{qnty}}</b>
                    </div>
                    <div v-if="count != qnty">
                        <div class="form-group ">
                            <label for="formrow-firstname-input">Asset Code: <span v-if="errors.assetcode" class="haveerror">({{ errors.assetcode[0] }})</span></label>
                            <input type="text" class="form-control" id="formrow-firstname-input" v-model="assetcode" style="text-transform: capitalize;">
                        </div>
                        <div class="form-group ">
                            <label for="formrow-firstname-input">Tracker Code: <span v-if="errors.code" class="haveerror">({{ errors.code[0] }})</span></label>
                            <input type="text" class="form-control" id="formrow-firstname-input" v-model="code" style="text-transform: capitalize;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade exampleModal" id="newquantity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Quantity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body customerform">
                  
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade exampleModal" id="track" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <asset-track :selectedasset="assetid" ref="tracks"></asset-track>
    </div>
</div>
</template>

<script>
export default {
    props: ['assetid'],
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            keyword: '',
            asset: {},
            trackers: [],
            locations: [],
            code: '',
            assetcode: '',
            location_id: '',
            qnty: '',
            count: '',
        }
    },

    created(){
        this.fetch();
        this.fetchTrackers();
        this.fetchLocations();
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

        fetchTrackers(page_url){
            let vm = this; 
            page_url = page_url || this.currentUrl + '/request/member/asset/'+this.assetid+'/purchased';
            axios.get(page_url)
            .then(response => {
                this.purchases = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        fetchLocations(page_url){
            let vm = this; 
            page_url = page_url || this.currentUrl + '/request/member/asset/'+this.assetid+'/locations';
            axios.get(page_url)
            .then(response => {
                this.locations = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        track(){
            $("#track").modal('show');
            this.$refs.tracks.test();
        },

        newtrack(id,qnty){
            this.location_id = id;
            this.qnty = qnty;
            axios.get(this.currentUrl + '/request/member/checktracker/'+id)
            .then(response => {
                this.count = response.data;
                $("#newtrack").modal('show');
            })
            .catch(err => console.log(err));
           
        },

        newquantity(id){
            this.location_id = id;
            $("#newquantity").modal('show');
        }
    }
}
</script>