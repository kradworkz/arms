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
        <agency-create @status="message" ref="create"></agency-create>
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
            keyword: '',
            members : [],
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

        addnew(){
            $("#new").modal('show');
        },

        edit(agency){
            this.editable = true;
            $("#new").modal('show');
            this.$refs.create.edit(agency,true);
        },

        message(val){
            if(val){
                if(this.editable == true){
                    let page_url = '/request/admin/members/-?page=' + this.pagination.current_page;
                    this.fetch(page_url);
                }else{
                    this.fetch();
                }
                $("#newloc").modal('hide');
                this.editable = false;
            }
        }

    }, 
}
</script>