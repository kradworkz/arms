<template>
<div class="d-xl-flex">                
    <div class="w-100">
        <div class="card">

            <div class="card-body" v-if="addnew == false">
                <div class="row mb-3">
                  <div class="col-xl-6 col-sm-6 form-inline">
                         <button type="button" @click="newasset" class="btn btn-danger waves-effect waves-light mr-2">New <i class='bx bx-plus-medical ml-2'></i></button>
                        <form class="float-sm-right form-inline">
                            <div class="search-box">
                                <div class="position-relative">
                                    <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                                   <i class='bx bx-search-alt search-icon'></i>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-6 col-sm-6">
                        <ul class="list-inline user-chat-nav text-right mb-0 dropdown">
                            <li class="list-inline-item d-none d-sm-inline-block font-size-12">{{pagination.current_page}} out of {{pagination.last_page}}</li>
                            <li class="list-inline-item d-none d-sm-inline-block">
                                <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetch(pagination.prev_page_url)">
                                    <i class='bx bxs-chevron-left font-size-16'></i>
                                </a>
                            </li>
                            <li class="list-inline-item d-none d-sm-inline-block">
                                <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetch(pagination.next_page_url)">
                                    <i class='bx bxs-chevron-right font-size-16'></i>
                                </a>
                            </li>
                            <li class="list-inline-item d-non d-sm-inline-block">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="d-none d-sm-inline-block"> <i class='bx bx-dots-vertical-rounded'></i></span></button>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-md" style="">
                                        <div class="dropdown-item-text">
                                            <div>
                                                <p class="text-muted mb-2">Available Balance</p>
                                                <h5 class="mb-0">$ 9148.23</h5>
                                            </div>
                                        </div>

                                        <div class="dropdown-divider"></div>

                                        <a class="dropdown-item" href="#">
                                            BTC : <span class="float-right">1.02356</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            ETH : <span class="float-right">0.04121</span>
                                        </a>
                                        <a class="dropdown-item" href="#">
                                            LTC : <span class="float-right">0.00356</span>
                                        </a>

                                        <div class="dropdown-divider"></div>

                                        <a class="dropdown-item text-primary text-center" href="#">
                                            Learn more
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Code</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Storage</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="asset in assets" v-bind:key="asset.id" @click="view(asset.id)" :class="{'table-success':trselected == asset.id}">
                                <td>
                                    <div class="avatar-xs">
                                        <span class="avatar-title rounded-circle">{{asset.name.charAt(0)}}</span>
                                    </div>
                                </td>
                                <td class="font-weight-bold">{{asset.code}}</td>
                                <td class="text-center">{{asset.name}}</td>
                                <td class="text-center">{{asset.quantity}}</td>
                                <td class="text-center">{{asset.storage}}</td>
                                <td class="text-center">
                                    <span class="badge badge-success font-size-12">{{asset.status}}</span>
                                </td>
                                <td class="text-center">
                                    <a :href="'assetlist/'+asset.id" class="mr-3 text-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><i class='bx bx-show'></i></a>
                                    <a class="mr-3 text-warning" @click="edit(asset)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class='bx bx-edit-alt' ></i></a>
                                    <a class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class='bx bx-trash'></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="card-body" v-else>
                <asset-create @status="newass"></asset-create>
            </div>

        </div>
    </div>
</div>
</template>

<script>
import myUpload from 'vue-image-crop-upload/upload-2.vue';
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            keyword: '',
            assets: [],
            editable: false,
            addnew: false,
            trselected : '',
            asset: {}
        }
    },

    created(){
        this.fetch();
    },

    methods: {
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            };
            this.pagination = pagination;
        },

        fetch(page_url) {
            let vm = this; let key;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            page_url = page_url || this.currentUrl + '/request/member/assets/'+key;

            axios.get(page_url)
            .then(response => {
                this.assets = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

         newass(status) {
            if (status) {
                Vue.$toast.success('<strong>Successfully Created</strong>', {
                    position: 'bottom-left'
                });
                this.addnew = false;
                this.fetch();
            }else{
                this.addnew = false;
            }
        },

        view(asset){
            this.trselected = asset;
        },

        newasset(){
            this.addnew = true;
        },

        edit(){

        }

    }, components: { myUpload }
}
</script>