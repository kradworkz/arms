<template>
     <div>
        <div class="float-right">
            <button @click="newloc('Vendor')" class="btn btn-sm btn-danger" type="button">
                <i class="bx bx-plus align-middle mr-1"></i> New Vendor
            </button>
             <button @click="newloc('Storage')" class="btn btn-sm btn-warning" type="button">
                <i class="bx bx-plus align-middle mr-1"></i> New Storage
            </button>
        </div>
        <h4 class="card-title">Asset Information</h4>
        <p class="card-title-desc">Fill all information below</p><br>

        <form  @submit.prevent="create">
            <div class="row">
                <div class="col-md-8">
                    <div class="row customerform">
                        <div class="col-md-6" style="margin-top: -10px;">
                            <div class="form-group form-primary">
                                <label class="float-label">Category <span v-if="errors.category" class="haveerror">({{ errors.category[0] }})</span></label>
                                <multiselect v-model="asset.category" :options="categories" placeholder="Select Category" label="name" track-by="id">
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-md-6" style="margin-top: -10px;">
                            <div class="form-group form-primary">
                                <label class="float-label">Storage <span v-if="errors.storage" class="haveerror">({{ errors.storage[0] }})</span></label>
                                <multiselect v-model="asset.storage" :options="storages" placeholder="Select Storage" label="name" track-by="id">
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: -10px;">
                            <div class="form-group">
                                <label for="formrow-firstname-input">Name: <span v-if="errors.name" class="haveerror">({{ errors.name[0] }})</span></label>
                                <input type="text" class="form-control" id="formrow-firstname-input" v-model="asset.name" style="text-transform: capitalize;">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>
                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="float-label">Vendor <span v-if="errors.vendor" class="haveerror">({{ errors.vendor[0] }})</span></label>
                                <multiselect v-model="asset.vendor" :options="vendors" placeholder="Select Vendor" label="name" track-by="id">
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Price <span v-if="errors.price" class="haveerror">({{ errors.price[0] }})</span></label>
                                <input type="text" class="form-control" id="formrow-firstname-input" v-model="asset.price" style="text-transform: capitalize;">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Quantity <span v-if="errors.quantity" class="haveerror">({{ errors.quantity[0] }})</span></label>
                            <div class="input-group  bootstrap-touchspin bootstrap-touchspin-injected"><input type="text" v-model="asset.quantity" class="form-control"><span class="input-group-btn-vertical">
                                <button @click="addup('add')" class="btn btn-primary bootstrap-touchspin-up " type="button">+</button>
                                <button @click="addup('minus')" class="btn btn-primary bootstrap-touchspin-down " type="button">-</button>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 20px;">
                            <hr>
                            <center>
                                <button @click="more" style="margin-top: -55px;" class="btn btn-sm btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                   Add more information
                                </button>
                            </center>
                        </div>

                        <div class="collapse" id="collapseExample">
                            <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">Brand: <span v-if="errors.brand" class="haveerror">({{ errors.brand[0] }})</span></label>
                                        <input type="text" class="form-control" id="formrow-firstname-input" v-model="asset.brand" style="text-transform: capitalize;">
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-top: -10px;">
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">Serial no: <span v-if="errors.serial_no" class="haveerror">({{ errors.serial_no[0] }})</span></label>
                                        <input type="text" class="form-control" id="formrow-firstname-input" v-model="asset.serial_no" style="text-transform: capitalize;">
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-top: -10px;">
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">Model: <span v-if="errors.nmodel" class="haveerror">({{ errors.model[0] }})</span></label>
                                        <input type="text" class="form-control" id="formrow-firstname-input" v-model="asset.model" style="text-transform: capitalize;">
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top: -10px;">
                                    <div class="form-group">
                                        <label class="float-label">Description <code style="color: red;" v-if="errors.desc">({{ errors.name[0] }})</code></label>
                                        <textarea v-model="asset.desc" class="form-control" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-md-4" style="margin-top: -20px;">
                    <myUpload field="img" @crop-success="cropSuccess" v-model="photo.show" :width="500" :height="500" :params="params" :headers="headers" lang-type="en" img-format="jpeg">
                    </myUpload>
                    <div @click="toggleShow" class="fuzone" style="width:100%;">
                        <div v-if="photo.url != ''">
                            <img :src="photo.url" style="width: 100%;">
                        </div>
                        <div v-else class="fu-text" @click="toggleShow">
                            <span><i class="fa fa-picture"></i> Click here to upload<br> 
                                <span v-if="errors.avatar" style="color: red; font-size: 12px; margin-top: -20px;">({{ errors.avatar[0] }})</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" @click="cancel">Cancel</button>
                    </div>
               </div>
            </div>
        </form>

        <div class="modal fade exampleModal" id="newloc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{selected}} Information</h5>
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

         <loading :active.sync="isLoading" 
        :can-cancel="true" 
        loader="dots"
        background-color="black"
        :is-full-page="fullPage">
        </loading>
    </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import Multiselect from 'vue-multiselect';
