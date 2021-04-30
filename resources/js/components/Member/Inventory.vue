<template>
<div class="d-xl-flex">                
    <div class="w-100">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-xl-4 col-sm-6 form-inline">
                        
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
                                
                    </div>
                    <div class="col-xl-8 col-sm-6">
                        <form class="float-sm-right form-inline">
                            <div class="search-box">
                                <div class="position-relative">
                                    <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                                    <i class="icofont icofont-search-user search-icon"></i>
                                </div>
                            </div>
                        </form>
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
                                    <div class="avatar-xs">
                                        <span class="avatar-title rounded-circle">{{member.municipality.name.charAt(0)}}</span>
                                    </div>
                                </td>
                                <td>{{member.municipality.name}}</td>
                                <td>
                                    <span v-if="member.member.status == 'Active'" class="badge badge-success font-size-12">Active</span>
                                    <span v-else-if="member.member.status == 'Inactive'" class="badge badge-secondary font-size-12">Inactive</span>
                                    <span v-else-if="member.member.status == 'Disabled'" class="badge badge-warning font-size-12">Disabled</span>
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
                prev_page_url: links.prev
            };
            this.pagination = pagination;
        },

        fetch(page_url) {
            let vm = this; let key;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            page_url = page_url || this.currentUrl + '/request/admin/lgus/'+key;

            axios.get(page_url)
            .then(response => {
                this.members = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        edit(){

        }

    }, components: { myUpload }
}
</script>