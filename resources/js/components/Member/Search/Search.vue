<template>
    <div class="row">
        <!--<div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="pt-4">
                        <h5 class="font-size-14 mb-3">Categories</h5>
                        <div>
                             <div class="custom-control custom-radio mb-2">
                                <input v-on:change="onChange" type="radio" id="all" value="-" v-model="cate" class="custom-control-input">
                                <label class="custom-control-label" for="all">All</label>
                            </div>
                            <div class="custom-control custom-radio mb-2" v-for="category in categories" v-bind:key="category.id">
                                <input v-on:change="onChange" type="radio" :id="'customCheck_'+ category.id" :value="category.id" v-model="cate" class="custom-control-input">
                                <label class="custom-control-label" :for="'customCheck_' + category.id">{{ category.name }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-xl-8 col-sm-8 form-inline">
                            <form class="float-sm-right form-inline">
                                <div class="search-box">
                                    <div class="position-relative">
                                        <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                                    <i class='bx bx-search-alt search-icon'></i>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xl-4 col-sm-4">
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
                        <table class="table table-nowrap table-centered mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Code</th>
                                    <th scope="col">Asset</th>
                                    <th scope="col">Tracker</th>
                                    <th scope="col" colspan="2">Station</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="asset in assets" v-bind:key="asset.id">
                                    <td>
                                        <h5 class="font-size-14 mb-1">{{asset.asset_code}}</h5>
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 mb-1">{{asset.name}}</h5>
                                        <div class="text-muted">{{asset.category}}</div>
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 mb-1">{{asset.tracker_code}}</h5>
                                        <div class="text-muted">{{asset.coordinates}}</div>
                                    </td>
                                    <td>
                                        <h5 class="font-size-14 mb-1">{{asset.location}}</h5>
                                        <div class="text-muted">{{asset.address}}</div>
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
                keyword: '',
                categories: [],
                assets: [],
                cate: ''
            }
        },

        created(){
            this.fetch();
            this.fetchCategory();
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

            fetch(page_url){
                let vm = this; let key; let cat;
                (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
                (this.cate != '' && this.cate != null) ? cat = this.cate : cat = '-';
                page_url = page_url || this.currentUrl + '/request/member/assets/search2/'+cat+'/'+key

                axios.get(page_url)
                .then(response => {
                    this.assets = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            fetchCategory(){
                axios.get(this.currentUrl + '/request/dropdowns/category/-')
                .then(response => {
                    this.categories = response.data.data;;
                })
                .catch(err => console.log(err));
            },

            onChange(){
                this.fetch();
            }

        }
    }
</script>
