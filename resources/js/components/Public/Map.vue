<template>
<div style="height: 100%;">
    <LMap ref="mymap" style="width: 100%; height: 100%;" :zoom="zoom" :center="center">
        <LTileLayer :url="url" :attribution="attribution"></LTileLayer>
        
        <LMarker v-for="(m, index) in markers" :key="index" :lat-lng="JSON.parse(m.coordinates)" @click="view(m)">
            // <LIcon
            // class-name="customicon">
            // <img :src="currentUrl+'/images/avatars/marker.png'" style="height: 50px; width: 50px;">
            // </LIcon>
                <l-icon
                :icon-size="iconSize"
                :icon-anchor="dynamicAnchor"
                :icon-url="'images/markers/'+m.status.color+'.png'"
            /> 
        </LMarker>
    </LMap>

    <div class="modal fade exampleModal" id="view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Asset</h5>
                     <button type="button" @click="zoomee(12)" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mb-4">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="text-lg-center">
                                <img class="rounded avatar-xl" :src="currentUrl+'/images/avatars/'+asset.image" alt="">
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div>
                                <a class="d-block text-primary mb-2">#{{asset.asset}}</a>
                                <h5 class="text-truncate mb-2">{{asset.name}} 
                                    <span :class="'badge badge-soft-'+asset.status.color+' ml-1 font-size-12'">{{asset.status.name}}</span>
                                </h5>
                                <p class="mb-4 mb-lg-4">Tracker : {{asset.tracker}}</p>
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <h5 class="font-size-14" data-toggle="tooltip" data-placement="top" title="" data-original-title="Due Date"><i class='bx bxs-map mr-2'></i>{{asset.location}}</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import L from 'leaflet';
import { LMap, LTileLayer, LMarker, LIcon } from 'vue2-leaflet';
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            currentUrl: window.location.origin,
            url: "https://{s}.tile.osm.org/{z}/{x}/{y}.png",
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            zoom: 8,
            zoomSnap: 0,
            center: [7.790777061377434, 122.8572650068709],
            confirmed : [],
            staticAnchor: [16, 37],
            customText: "Foobar",
            iconSize: [25,25],
            markers: [],
            selected: [],
            asset : {
                status: {}
            }
        }
    },

    computed: {
        dynamicSize() {
            return [this.iconSize, this.iconSize * 1.15];
        },
        dynamicAnchor() {
            return [this.iconSize / 2, this.iconSize * 1.15];
        }
    },

    created(){
        this.fetchAssets();
    },

    methods : {
        fetchAssets(id){
            this.markers = [];
            this.selected = [];
            let key;
            (id != '' && id != null) ? id = id : id = '-';
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            axios.get(this.currentUrl + '/assets/'+id+'/'+key)
            .then(response => {
                this.markers = response.data.data;
                this.selected = response.data.data;
                this.$parent.recount();
            })
            .catch(err => console.log(err));
            // this.center = JSON.parse(coor);
            setTimeout(() => {
                this.$refs.mymap.mapObject.invalidateSize(); 
            }, 500);
        },

        filterAssets(id){
            var assetcount = this.markers.filter((item) => item.status.id == id);
            return assetcount.length;
        },

        filter(id){
            if(id == 'krad') {
                var asset = this.selected;
            }else{
                var asset =  this.selected.filter((item) => item.status.id == id);
            }
            this.markers = asset;
            return asset.length;
        },

        view(marker){
            this.asset = marker;
            this.zoomee(15)

            // this.$refs.mymap.mapObject.on('zoomend', function (){
            //     $("#view").modal('show');
            //     this.iconSize = 40
            // });

            setTimeout(() => {
                $("#view").modal('show');
            }, 2000);
        },

        zoomee(val){
            this.$refs.mymap.mapObject.flyTo(JSON.parse(this.asset.coordinates), val, {
                animate: true,
                duration: 2.0
            });
        }

    }, components: { LMap, LTileLayer,LMarker, LIcon }
}
</script>>