import myUpload from 'vue-image-crop-upload/upload-2.vue';
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            keyword: '',
            asset: {
                id : '',
                code: '',
                name: '',
                price: '',
                quantity: 1,
                category: '',
                storage: '',
                status: '',
                brand: '',
                serial_no: '',
                model: '',
                description: '',
                vendor: '',
                desc: ''
            },
            loc: {
                name: '',
                address: '',
                contact_no: ''
            },
            categories: [],
            storages :[],
            vendors: [],
             photo: {show: false,url: '',signature: ''},
            params: {token: '123456798',name: 'avatar'},
            headers: {smail: '*_~'},
            isLoading: false,
            fullPage: true,
            extra: false,
            selected: ''
        }
    },

    created(){
        this.fetchCategory();
        this.fetchStorage();
        this.fetchVendor();
    },

    methods : {
        create(){
           
            axios.post(this.currentUrl + '/request/member/asset/store', {
                id: this.asset.id,
                name: this.asset.name,
                price: this.asset.price,
                quantity: this.asset.quantity,
                category: this.asset.category.id,
                storage: this.asset.storage.id,
                vendor: this.asset.vendor.id,
                brand: this.asset.brand,
                serial_no: this.asset.serial_no,
                model: this.asset.model,
                desc: this.asset.desc,
                avatar: this.photo.url,
                editable: this.editable,
                extra: this.extra,
                selected: this.selected
            })
            .then(response => {
                if(this.editable == true){
                    let page_url = '/request/admin/users?page=' + this.pagination.current_page;
                    this.fetch(page_url);
                }else{
                    this.fetch();
                }
                this.editable = false;
                $("#new").modal("hide");
                this.$emit('status', true);
                this.clear();
                this.isLoading = false;
            })
            .catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        },

        createloc(){
           
            axios.post(this.currentUrl + '/request/member/location/store', {
                name: this.loc.name,
                address: this.loc.address,
                contact_no: this.loc.contact_no,
                selected: this.selected,
            })
            .then(response => {
                if(this.selected == 'Storage'){
                    this.fetchStorage();
                }else{
                    this.fetchVendor();
                }
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

        fetchCategory(){
            axios.get(this.currentUrl + '/request/admin/lists/s/1')
            .then(response => {
                this.categories = response.data.data;;
            })
            .catch(err => console.log(err));
        },

        fetchStorage(){
            axios.get(this.currentUrl + '/request/member/lists/s/1')
            .then(response => {
                this.storages = response.data.data;;
            })
            .catch(err => console.log(err));
        },

        fetchVendor(){
            axios.get(this.currentUrl + '/request/member/lists/s/2')
            .then(response => {
                this.vendors = response.data.data;;
            })
            .catch(err => console.log(err));
        },

        newloc(val){
            $("#newloc").modal('show');
            this.selected = val;
        },

        more(){
            (this.extra) ? this.extra = false : this.extra = true;
        },

        addup(val){
            if(val == 'add'){
                this.asset.quantity += 1;
            }else{
                if(this.asset.quantity > 1){
                this.asset.quantity -= 1;
                }
            }
        },

        toggleShow() {
            this.photo.show = !this.photo.show;
        },

        cropSuccess(imgDataUrl, field) {
            this.photo.url = imgDataUrl;
        },

        cancel(){
            this.$emit('status', false);
            this.asset  = {};
        }

    }, components: { Multiselect, myUpload, Loading}
}
</script>