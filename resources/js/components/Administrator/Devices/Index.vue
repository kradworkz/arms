<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-xl-6 col-sm-6 form-inline">
                            <button type="button" @click="addnew" class="btn btn-danger waves-effect waves-light mr-2">New <i class='bx bx-plus-medical ml-2'></i></button>
                            <form class="float-sm-right form-inline">
                                <div class="search-box">
                                    <div class="position-relative">
                                        <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="search()">
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
                                    <button @click="check(true)" type="button" class="btn btn-light"><span class="d-none d-sm-inline-block "> <i class='bx bx-refresh'></i></span></button>                                 
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="table-responsive" style="min-height: 230px;">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Station</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Data Logger</th>
                                    <th class="text-center">Coordinates</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(device,index) in devices" v-bind:key="device+index">
                                    <td>{{index+1}}</td>
                                    <td>
                                        <h5 class="font-size-14 mb-1"><a class="text-dark">{{device.station}}</a></h5>
                                        <p class="text-muted mb-0">{{device.municipality.name}}, {{device.province.name}}</p>
                                    </td>
                                    <td class="text-center">{{device.type.name}}</td>
                                    <td class="text-center">{{device.datalogger}}</td>
                                    <td class="text-center">{{device.coordinates}}</td>
                                    <td class="text-center">
                                     <span :class="'badge badge-'+device.status.color">{{device.status.name}}</span>
                                    </td>
                                    <td class="text-center">
                                        <a @click="getData(device.id)" class="font-size-16"><i class='bx bxs-data mr-2' ></i></a>
                                        <a @click="track(device.coordinates)" v-bind:class="[(device.coordinates != 'n/a' ? 'text-danger' : 'text-secondary')]" class="font-size-16"><i class='bx bx-current-location'></i></a>
                                    </td>
                                </tr>
                                
                            </tbody>
                            
                        </table>
                    </div>
                    <!-- end table-responsive -->
                </div>
            </div>
        </div>

        <div class="modal fade exampleModal" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <device-create @status="message" ref="create"></device-create>
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
                keyword: '',
                pagination: {},
                devices: [],
                editable: false
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
                page_url = page_url || this.currentUrl + '/request/admin/devices/'+key;

                axios.get(page_url)
                .then(response => {
                    this.devices = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            

            search(){

            },

            addnew(){
                $("#new").modal('show');
            },

            clear(){
                this.device = {};
            },

            track(coordinates){
                if(coordinates != 'n/a'){
                    this.$parent.trackMap(coordinates);
                }
            },

            getData(id){
                this.$parent.getData(id);
            },

            message(val){
                if(val){
                    if(this.editable == true){
                        let page_url = '/request/admin/devices/-?page=' + this.pagination.current_page;
                        this.fetch(page_url);
                    }else{
                        this.fetch();
                    }
                    $("#new").modal('hide');
                    this.editable = false;
                    Vue.$toast.success('<strong>Successfully Updated</strong>', {
                        position: 'bottom-right'
                    });
                }
            }


        },  components: { Multiselect }
    }
</script>