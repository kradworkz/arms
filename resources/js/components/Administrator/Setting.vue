<template>
<div class="d-xl-flex">
    <div class="w-100">
        <div class="d-md-flex">
            
            <div class="card filemanager-sidebar mr-md-2">
                <div class="card-body">
                    <div class="d-flex flex-column h-100">
                        <div class="mb-4">
                            <div class="mb-3">
                                <div class="dropdown">
                                    <button @click="addnew" class="btn btn-light btn-block " type="button">
                                        <i class="mdi mdi-plus mr-1"></i> Create New
                                    </button>
                                </div>
                            </div>
                            <div class="mail-list mt-4">
                                <a @click="change(1)" :class="{active:selected == 1}">
                                    <i class='bx bx-home-alt mr-2'></i>Storages
                                </a>
                                <a @click="change(2)" :class="{active:selected == 2}">
                                    <i class='bx bx-store mr-2'></i>Vendors
                                </a>
                                <a @click="change(3)" :class="{active:selected == 3}">
                                   <i class='bx bx-list-ul mr-2'></i>Categories
                                </a>
                                <a @click="change(4)" :class="{active:selected == 4}">
                                    <i class='bx bx-list-check mr-2'></i>Statuses
                                </a>
                            </div>
                            <hr class="mb-4">
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-100">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-sm-6 ">
                                <form class="form-inline">
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
                                </ul>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th v-if="selected == 1 || selected == 2">Address</th>
                                        <th v-if="selected == 1 || selected == 2">Contact no</th>
                                        <th v-if="selected == 1 ||  selected == 2 || selected == 3">Status</th>
                                        <th v-if="selected == 4">Type</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="list in lists" v-bind:key="list.id">
                                        <td>{{list.name}}</td>
                                        <td v-if="selected == 1 || selected == 2">{{list.address}}</td>
                                        <td v-if="selected == 1 || selected == 2">{{list.contact_no}}</td>
                                        <td v-if="selected == 1 || selected == 2 ||  selected == 3">
                                            <span v-if="list.status == 0" class="badge badge-lg badge-success">Active</span>
                                            <span v-else class="badge badge-danger">Inactive</span>
                                        </td> 
                                        <td v-if="selected == 4">{{list.type}}</td>
                                        <td class="text-right">
                                            <button v-if="list.status == 0" @click="status(list.id,list.status)" class="btn btn-sm btn-danger waves-effect waves-light">Deactivate</button>
                                            <button v-else @click="status(list.id,list.status)" class="btn btn-sm btn-success waves-effect waves-light">Activate</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade exampleModal" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Lists</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <form @submit.prevent="create">
                            <div class="modal-body">
                                <div class="customerform">
                                    <div class="row" style="margin-bottom: -10px;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name: <span v-if="errors.name" class="haveerror">({{ errors.name[0] }})</span></label>
                                                <input type="text" class="form-control"  v-model="name" style="text-transform: capitalize;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" v-if="selected == 1 || selected == 2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="formrow-firstname-input">Address: <span v-if="errors.address" class="haveerror">({{ errors.address[0] }})</span></label>
                                                <input type="text" class="form-control" id="formrow-firstname-input" v-model="address" style="text-transform: capitalize;">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="formrow-firstname-input">Contact: <span v-if="errors.contact_no" class="haveerror">({{ errors.contact_no[0] }})</span></label>
                                                <input type="text" class="form-control" id="formrow-firstname-input" v-model="contact_no">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" v-if="selected == 4">
                                        <div class="col-md-12">
                                            <label for="formrow-firstname-input">Type: <span v-if="errors.type" class="haveerror">({{ errors.type[0] }})</span></label>
                                            <multiselect 
                                                v-model="type" 
                                                :options="options"
                                                :allow-empty="false"
                                                deselect-label="Can't remove this value"
                                                >
                                            </multiselect>
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
            lists: [],
            id: '',
            name: '',
            address: '',
            contact_no: '',
            type: '',
            selected: 1,
            editable: false,
            options : ["Asset","Activity","Request","Maintenance"],
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

        fetch(page_url) {
            let vm = this; let key;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            page_url = page_url || this.currentUrl + '/request/admin/'+this.selected+'/'+key;

            axios.get(page_url)
            .then(response => {
                this.lists = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        create(){
            const form = new FormData();
            form.append('id', this.id);
            form.append('name', this.name);
            form.append('selected', this.selected);
            (this.editable == true) ? form.append('update', 'update') : form.append('update','create');

            (this.selected == 1 || this.selected == 2) ? form.append('address', this.address) : '';
            (this.selected == 1 || this.selected == 2) ? form.append('contact_no', this.contact_no) : '';
            (this.selected == 4) ? form.append('type', this.type) : '';

            axios.post(this.currentUrl + '/request/admin/list/store', form)
            .then(response => {
                $('#new').modal('hide');
                let page_url = '/request/admin/'+this.selected+'/-?page=' + this.pagination.current_page;
                this.fetch(page_url);
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
        },

        addnew(){
            $("#new").modal('show');
        },

        status(){

        },

        change(number){
            this.selected = number;
            this.fetch();
        },

        clear(){
            this.name = '';
            this.address = '';
            this.contact_no = '';
            this.type = '';
            this.editable = false;
        }
     }, components: { Multiselect }
}
</script>