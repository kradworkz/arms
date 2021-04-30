<template>
<div class="d-xl-flex">                
    <div class="w-100">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-xl-6 col-sm-6 form-inline">
                        <button type="button" @click="addnew" class="btn btn-danger waves-effect waves-light mr-2">New <i class='bx bx-plus-medical ml-2'></i></button>
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
                        <!-- <div class="float-sm-right">
                            <div class="btn-group mr-2 mb-2 mb-sm-0">
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i class='bx bxs-alarm-exclamation'></i></button>
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i class='bx bxs-trash'></i></button>
                                <button type="button" class="btn btn-primary waves-light waves-effect"><i class='bx bx-refresh'></i></button>
                            </div>
                            <div class="btn-group mr-2 mb-2 mb-sm-0">
                                <button type="button" class="btn btn-primary waves-light waves-effect dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bxs-folder-open'></i> <i class='bx bxs-chevron-down ml-1'></i>
                                </button>
                                <div class="dropdown-menu" style="">
                                    <a class="dropdown-item" href="#">Updates</a>
                                    <a class="dropdown-item" href="#">Social</a>
                                    <a class="dropdown-item" href="#">Team Manage</a>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="member in members" v-bind:key="member.id">
                                <td>
                                    <div class="avatar-xs" v-if="member.avatar == 'n/a'">
                                        <span class="avatar-title rounded-circle">{{member.name.charAt(0)}}</span>
                                    </div>
                                    <div v-else>
                                        <img class="rounded-circle avatar-xs" :src="currentUrl+'/images/avatars/'+member.avatar" alt="">
                                    </div>
                                </td>
                                <td>{{member.name}}</td>
                                <td>
                                    <span v-if="member.status == 'Active'" class="badge badge-success font-size-12">Active</span>
                                    <span v-else-if="member.status == 'Inactive'" class="badge badge-secondary font-size-12">Inactive</span>
                                    <span v-else-if="member.status == 'Disabled'" class="badge badge-warning font-size-12">Disabled</span>
                                    <span v-else class="badge badge-danger font-size-12">Retired</span>
                                </td>
                                <td>{{member.created_at}}</td>
                                <td>{{member.updated_at}}</td>
                                <td class="text-center">
                                    <a class="mr-3 text-info" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><i class='bx bx-show'></i></a>
                                    <a class="mr-3 text-warning" @click="edit(member)" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class='bx bx-edit-alt' ></i></a>
                                    <a class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class='bx bx-trash'></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade exampleModal" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Staff Information</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form @submit.prevent="create">
                    <div class="modal-body">
                        <div class="row" style="margin-right: 10px; margin-left: 10px;">
                            <div class="col-md-4">
                                <myUpload field="img" @crop-success="cropSuccess" v-model="photo.show" :width="500" :height="500" :params="params" :headers="headers" lang-type="en" img-format="jpeg">
                                </myUpload>
                                <div @click="toggleShow" class="fuzone" style="width: 210px; height: 210px;">
                                    <div v-if="photo.url != ''">
                                        <img :src="photo.url" style="width: 200px; height: 200x;">
                                    </div>
                                    <div v-else class="fu-text" @click="toggleShow">
                                        <span><i class="fa fa-picture"></i> Click here to upload<br> <span
                                                v-if="errors.avatar"
                                                style="color: red; font-size: 12px; margin-top: -20px;">
                                                ({{ errors.avatar[0] }})</span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 customerform" style="margin-top: 15px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="formrow-firstname-input">Name: <span v-if="errors.member" class="haveerror">({{ errors.member[0] }})</span></label>
                                            <input type="text" class="form-control" id="formrow-firstname-input" v-model="member.name" style="text-transform: capitalize;">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="formrow-firstname-input">Acronym: <span v-if="errors.acronym" class="haveerror">({{ errors.acronym[0] }})</span></label>
                                            <input type="text" class="form-control" id="formrow-firstname-input" v-model="member.acronym" style="text-transform: uppercase;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
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
            members : [],
            member: {id: '',name: '',acronym: '',avatar: ''},
            photo: {show: false,url: '',signature: ''},
            params: {token: '123456798',name: 'avatar'},
            headers: {smail: '*_~'},
            editable: false
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
                prev_page_url: links.prev,
                total: meta.total,
            };
            this.pagination = pagination;
        },

        addnew(){
            $("#new").modal('show');
        },

        create(){
            axios.post(this.currentUrl + '/request/admin/member/store', {
                id: this.member.id,
                name: this.member.name,
                acronym: this.member.acronym,
                avatar: this.photo.url,
                editable: this.editable
            })
            .then(response => {
                if(this.editable == true){
                    let page_url = '/request/admin/members?page=' + this.pagination.current_page;
                    this.fetch(page_url);
                }else{
                    this.fetch();
                }
                this.editable = false;
                $("#new").modal("hide");
                this.clear();
            })
            .catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        },

        fetch(page_url) {
            let vm = this; let key;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            page_url = page_url || this.currentUrl + '/request/admin/members/'+key;

            axios.get(page_url)
            .then(response => {
                this.members = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        clear(){
            this.member = {};  
        },

        edit(member){
            this.editable = true;
            this.member = member;
            $("#new").modal('show');
        },
        
        toggleShow() {
            this.photo.show = !this.photo.show;
        },

        cropSuccess(imgDataUrl, field) {
            this.photo.url = imgDataUrl;
        }

    }, components: { myUpload }
}
</script>