<template>
<div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="d-flex flex-wrap">
                        <h5 class="card-title mr-2">Visitors</h5>
                        <div class="ml-auto">
                            <div class="toolbar button-items text-right">
                                <button @click="track" type="button" class="btn btn-light btn-sm">
                                    Track
                                </button>
                                <button type="button" class="btn btn-light btn-sm">
                                    Restock
                                </button>
                                <button type="button" class="btn btn-light btn-sm">
                                    Maintenance
                                </button>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="product-detai-imgs mr-4">
                        <div class="row">
                            <img :src="currentUrl+'/images/avatars/'+asset.image" class="img-fluid rounded" alt="Responsive image">
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="ml-4">
                        <h4 class="mb-3">{{asset.name}} <small class="mt-1 font-size-11 text-muted float-right"><span class="text-success">{{asset.status}}</span> ( {{asset.quantity}} {{(asset.quantity = 1) ? 'piece' : 'pieces' }})</small></h4>
                        
                        <p class="text-muted mb-4">{{asset.description}}</p>
                        <div class="mt-3">
                            <h6 class="mb-3">Information:</h6>

                            <div class="table-responsive">
                                <table class="table mb-0 table-bordered">
                                    <tbody>
                                        <tr>
                                            <th scope="row" style="width: 200px;">Category</th>
                                            <td>{{asset.category}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Storage</th>
                                            <td>{{asset.storage}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Brand</th>
                                            <td>{{asset.brand}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Serial No</th>
                                            <td>{{asset.serial_no}}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Model</th>
                                            <td>{{asset.model}}</td>
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
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Activity</h4>
                    <ul class="verti-timeline list-unstyled">
                        <li class="event-list">
                            <div class="event-timeline-dot">
                                <i class="bx bx-right-arrow-circle font-size-18"></i>
                            </div>
                            <div class="media">
                                <div class="mr-3">
                                    <h5 class="font-size-14">22 Nov <i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ml-2"></i></h5>
                                </div>
                                <div class="media-body">
                                    <div>
                                        Responded to need “Volunteer Activities
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="event-list">
                            <div class="event-timeline-dot">
                                <i class="bx bx-right-arrow-circle font-size-18"></i>
                            </div>
                            <div class="media">
                                <div class="mr-3">
                                    <h5 class="font-size-14">17 Nov <i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ml-2"></i></h5>
                                </div>
                                <div class="media-body">
                                    <div>
                                        Everyone realizes why a new common language would be desirable... <a href="#">Read more</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="event-list active">
                            <div class="event-timeline-dot">
                                <i class="bx bxs-right-arrow-circle font-size-18 bx-fade-right"></i>
                            </div>
                            <div class="media">
                                <div class="mr-3">
                                    <h5 class="font-size-14">15 Nov <i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ml-2"></i></h5>
                                </div>
                                <div class="media-body">
                                    <div>
                                        Joined the group “Boardsmanship Forum”
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="event-list">
                            <div class="event-timeline-dot">
                                <i class="bx bx-right-arrow-circle font-size-18"></i>
                            </div>
                            <div class="media">
                                <div class="mr-3">
                                    <h5 class="font-size-14">12 Nov <i class="bx bx-right-arrow-alt font-size-16 text-primary align-middle ml-2"></i></h5>
                                </div>
                                <div class="media-body">
                                    <div>
                                        Responded to need “In-Kind Opportunity”
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="text-center mt-4"><a href="#" class="btn btn-primary waves-effect waves-light btn-sm">View More <i class="mdi mdi-arrow-right ml-1"></i></a></div>
                </div>
            </div>
        </div>
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
                    </ul>
                    <h4 class="card-title mb-5">Purchased History</h4>

                    <div class="table-responsive"  data-simplebar style="max-height: 278px; min-height: 278px;">
                        <table class="table table-centered table-nowrap mb-0">
                           <tbody>
                                <tr v-for="purchase in purchases" v-bind:key="purchase.id">
                                    <td>
                                        <h5 class="font-size-13 text-truncate mb-1"><a href="#" class="text-dark">{{purchase.vendor.name}}</a></h5>
                                        <p class="text-muted mb-0">{{purchase.created_at}}</p>
                                    </td>
                                    <td><i class="bx bxs-cart-alt  align-middle mr-1"></i> {{purchase.quantity}}</td>
                                    <td class="text-right">₱ {{ purchase.price}}</td>
                                    <td>
                                        <div class="dropdown">
                                            <a class="text-muted dropdown-toggle font-size-16" role="button" data-toggle="dropdown" aria-haspopup="true">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#">Action</a>
                                                <a class="dropdown-item" href="#">Another action</a>
                                                <a class="dropdown-item" href="#">Something else here</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">Separated link</a>
                                            </div>
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
            purchases: [],
            locations: []
        }
    },

    created(){
        this.fetch();
        this.fetchPurchases();
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

        fetchPurchases(page_url){
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
        }
    }
}
</script>