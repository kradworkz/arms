<<template>
<div class="d-xl-flex">
    <div class="w-100">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-xl-6 col-sm-6 form-inline">
                        <form class="float-sm-right form-inline">
                            <div class="search-box">
                                <div class="position-relative">
                                    <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                                   <i class='bx bx-search-alt search-icon'></i>
                                </div>
                            </div>
                        </form>
                        <button type="button" class="btn btn-danger waves-effect waves-light ml-2">New <i class='bx bx-plus-medical ml-2'></i></button>
                        <button type="button" class="btn btn-danger waves-effect waves-light ml-2">New <i class='bx bx-plus-medical ml-2'></i></button>
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
                                <th class="text-center">Asset</th>
                                <th class="text-center">Agency</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="location in locations" v-bind:key="location.id" @click="view(location.id)" :class="{'table-success':trselected == location.id}">
                                <td>
                                    <div class="avatar-xs"><span class="avatar-title rounded-circle">{{location.name.charAt(0)}}</span></div>
                                </td>
                                <td class="text-center">{{location.asset}}</td>
                                <td class="text-center">{{location.agency}}</td>
                                <td class="text-center">{{location.agency}}</td>
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
                pagination: {},
            }
        }
    }
</script>