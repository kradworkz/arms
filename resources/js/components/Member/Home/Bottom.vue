<template>
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <div class="float-right" style="margin-top: -5px;">
                    <ul class="list-inline user-chat-nav text-right mb-0 dropdown"  v-if="expiration.length != 0"> 
                        <li class="list-inline-item d-none d-sm-inline-block font-size-12">{{paginationE.from}}-{{paginationE.to}} of {{paginationE.total}} </li>
                        <li class="list-inline-item d-none d-sm-inline-block">
                            <a class="btn nav-btn" v-bind:class="[{disabled: !paginationE.prev_page_url}]" @click="fetchExpiration(paginationE.prev_page_url)">
                                <i class='bx bxs-chevron-left font-size-16'></i>
                            </a>
                        </li>
                        <li class="list-inline-item d-none d-sm-inline-block">
                            <a class="btn nav-btn" v-bind:class="[{disabled: !paginationE.next_page_url}]" @click="fetchExpiration(paginationE.next_page_url)">
                                <i class='bx bxs-chevron-right font-size-16'></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <h6 class="card-title mb-4 text-truncate font-size-14"><i class='bx bxs-alarm-exclamation font-size-18 text-warning mr-2'></i>For Disposal</h6>
                <div class="table-responsive" data-simplebar style="max-height: 250px; min-height: 250px; ">
                    <table class="table table-nowrap table-centered mb-0">
                        <tbody>
                            <tr  v-for="(e,index) in expiration" v-bind:key="'e'+index+e.id">
                                <td>
                                    <h5 class="text-truncate font-size-14 m-0"><a href="#" class="text-dark">{{e.code}}</a></h5>
                                    <p class="text-muted mb-0">{{e.name}}</p>
                                </td>
                                <td>
                                    <div class="text-center">
                                        {{e.expiration}}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-12 align-center" style="margin-top: 50px;" v-if="expiration.length == 0">
                        <center>
                        <i class='bx bx-clipboard text-muted' style="font-size: 70px;"></i> <p class="text-muted">Nothing found.</p>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                <div class="float-right" style="margin-top: -5px;">
                    <ul class="list-inline user-chat-nav text-right mb-0 dropdown" v-if="maintenance.length != 0">
                        <li class="list-inline-item d-none d-sm-inline-block font-size-12">{{paginationM.from}}-{{paginationM.to}} of {{paginationM.total}} </li>
                        <li class="list-inline-item d-none d-sm-inline-block">
                            <a class="btn nav-btn" v-bind:class="[{disabled: !paginationM.prev_page_url}]" @click="fetchMaintenance(paginationM.prev_page_url)">
                                <i class='bx bxs-chevron-left font-size-16'></i>
                            </a>
                        </li>
                        <li class="list-inline-item d-none d-sm-inline-block">
                            <a class="btn nav-btn" v-bind:class="[{disabled: !paginationM.next_page_url}]" @click="fetchMaintenance(paginationM.next_page_url)">
                                <i class='bx bxs-chevron-right font-size-16'></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <h6 class="card-title mb-4 text-truncate font-size-14"><i class="bx bxs-trash font-size-18 text-danger mr-2"></i>For Maintenance</h6>
                 <div class="table-responsive" data-simplebar style="max-height: 250px; min-height: 250px; ">
                    <table class="table table-nowrap table-centered mb-0">
                        <tbody>
                            <tr  v-for="(m,index) in maintenance" v-bind:key="'m'+index+m.id">
                                <td>
                                    <h5 class="text-truncate font-size-14 m-0"><a href="#" class="text-dark">{{m.code}}</a></h5>
                                    <p class="text-muted mb-0">{{m.name}}</p>
                                </td>
                                <td>
                                    <div class="text-center">
                                        {{m.maintenance}}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="col-md-12 align-center" style="margin-top: 50px;" v-if="maintenance.length == 0">
                        <center>
                        <i class='bx bx-clipboard text-muted' style="font-size: 70px;"></i> <p class="text-muted">Nothing found.</p>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
           <div class="card-body">
                <h5 class="card-title mb-4">Activity Logs</h5>
                <div data-simplebar style="max-height: 250px; min-height: 250px;">
                    <ul class="verti-timeline list-unstyled" >
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
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                paginationM: {},
                paginationE: {},
                categories: [],
                maintenance: [],
                expiration: []
            }   
        },

        created(){
            this.fetchExpiration();
            this.fetchMaintenance();
        },

        methods : {
         
            makePaginationM(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                    to: meta.to,
                    from: meta.from,
                    total: meta.total
                };
                this.paginationM = pagination;
            },

            fetchMaintenance(){
                let vm = this; 
                axios.get(this.currentUrl + '/request/member/foraction/M')
                .then(response => {
                    this.maintenance = response.data.data;
                    vm.makePaginationM(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },
            
            makePaginationE(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev,
                    to: meta.to,
                    from: meta.from,
                    total: meta.total
                };
                this.paginationE = pagination;
            },
            fetchExpiration(){
                let vm = this; 
                axios.get(this.currentUrl + '/request/member/foraction/E')
                .then(response => {
                    this.expiration = response.data.data;
                    vm.makePaginationE(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },
        }
    }
</script>