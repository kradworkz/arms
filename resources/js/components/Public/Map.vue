<template>
<div style="height: 100%;">
    <div class="b">
        <ul class="list-inline user-chat-nav text-right mb-0">
            <li class="list-inline-item mr-0">
                <div class="dropdown" data-toggle="tooltip" data-placement="top" title="" data-original-title="Show Lists">
                    <button class="btn nav-btn" type="button">
                        <i class='bx bx-list-ul'></i>
                    </button>
                </div>
            </li>
        </ul>
    </div>
    <LMap ref="mymap" style="width: 100%; height: 100%;" :zoom="zoom" :center="center">
        <LTileLayer :url="url" :attribution="attribution"></LTileLayer>
        
        <LMarker v-for="(m, index) in markers" :key="index" :lat-lng="JSON.parse(m.coordinates)" @click="view(m)">
            <!--<LIcon
            class-name="customicon">
            <img :src="currentUrl+'/images/avatars/marker.png'" style="height: 50px; width: 50px;">
            </LIcon>-->
                <l-icon
                :icon-size="iconSize"
                :icon-anchor="dynamicAnchor"
                :icon-url="'images/markers/'+m.avatar"
            /> 
        </LMarker>
         <LMarker v-for="(m, index) in stations" :key="'c'+index" :lat-lng="JSON.parse(m.coordinates)" @click="station(m)">
                <l-icon
                :icon-size="[40,40]"
                :icon-anchor="dynamicAnchor"
                :icon-url="'images/avatars/'+m.avatar"
            /> 
        </LMarker>
    </LMap>
    <public-asset @status="message" ref="assetModal"></public-asset>
    <public-station @status="message" ref="stationModal"></public-station>
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
            stations: [],
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
        this.fetchStations();
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

         fetchStations(id){
            axios.get(this.currentUrl + '/stations/lists')
            .then(response => {
                this.stations = response.data.data;
            })
            .catch(err => console.log(err));
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
            // this.$refs.mymap.mapObject.on('zoomend', function (){
            //     $("#view").modal('show');
            //     this.iconSize = 40
            // });
            this.zoomee(15,marker.coordinates)
            setTimeout(() => {
                this.$refs.assetModal.open(marker);
            }, 2000);
        },

        station(marker){
            this.zoomee(15,marker.coordinates)
            this.$refs.stationModal.open(marker);
        },

        message({size,coor}){
            this.zoomee(size,coor);
        },
        zoomee(val,coordinates){
            this.$refs.mymap.mapObject.flyTo(JSON.parse(coordinates), val, {
                animate: true,
                duration: 2.0
            });
        }

    }, components: { LMap, LTileLayer,LMarker, LIcon }
}
</script>

<style>
div.b {
  position:fixed;
  padding:7px;
  top:50px;
  right:80px;
  max-width:450px;
  z-index:999
} 

</style>