<template>
<div>
    <div class="search-box chat-search-box py-3">
        <div class="position-relative">
            <input type="text" class="form-control" placeholder="Search...">
        <i class="bx bx-search-alt search-icon"></i>
        </div>
    </div>

    <div class="chat-leftsidebar-nav">
        <div class="mt-2" v-for="(category,index) in categories" v-bind:key="category.id" @click="show(category)">
            <div class="card border shadow-none mb-2">
                <a href="javascript: void(0);" class="text-body">
                    <div class="p-2">
                        <div class="d-flex">
                            <div class="avatar-xs align-self-center ml-2 mr-3">
                                <div :class="'avatar-title rounded bg-transparent text-'+category.color+' font-size-20'">
                                        <i :class="'bx bx-'+category.type"></i>
                                </div>
                            </div>

                            <div class="overflow-hidden mr-auto">
                                <h5 class="font-size-13 text-truncate mb-1">{{ category.name }}</h5>
                                <p class="text-muted text-truncate mb-0">{{category.counts}} Assets</p>
                            </div>

                            <div class="float-right font-size-16 mt-2 mr-2" v-if="drop == true">
                              <i :class="'text-'+category.color+' bx bxs-x-circle'"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>           
        </div>

        <table  v-if="drop == true"  class="table table-centered table-nowrap mt-4" >
            <tbody>
                <tr v-for="(status,index) in statuses" v-bind:key="status.id" style="cursor: pointer;" @click="view(status.id)"  :class="{'table-secondary':selected == status.id}">
                    <td style="width: 50px;">
                        <div :class="'font-size-22 text-'+status.color">
                           <i class='bx bxs-alarm-exclamation' ></i>
                        </div>
                    </td>
                    <td>
                        <div>
                            <h5 class="font-size-12 mb-1">{{ status.name }}</h5>
                        </div>
                    </td>
                    <td>
                        <div class="text-right">
                            <h5 class="font-size-12 text-muted mb-0">({{ status.count }})</h5>
                        </div>
                    </td>
                </tr>
                <tr style="cursor: pointer;" @click="view('krad')"  :class="{'table-secondary':selected == 'krad'}">
                    <td style="width: 50px;">
                        <div class='font-size-22 text-secondary'>
                           <i class='bx bxs-alarm-exclamation' ></i>
                        </div>
                    </td>
                    <td>
                        <div>
                            <h5 class="font-size-12 mb-1">Show All</h5>
                        </div>
                    </td>
                    <td>
                        <div class="text-right">
                            <h5 class="font-size-12 text-muted mb-0">({{this.l}})</h5>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
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
            categories: [],
            statuses: [],
            active: [],
            inactive: [],
            drop: false,
            selected: '',
            l: 0
        }
    },

    created(){
        this.fetchCategory();
        this.fetchStatus();
    },

    methods : {
        fetchCategory(){
            axios.get(this.currentUrl + '/request/dropdown/count/category/-')
            .then(response => {
                this.categories = response.data.data;
                this.inactive = response.data.data;
            })
            .catch(err => console.log(err));
        },

        show(category){
            if(this.drop == true){
                this.categories = this.inactive;
                this.active = [];
                this.drop = false;
                this.selected = '';
            }else{
                if(this.active.length < 1){
                    this.active.push(category);
                    this.categories = this.active;
                    this.drop = true;
                    this.$parent.fetch(category.id);
                }
            }
        },

        fetchStatus(){
            axios.get(this.currentUrl + '/request/dropdown/lists/status/asset')
            .then(response => {
                this.statuses = response.data.data;
                this.countStatus();
            })
            .catch(err => console.log(err));
        },

        countStatus(){
            this.l = 0;
            for(var i=0; i < this.statuses.length; i++){
                if(this.statuses.length > 0){
                    var total = this.$parent.count(this.statuses[i].id);
                    this.statuses[i].count = total;
                    this.l = parseInt(total) + this.l;
                }
            } 
        },

        view(id){
            this.selected = id;
            this.$parent.filter(id);
        }
    }
}
</script>>