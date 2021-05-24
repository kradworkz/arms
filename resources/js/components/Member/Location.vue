<template>
<div class="d-xl-flex">
    <div class="w-100">
        <div class="card">
            
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-xl-6 col-sm-6 form-inline">
                        <button @click="newloc" type="button" class="btn btn-danger waves-effect waves-light mr-2">New <i class='bx bx-plus-medical ml-2'></i></button>
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
                                <button @click="fetch()" type="button" class="btn btn-light"><span class="d-none d-sm-inline-block "> <i class='bx bx-refresh'></i></span></button>                                 
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap">
                        <thead class="thead-light">
                            <tr>
                                <th></th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Asset Count</th>
                                <th class="text-center">Address</th>
                                <th class="text-center">Contact</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="location in locations" v-bind:key="location.id" @click="view(location.id)" :class="{'table-success':trselected == location.id}">
                                <td>
                                    <div class="avatar-xs"><span class="avatar-title rounded-circle">{{location.name.charAt(0)}}</span></div>
                                </td>
                                <td class="text-center">{{location.name}}</td>
                                <td class="text-center">{{location.assets}}</td>
                                <td class="text-center">{{location.address}}</td>
                                <td class="text-center">{{location.contact_no}}</td>
                                <td class="text-center">
                                    <a :href="'assetlist/'+location.id" class="mr-3 text-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><i class='bx bx-show'></i></a>
                                    <a class="mr-3 text-warning" @click="edit(location)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class='bx bx-edit-alt' ></i></a>
                                    <a class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class='bx bx-trash'></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal fade exampleModal" id="newloc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{(this.editable) ? 'Update' : 'New'}} Station</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <form @submit.prevent="createloc">
                            <div class="modal-body">
                                <div class="row" style="margin-right: 10px; margin-left: 10px;">
                                    
                                    <div class="col-md-12 customerform" style="margin-top: 15px;">
                                        <div class="row">
                                            <div class="col-md-12" style="margin-bottom: -10px;">
                                                <div class="form-group">
                                                    <label for="formrow-firstname-input">Name: <span v-if="errors.name" class="haveerror">({{ errors.name[0] }})</span></label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input" v-model="loc.name" style="text-transform: capitalize;">
                                                </div>
                                            </div>
                                            <div class="col-md-12" style="margin-bottom: -10px;">
                                                <div class="form-group">
                                                    <label for="formrow-firstname-input">Address: <span v-if="errors.address" class="haveerror">({{ errors.address[0] }})</span></label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input" v-model="loc.address" style="text-transform: capitalize;">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="formrow-firstname-input">Contact no: <span v-if="errors.contact_no" class="haveerror">({{ errors.contact_no[0] }})</span></label>
                                                    <input type="text" class="form-control" id="formrow-firstname-input" v-model="loc.contact_no" style="text-transform: capitalize;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>

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
            locations: [],
            trselected : '',
            editable: false, 
            loc: {
                id: '',
                name: '',
                address: '',
                contact_no: ''
            },
        }
    },

    created(){
        this.fetch();
    },

    methods : {

        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev,
                total: meta.total,
            };
            this.pagination = pagination;
        },

        fetch(page_url){
            let vm = this; let key;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            page_url = page_url || this.currentUrl + '/request/member/location/lists/'+key;

            axios.get(page_url)
            .then(response => {
                this.locations = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        createloc(){
            axios.post(this.currentUrl + '/request/member/location/store', {
                id: this.loc.id,
                name: this.loc.name,
                address: this.loc.address,
                contact_no: this.loc.contact_no,
                editable: this.editable
            })
            .then(response => {
                this.fetch();
                $("#newloc").modal("hide");
                this.loc.name = '';
                this.loc.address = '';
                this.loc.contact_no = '';
                 Vue.$toast.success('<strong>Successfully Created</strong>', {
                    position: 'bottom-right'
                });
            })
            .catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        },

        newloc(val){
            $("#newloc").modal('show');
        },

        edit(location){
            this.loc = location;
            $("#newloc").modal('show');
            this.editable = true;
        },

        view(id){
            this.trselected = id;
        }

     }, components: { Multiselect }
}
</script>